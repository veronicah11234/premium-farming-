@extends('layouts.shop')

@section('title', 'Customers')

@section('content')

<h1 class="text-2xl font-bold mb-6">Customers</h1>

{{-- Create Customer Form --}}
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4 text-green-700">Add New Customer</h2>

    <form action="{{ route('customers.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold mb-1">Full Name</label>
            <input type="text" name="name" required
                   class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block font-semibold mb-1">Email Address</label>
            <input type="email" name="email" required
                   class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block font-semibold mb-1">Phone Number</label>
            <input type="text" name="phone"
                   class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block font-semibold mb-1">Address</label>
            <input type="text" name="address"
                   class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit"
            style="background-color:#dc2626; color:black;"
            class="px-5 py-2 rounded-lg font-bold hover:bg-red-700 transition">
            Save Customer
        </button>

    </form>
</div>

{{-- Customers Table --}}
<table class="min-w-full bg-white rounded shadow">
    <thead class="bg-green-100">
        <tr>
            <th class="py-2 px-4 text-left">ID</th>
            <th class="py-2 px-4 text-left">Name</th>
            <th class="py-2 px-4 text-left">Email</th>
            <th class="py-2 px-4 text-left">Phone</th>
            <th class="py-2 px-4 text-left">Address</th>
            <th class="py-2 px-4 text-left">Joined</th>
            <th class="py-2 px-4 text-left">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($customers as $customer)
        <tr class="border-t">
            <td class="py-2 px-4">{{ $customer->id }}</td>
            <td class="py-2 px-4">{{ $customer->name }}</td>
            <td class="py-2 px-4">{{ $customer->email }}</td>
            <td class="py-2 px-4">{{ $customer->phone ?? '-' }}</td>
            <td class="py-2 px-4">{{ $customer->address ?? '-' }}</td>
            <td class="py-2 px-4">{{ $customer->created_at->format('d-M-Y') }}</td>

            {{-- Delete Button --}}
            <td class="py-2 px-4">
                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this customer?')">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

@endsection
