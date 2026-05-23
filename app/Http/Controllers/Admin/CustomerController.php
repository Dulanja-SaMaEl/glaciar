<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount(['orders', 'subscriptions'])
            ->withSum('orders', 'total');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Type filter (web / app)
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Metrics
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', 'active')->count();
        $businessCustomers = Customer::whereNotNull('business_type')
            ->where('business_type', '!=', '')
            ->count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();

        $customers = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.customers.index', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'businessCustomers',
            'activeSubscriptions'
        ));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders.items.product', 'subscriptions.product', 'deliveryRoutes', 'complaints']);

        $recentOrders = $customer->orders()
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $totalSpent = $customer->orders()->sum('total');
        $orderCount = $customer->orders()->count();
        $activeSubscriptions = $customer->subscriptions()->where('status', 'active')->count();

        return view('admin.customers.show', compact(
            'customer',
            'recentOrders',
            'totalSpent',
            'orderCount',
            'activeSubscriptions'
        ));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'business_type' => 'nullable|string|max:255',
            'type' => 'nullable|in:web,app',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $customer->update($data);

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function toggleStatus(Customer $customer)
    {
        $newStatus = $customer->status === 'active' ? 'inactive' : 'active';
        $customer->update(['status' => $newStatus]);

        return back()->with('success', "Customer status changed to {$newStatus}.");
    }
}
