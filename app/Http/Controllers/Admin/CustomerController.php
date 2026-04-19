<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders.items.product', 'subscriptions']);
        $recentOrders = $customer->orders()->with('items.product')->orderBy('created_at', 'desc')->take(5)->get();
        
        return view('admin.customers.show', compact('customer', 'recentOrders'));
    }
}
