@extends('pos.layout')

@section('title', $product->name)

@section('content')
<div class="card shadow-sm p-4">
    <img src="{{ asset($product->image) }}" style="width: 300px;">
    <h3 class="mt-3">{{ $product->name }}</h3>
    <p>{{ $product->description }}</p>
    <p class="fw-bold">KES {{ number_format($product->price, 2) }}</p>

    <a href="/shop" class="btn btn-secondary">Back</a>
</div>
@endsection
