@extends('layouts.shop')

@section('title', $product->name)

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    
    <img src="{{ asset($product->image ?? 'images/default.jpg') }}" 
         class="w-full h-72 object-cover rounded mb-4">

    <h2 class="text-3xl font-bold text-blue-900">{{ $product->name }}</h2>

    <p class="text-xl font-semibold text-green-700 mt-2">
        Ksh {{ number_format($product->price, 2) }}
    </p>

    <p class="text-gray-700 mt-4">
        {{ $product->description }}
    </p>

    <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        
        <input type="number" 
               name="quantity" 
               value="1" 
               min="1" 
               class="border rounded p-2 w-24">

        <button class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 ml-2">
            Add to Cart
        </button>
    </form>

    <a href="{{ route('shop.products') }}" 
       class="inline-block mt-4 text-blue-700 hover:underline">
       ← Back to Products
    </a>

</div>

@endsection
