@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Inter-Store Transfers</h3>

    <form action="{{ route('transfers.store') }}" method="POST">
        @csrf

        <label>From Store</label>
        <select name="from_store" class="form-control mb-2">
            @foreach($stores as $store)
            <option>{{ $store->name }}</option>
            @endforeach
        </select>

        <label>To Store</label>
        <select name="to_store" class="form-control mb-2">
            @foreach($stores as $store)
            <option>{{ $store->name }}</option>
            @endforeach
        </select>

        <select name="item_id" class="form-control mb-2">
            @foreach($items as $item)
            <option>{{ $item->name }}</option>
            @endforeach
        </select>

        <input type="number" name="qty" class="form-control mb-2" placeholder="Quantity">

        <button class="btn btn-warning">Transfer</button>
    </form>
</div>
@endsection
