@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Orders</h2>

    {{-- If $orders is empty --}}
    @if($orders->isEmpty())
        <div class="alert alert-info">
            No orders available.
        </div>
    @else

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_number ?? 'N/A' }}</td>
                    <td>
                        @if($order->customer)
                            {{ $order->customer->name ?? 'Unknown' }}
                        @else
                            No customer
                        @endif
                    </td>

                    <td>KES {{ number_format($order->total, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
</div>
@endsection
