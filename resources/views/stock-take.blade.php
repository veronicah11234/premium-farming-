@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Stock Take</h3>

    <table class="table table-bordered">
        <tr><th>Item</th><th>Store</th><th>Quantity</th><th>Price</th></tr>

        @foreach($stocks as $s)
        <tr>
            <td>{{ $s->item->name }}</td>
            <td>{{ $s->store->name }}</td>
            <td>{{ $s->qty }}</td>
            <td>{{ $s->item->price }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
