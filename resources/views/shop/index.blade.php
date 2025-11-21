@extends('layouts.shop')

@section('title', 'Shop Home')

@section('content')

<h1 class="text-3xl font-bold text-green-700 mb-6">Welcome to Premium Farming Feeds Online Shop</h1>
<p class="text-gray-600 mb-8">Order high-quality feeds easily & quickly! We provide the best feed in Kenya for your livestock: chickens, pigs, cows, and more.</p>

<section class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($products as $product)
    <div class="bg-white rounded shadow hover:shadow-lg transition p-4">
        <img src="{{ asset($product->image ?? 'images/default.jpg') }}" 
             class="h-40 w-full object-cover rounded">
        <h3 class="font-bold text-lg mt-2">{{ $product->name }}</h3>
        <p class="text-gray-600 mt-1 text-sm">{{ Str::limit($product->description, 100) }}</p>
        <div class="mt-3 font-bold text-green-700">KES {{ number_format($product->price, 2) }}</div>
        <button class="mt-4 w-full bg-green-700 text-white py-2 rounded hover:bg-green-800">
            Add to Cart
        </button>
    </div>
    @endforeach
</section>

@endsection
