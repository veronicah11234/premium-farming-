@extends('layouts')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold">Orders</h2>

    {{-- If $orders is empty --}}
    @if($orders->isEmpty())
        <div class="alert alert-info text-center py-3">
            No orders available.
        </div>
    @else

        <table class="table table-hover table-bordered align-middle">

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
                            <span class="fw-medium">{{ $order->customer->name ?? 'Unknown' }}</span>
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
</div>
@endsection
