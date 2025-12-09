@extends('layouts.shop')

@section('title', 'My Cart')

@section('content')

<style>
    /* GLOBAL PAGE BEAUTIFICATION */
    .cart-container {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .cart-table th {
        background: #0d6efd !important;
        color: #fff !important;
        font-size: 15px;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .cart-table td {
        vertical-align: middle !important;
        padding: 18px 12px !important;
    }

    .cart-img {
        width: 75px;
        height: 75px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    /* REMOVE BUTTON (strong red) */
    .btn-remove {
        background: #e02424 !important;
        border-color: #e02424 !important;
        color: #fff !important;
        font-weight: 600;
        border-radius: 8px;
        padding: 6px 14px;
        transition: .2s;
    }

    .btn-remove:hover {
        background: #b91c1c !important;
        border-color: #b91c1c !important;
    }

    /* QTY BUTTONS */
    .qty-btn {
        background: #e9ecef;
        border-radius: 8px;
        padding: 4px 10px;
        font-size: 18px;
        font-weight: bold;
    }

    .grand-total-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    /* CLEAR CART — premium warning style */
.btn-clear-cart {
    background: linear-gradient(135deg, #ff9f1c, #ff5f1c);
    border: none !important;
    color: #fff !important;
    font-weight: 700;
    padding: 10px 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(255, 96, 26, 0.35);
    transition: 0.25s ease-in-out;
}
.btn-clear-cart:hover {
    background: linear-gradient(135deg, #ff6b00, #ff2d00);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(255, 60, 0, 0.4);
}

/* CHECKOUT — luxurious green gradient */
.btn-checkout {
    background: linear-gradient(135deg, #0bbf69, #009f55);
    border: none !important;
    color: #fff !important;
    font-weight: 700;
    padding: 10px 28px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 150, 90, 0.35);
    transition: 0.25s ease-in-out;
}
.btn-checkout:hover {
    background: linear-gradient(135deg, #00b46a, #008c4e);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 120, 70, 0.4);
}

/* Header Container */
.cart-header {
    background: linear-gradient(to right, #f8f9fa, #eef4ff);
    padding: 18px 22px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
}

/* Title Styling */
.cart-title {
    font-size: 30px !important;
    font-weight: 800 !important;
    color: #0d6efd !important;
    display: flex;
    align-items: center;
    gap: 10px;
}
.cart-title span {
    font-size: 32px;
}

/* Continue Shopping Button */
.btn-continue {
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    border: 2px solid #0d6efd !important;
    color: #0d6efd !important;
    transition: 0.25s ease-in-out;
}

/* Hover */
.btn-continue:hover {
    background: #0d6efd !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13,110,253,0.3);
}



</style>

<div class="container py-5">

    <div class="cart-header mb-4">
    <h2 class="cart-title">
        <span>🛒</span> My Cart
    </h2>

    <a href="{{ route('shop.products') }}" class="btn btn-continue btn-sm">
        ← Continue Shopping
    </a>
</div>


    @if(count($cart) == 0)

        <div class="alert alert-info text-center py-5 rounded shadow-sm">
            <h5 class="fw-bold">Your cart is empty</h5>
            <p>Browse products and add items to your cart.</p>
        </div>

    @else

        <div class="cart-container mb-4">
            <div class="table-responsive">
                <table class="table table-hover cart-table">
                    <thead>
                        <tr>
                            <th class="text-center">Image</th>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th class="text-center">Actions</th>
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

                            <!-- Image -->
                            <td class="text-center">
                                <img src="{{ asset($item['image']) }}" class="cart-img">
                            </td>

                            <!-- Name -->
                            <td>
                                <strong class="text-dark">{{ $item['name'] }}</strong><br>
                                <small class="text-muted">ID: {{ $id }}</small>
                            </td>

                            <!-- Quantity -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">

                                    <!-- - -->
                                    <form action="{{ route('cart.decrement') }}" method="POST" class="mx-1">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button class="qty-btn">−</button>
                                    </form>

                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="number" name="quantity"
                                               value="{{ $item['quantity'] }}"
                                               min="1"
                                               class="form-control form-control-sm text-center shadow-sm"
                                               style="width: 65px;">
                                    </form>

                                    <!-- + -->
                                    <form action="{{ route('cart.increment') }}" method="POST" class="mx-1">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button class="qty-btn">+</button>
                                    </form>

                                </div>
                            </td>

                            <!-- Price -->
                            <td class="fw-semibold">Ksh {{ number_format($item['price']) }}</td>

                            <!-- Total -->
                            <td class="fw-bold text-success">Ksh {{ number_format($total) }}</td>

                            <!-- Remove -->
                            <td class="text-center">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button class="btn btn-remove">Remove</button>
                                </form>
                            </td>

                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        <!-- GRAND TOTAL -->
        <div class="grand-total-box">
            <h4 class="fw-bold mb-3">
                Grand Total: 
                <span class="text-primary">Ksh {{ number_format($grandTotal) }}</span>
            </h4>

           <div class="d-flex gap-3">

    <!-- Clear -->
    <form action="{{ route('cart.clear') }}" method="POST">
        @csrf
        <button class="btn-clear-cart">Clear Cart</button>
    </form><br>

    <!-- Checkout -->
    <a href="{{ route('checkout') }}" class="btn-checkout">
        Checkout →
    </a>

</div>

        </div>

    @endif
</div>

@endsection
