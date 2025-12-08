@extends('layouts.app')

@section('content')

<div class="container py-10">

    <!-- Page Header -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-green-700 mb-2 drop-shadow">
            Contact Us
        </h1>
        <p class="text-gray-600 text-lg">
            We value your feedback and are here to assist you anytime.
        </p>
    </div>

    <!-- Contact Info + Form -->
    <div class="grid md:grid-cols-2 gap-12">

        <!-- Contact Information -->
        <div class="bg-gradient-to-br from-blue-50 via-white to-green-50 p-8 rounded-3xl shadow-2xl border border-green-300">
            <h3 class="text-3xl font-bold text-blue-800 mb-6">
                Get In Touch
            </h3>

            <div class="space-y-4 text-gray-700">
                <p><strong class="text-black">Phone:</strong> 0790 641 428</p>
                <p><strong class="text-black">Email:</strong> premiumfeeds@gmail.com</p>
                <p><strong class="text-black">Location:</strong> Nairobi, Kenya</p>

                <p class="text-gray-700 mt-4 italic">
                    Our customer support team responds within
                    <span class="font-semibold text-green-700">24 hours</span>.
                </p>
            </div>

            <img src="{{ asset('images/contact.jpg') }}"
                 class="rounded-2xl shadow-xl w-full object-cover h-64 mt-6 border border-green-300">
        </div>

        <!-- Contact Form -->
        <div class="bg-white p-8 rounded-3xl shadow-2xl border border-blue-200">
            <h3 class="text-3xl font-bold text-blue-800 mb-6">
                Send Us a Message
            </h3>

            <form action="#" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-gray-700 mb-1 font-semibold">Your Name</label>
                    <input type="text"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 mb-1 font-semibold">Email Address</label>
                    <input type="email"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 mb-1 font-semibold">Message</label>
                    <textarea rows="5"
                              class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600"></textarea>
                </div>

                <button class="bg-green-700 text-red px-8 py-3 rounded-xl shadow-lg hover:bg-green-800 transition font-semibold">
                    Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- ⭐ Customer Reviews Section -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold text-green-700 mb-6 border-l-4 border-green-700 pl-3">
            Customer Reviews
        </h2>

        <div class="grid md:grid-cols-3 gap-8">

            <!-- Review 1 -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-green-100 hover:shadow-xl transition">
                <h4 class="font-bold text-blue-800 text-lg mb-1">James (Dairy Farmer)</h4>
                <p class="text-yellow-500 mb-2 text-lg">★★★★★</p>
                <p class="text-gray-600">“The feeds improved milk production. Highly recommended!”</p>
            </div>

            <!-- Review 2 -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-green-100 hover:shadow-xl transition">
                <h4 class="font-bold text-blue-800 text-lg mb-1">Mary (Poultry Farmer)</h4>
                <p class="text-yellow-500 mb-2 text-lg">★★★★★</p>
                <p class="text-gray-600">“My broilers gained weight faster than ever before.”</p>
            </div>

            <!-- Review 3 -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl transition">
                <h4 class="font-bold text-blue-800 text-lg mb-1">Kelvin (Pig Farmer)</h4>
                <p class="text-yellow-500 mb-2 text-lg">★★★★☆</p>
                <p class="text-gray-600">“Clean feeds, fast delivery, and very affordable.”</p>
            </div>

        </div>
    </div>

    <!-- ⭐ Leave a Review -->
    <div class="mt-16 bg-gradient-to-br from-gray-100 via-white to-green-100 p-10 rounded-3xl shadow-inner border border-green-300">
        <h2 class="text-3xl font-bold text-green-700 mb-4">
            Leave a Review
        </h2>

        <p class="mb-6 text-gray-700 text-lg">
            Share your experience with Premium Farming Feeds:
        </p>

        <form action="#" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 font-semibold">Full Name</label>
                <input type="text" class="w-full border border-gray-300 rounded-lg p-3">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 font-semibold">Your Review</label>
                <textarea rows="4" class="w-full border border-gray-300 rounded-lg p-3"></textarea>
            </div>

            <button class="bg-blue-700 text-black px-8 py-3 rounded-xl shadow-lg hover:bg-blue-800 transition font-semibold">
                Submit Review
            </button>
        </form>
    </div>

</div>

@endsection
