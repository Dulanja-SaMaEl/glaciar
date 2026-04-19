<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'payment'])->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product', 'delivery.rep', 'payment', 'invoice']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function invoice(Order $order, InvoiceService $invoiceService)
    {
        $invoice = $invoiceService->generateForOrder($order);

        return $invoiceService->download($invoice);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,delivered,cancelled,failed'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
