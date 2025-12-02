@extends('layouts.app')
@section('content')
<div class="container">
<h2>Create Credit Note</h2>


<form action="{{ route('credit_notes.store') }}" method="POST">
@csrf


<div class="mb-3">
<label>Sale</label>
<select name="sale_id" class="form-control">
@foreach($sales as $sale)
<option value="{{ $sale->id }}">Sale #{{ $sale->id }} - Ksh {{ $sale->total }}</option>
@endforeach
</select>
</div>


<div class="mb-3">
<label>Amount</label>
<input type="number" step="0.01" name="amount" class="form-control" required>
</div>


<div class="mb-3">
<label>Reason</label>
<textarea class="form-control" name="reason" required></textarea>
</div>


<button class="btn btn-warning">Issue Credit Note</button>
</form>
</div>
@endsection