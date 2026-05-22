@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Product Details</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Category:</strong> {{ ucfirst($product->category) }}</p>
            <!-- <p><strong>Buying Price:</strong> KSh {{ number_format($product->buying_price, 2) }}</p> -->
            <p><strong>Selling Price:</strong> KSh {{ number_format($product->selling_price, 2) }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }} {{ $product->unit }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
        </div>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
