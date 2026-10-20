<?php

namespace App\Http\Controllers;

use App\Models\DeliveryRoute;
use App\Models\Customer;
use App\Models\Rep;
use Illuminate\Http\Request;

class DeliveryRouteController extends Controller
{
    public function index()
    {
        $routes = DeliveryRoute::withCount(['customers', 'reps'])->get();
        return view('admin.delivery_routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.delivery_routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DeliveryRoute::create($validated);

        return redirect()->route('admin.delivery-routes.index')->with('success', 'Delivery route created successfully.');
    }

    public function show(DeliveryRoute $delivery_route)
    {
        $delivery_route->load(['customers', 'reps']);
        $all_customers = Customer::orderBy('name')->get();
        $all_reps = Rep::where('status', 'active')->orderBy('name')->get();
        
        return view('admin.delivery_routes.show', compact('delivery_route', 'all_customers', 'all_reps'));
    }

    public function edit(DeliveryRoute $delivery_route)
    {
        return view('admin.delivery_routes.edit', compact('delivery_route'));
    }

    public function update(Request $request, DeliveryRoute $delivery_route)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $delivery_route->update($validated);

        return redirect()->route('admin.delivery-routes.index')->with('success', 'Delivery route updated successfully.');
    }

    public function destroy(DeliveryRoute $delivery_route)
    {
        $delivery_route->delete();
        return redirect()->route('admin.delivery-routes.index')->with('success', 'Delivery route deleted successfully.');
    }

    public function syncCustomers(Request $request, DeliveryRoute $delivery_route)
    {
        $request->validate([
            'customer_ids' => 'array',
            'customer_ids.*' => 'exists:customers,id',
        ]);

        $delivery_route->customers()->sync($request->input('customer_ids', []));

        return back()->with('success', 'Customers synced successfully.');
    }

    public function syncReps(Request $request, DeliveryRoute $delivery_route)
    {
        $request->validate([
            'rep_ids' => 'array',
            'rep_ids.*' => 'exists:reps,id',
        ]);

        $delivery_route->reps()->sync($request->input('rep_ids', []));

        return back()->with('success', 'Sales reps synced successfully.');
    }
}
