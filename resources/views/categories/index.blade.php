@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Feed Categories</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <a href="{{ url('/shop/categories/' . $category->slug) }}" 
               class="block p-5 border rounded-lg shadow hover:shadow-lg transition">

                <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                     class="w-full h-40 object-cover rounded">

                <h2 class="text-xl font-semibold mt-4">{{ $category->name }}</h2>

                <p class="text-gray-600 mt-1">{{ $category->description }}</p>
            </a>
        @endforeach
    </div>
</div>
@endsection
