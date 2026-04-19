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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:cash,card,bank_transfer,cheque',
        ]);

        $order = Order::find($validatedData['order_id']);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        DB::beginTransaction();

        try {
            $payment = Payment::create([
                'order_id' => $validatedData['order_id'],
                'amount' => $validatedData['amount'],
                'method' => $validatedData['method'],
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
