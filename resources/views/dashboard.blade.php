@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<h1 class="text-3xl font-bold text-gray-700 mb-6">
    Welcome to Your Dashboard
</h1>

<!-- VIDEO SECTION -->
<h2 class="text-xl font-semibold text-gray-600 mb-3">Featured Videos</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

    <div class="bg-white shadow rounded p-3">
        <video controls class="w-full rounded">
            <source src="{{ asset('videos/video1.mp4') }}" type="video/mp4">
        </video>
        <p class="mt-2 text-gray-600 font-medium">How to Feed Dairy Cows</p>
    </div>

    <div class="bg-white shadow rounded p-3">
        <video controls class="w-full rounded">
            <source src="{{ asset('videos/video2.mp4') }}" type="video/mp4">
        </video>
        <p class="mt-2 text-gray-600 font-medium">Healthy Chicken Feeding Guide</p>
    </div>

    <div class="bg-white shadow rounded p-3">
        <video controls class="w-full rounded">
            <source src="{{ asset('videos/video3.mp4') }}" type="video/mp4">
        </video>
        <p class="mt-2 text-gray-600 font-medium">Boosting Animal Nutrition</p>
    </div>

</div>

<!-- IMAGE SECTION -->
<h2 class="text-xl font-semibold text-gray-600 mt-10 mb-3">Featured Images</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">

    <div class="bg-white shadow p-2 rounded">
        <img src="{{ asset('images/feed1.jpg') }}" class="rounded w-full">
    </div>

    <div class="bg-white shadow p-2 rounded">
        <img src="{{ asset('images/feed2.jpg') }}" class="rounded w-full">
    </div>

    <div class="bg-white shadow p-2 rounded">
        <img src="{{ asset('images/feed3.jpg') }}" class="rounded w-full">
    </div>

    <div class="bg-white shadow p-2 rounded">
        <img src="{{ asset('images/feed4.jpg') }}" class="rounded w-full">
    </div>

</div>

@endsection
