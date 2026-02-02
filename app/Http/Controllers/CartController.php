<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * View cart page
     */
    public function view()
    {
        return view('shop.cart');
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // Get product details (you can fetch from Django API or use hardcoded data)
        $product = $this->getProductById($request->product_id);

        if (!$product) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }
            return redirect()->back()->with('error', 'Product not found');
        }

        // Get current cart from session
        $cart = session()->get('cart', []);

        // If product already exists in cart, update quantity
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            // Add new product to cart
            $cart[$request->product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'] ?? $product['unit_price'] ?? 0,
                'quantity' => $request->quantity,
                'image' => $product['image'] ?? null,
                'unit' => $product['unit'] ?? 'unit',
                'description' => $product['description'] ?? '',
            ];
        }

        // Save cart to session
        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Get cart count
     */
    public function count(Request $request)
    {
        $cart = session()->get('cart', []);
        $count = count($cart);
        $total = 0;

        foreach ($cart as $item) {
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        return response()->json([
            'success' => true,
            'count' => $count,
            'total' => $total
        ]);
    }

    /**
     * Increment cart item quantity
     */
    public function increment(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'index' => 'required|integer'
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            session()->put('cart', $cart);

            $itemTotal = $cart[$productId]['price'] * $cart[$productId]['quantity'];

            return response()->json([
                'success' => true,
                'quantity' => $cart[$productId]['quantity'],
                'item_total' => number_format($itemTotal, 0)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }

    /**
     * Decrement cart item quantity
     */
    public function decrement(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'index' => 'required|integer'
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->id;

        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
                session()->put('cart', $cart);

                $itemTotal = $cart[$productId]['price'] * $cart[$productId]['quantity'];

                return response()->json([
                    'success' => true,
                    'quantity' => $cart[$productId]['quantity'],
                    'item_total' => number_format($itemTotal, 0),
                    'message' => 'Quantity decreased'
                ]);
            } else {
                // Remove item if quantity would be 0
                unset($cart[$productId]);
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'removed' => true,
                    'message' => 'Item removed from cart'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'index' => 'required|integer'
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared'
            ]);
        }

        return redirect()->route('products')->with('success', 'Cart cleared successfully');
    }

    /**
     * Get product by ID (hardcoded for now, can be replaced with Django API call)
     */
    private function getProductById($id)
    {
        // Hardcoded products (same as ProductController)
        $products = [
            1 => [
                'id' => 1,
                'name' => 'Layers Mash Premium',
                'description' => 'High-quality feed for laying hens',
                'unit_price' => 3500.00,
                'price' => 3500.00,
                'unit' => '50kg bag',
                'stock' => 150,
                'image' => asset('images/products/layers-mash.jpg')
            ],
            2 => [
                'id' => 2,
                'name' => 'Broiler Starter',
                'description' => 'Starter feed for broiler chicks',
                'unit_price' => 4200.00,
                'price' => 4200.00,
                'unit' => '50kg bag',
                'stock' => 200,
                'image' => asset('images/products/broiler-starter.jpg')
            ],
            3 => [
                'id' => 3,
                'name' => 'Dairy Meal 16%',
                'description' => 'Balanced dairy feed',
                'unit_price' => 2800.00,
                'price' => 2800.00,
                'unit' => '70kg bag',
                'stock' => 100,
                'image' => asset('images/products/dairy-meal.jpg')
            ],
            4 => [
                'id' => 4,
                'name' => 'Pig Grower Pellets',
                'description' => 'Nutritious pellets for growing pigs',
                'unit_price' => 3800.00,
                'price' => 3800.00,
                'unit' => '50kg bag',
                'stock' => 80,
                'image' => asset('images/products/pig-grower.jpg')
            ],
            5 => [
                'id' => 5,
                'name' => 'Pig Starter Crumbs',
                'description' => 'Premium starter feed for piglets',
                'unit_price' => 4500.00,
                'price' => 4500.00,
                'unit' => '50kg bag',
                'stock' => 60,
                'image' => asset('images/products/pig-starter.jpg')
            ],
            6 => [
                'id' => 6,
                'name' => 'Kienyeji Chicken Feed',
                'description' => 'Natural feed for free-range chickens',
                'unit_price' => 3200.00,
                'price' => 3200.00,
                'unit' => '50kg bag',
                'stock' => 120,
                'image' => asset('images/products/kienyeji-feed.jpg')
            ],
            7 => [
                'id' => 7,
                'name' => 'Dog Premium Adult',
                'description' => 'Complete nutrition for adult dogs',
                'unit_price' => 5500.00,
                'price' => 5500.00,
                'unit' => '20kg bag',
                'stock' => 45,
                'image' => asset('images/products/dog-food.jpg')
            ],
            8 => [
                'id' => 8,
                'name' => 'Maize Bran',
                'description' => 'Quality maize bran',
                'unit_price' => 1800.00,
                'price' => 1800.00,
                'unit' => '90kg bag',
                'stock' => 250,
                'image' => asset('images/products/maize-bran.jpg')
            ],
            9 => [
                'id' => 9,
                'name' => 'Wheat Bran',
                'description' => 'Fresh wheat bran',
                'unit_price' => 2200.00,
                'price' => 2200.00,
                'unit' => '90kg bag',
                'stock' => 180,
                'image' => asset('images/products/wheat-bran.jpg')
            ],
            10 => [
                'id' => 10,
                'name' => 'Broiler Finisher',
                'description' => 'High-energy feed for broilers',
                'unit_price' => 4000.00,
                'price' => 4000.00,
                'unit' => '50kg bag',
                'stock' => 175,
                'image' => asset('images/products/broiler-finisher.jpg')
            ],
            11 => [
                'id' => 11,
                'name' => 'Calf Starter Pellets',
                'description' => 'Nutritious pellets for weaned calves',
                'unit_price' => 5200.00,
                'price' => 5200.00,
                'unit' => '50kg bag',
                'stock' => 90,
                'image' => asset('images/products/calf-starter.jpg')
            ],
            12 => [
                'id' => 12,
                'name' => 'Cat Premium Adult',
                'description' => 'Complete balanced diet for adult cats',
                'unit_price' => 4800.00,
                'price' => 4800.00,
                'unit' => '15kg bag',
                'stock' => 35,
                'image' => asset('images/products/cat-food.jpg')
            ]
        ];

        return $products[$id] ?? null;

        /* 
        // OR fetch from Django API:
        try {
            $response = Http::withOptions(['verify' => false])
                ->get(config('services.django.url') . '/api/public/products/' . $id . '/');
            
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Error fetching product: ' . $e->getMessage());
        }
        
        return null;
        */
    }
}