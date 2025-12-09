@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')

<div class="container py-5">

    <h2 class="fw-bold text-primary mb-4">Checkout</h2>

    <div class="row g-4">

        <!-- Billing Form -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-red">
                    <h5 class="mb-0">Billing Details</h5>
                </div>

                <div class="card-body">

                    <form>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="Enter your full name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" placeholder="07XX XXX XXX">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location / Address</label>
                            <input type="text" class="form-control" placeholder="Delivery location">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select class="form-select">
                                <option>M-Pesa</option>
                                <option>Cash on Delivery</option>
                                <option>Bank Transfer</option>
                            </select>
                        </div>

                        <button class="btn btn-success w-100 py-2">Place Order</button>

                    </form>

                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-red">
                    <h5 class="mb-0">Order Summary</h5>
                </div>

                <div class="card-body">

                    <ul class="list-group mb-3">

                        @foreach($cart as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $item['name'] }}</strong>
                                    <br>
                                    <small class="text-muted">x{{ $item['quantity'] }}</small>
                                </div>
                                <span>
                                    Ksh {{ number_format($item['quantity'] * $item['price']) }}
                                </span>
                            </li>
                        @endforeach

                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <span class="fw-bold">Grand Total</span>
                            <strong class="text-primary">Ksh {{ number_format($grandTotal) }}</strong>
                        </li>

                    </ul>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
