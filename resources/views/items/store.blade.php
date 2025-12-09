@extends('layouts.app')

@section('title', 'Create Item')

@section('content')

<style>
    .form-card {
        max-width: 550px;
        margin: auto;
        border-radius: 15px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.1);
        background: #ffffff;
    }

    .form-card h3 {
        font-weight: 700;
        color: #0d6efd;
    }

    .btn-save {
        background: #0d6efd;
        font-weight: bold;
        color: #fff;
        border-radius: 10px;
        padding: 10px 20px;
        width: 100%;
        transition: .2s;
    }
    .btn-save:hover {
        background: #084298;
    }

    .btn-back {
        border-radius: 10px;
        font-weight: 600;
    }
</style>

<div class="container py-5">

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2 class="fw-bold text-primary">➕ Add New Item</h2>
        <a href="{{ route('items.index') }}" class="btn btn-secondary btn-back">
            ← Back to Items
        </a>
    </div>

    <div class="card form-card p-4">

        <h3 class="text-center mb-4">Create Item</h3>

        <form action="{{ route('items.store') }}" method="POST">
            @csrf

            <!-- SKU -->
            <div class="mb-3">
                <label class="form-label fw-semibold">SKU</label>
                <input type="text" name="sku" class="form-control form-control-lg" placeholder="Enter SKU" required>
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Item Name</label>
                <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter item name" required>
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Price (KES)</label>
                <input type="number" name="price" step="0.01" class="form-control form-control-lg" placeholder="Enter price" required>
            </div>

            <!-- Submit -->
            <button class="btn btn-save mt-3">Save Item</button>

        </form>

    </div>
</div>

@endsection
