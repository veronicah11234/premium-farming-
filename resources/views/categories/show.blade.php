@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">{{ $category->name }} Feeds</h1>

    <p class="text-gray-700 mb-6">{{ $category->description }}</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($feeds as $feed)
            <div class="p-5 border rounded-lg shadow hover:shadow-lg transition">
                
                <img src="{{ $feed->image }}" 
                     alt="{{ $feed->name }}" 
                     class="w-full h-40 object-cover rounded">

                <h2 class="text-xl font-semibold mt-4">{{ $feed->name }}</h2>

                <p class="text-gray-600 mt-2">{{ $feed->description }}</p>

                <p class="text-green-700 font-bold mt-3">
                    Ksh {{ number_format($feed->price) }}
                </p>

                <button class="mt-4 w-full bg-green-700 text-white px-4 py-2 rounded">
                    Add to Cart
                </button>
            </div>
        @endforeach
    </div>

</div>
@endsection
