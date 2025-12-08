@extends('layouts.app')

@section('title', 'My Cart')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-4 text-primary">My Cart</h2>

    @if(count($cart) == 0)
        <p class="text-muted">Your cart is empty.</p>
    @else
        <table class="table table-bordered shadow-sm align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @php $grandTotal = 0; @endphp

                @foreach($cart as $id => $item)
                    @php 
                        $total = $item['price'] * $item['quantity'];
                        $grandTotal += $total;
                    @endphp

                    <tr>
                        <!-- Product Image -->
                        <td><img src="{{ asset($item['image']) }}" width="70" class="rounded"></td>

                        <!-- Name -->
                        <td>{{ $item['name'] }}</td>

                        <!-- Quantity Section -->
                        <td>
                            <div class="d-flex align-items-center">

                                <!-- Decrease -->
                                <form action="{{ route('cart.decrement') }}" method="POST" class="me-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button class="btn btn-outline-secondary btn-sm">-</button>
                                </form>

                                <!-- Manual Input -->
                                <form action="{{ route('cart.update') }}" method="POST" class="mx-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                           class="form-control form-control-sm text-center"
                                           min="1" style="width: 70px;">
                                </form>

                                <!-- Increase -->
                                <form action="{{ route('cart.increment') }}" method="POST" class="ms-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button class="btn btn-outline-secondary btn-sm">+</button>
                                </form>

                            </div>
                        </td>

                        <!-- Price -->
                        <td>Ksh {{ number_format($item['price']) }}</td>

                        <!-- Total -->
                        <td>Ksh {{ number_format($total) }}</td>

                        <!-- Remove -->
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button class="btn btn-danger btn-sm">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Grand Total -->
        <h4 class="fw-bold">Grand Total: Ksh {{ number_format($grandTotal) }}</h4>

        <!-- Clear Cart -->
        <form action="{{ route('cart.clear') }}" method="POST" class="mt-3">
            @csrf
            <button class="btn btn-warning">Clear Cart</button>
        </form>

    @endif
</div>

@endsection
