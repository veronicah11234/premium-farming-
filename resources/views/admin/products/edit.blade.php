@extends('layout')

@section('title','Edit Product')

@section('content')
<h1>Edit Product</h1>

<form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>SKU (optional)</label>
        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
        @error('sku')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Price (KES)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        @error('price')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" required>
        @error('quantity')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
        @error('description')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Image (jpg/png)</label>
        <input type="file" name="image" class="form-control">
        <div class="mt-2">
            <small>Current:</small><br>
            <img src="{{ $product->image ? asset($product->image) : asset('images/default.jpg') }}" style="height:80px; object-fit:cover;">
        </div>
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
