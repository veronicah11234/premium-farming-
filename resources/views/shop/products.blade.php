@extends('layouts.shop')

@section('title', 'Manage Products')

@section('content')
<h1 class="text-2xl font-bold mb-4">Manage Products</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($products as $product)
        <div class="bg-white p-4 rounded shadow hover:shadow-lg transition">
            <img src="{{ $product->image ?? asset('images/default.jpg') }}" class="h-40 w-full object-cover rounded">
            <h3 class="font-bold text-lg mt-2">{{ $product->name }}</h3>
            <p class="text-gray-600 mt-1">{{ Str::limit($product->description, 100) }}</p>
            <div class="mt-3 font-bold text-green-700">Ksh {{ $product->price }}</div>
            <button class="mt-4 w-full bg-green-700 text-white py-2 rounded hover:bg-green-800">
                Edit
            </button>
        </div>
    @endforeach
</div>
@endsection
