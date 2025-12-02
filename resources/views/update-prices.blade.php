@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Stores / Branches</h3>

    <form method="POST" action="{{ route('stores.store') }}">
        @csrf
        <input type="text" name="name" class="form-control mb-2" placeholder="Store Name (Ikinu / Githiga / Turitu)">
        <button class="btn btn-primary">Add Store</button>
    </form>

    <hr>

    <table class="table table-bordered mt-2">
        <tr><th>Store</th><th>Actions</th></tr>
        @foreach($stores as $store)
        <tr>
            <td>{{ $store->name }}</td>
            <td><button class="btn btn-info btn-sm">Edit</button></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
