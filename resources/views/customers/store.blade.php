@extends('layouts.shop')

@section('title', 'Customer Saved')

@section('content')

<div class="bg-white shadow rounded-lg p-6 text-center">

    <h1 class="text-2xl font-bold text-green-700 mb-3">Customer Added Successfully</h1>

    <p class="text-gray-600 mb-6">
        The new customer has been saved to the system.
    </p>

    <a href="{{ route('customers.index') }}"
        class="bg-green-700 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-800 transition">
        Back to Customers
    </a>

</div>

@endsection
