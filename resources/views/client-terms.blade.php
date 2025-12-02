@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Client Terms</h3>

    <form method="POST" action="{{ route('client.terms.update') }}">
        @csrf
        <select name="client_id" class="form-control mb-2">
            @foreach($clients as $client)
            <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>

        <input type="number" name="limit" class="form-control mb-2" placeholder="Credit Limit">
        <input type="number" name="balance" class="form-control mb-2" placeholder="Balance">

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
