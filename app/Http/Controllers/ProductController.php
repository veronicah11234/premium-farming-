<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $djangoUrl = config('services.django_api.url');
        $endpoint  = $djangoUrl . '/public/products/';

        try {
            $response = Http::withOptions([
                'verify'  => false,
                'timeout' => 15,
            ])->withHeaders([
                'ngrok-skip-browser-warning' => 'true', 
                'Accept'                     => 'application/json',
            ])->get($endpoint);

            if ($response->successful()) {
                $json = $response->json();

                $products = collect($json['results'] ?? $json);
            } else {
                $products = collect([]);

                Log::warning('Failed to fetch products from Django API', [
                    'endpoint' => $endpoint,
                    'status'   => $response->status(),
                    'body'     => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            $products = collect([]);

            Log::error('Error fetching products from Django API', [
                'endpoint' => $endpoint,
                'message'  => $e->getMessage(),
            ]);
        }

        return view('shop.products', [
            'products' => $products,
        ]);
    }
}