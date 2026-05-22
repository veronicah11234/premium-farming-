<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Categories Listing
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $apiUrl = config('services.django_api.url');

        $response = Http::get(
            $apiUrl . '/api/categories/'
        );

        if (!$response->successful()) {
            abort(500, 'Unable to load categories');
        }

        $categories = $response->json();

        return view('categories.index', [
            'categories' => $categories
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Single Category Products
    |--------------------------------------------------------------------------
    */

    public function show($slug)
    {
        $apiUrl = config('services.django_api.url');

        $response = Http::get(
            $apiUrl . '/api/public/products/',
            [
                'category' => $slug
            ]
        );

        if (!$response->successful()) {
            abort(500, 'Unable to load products');
        }

        $products = $response->json();

        return view('categories.show', [
            'products' => $products,
            'slug' => $slug
        ]);
    }
}