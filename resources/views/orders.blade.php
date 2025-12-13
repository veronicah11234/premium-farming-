@extends('layouts.shop')

@section('title', 'Orders')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold">Orders</h2>

    {{-- ========================= --}}
    {{-- Create New Order Form --}}
    {{-- ========================= --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white fw-bold">
            Create New Order
        </div>

        <div class="card-body">

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="row mb-3">

                    {{-- Customer --}}
                    <div class="col-md-4">
                        <label class="fw-semibold">Select Customer</label>
                        <select name="customer_id" class="form-select" required>
                            <option value="">-- choose customer --</option>

                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }} ({{ $customer->phone ?? 'No phone' }})
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Total Amount --}}
                    <div class="col-md-4">
                        <label class="fw-semibold">Total Amount (KES)</label>
                        <input type="number" step="0.01" name="total" 
                               class="form-control" placeholder="Enter total amount" required>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="fw-semibold">Order Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                </div>

                <button type="submit" class="btn btn-success px-4 fw-bold">
                    Save Order
                </button>

            </form>

        </div>
    </div>


    {{-- ========================= --}}
    {{-- Orders Table --}}
    {{-- ========================= --}}
    @if($orders->isEmpty())
        <div class="alert alert-info text-center py-3">
            No orders available.
        </div>
    @else

        <table class="table table-hover table-bordered align-middle shadow-sm mb-5">

            <thead class="table-dark">
                <tr>
                    <th class="text-center">Order #</th>
                    <th>Customer</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Date</th>
                </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td class="text-center fw-semibold">{{ $order->order_number ?? 'N/A' }}</td>

                    <td>
                        @if($order->customer)
                            <span class="fw-medium">{{ $order->customer->name }}</span>
                        @else
                            <span class="text-muted">No customer</span>
                        @endif
                    </td>

                    <td class="text-center fw-bold text-success">
                        KES {{ number_format($order->total, 2) }}
                    </td>

                    <td class="text-center">
                        <span class="badge bg-primary px-3 py-2">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td class="text-center">
                        {{ $order->created_at->format('d M Y') }}
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    @endif


    {{-- ========================= --}}
    {{-- CUSTOMERS WITH THEIR ORDERS --}}
    {{-- ========================= --}}
    <h3 class="fw-bold mt-5 mb-3">Customers & Their Orders</h3>

    <table class="table table-bordered shadow-sm">
        <thead class="table-success">
            <tr>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total Orders</th>
                <th>Last Order Date</th>
            </tr>
        </thead>

        <tbody>
        @foreach($customers as $customer)
            <tr>
                <td class="fw-semibold">{{ $customer->name }}</td>
                <td>{{ $customer->phone ?? 'N/A' }}</td>
                <td>{{ $customer->orders->count() }}</td>
                <td>
                    @if($customer->orders->count() > 0)
                        {{ $customer->orders->last()->created_at->format('d M Y') }}
                    @else
                        <i>No orders</i>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection
