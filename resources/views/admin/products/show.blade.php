@extends('layout')

@section('title', $product->name)

@section('content')

<div class="card shadow-sm p-4">
    <img src="{{ $product->image ? asset($product->image) : asset('images/default.jpg') }}"
         alt="{{ $product->name }}"
         style="width:100%; max-height:450px; object-fit:cover; border-radius:10px;">

    <h2 class="mt-3" style="font-weight: 800; color:#0d47a1;">{{ $product->name }}</h2>

    @if($product->sku)
    <p class="text-muted">SKU: {{ $product->sku }}</p>
    @endif

    <p style="font-size:18px; font-weight:700; color:#0d47a1;">KES {{ number_format($product->price, 2) }}</p>

    <p style="color:#444; font-size:16px;">{{ $product->description }}</p>

    <p class="text-success">Available: {{ $product->quantity }}</p>

    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back to Products</a>
</div>

@endsection
