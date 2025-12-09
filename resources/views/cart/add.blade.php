@extends('layouts.shop')

@section('content')
<div class="container py-5">

    <!-- Page Title -->
    <div class="mb-5">
        <h2 class="text-3xl font-bold text-green-700">Add Item to Cart</h2>
        <p class="text-gray-600">Select product details and add them to your shopping cart.</p>
    </div>

    <!-- Add to Cart Form -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 max-w-xl">
        <form action="{{ route('cart.store') }}" method="POST">
            @csrf

            <!-- Product Name -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Product Name</label>
                <input type="text" name="product_name" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300" placeholder="Enter product name" required>
            </div>

            <!-- Quantity -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Quantity (Kgs or Bags)</label>
                <input type="number" name="quantity" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300" placeholder="Enter quantity" required>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Price (Ksh)</label>
                <input type="number" name="price" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300" placeholder="Enter price" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Description (optional)</label>
                <textarea name="description" rows="3" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300" placeholder="Additional notes..."></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button class="bg-green-700 text-white px-6 py-3 rounded-xl shadow hover:bg-green-800 transition">
                    Add to Cart
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
