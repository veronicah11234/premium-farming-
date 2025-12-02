@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">

    <!-- Top Section: Profile + Search -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-6">

        <!-- Profile Image -->
        <div class="flex items-center space-x-4 mb-4 md:mb-0">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                 class="w-20 h-20 rounded-full shadow-md" />

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ Auth::user()->name }}
                </h2>
                <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Search Box -->
        <div class="w-full md:w-1/2">
            <input
                type="text"
                placeholder="Search..."
                class="w-full p-3 border rounded-lg shadow-sm focus:ring focus:ring-blue-300"
            >
        </div>

    </div>

    <!-- Video Section -->
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="text-xl font-semibold mb-3">Your Video</h3>

        <video controls class="w-full rounded-lg shadow">
            <source src="/videos/sample.mp4" type="video/mp4">
            Your browser does not support video playback.
        </video>
    </div>

</div>
@endsection
