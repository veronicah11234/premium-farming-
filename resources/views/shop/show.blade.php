@extends('layouts.shop')

@section('title', 'Shop Home')

@section('content')

<!-- INTRO SECTION -->
<div class="mb-10">
    <h1 class="text-3xl font-bold text-green-700 mb-3">
        Welcome to Premium Farming Feeds Online Shop
    </h1>

    <p class="text-gray-700 text-lg leading-relaxed">
        At Premium Farming Feeds, we provide high–quality feeds designed to improve animal health,
        boost productivity, and support farmers across Kenya.  
        Explore our premium selection for poultry, dairy cows, pigs and more.
    </p>
</div>

<!-- IMAGE SHOWCASE -->
<h2 class="text-2xl font-semibold text-green-700 mt-8 mb-4">Our Company in Action</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">

    <img src="{{ asset('images/counter.jpg') }}" class="rounded shadow h-56 w-full object-cover">
    <img src="{{ asset('images/counter3.jpeg') }}" class="rounded shadow h-56 w-full object-cover">

    <img src="{{ asset('images/transport1.jpeg') }}" class="rounded shadow h-56 w-full object-cover">
    <img src="{{ asset('images/transport2.jpeg') }}" class="rounded shadow h-56 w-full object-cover">
    <img src="{{ asset('images/trasport3.jpeg') }}" class="rounded shadow h-56 w-full object-cover">

</div>

<!-- VIDEO SECTION -->
<h2 class="text-2xl font-semibold text-green-700 mt-8 mb-4">Animals Feeding on Our Products</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

    <video controls class="rounded shadow w-full h-64 object-cover">
        <source src="{{ asset('images/all feeds.mov') }}" type="video/mp4">
    </video>

    <video controls class="rounded shadow w-full h-64 object-cover">
        <source src="{{ asset('images/chicken eating.mov') }}" type="video/mp4">
    </video>

    <video controls class="rounded shadow w-full h-64 object-cover">
        <source src="{{ asset('images/chicken 2.mov') }}" type="video/mp4">
    </video>

    <video controls class="rounded shadow w-full h-64 object-cover">
        <source src="{{ asset('images/cows eating.mov') }}" type="video/mp4">
    </video>

    <video controls class="rounded shadow w-full h-64 object-cover">
        <source src="{{ asset('images/pig eating.mov') }}" type="video/mp4">
    </video>

</div>

<!-- PRODUCT LISTING -->
<h2 class="text-2xl font-semibold text-green-700 mb-4">Our Products</h2>

<section class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($products as $product)
    <div class="bg-white rounded shadow hover:shadow-lg transition p-4">
        <img src="{{ asset($product->image ?? 'images/default.jpg') }}"
             class="h-40 w-full object-cover rounded">

        <h3 class="font-bold text-lg mt-2">{{ $product->name }}</h3>

        <p class="text-gray-600 mt-1 text-sm">
            {{ Str::limit($product->description, 100) }}
        </p>

        <div class="mt-3 font-bold text-green-700">
            KES {{ number_format($product->price, 2) }}
        </div>

        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button class="mt-4 w-full bg-green-700 text-white py-2 rounded hover:bg-green-800">
                Add to Cart
            </button>
        </form>
    </div>
    @endforeach
</section>

@endsection
