<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('customer.account.index');
    }

    public function orders()
    {
        $user = Auth::user();

        $customer = $user->customer ?: Customer::query()->where('user_id', $user->id)->first();

        $orders = Order::query()
            ->when($customer, fn ($q) => $q->where('customer_id', $customer->id), fn ($q) => $q->whereRaw('1=0'))
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.account.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $user = Auth::user();

        $customer = $user->customer ?: Customer::query()->where('user_id', $user->id)->first();

        $order = Order::query()
            ->where('id', $id)
            ->when($customer, fn ($q) => $q->where('customer_id', $customer->id), fn ($q) => $q->whereRaw('1=0'))
            ->with(['items.product', 'delivery.rep', 'payment', 'invoice'])
            ->firstOrFail();

        return view('customer.account.show-order', compact('order'));
    }

    public function invoice($id)
    {
        // Minimal invoice rendering for now (PDF generation can be wired later).
        $user = Auth::user();
        $customer = $user->customer ?: Customer::query()->where('user_id', $user->id)->first();

        $order = Order::query()
            ->where('id', $id)
            ->when($customer, fn ($q) => $q->where('customer_id', $customer->id), fn ($q) => $q->whereRaw('1=0'))
            ->with(['items.product', 'payment', 'invoice'])
            ->firstOrFail();

        return view('invoices.template', [
            'order' => $order,
            'invoice' => $order->invoice,
        ]);
    }
}
