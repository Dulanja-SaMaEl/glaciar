<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        
        // Transform the session array into an array of objects to match the view's expectation
        $cartItems = [];
        $cartTotal = 0;
        
        foreach ($cart as $id => $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $cartItems[] = (object)[
                    'id' => $id, // Use array key as a pseudo-id for the cart item
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'product' => $product
                ];
                $cartTotal += $product->price * $item['qty'];
            }
        }

        return view('customer.cart.index', compact('cartItems', 'cartTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $request->qty;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'qty' => $request->qty,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $request->qty;
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully');
    }

    public function destroy($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }
}
