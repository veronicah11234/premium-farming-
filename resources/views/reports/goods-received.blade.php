@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Goods Received Report</h3>

    <form method="GET">
        <input type="date" name="from" class="form-control mb-2">
        <input type="date" name="to" class="form-control mb-2">
        <button class="btn btn-primary">Filter</button>
    </form>

    <table class="table table-bordered mt-3">
        <tr><th>Item</th><th>Store</th><th>Qty</th><th>Date</th></tr>
        @foreach($records as $r)
        <tr>
            <td>{{ $r->item->name }}</td>
            <td>{{ $r->store->name }}</td>
            <td>{{ $r->qty }}</td>
            <td>{{ $r->created_at->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
