@extends('layout')

@section('title','Create Product')

@section('content')
<h1>Create Product</h1>

<form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>SKU (optional)</label>
        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
        @error('sku')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Price (KES)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price',0) }}" required>
        @error('price')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" value="{{ old('quantity',0) }}" required>
        @error('quantity')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        @error('description')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label>Image (jpg/png)</label>
        <input type="file" name="image" class="form-control">
        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <button class="btn btn-primary">Create</button>
</form>
@endsection
