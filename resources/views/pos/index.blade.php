@extends('pos.layout')

@section('title', 'Dashboard')

@section('content')
<h1 class="mb-4">POS Dashboard</h1>
<p>Welcome to the POS dashboard. Use the sidebar to navigate between categories, item master, transactions, and reports.</p>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card p-3 shadow-sm text-center">
            <h5>Pos</h5>
            {{-- <p>Total: 5</p> --}}
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 shadow-sm text-center">
            <h5>Categories</h5>
            <p>Total: 5</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 shadow-sm text-center">
            <h5>Items</h5>
            <p>Total: 50</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 shadow-sm text-center">
            <h5>Sales Today</h5>
            <p>KES 120,000</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 shadow-sm text-center">
            <h5>Stock Level</h5>
            <p>150 Items</p>
        </div>
    </div>
</div>
@endsection
