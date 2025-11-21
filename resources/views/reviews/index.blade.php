@extends('layout')

@section('title','Reviews & Testimonials')

@section('content')
<h1>Customer Reviews</h1>

<div class="mb-4">
    <form method="post" action="{{ route('reviews.store') }}">
        @csrf
        <div class="mb-2">
            <input type="text" name="name" class="form-control" placeholder="Your name" required>
        </div>
        <div class="mb-2">
            <select name="rating" class="form-control">
                <option value="5">5 — Excellent</option>
                <option value="4">4 — Very good</option>
                <option value="3">3 — Good</option>
                <option value="2">2 — Fair</option>
                <option value="1">1 — Poor</option>
            </select>
        </div>
        <div class="mb-2">
            <textarea name="comment" class="form-control" placeholder="Your review" rows="3" required></textarea>
        </div>
        <button class="btn btn-success">Submit Review</button>
    </form>
</div>

@foreach($reviews as $r)
    <div class="card mb-2">
        <div class="card-body">
            <strong>{{ $r->name }}</strong> — <small>{{ $r->created_at->format('d M Y') }}</small>
            <p>Rating: {{ $r->rating }} / 5</p>
            <p>{{ $r->comment }}</p>
        </div>
    </div>
@endforeach

{{ $reviews->links() }}
@endsection
