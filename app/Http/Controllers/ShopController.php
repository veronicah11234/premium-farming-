<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Show all products for online shop
    public function index() {
        $products = Product::all();
        return view('shop.index', ['products' => $products, 'mode' => 'shop']);
    }
    

    // Show single product page
    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }

    public function products() {
        $products = Product::all();
        return view('shop.products', ['products' => $products, 'mode' => 'shop']);
    }
    
    public function orders() {
        $orders = Order::with('customer')->get();
        return view('shop.orders', ['orders' => $orders, 'mode' => 'shop']);
    }
    
    public function customers() {
        $customers = Customer::all();
        return view('shop.customers', ['customers' => $customers, 'mode' => 'shop']);
    }
    
    public function reports() {
        $totalSales = Order::sum('total');
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        return view('shop.reports', compact('totalSales','totalOrders','totalCustomers'))->with('mode', 'shop');
    }
}

