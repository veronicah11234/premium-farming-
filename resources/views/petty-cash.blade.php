@extends('layouts.app')
@section('content')
<div class="container">
<h2>Petty Cash Entry</h2>


<form action="{{ route('petty_cash.store') }}" method="POST">
@csrf


<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" required></textarea>
</div>


<div class="mb-3">
<label>Type</label>
<select name="type" class="form-control">
<option value="expense">Expense</option>
<option value="reimbursement">Reimbursement</option>
</select>
</div>


<div class="mb-3">
<label>Amount</label>
<input type="number" step="0.01" name="amount" class="form-control" required>
</div>


<button class="btn btn-primary">Save</button>
</form>
</div>
@endsection