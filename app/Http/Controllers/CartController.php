<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get Django API base URL
     */
    private function getDjangoUrl()
    {
        return config('services.django.url');
    }

    /**
     * Get Django API cart endpoint
     */
    private function getCartEndpoint()
    {
        return $this->getDjangoUrl() . '/api/cart/';
    }

    /**
     * View cart page
     */
    public function view()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart');
        }
        
        return view('shop.cart');
    }

    /**
     * Get cart data from Django API (JSON endpoint)
     */
    public function index(Request $request)
    {
        // Check authentication first
        if (!Auth::check()) {
            // Return JSON error for AJAX requests
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'authenticated' => false,
                    'message' => 'Unauthenticated',
                    'items' => [],
                    'total' => 0,
                    'count' => 0
                ], 401);
            }
            
            // Redirect for normal requests
            return redirect()->route('login')->with('error', 'Please login to view your cart');
        }

        $endpoint = $this->getCartEndpoint();

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])->get($endpoint);

            if ($response->successful()) {
                $cartData = $response->json();
                
                // Sync with session for navbar display
                $this->syncSessionCart($cartData);

                return response()->json([
                    'success' => true,
                    'authenticated' => true,
                    'items' => $cartData['items'] ?? [],
                    'total' => $cartData['total'] ?? 0,
                    'count' => $cartData['count'] ?? 0
                ]);
            } else {
                Log::warning('Failed to fetch cart from Django', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                // Fallback to session cart
                return $this->getSessionCart();
            }
        } catch (\Exception $e) {
            Log::error('Error fetching cart from Django', [
                'message' => $e->getMessage(),
            ]);

            // Fallback to session cart
            return $this->getSessionCart();
        }
    }

    /**
     * Add item to cart via Django API
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $endpoint = $this->getCartEndpoint() . 'add/';

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])->post($endpoint, [
                'product' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Update session cart
                $this->addToSessionCart($request->product_id, $request->quantity);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => $data['message'] ?? 'Product added to cart',
                        'cart_count' => $data['count'] ?? 0
                    ]);
                }

                return redirect()->back()->with('success', 'Product added to cart!');
            } else {
                Log::warning('Failed to add to cart via Django', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                // Fallback: Add to session cart
                $this->addToSessionCart($request->product_id, $request->quantity);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Product added to cart'
                    ]);
                }

                return redirect()->back()->with('success', 'Product added to cart!');
            }
        } catch (\Exception $e) {
            Log::error('Error adding to cart', [
                'message' => $e->getMessage(),
            ]);

            // Fallback: Add to session cart
            $this->addToSessionCart($request->product_id, $request->quantity);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart'
                ]);
            }

            return redirect()->back()->with('success', 'Product added to cart!');
        }
    }

    /**
     * Get cart count
     */
    public function count(Request $request)
    {
        // Allow unauthenticated access - return empty cart
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'authenticated' => false,
                'count' => 0,
                'total' => 0
            ]);
        }

        $endpoint = $this->getCartEndpoint() . 'count/';

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->get($endpoint);

            if ($response->successful()) {
                $data = $response->json();
                
                return response()->json([
                    'success' => true,
                    'authenticated' => true,
                    'count' => $data['count'] ?? 0,
                    'total' => $data['total'] ?? 0
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error getting cart count', [
                'message' => $e->getMessage(),
            ]);
        }

        // Fallback to session
        $cart = session()->get('cart', []);
        $count = count($cart);
        $total = 0;

        foreach ($cart as $item) {
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        return response()->json([
            'success' => true,
            'authenticated' => true,
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

        $endpoint = $this->getCartEndpoint() . 'increment/';

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->post($endpoint, [
                'product_id' => $request->id,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Update session
                $this->incrementSessionCart($request->id);

                return response()->json([
                    'success' => true,
                    'quantity' => $data['quantity'] ?? 1,
                    'item_total' => $data['item_total'] ?? 0
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error incrementing cart', [
                'message' => $e->getMessage(),
            ]);
        }

        // Fallback to session
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

        $endpoint = $this->getCartEndpoint() . 'decrement/';

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->post($endpoint, [
                'product_id' => $request->id,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Update session
                $this->decrementSessionCart($request->id);

                return response()->json([
                    'success' => true,
                    'quantity' => $data['quantity'] ?? 0,
                    'item_total' => $data['item_total'] ?? 0,
                    'removed' => ($data['quantity'] ?? 0) == 0,
                    'message' => $data['message'] ?? 'Quantity decreased'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error decrementing cart', [
                'message' => $e->getMessage(),
            ]);
        }

        // Fallback to session
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

        $endpoint = $this->getCartEndpoint() . 'remove/';

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->post($endpoint, [
                'product_id' => $request->id,
            ]);

            if ($response->successful()) {
                // Remove from session
                $this->removeFromSessionCart($request->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error removing from cart', [
                'message' => $e->getMessage(),
            ]);
        }

        // Fallback to session
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
        $endpoint = $this->getCartEndpoint() . 'clear/';

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->post($endpoint);

            if ($response->successful()) {
                session()->forget('cart');

                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Cart cleared'
                    ]);
                }

                return redirect()->route('products')->with('success', 'Cart cleared successfully');
            }
        } catch (\Exception $e) {
            Log::error('Error clearing cart', [
                'message' => $e->getMessage(),
            ]);
        }

        // Fallback
        session()->forget('cart');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared'
            ]);
        }

        return redirect()->route('products')->with('success', 'Cart cleared successfully');
    }

    // ========================================
    // SESSION CART HELPER METHODS (Fallback)
    // ========================================

    /**
     * Get cart from session (fallback)
     */
    private function getSessionCart()
    {
        $cart = session()->get('cart', []);
        $items = array_values($cart);
        $total = 0;

        foreach ($items as $item) {
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        return response()->json([
            'success' => true,
            'authenticated' => true,
            'items' => $items,
            'total' => $total,
            'count' => count($items)
        ]);
    }

    /**
     * Sync Django cart data with session
     */
    private function syncSessionCart($djangoCart)
    {
        $sessionCart = [];
        
        foreach ($djangoCart['items'] ?? [] as $item) {
            $sessionCart[$item['product_id']] = [
                'id' => $item['product_id'],
                'name' => $item['product_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'image' => $item['product_image'] ?? null,
                'unit' => $item['product_unit'] ?? 'unit',
                'description' => $item['product_description'] ?? '',
            ];
        }

        session()->put('cart', $sessionCart);
    }

    /**
     * Add to session cart (fallback)
     */
    private function addToSessionCart($productId, $quantity)
    {
        $product = $this->getProductById($productId);
        
        if (!$product) {
            return;
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['unit_price'] ?? $product['price'] ?? 0,
                'quantity' => $quantity,
                'image' => $product['image'] ?? null,
                'unit' => $product['unit'] ?? 'unit',
                'description' => $product['description'] ?? '',
            ];
        }

        session()->put('cart', $cart);
    }

    /**
     * Increment session cart
     */
    private function incrementSessionCart($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            session()->put('cart', $cart);
        }
    }

    /**
     * Decrement session cart
     */
    private function decrementSessionCart($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            } else {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
        }
    }

    /**
     * Remove from session cart
     */
    private function removeFromSessionCart($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    }

    /**
     * Get product by ID from Django API
     */
    private function getProductById($id)
    {
        $djangoUrl = $this->getDjangoUrl();
        $endpoint = $djangoUrl . '/api/public/products/' . $id . '/';

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->get($endpoint);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Error fetching product', [
                'product_id' => $id,
                'message' => $e->getMessage(),
            ]);
        }

        return null;
    }
}