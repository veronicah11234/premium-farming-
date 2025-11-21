<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'delivery_address' => 'nullable|string',
            'delivery_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'delivery_address' => $request->delivery_address,
                'delivery_date' => $request->delivery_date ? Carbon::parse($request->delivery_date) : null,
                'status' => 'pending',
                'total' => 0,
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $qty = (int) $item['quantity'];

                // decrease stock
                if ($product->quantity < $qty) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }
                $product->quantity -= $qty;
                $product->save();

                $lineTotal = $product->price * $qty;
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'line_total' => $lineTotal,
                ]);
                $total += $lineTotal;
            }

            $order->total = $total;
            $order->save();
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    public function index()
    {
        $orders = Order::with('orderItems.product')->orderBy('created_at','desc')->paginate(15);
        return view('orders.index', compact('orders'));
    }
}
