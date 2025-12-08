@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="container py-4">

    <h2 class="text-center mb-4 fw-bold text-primary">Our Products</h2>

    <div class="row">

        <!-- Product 1 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">

                <img src="{{ asset('images/dairyhigh.jpeg') }}" 
                     class="card-img-top img-fluid"
                     style="height: 220px; object-fit: cover;">

                <div class="card-body">

                    <h5 class="card-title fw-bold">Dairy Meal</h5>
                    <p class="card-text">High-quality feed specially formulated for dairy cows.</p>

                    <h6 class="text-success fw-bold mb-3">Ksh 2,500</h6>

                    <!-- Updated Cart Form -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="1">
                        <input type="hidden" name="name" value="Dairy Meal">
                        <input type="hidden" name="price" value="2500">
                        <input type="hidden" name="image" value="images/dairyhigh.jpeg">

                        <button class="btn btn-success w-100">
                            Add to Cart
                        </button>
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

                    <h5 class="card-title fw-bold">Layers Mash</h5>
                    <p class="card-text">Nutritious feed designed for improved egg production.</p>

                    <h6 class="text-success fw-bold mb-3">Ksh 1,800</h6>

                    <!-- Updated Cart Form -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="2">
                        <input type="hidden" name="name" value="Layers Mash">
                        <input type="hidden" name="price" value="1800">
                        <input type="hidden" name="image" value="images/kienyeji.jpeg">

                        <button class="btn btn-success w-100">
                            Add to Cart
                        </button>
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

                    <h5 class="card-title fw-bold">Dairymeal</h5>
                    <p class="card-text">Balanced nutrition feed for growing pigs.</p>

                    <h6 class="text-success fw-bold mb-3">Ksh 2,450</h6>

                    <!-- Updated Cart Form -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="3">
                        <input type="hidden" name="name" value="Dairymeal">
                        <input type="hidden" name="price" value="2450">
                        <input type="hidden" name="image" value="images/dairy.jpeg">

                        <button class="btn btn-success w-100">
                            Add to Cart
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
