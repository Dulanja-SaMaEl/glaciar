<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        // NOTE: auth model will be normalized in Phase 3.
        // For now, keep the endpoint schema-compatible with current DB.
        $repId = optional($request->user())->rep?->id;

        $query = Delivery::query()
            ->with(['order.customer', 'order.items.product'])
            ->when($repId, fn ($q) => $q->where('rep_id', $repId), fn ($q) => $q->whereRaw('1=0'));

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        // Creating an ad-hoc delivery (e.g., flag down or immediate request)
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,bank_transfer,cheque',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $repId = optional($request->user())->rep?->id;
            if (!$repId) {
                return response()->json(['success' => false, 'message' => 'Rep profile not available for this user'], 403);
            }

            // Calculate total
            $totalAmount = 0;
            $orderItems = [];
            foreach ($validatedData['items'] as $item) {
                $product = Product::find($item['product_id']);
                $totalPrice = $product->price * $item['quantity'];
                $totalAmount += $totalPrice;
                
                $orderItems[] = [
                    'product_id' => $product->id,
                    'qty' => (int) $item['quantity'],
                    'unit_price' => $product->price,
                ];
            }

            // Create Order
            $order = Order::create([
                'customer_id' => $validatedData['customer_id'],
                'rep_id' => $repId,
                'type' => 'app',
                'total' => $totalAmount,
                'status' => 'delivered',
                'payment_method' => $validatedData['payment_method'],
                'notes' => $validatedData['notes'] ?? null,
            ]);

            // Create Order Items
            foreach ($orderItems as $orderItem) {
                $order->items()->create($orderItem);
            }

            // Create Delivery
            $delivery = Delivery::create([
                'order_id' => $order->id,
                'status' => 'delivered',
                'rep_id' => $repId,
                'delivered_at' => now(),
                'notes' => $validatedData['notes'] ?? 'Ad-hoc delivery created by rep',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ad-hoc delivery created successfully',
                'data' => $delivery->load(['order'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $delivery = Delivery::with('order')->find($id);

        if (!$delivery) {
            return response()->json(['success' => false, 'message' => 'Delivery not found'], 404);
        }

        // Ensure the delivery belongs to this rep
        if ($delivery->rep_id !== optional($request->user())->rep?->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access'], 403);
        }

        $validatedData = $request->validate([
            'status' => 'required|in:pending,delivered,failed',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $delivery->update([
                'status' => $validatedData['status'],
                'notes' => $validatedData['notes'] ?? $delivery->notes,
                'delivered_at' => $validatedData['status'] === 'delivered' ? now() : null,
            ]);

            // Sync order status
            if (in_array($validatedData['status'], ['delivered', 'failed'])) {
                $delivery->order->update(['status' => $validatedData['status']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Delivery updated successfully',
                'data' => $delivery
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
