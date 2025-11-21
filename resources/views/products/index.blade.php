@extends('layout')

@section('title','Products')

@section('content')
<h1>Products</h1>
<div class="row">
    @foreach($products as $product)
    <div class="col-md-4 mb-3">
        <div class="card h-100">

            {{-- Display product image --}}
            @if($product->image)
            <img src="{{ asset('images/kienyeji.jpeg' . $product->image) }}" 
                 class="card-img-top"
                 alt="{{ $product->name }}"
                 style="height: 200px; object-fit: cover;">
            @else
            {{-- Default image if none uploaded --}}
            <img src="{{ asset('images/dairyhigh.jpeg') }}" 
                 class="card-img-top"
                 style="height: 200px; object-fit: cover;">
            @endif

            <div class="card-body">
                <h5>{{ $product->name }}</h5>
                <p>{{ Str::limit($product->description, 120) }}</p>
                <p><strong>KES {{ number_format($product->price, 2) }}</strong></p>
                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">View</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{ $products->links() }}
@endsection
