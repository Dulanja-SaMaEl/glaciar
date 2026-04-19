<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $rep = $request->user()->rep;
        if (!$rep) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Current DB schema does not store customer zone assignment; return active customers.
        $customers = Customer::query()
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'business_type' => 'nullable|string|max:255',
            'source' => 'nullable|in:web,app',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make('password123'), // Default password or randomly generated
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'role' => 'customer',
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'business_type' => $validatedData['business_type'] ?? null,
                'type' => $validatedData['source'] ?? 'app',
                'status' => 'active',
                'password' => $user->password,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Customer added successfully',
                'data' => $customer
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add customer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $customer = Customer::with(['orders.items.product'])->find($id);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
             return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        $data = $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'business_type' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        $customer->update(array_filter($data, fn ($v) => $v !== null));

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully',
            'data' => $customer
        ]);
    }
}
