@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Clients</h3>

    <form method="POST" action="{{ route('clients.store') }}">
        @csrf
        <input type="text" name="name" class="form-control mb-2" placeholder="Client Name">
        <input type="text" name="phone" class="form-control mb-2" placeholder="Phone">
        <button class="btn btn-primary">Save</button>
    </form>

    <hr>

    <table class="table table-bordered mt-2">
        <tr><th>Name</th><th>Phone</th></tr>
        @foreach($clients as $c)
        <tr>
            <td>{{ $c->name }}</td>
            <td>{{ $c->phone }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
