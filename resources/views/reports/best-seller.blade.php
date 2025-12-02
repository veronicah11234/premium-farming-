@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Best Sellers Report</h3>

    <form method="GET">
        <label>Date From</label>
        <input type="date" name="from" class="form-control mb-2">
        <label>Date To</label>
        <input type="date" name="to" class="form-control mb-2">
        <button class="btn btn-primary">Show</button>
    </form>

    <table class="table table-bordered mt-3">
        <tr><th>Item</th><th>Total Sold</th></tr>
        @foreach($bestsellers as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->total }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
