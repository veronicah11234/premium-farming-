@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">{{ $category->name }} Feeds</h1>

    <p class="text-gray-700 mb-6">{{ $category->description }}</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach ($items as $item)
        <div class="border rounded shadow p-4">
            <img src="{{ asset('storage/' . $item->image) }}"
                 class="w-full h-40 object-cover rounded">

            <h3 class="text-xl font-semibold mt-3">{{ $item->name }}</h3>

            <p class="text-gray-600">{{ $item->description }}</p>

            <p class="font-bold text-green-700 mt-2">Ksh {{ number_format($item->price,2) }}</p>

            <button class="mt-3 bg-blue-600 text-white px-3 py-1 rounded">
                Add to Cart
            </button>
        </div>
    @endforeach
    </div>

</div>
@endsection
