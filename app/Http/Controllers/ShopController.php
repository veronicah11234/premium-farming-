<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;


use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Show all products for online shop
    public function index() {
        $products = \App\Models\Product::all();  // Fetch products from DB
        return view('shop.index', ['products' => $products, 'mode' => 'shop']);
    }
    

    // Show single product page
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('shop.show', compact('product'));
    }
    

    public function products() {
        $products = Product::all();
        return view('shop.products', ['products' => $products, 'mode' => 'shop']);
    }
    
public function orders()
{
    $orders = Order::with('customer')->latest()->get();
    $customers = Customer::with('orders')->get();

    return view('shop.orders', compact('orders', 'customers'));
}



public function category($slug)
{
    $products = Product::where('category_slug', $slug)->get();

    return view('shop.category', [
        'title' => ucfirst($slug) . ' Feeds',
        'products' => $products,
        'slug' => $slug,
    ]);
}



    
    
    public function customers()
{
    $customers = Customer::latest()->get();

    return view('shop.customers', compact('customers'));
}

    
    public function reports() {
        $totalSales = Order::sum('total');
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        return view('shop.reports', compact('totalSales','totalOrders','totalCustomers'))->with('mode', 'shop');
    }
}

