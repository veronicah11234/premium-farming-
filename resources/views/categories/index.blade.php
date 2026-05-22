@extends('layouts.app')

@section('title', 'Feed Categories | Premium Farming Feeds')

@section('content')

<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">
        Feed Categories
    </h1>

    {{-- Category Dropdown --}}
    <div class="mb-8">

        <select
            class="w-full border rounded px-4 py-3"
            onchange="if(this.value) window.location.href=this.value"
        >

            <option value="">
                Select Category
            </option>

            @foreach ($categories as $category)

                <option
                    value="{{ url('/api/category/' . $category['slug']) }}"
                >
                    {{ $category['name'] }}
                </option>

            @endforeach

        </select>

    </div>


    {{-- Categories Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($categories as $category)

            <a
                href="{{ url('/api/category/' . $category['slug']) }}"
                class="block p-5 border rounded-lg shadow hover:shadow-lg transition bg-white"
            >

                {{-- Category Image --}}
                <img
                    src="{{ $category['image'] ?? 'https://via.placeholder.com/400x300?text=Category' }}"
                    alt="{{ $category['name'] }}"
                    class="w-full h-40 object-cover rounded"
                >

                {{-- Category Name --}}
                <h2 class="text-xl font-semibold mt-4">
                    {{ $category['name'] }}
                </h2>

                {{-- Description --}}
                <p class="text-gray-600 mt-1">
                    {{ $category['description'] ?? '' }}
                </p>

            </a>

        @endforeach

    </div>

</div>

@endsection