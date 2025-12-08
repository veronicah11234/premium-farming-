@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Edit Cart Item</h2>

    <form action="{{ route('cart.update', $cartItem->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $cartItem->quantity }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('cart.index') }}" class="btn btn-secondary">Cancel</a>

    </form>

</div>
@endsection
