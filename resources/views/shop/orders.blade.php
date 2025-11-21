@extends('layouts.shop')

@section('title', 'Orders')

@section('content')
<h1 class="text-2xl font-bold mb-4">Orders</h1>

<table class="min-w-full bg-white rounded shadow">
    <thead class="bg-green-100">
        <tr>
            <th class="py-2 px-4">Order ID</th>
            <th class="py-2 px-4">Customer</th>
            <th class="py-2 px-4">Total</th>
            <th class="py-2 px-4">Status</th>
            <th class="py-2 px-4">Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="border-t">
            <td class="py-2 px-4">{{ $order->id }}</td>
            <td class="py-2 px-4">{{ $order->customer->name ?? 'N/A' }}</td>
            <td class="py-2 px-4">Ksh {{ $order->total }}</td>
            <td class="py-2 px-4">{{ $order->status ?? 'Pending' }}</td>
            <td class="py-2 px-4">{{ $order->created_at->format('d-M-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
