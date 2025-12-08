@extends('layouts.shop')

@section('content')

<!-- Category Header -->
<section class="py-12 px-4 text-center">
    <h1 class="text-4xl font-bold text-green-700 mb-4">
        {{ $category->name }} Feeds
    </h1>
    <p class="text-gray-600 text-lg">
        Browse all {{ $category->name }} related products.
    </p>
</section>

<!-- Product List -->
<section class="px-4 pb-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

        @forelse($products as $product)
            <div class="border rounded-2xl p-5 shadow-xl bg-white hover:shadow-2xl transition">
                
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="w-full h-56 object-cover rounded-xl mb-4">

                <h2 class="text-2xl font-bold text-green-700 mb-2">
                    {{ $product->name }}
                </h2>

                <p class="text-gray-700 mb-3">
                    {{ $product->description }}
                </p>

                <p class="font-semibold text-green-800 text-xl">
                    Ksh {{ number_format($product->price) }}
                </p>

            </div>
        @empty

            <p class="text-center text-gray-600 col-span-3">
                No products found for this category.
            </p>

        @endforelse

    </div>
</section>

@endsection
