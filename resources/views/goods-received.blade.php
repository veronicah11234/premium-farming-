@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Goods Received</h3>

    <form method="POST" action="{{ route('goods.store') }}">
        @csrf

        <select name="store_id" class="form-control mb-2">
            @foreach($stores as $store)
            <option value="{{ $store->id }}">{{ $store->name }}</option>
            @endforeach
        </select>

        <select name="item_id" class="form-control mb-2">
            @foreach($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>

        <input type="number" name="qty" class="form-control mb-2" placeholder="Quantity">
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
