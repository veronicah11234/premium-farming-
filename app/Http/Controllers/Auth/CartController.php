<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Here you can implement adding to cart logic, session or database cart
        return redirect()->back()->with('success', 'Product added to cart!');
    }
}
