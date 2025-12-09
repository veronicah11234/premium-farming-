@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-primary mb-3">✏ Edit Item</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('items.update', $item->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" value="{{ $item->sku }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Item Name</label>
                    <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (KES)</label>
                    <input type="number" name="price" value="{{ $item->price }}" class="form-control" step="0.01" required>
                </div>

                <button class="btn btn-primary">Update Item</button>
                <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>

            </form>

        </div>
    </div>
</div>
@endsection
