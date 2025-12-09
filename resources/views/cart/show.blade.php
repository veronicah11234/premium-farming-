@extends('layouts.shop')

@section('content')
<div class="container mt-4">

    <a href="{{ route('cart.index') }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow-lg">
        <div class="row g-0">

            <div class="col-md-4">
                <img src="{{ asset('storage/' . $cartItem->image) }}" class="img-fluid rounded-start">
            </div>

            <div class="col-md-8">
                <div class="card-body">

                    <h3 class="card-title">{{ $cartItem->name }}</h3>

                    <p class="card-text">
                        <strong>Price:</strong> Ksh {{ number_format($cartItem->price) }} <br>
                        <strong>Quantity:</strong> {{ $cartItem->quantity }} <br>
                        <strong>Total:</strong> Ksh {{ number_format($cartItem->price * $cartItem->quantity) }}
                    </p>

                    <a href="{{ route('cart.edit', $cartItem->id) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Remove</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
