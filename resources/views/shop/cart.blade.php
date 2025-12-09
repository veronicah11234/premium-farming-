@extends('layouts.shop')

@section('title', 'Products')

@section('content')

<style>
    body, h1, h2, h3, h4, h5, h6, p, td, th, span, label, a {
        color: #000 !important;
    }

    .cart-title {
        font-size: 32px;
        font-weight: 800;
        color: #000 !important;
    }

    .table thead th {
        background: #111 !important;
        color: #fff !important;
        font-size: 15px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .table-bordered {
        border: 1px solid #d1d5db !important;
    }

    .table td, .table th {
        vertical-align: middle !important;
    }

    .qty-input {
        border-radius: 6px;
        border: 1px solid #cbd5e1;
    }

    .btn-update {
        background: #065f46;
        color: #fff;
        font-weight: 700;
        border-radius: 6px;
    }

    .btn-update:hover {
        background: #064e3b;
        color: #fff;
    }

    .btn-remove {
        background: #dc2626;
        color: #fff;
        font-weight: 700;
        border-radius: 6px;
    }

    .btn-remove:hover {
        background: #b91c1c;
        color: #fff;
    }

    .checkout-btn {
        background: #facc15;
        font-weight: 800;
        font-size: 18px;
        color: #000 !important;
        padding: 12px 28px;
        border-radius: 10px;
        border: none;
    }

    .checkout-btn:hover {
        background: #eab308;
        color: #000 !important;
    }

    .empty-cart {
        font-size: 18px;
        font-weight: 600;
        color: #6b7280 !important;
        margin-top: 15px;
    }

    img.cart-img {
        border-radius: 8px;
        border: 1px solid #ddd;
        object-fit: cover;
    }
</style>

<div class="container mt-5">

    <h2 class="mb-4 cart-title">Your Cart</h2>

    @if(count($cart) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle shadow-sm">

                <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($cart as $item)
                    <tr>

                        <!-- Image -->
                        <td>
                            <img src="{{ asset('images/'.$item['image']) }}"
                                 width="90" height="70"
                                 class="cart-img">
                        </td>

                        <!-- Product Name -->
                        <td class="fw-bold">{{ $item['name'] }}</td>

                        <!-- Price -->
                        <td>KES {{ number_format($item['price']) }}</td>

                        <!-- Quantity -->
                        <td>
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="number" name="quantity"
                                       value="{{ $item['quantity'] }}"
                                       class="form-control form-control-sm qty-input w-50 me-2">
                                <button class="btn btn-update btn-sm">Update</button>
                            </form>
                        </td>

                        <!-- Total -->
                        <td class="fw-bold">
                            KES {{ number_format($item['price'] * $item['quantity']) }}
                        </td>

                        <!-- Remove -->
                        <td>
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf
                                <button class="btn btn-remove btn-sm w-100">Remove</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <div class="text-end mt-3">
            <a href="{{ route('checkout') }}" class="checkout-btn">
                Proceed to Checkout →
            </a>
        </div>

    @else
        <p class="empty-cart">Your cart is empty.</p>
    @endif

</div>

@endsection
