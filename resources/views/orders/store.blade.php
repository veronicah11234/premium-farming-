@extends('layouts.shop')

@section('title', 'Add Order')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4 fw-bold">Add New Order</h2>

    <div class="bg-white shadow rounded p-4">

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            {{-- Select Customer --}}
            <div class="mb-3">
                <label class="fw-semibold">Customer</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">-- select customer --</option>

                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }} ({{ $customer->phone ?? '-' }})
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Total Amount --}}
            <div class="mb-3">
                <label class="fw-semibold">Order Total (KES)</label>
                <input 
                    type="number" 
                    name="total" 
                    class="form-control" 
                    placeholder="Enter total amount" 
                    required
                    step="0.01"
                >
            </div>

            {{-- Order Status --}}
            <div class="mb-3">
                <label class="fw-semibold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-success px-4 fw-bold">
                Save Order
            </button>

            <a href="{{ route('shop.orders') }}" class="btn btn-secondary px-4 ms-2">
                Cancel
            </a>

        </form>

    </div>

</div>

@endsection
