@extends('layouts.shop')

@section('title', 'Reports')

@section('content')
<h1 class="text-2xl font-bold mb-4">Reports</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-4 rounded shadow text-center">
        <h2 class="font-bold text-xl text-green-700">Total Sales</h2>
        <p class="text-gray-600 mt-2">Ksh {{ $totalSales ?? 0 }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow text-center">
        <h2 class="font-bold text-xl text-green-700">Total Orders</h2>
        <p class="text-gray-600 mt-2">{{ $totalOrders ?? 0 }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow text-center">
        <h2 class="font-bold text-xl text-green-700">Total Customers</h2>
        <p class="text-gray-600 mt-2">{{ $totalCustomers ?? 0 }}</p>
    </div>
</div>
@endsection
