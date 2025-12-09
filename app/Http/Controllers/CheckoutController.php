<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get the cart from session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $grandTotal = 0;
        foreach ($cart as $item) {
            $grandTotal += $item['quantity'] * $item['price'];
        }

        return view('checkout.index', compact('cart', 'grandTotal'));
    }
}
