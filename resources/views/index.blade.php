@extends('layout')

@section('title','Products')

@section('content')

<h1 class="mb-4" style="font-weight: 800; color:#0d47a1;">Our Products</h1>

<div class="row">
    @foreach($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">

            {{-- Product Image --}}
            <img 
                src="{{ asset($product->image ?? 'images/default.jpg') }}" 
                alt="{{ $product->name }}"
                class="card-img-top"
                style="height: 220px; object-fit: cover; border-radius: 8px;"
            >

            <div class="card-body">

                {{-- Product Name --}}
                <h5 class="card-title" style="font-weight: 700; color:#0d47a1;">
                    {{ $product->name }}
                </h5>

                {{-- SKU --}}
                @if($product->sku)
                <p class="text-muted">SKU: {{ $product->sku }}</p>
                @endif

                {{-- Description --}}
                <p class="card-text text-muted">
                    {{ Str::limit($product->description, 120) }}
                </p>

                {{-- Price --}}
                <p class="fw-bold" style="font-size: 18px; color:#0d47a1;">
                    KES {{ number_format($product->price, 2) }}
                </p>

                {{-- Quantity --}}
                <p class="text-success">Available: {{ $product->quantity }}</p>

                {{-- View Details Button --}}
                <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">
                    View Details
                </a>

            </div>

        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $products->links() }}
</div>

@endsection
