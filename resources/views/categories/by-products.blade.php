@extends('layouts.shop')

@section('title', 'Products')

@section('content')

<style>
    body, h1, h2, h3, h4, h5, h6, p, span, a, li, label {
        color: #000 !important;
    }

    .product-title {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #000 !important;
    }

    .scroll-container {
        display: flex;
        gap: 25px;
        overflow-x: auto;
        padding-bottom: 20px;
        scroll-behavior: smooth;
        padding-top: 10px;
    }

    .scroll-container::-webkit-scrollbar {
        height: 8px;
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 20px;
    }

    .scroll-container::-webkit-scrollbar-track {
        background: #f0f0f0;
    }

    .product-card {
        min-width: 320px;
        max-width: 320px;
        border-radius: 12px;
        border: 1px solid #d1d5db;
        background: #fff;
        transition: all .3s ease;
        flex-shrink: 0;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }

    .card-title {
        font-size: 20px;
        font-weight: 800;
        color: #000 !important;
    }

    .card-text {
        font-size: 15px;
        color: #000 !important;
        line-height: 1.6;
    }

    .price-tag {
        font-size: 18px;
        font-weight: 800;
        color: #000 !important;
    }

    .btn-buy {
        background: #065f46;
        font-weight: 700;
        color: #fff !important;
        padding: 10px 0;
        border-radius: 8px;
        letter-spacing: .5px;
    }

    .btn-buy:hover {
        background: #064e3b;
        color: #fff !important;
    }

    .product-img {
        height: 240px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        width: 100%;
    }
</style>

<div class="container py-5">

    <h2 class="text-center mb-4 product-title">Our Products</h2>

    <div class="scroll-container">

        <!-- Product 1 -->
        <div class="product-card">
            <img src="{{ asset('images/dairyhigh.jpeg') }}" class="product-img">

            <div class="p-3">
                <h5 class="card-title">Dairy Meal</h5>
                <p class="card-text">
                    Premium dairy feed formulated to enhance milk production and animal health.
                </p>
                <h6 class="price-tag mb-3">Ksh 2,500</h6>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="1">
                    <input type="hidden" name="name" value="Dairy Meal">
                    <input type="hidden" name="price" value="2500">
                    <input type="hidden" name="image" value="images/dairyhigh.jpeg">

                    <button class="btn btn-buy w-100">Add to Cart</button>
                </form>
            </div>
        </div>

        <!-- Product 2 -->
        {{-- <div class="product-card">
            <img src="{{ asset('images/kienyeji.jpeg') }}" class="product-img">

            <div class="p-3">
                <h5 class="card-title">Layers Mash</h5>
                <p class="card-text">
                    High-performance nutritious feed that boosts egg production.
                </p>
                <h6 class="price-tag mb-3">Ksh 1,800</h6>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="2">
                    <input type="hidden" name="name" value="Layers Mash">
                    <input type="hidden" name="price" value="1800">
                    <input type="hidden" name="image" value="images/kienyeji.jpeg">

                    <button class="btn btn-buy w-100">Add to Cart</button>
                </form>
            </div>
        </div> --}}

        <!-- Product 3 -->
        <div class="product-card">
            <img src="{{ asset('images/dairy.jpeg') }}" class="product-img">

            <div class="p-3">
                <h5 class="card-title">Dairymeal</h5>
                <p class="card-text">
                    High-quality feed formulated for optimal nutrition and livestock growth.
                </p>
                <h6 class="price-tag mb-3">Ksh 2,450</h6>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="3">
                    <input <input type="hidden" name="name" value="Dairymeal">
                    <input type="hidden" name="price" value="2450">
                    <input type="hidden" name="image" value="images/dairy.jpeg">

                    <button class="btn btn-buy w-100">Add to Cart</button>
                </form>
            </div>
        </div>

    </div>

</div>

@endsection
