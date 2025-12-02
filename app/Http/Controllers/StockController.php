<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;

class StockController extends Controller
{
    public function categories() {
        $categories = Category::all();
        $products = Product::all(); // <-- Add this
        return view('pos.categories', compact('categories', 'products'))->with('mode','pos');
    }
    

    public function items() {
        $products = Product::with('category')->paginate(24);
        return view('pos.items', compact('products'))->with('mode','pos');
    }
    public function stores() {
        $stores = Store::all();
        $products = Product::all(); // add this
        return view('pos.stores', compact('stores', 'products'))->with('mode','pos');
    }
    

    public function updatePrices(Request $request) {
        // if GET show form else process update
        if($request->isMethod('post')) {
            $data = $request->validate([
                'product_id' => 'required|exists:products,id',
                'price' => 'required|numeric',
            ]);
            $p = Product::find($data['product_id']);
            $p->price = $data['price'];
            $p->save();
            return back()->with('success','Price updated');
        }
        $products = Product::paginate(30);
        return view('pos.update-prices', compact('products'))->with('mode','pos');
    }

    public function receiveStock(Request $request)
{
    if ($request->isMethod('post')) {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $product = Product::find($data['product_id']);
        $product->quantity += $data['quantity'];
        $product->save();

        return back()->with('success', 'Stock received successfully!');
    }

    $products = Product::all();
    return view('pos.receive-stock', compact('products'))->with('mode','pos');
}

public function sell(Request $request)
{
    $data = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|numeric|min:1',
    ]);

    $product = Product::find($data['product_id']);
    if($product->quantity < $data['quantity']) {
        return back()->with('error', 'Not enough stock!');
    }

    $product->quantity -= $data['quantity'];
    $product->save();

    // Create sale record
    $sale = Sale::create([
        'invoice' => 'INV'.time(),
        'total' => $product->price * $data['quantity'],
        'client_id' => auth()->id(),
    ]);

    $sale->items()->create([
        'product_id' => $product->id,
        'quantity' => $data['quantity'],
        'price' => $product->price,
    ]);

    return back()->with('success', 'Sale completed successfully!');
}


}
