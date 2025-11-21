<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // middleware auth if you have auth: uncomment
    // public function __construct() { $this->middleware('auth'); }

    public function index()
    {
        $products = Product::orderBy('name')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/products', 'public');
            $data['image'] = 'storage/' . $path; // or 'images/products/...' based on preference
        }

        // generate SKU if not provided
        if (empty($data['sku'])) {
            $data['sku'] = strtoupper('PF-' . Str::random(6));
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/products', 'public');
            $data['image'] = 'storage/' . $path;

            // optionally delete old image - implement if needed
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        // optionally delete image file here
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
