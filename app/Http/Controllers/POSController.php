<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;

class POSController extends Controller
{
    // POS Home (Dashboard)
    public function index()
    {
        $products = Product::where('quantity', '>', 0)->get();

        return view('home', [
            'mode' => 'pos',
            'products' => $products
        ]);
    }

    // POS Sell page
    public function sell()
    {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.sell', ['mode' => 'pos', 'products' => $products]);
    }

    // Store a sale
    public function storeSale(Request $request)
{
    $data = $request->validate([
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.discount' => 'nullable|numeric|min:0',
        'items.*.vat_mode' => 'required|string',
        'items.*.price_type' => 'nullable|string',
        'items.*.bonus' => 'nullable|numeric|min:0',
        'items.*.batch' => 'nullable|string',
        'items.*.cost_center' => 'nullable|string',
    ]);

    // Create sale
    $sale = Sale::create([
        'user_id' => auth()->id(),
        'total' => collect($data['items'])->sum(function($i){
            return ($i['quantity'] * $i['unit_price']) - ($i['discount'] ?? 0);
        }),
    ]);

    // Save sale items
    foreach ($data['items'] as $item) {
        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'discount' => $item['discount'] ?? 0,
            'vat_mode' => $item['vat_mode'],
            'price_type' => $item['price_type'] ?? 'retail',
            'bonus' => $item['bonus'] ?? 0,
            'batch' => $item['batch'] ?? null,
            'cost_center' => $item['cost_center'] ?? null,
        ]);
    }

    // 🔥 Redirect to receipt after saving
    return redirect()->route('sales.receipt', $sale->id);
}

    // POS Modules --------------------------

    public function categories() {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.categories', ['mode' => 'pos', 'products' => $products]);
    }

    public function items() {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.items', ['mode' => 'pos', 'products' => $products]);
    }

    public function stores() {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.stores', ['mode' => 'pos', 'products' => $products]);
    }

    public function updatePrices() {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.update-prices', ['mode' => 'pos', 'products' => $products]);
    }

    public function goodsReceived() {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.goods-received', ['mode' => 'pos', 'products' => $products]);
    }

    public function returns() {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.returns', ['mode' => 'pos', 'products' => $products]);
    }

    public function issues() {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.issues', ['mode' => 'pos', 'products' => $products]);
    }

    public function stockTake() {
        $products = Product::where('quantity', '>', 0)->get();
        return view('pos.stock-take', ['mode' => 'pos', 'products' => $products]);
    }

    // Reports (These pages do NOT need products)
    public function bestSeller() {
        return view('pos.best-seller', ['mode' => 'pos']);
    }

    public function goodsReceivedReport() {
        return view('pos.goods-received-report', ['mode' => 'pos']);
    }

    public function issuedStock() {
        return view('pos.issued-stock', ['mode' => 'pos']);
    }

    public function stockLevel() {
        return view('pos.stock-level', ['mode' => 'pos']);
    }

    // Client management
    public function clients() {
        return view('pos.clients', ['mode' => 'pos']);
    }

    public function clientTerms() {
        return view('pos.client-terms', ['mode' => 'pos']);
    }

    public function transactions() {
        return view('pos.transactions', ['mode' => 'pos']);
    }
    public function printReceipt()
{
    $items = [
        ['name' => 'Dairy Meal', 'quantity' => 2, 'price' => 450, 'amount' => 900],
        ['name' => 'Kienyeji Mash', 'quantity' => 1, 'price' => 380, 'amount' => 380],
    ];

    return view('pos.receipt', [
        'receiptNumber' => 'RCP-' . rand(1000,9999),
        'date' => now()->format('d/m/Y H:i'),
        'servedBy' => auth()->user()->name ?? 'Cashier',
        'items' => $items,
        'total' => array_sum(array_column($items, 'amount')),
    ]);
}


}

