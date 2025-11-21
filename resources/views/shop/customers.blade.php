@extends('layouts.shop')

@section('title', 'Customers')

@section('content')
<h1 class="text-2xl font-bold mb-4">Customers</h1>

<table class="min-w-full bg-white rounded shadow">
    <thead class="bg-green-100">
        <tr>
            <th class="py-2 px-4">Name</th>
            <th class="py-2 px-4">Email</th>
            <th class="py-2 px-4">Phone</th>
            <th class="py-2 px-4">Joined</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr class="border-t">
            <td class="py-2 px-4">{{ $customer->name }}</td>
            <td class="py-2 px-4">{{ $customer->email }}</td>
            <td class="py-2 px-4">{{ $customer->phone ?? '-' }}</td>
            <td class="py-2 px-4">{{ $customer->created_at->format('d-M-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
