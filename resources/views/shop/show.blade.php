@extends('layout')

@section('title', $product->name)

@section('content')

<div class="card shadow-sm p-4">
    <img src="{{ asset($product->image ?? 'images/default.jpg') }}" 
         class="img-fluid mb-3" style="max-height:350px; object-fit:cover; border-radius:10px;">
    <h2 style="font-weight:800; color:#0d47a1;">{{ $product->name }}</h2>
    <p class="fw-bold" style="font-size:18px; color:#0d47a1;">KES {{ number_format($product->price,2) }}</p>
    <p style="color:#444;">{{ $product->description }}</p>
    
    <form action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="number" name="quantity" class="form-control mb-2" value="1" min="1">
        <button class="btn btn-primary">Add to Cart</button>
    </form>

    <a href="{{ route('shop.index') }}" class="btn btn-secondary mt-3">Back to Shop</a>
</div>

@endsection
