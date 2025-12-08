<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Display cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Add product to cart
    public function add(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);

        // If item already exists, increase quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Add new item
            $cart[$id] = [
                "name" => $request->name,
                "quantity" => 1,
                "price" => $request->price,
                "image" => $request->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function increment(Request $request)
{
    $cart = session()->get('cart', []);

    $id = $request->id;

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += 1;
    }

    session()->put('cart', $cart);

    return response()->json(['success' => true, 'quantity' => $cart[$id]['quantity']]);
}


public function decrement(Request $request)
{
    $cart = session()->get('cart', []);

    $id = $request->id;

    if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
        $cart[$id]['quantity'] -= 1;
    }

    session()->put('cart', $cart);

    return response()->json(['success' => true, 'quantity' => $cart[$id]['quantity']]);
}


    // Remove a single product
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed');
    }

    // Clear cart
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }


}
