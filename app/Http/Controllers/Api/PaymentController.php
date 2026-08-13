<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $repId = optional($request->user())->rep?->id;

        $query = Payment::query()
            ->with(['order.customer'])
            ->when($repId, function ($q) use ($repId) {
                $q->whereHas('order', function ($sq) use ($repId) {
                    $sq->where('rep_id', $repId);
                });
            });

        $payments = $query->latest()->get()->map(function ($payment) {
            return [
                'id' => (string) $payment->id,
                'customer_name' => $payment->order->customer->name ?? 'Unknown',
                'time' => $payment->created_at->format('Y-m-d H:i:s'),
                'invoice_number' => $payment->reference,
                'amount' => (float) $payment->amount,
                'method' => $payment->method,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer,cheque,transfer',
            'notes' => 'nullable|string',
        ]);

        // Map payment method correctly if it's 'transfer'
        $method = $validatedData['payment_method'] === 'transfer' ? 'bank_transfer' : $validatedData['payment_method'];

        // Find the latest order for this customer to attach the payment to
        $order = Order::where('customer_id', $validatedData['customer_id'])
                      ->latest()
                      ->first();

        if (!$order) {
            // Create a dummy order if none exists so the payment can be tracked in the system
            $order = Order::create([
                'customer_id' => $validatedData['customer_id'],
                'rep_id' => optional($request->user())->rep?->id,
                'type' => 'app',
                'total' => $validatedData['amount'],
                'status' => 'delivered',
                'payment_method' => $method,
                'notes' => 'Auto-generated order for direct payment. ' . ($validatedData['notes'] ?? ''),
            ]);
        }

        DB::beginTransaction();

        try {
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $validatedData['amount'],
                'method' => $method,
                'status' => 'pending',
                'reference' => 'PAY-' . strtoupper(uniqid()),
            ]);

            // Optional: Generate Invoice Automatically
            $invoiceService = new InvoiceService();
            $invoice = $invoiceService->generateForOrder($order);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment logged successfully',
                'data' => [
                    'payment' => $payment,
                    'invoice' => $invoice,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function invoice(Request $request, $id)
    {
        $invoice = \App\Models\Invoice::find($id);

        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
        }

        // Normally, return a link to download or display
        return response()->json([
            'success' => true,
            'data' => [
                'invoice_number' => $invoice->invoice_number,
                'download_url' => $invoice->pdf_path ? url('/storage/' . $invoice->pdf_path) : null,
            ]
        ]);
    }
}
