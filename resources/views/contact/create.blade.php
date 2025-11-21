@extends('layout')

@section('title','Contact Us')

@section('content')
<h1>Contact Us</h1>

<form method="post" action="{{ route('contact.store') }}">
    @csrf
    <div class="mb-3">
        <label>Your name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
        <label>Message</label>
        <textarea name="message" class="form-control" rows="5" required></textarea>
    </div>
    <button class="btn btn-primary">Send Message</button>
</form>
@endsection
