@extends('layouts.app')

@section('title', 'Manage Online Products')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-700">Manage Online Products</h1>

    <a href="{{ route('shop.products.create') }}"
       class="bg-green-700 text-white px-4 py-2 rounded shadow hover:bg-green-800 transition">
        + Add New Product
    </a>
</div>

<!-- PRODUCT TABLE -->
<div class="bg-white shadow rounded p-4">

    <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="p-2 border">Image</th>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Price (KES)</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($products as $product)
                <tr class="hover:bg-gray-50">

                    <!-- Image -->
                    <td class="border p-2 text-center">
                        <img src="{{ asset($product->image) }}"
                             class="h-16 w-16 object-cover mx-auto rounded">
                    </td>

                    <!-- Name -->
                    <td class="border p-2">
                        {{ $product->name }}
                    </td>

                    <!-- Price -->
                    <td class="border p-2 text-green-700 font-bold">
                        KES {{ number_format($product->price) }}
                    </td>

                    <!-- Status -->
                    <td class="border p-2">
                        @if ($product->is_active)
                            <span class="text-green-600 font-bold">Active</span>
                        @else
                            <span class="text-red-500 font-bold">Hidden</span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="border p-2 text-center">

                        <a href="{{ route('shop.products.edit', $product->id) }}"
                           class="text-blue-600 font-semibold hover:underline">
                           Edit
                        </a>

                        <form action="{{ route('shop.products.delete', $product->id) }}"
                              method="POST"
                              class="inline-block ml-2"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600 font-semibold hover:underline">
                                Delete
                            </button>
                        </form>

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
