<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $suppliers = Supplier::withCount('products')
            ->when($search, function ($query) use ($search) {
                $query->where('company_name', 'like', "%{$search}%")
                      ->orWhere('contact_person', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('company_name')
            ->paginate(15);
            
        return view('admin.inventory.suppliers.index', compact('suppliers', 'search'));
    }

    public function create()
    {
        return view('admin.inventory.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.inventory.suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('products', 'purchases');
        return view('admin.inventory.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.inventory.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.inventory.suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->count() > 0 || $supplier->purchases()->count() > 0) {
            return back()->with('error', 'Cannot delete supplier with associated products or purchases.');
        }
        
        $supplier->delete();
        return redirect()->route('admin.inventory.suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
