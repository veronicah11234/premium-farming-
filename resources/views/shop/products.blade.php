@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="container py-4">

    <h2 class="text-center mb-4">Our Products</h2>

    <div class="row">

        <!-- Product 1 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <img src="{{ asset('images/dairyhigh.jpeg') }}" 
                     class="card-img-top img-fluid"
                     style="height: 220px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title">Dairy Meal</h5>
                    <p class="card-text">High-quality feed specially formulated for dairy cows.</p>

                    <h6 class="text-success fw-bold mb-3">Ksh 2,500</h6>

                    <form action="/cart/add" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="1">
                        <button class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <img src="{{ asset('images/kienyeji.jpeg') }}" 
                     class="card-img-top img-fluid"
                     style="height: 220px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title">Layers Mash</h5>
                    <p class="card-text">Nutritious feed designed for improved egg production.</p>

                    <h6 class="text-success fw-bold mb-3">Ksh 1,800</h6>

                    <form action="/cart/add" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="2">
                        <button class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <img src="{{ asset('images/dairy.jpeg') }}" 
                     class="card-img-top img-fluid"
                     style="height: 220px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title">Dairymeal</h5>
                    <p class="card-text">Balanced nutrition feed for growing pigs.</p>

                    <h6 class="text-success fw-bold mb-3">Ksh 2,450</h6>

                    <form action="/cart/add" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="3">
                        <button class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
