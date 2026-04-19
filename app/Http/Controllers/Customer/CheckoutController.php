<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $cartItems = [];
        $cartTotal = 0;
        
        foreach ($cart as $id => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $cartItems[] = (object)[
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'product' => $product
                ];
                $cartTotal += $product->price * $item['qty'];
            }
        }

        $zones = Zone::orderBy('name')->get();

        return view('customer.checkout.index', compact('cartItems', 'cartTotal', 'zones'));
    }

    public function store(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $validatedData = $request->validate([
            'name' => Auth::check() ? 'nullable' : 'required|string|max:255',
            'email' => Auth::check() ? 'nullable' : 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'zone_id' => 'required|exists:zones,id',
            'payment_method' => 'required|in:cash,card,bank_transfer,cheque',
            'is_subscription' => 'nullable|boolean',
            'frequency' => 'nullable|in:weekly,biweekly,monthly',
        ]);

        DB::beginTransaction();

        try {
            // 1. Calculate Total
            $totalAmount = 0;
            $itemsData = [];
            
            foreach ($cart as $id => $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $unitPrice = $product->price;
                    $totalPrice = $unitPrice * $item['qty'];
                    $totalAmount += $totalPrice;
                    
                    $itemsData[] = [
                        'product_id' => $product->id,
                        'qty' => (int) $item['qty'],
                        'unit_price' => $unitPrice,
                    ];
                }
            }

            // 2. Ensure a Customer record exists (current DB uses customers table; we bridge via email for now)
            if (!Auth::check()) {
                abort(403, 'Please login to checkout');
            }

            $user = Auth::user();
            $customer = $user->customer ?: Customer::query()->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $validatedData['phone'],
                    'address' => $validatedData['address'],
                    'business_type' => 'Individual',
                    'type' => 'web',
                    'status' => 'active',
                    'password' => $user->password,
                ]
            );

            // Keep customer profile up to date
            $customer->update([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
            ]);

            // 3. Create Order
            $order = Order::create([
                'customer_id' => $customer->id,
                'type' => 'web',
                'status' => 'pending',
                'total' => $totalAmount,
                'payment_method' => $validatedData['payment_method'],
                'notes' => 'Zone #' . $validatedData['zone_id'] . ' | Address: ' . $validatedData['address'],
            ]);

            // 4. Create Order Items
            foreach ($itemsData as $itemData) {
                $order->items()->create($itemData);
            }

            // 5. Handle Subscription if selected
            if ($request->boolean('is_subscription')) {
                // Logic to create subscription
                $order->customer->subscriptions()->create([
                    'status' => 'active',
                    'frequency' => $validatedData['frequency'] ?? 'weekly',
                    'next_delivery_date' => now()->addDays(7), // Example logic
                ]);
            }

            DB::commit();

            // Clear Cart
            Session::forget('cart');

            return redirect()->route('account.orders.show', $order->id)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'There was an error processing your order. Please try again.')->withInput();
        }
    }
}
