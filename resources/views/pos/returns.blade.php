@extends('layouts.app')
@section('content')
<div class="container">
<h2>POS Return</h2>


<form action="{{ route('pos_returns.store') }}" method="POST">
@csrf


<div class="mb-3">
<label>Sale (Receipt Number)</label>
<select name="sale_id" class="form-control">
@foreach($sales as $sale)
<option value="{{ $sale->id }}">Receipt #{{ $sale->id }} - Ksh {{ $sale->total }}</option>
@endforeach
</select>
</div>


<div class="mb-3">
<label>Reason for Return</label>
<textarea name="reason" class="form-control" required></textarea>
</div>


<div class="mb-3">
<label>Amount Returned</label>
<input type="number" step="0.01" name="amount_returned" class="form-control" required>
</div>


<button class="btn btn-danger">Process Return</button>
</form>
</div>
@endsection