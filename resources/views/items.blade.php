@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Item Master</h3>

    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        <input type="text" name="name" class="form-control mb-2" placeholder="Item Name">
        <input type="number" name="price" class="form-control mb-2" placeholder="Price">
        <select name="category_id" class="form-control mb-2">
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary">Save</button>
    </form>

    <hr>

    <h5>All Items</h5>
    <table class="table table-bordered">
        <tr><th>Name</th><th>Category</th><th>Price</th><th>Actions</th></tr>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->category->name }}</td>
            <td>{{ $item->price }}</td>
            <td><button class="btn btn-info btn-sm">Edit</button></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
