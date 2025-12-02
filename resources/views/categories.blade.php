@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Categories</h3>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <input type="text" name="name" class="form-control mb-2" placeholder="Category Name">
        <button class="btn btn-primary">Save</button>
    </form>

    <hr>

    <h5>All Categories</h5>
    <table class="table table-bordered mt-2">
        <tr><th>Name</th><th>Actions</th></tr>
        @foreach($categories as $cat)
        <tr>
            <td>{{ $cat->name }}</td>
            <td><a class="btn btn-info btn-sm">Edit</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
