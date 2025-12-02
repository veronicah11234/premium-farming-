@extends('layouts.app')
@section('content')
<div class="container">
<h2>Create Invoice</h2>


<form action="{{ route('invoices.store') }}" method="POST">
@csrf


<div class="mb-3">
<label>Client</label>
<select name="client_id" class="form-control" required>
<option value="">-- Select Client --</option>
@foreach($clients as $client)
<option value="{{ $client->id }}">{{ $client->name }}</option>
@endforeach
</select>
</div>


<div class="mb-3">
<label>Invoice Date</label>
<input type="date" class="form-control" name="invoice_date" required>
</div>


<div class="mb-3">
<label>Total Amount</label>
<input type="number" step="0.01" class="form-control" name="total" required>
</div>


<button type="submit" class="btn btn-primary">Save Invoice</button>
</form>
</div>
@endsection