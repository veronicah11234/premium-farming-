@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Stock Level Report</h3>

    <table class="table table-bordered">
        <tr><th>Item</th><th>Store</th><th>Qty Available</th></tr>

        @foreach($stocks as $s)
        <tr>
            <td>{{ $s->item->name }}</td>
            <td>{{ $s->store->name }}</td>
            <td>{{ $s->qty }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
