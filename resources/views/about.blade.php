@extends('layouts.app')

@section('title', 'About Premium Farming Feeds')

@section('content')

<!-- =============================== -->
<!--          HERO SECTION          -->
<!-- =============================== -->
<section class="bg-green-800 text-black py-20">
    <div class="max-w-6xl mx-auto px-6 text-center">

        <h1 class="text-4xl md:text-5xl font-bold tracking-wide">
            About Premium Farming Feeds
        </h1>

        <p class="mt-4 text-lg opacity-90">
            Quality • Nutrition • Growth
        </p>

    </div>
</section>



<!-- =============================== -->
<!--        COMPANY OVERVIEW        -->
<!-- =============================== -->
<section class="py-16 bg-b">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

        <!-- Image -->
        <div>
            <img src="{{ asset('images/ikinu prem.jpeg') }}" 
                 class="rounded-xl shadow-lg w-full" 
                 alt="Feed Production">
        </div>

        <!-- Text -->
        <div>
            <h2 class="text-3xl font-bold text-green-700 mb-4">
                Who We Are
            </h2>

            <p class="text-gray-700 leading-relaxed text-lg">
                Premium Farming Feeds is a trusted manufacturer of high-quality livestock feeds 
                designed to support optimal animal growth, health, and productivity.
            </p>

            <p class="text-gray-700 leading-relaxed text-lg mt-4">
                Our products are formulated using advanced techniques, strict quality standards, 
                and nutritional expertise to ensure farmers receive reliable and consistent feed 
                for their animals.
            </p>
        </div>

    </div>
</section>



<!-- =============================== -->
<!--        MISSION & VISION        -->
<!-- =============================== -->
<section class="py-16 bg-gray-100">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10">

        <!-- Mission -->
        <div class="bg-white p-8 rounded-xl shadow">
            <h3 class="text-2xl font-bold text-green-800 mb-3">
                Our Mission
            </h3>

            <p class="text-gray-700 text-lg leading-relaxed">
                To provide farmers with nutritious, consistent, and affordable feeds 
                that improve livestock performance and farm profitability.
            </p>
        </div>

        <!-- Vision -->
        <div class="bg-white p-8 rounded-xl shadow">
            <h3 class="text-2xl font-bold text-green-800 mb-3">
                Our Vision
            </h3>

            <p class="text-gray-700 text-lg leading-relaxed">
                To become Kenya’s leading provider of quality livestock feed through 
                innovation, excellence, and customer trust.
            </p>
        </div>

    </div>
</section>
<br>


<!-- =============================== -->
<!--        CORE VALUES           -->
<!-- =============================== -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-center text-green-800 mb-12">
            Our Core Values
        </h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">

            <div class="p-6 bg-gray-50 rounded-xl shadow text-center">
                <h4 class="font-bold text-red-700">Quality</h4>
                <p class="text-gray-600 mt-2 text-sm">
                    We deliver only the best feed products.
                </p>
            </div>

            <div class="p-6 bg-gray-50 rounded-xl shadow text-center">
                <h4 class="font-bold text-green-700">Integrity</h4>
                <p class="text-gray-600 mt-2 text-sm">
                    Honest service and transparent processes.
                </p>
            </div>

            <div class="p-6 bg-gray-50 rounded-xl shadow text-center">
                <h4 class="font-bold text-green-700">Innovation</h4>
                <p class="text-gray-600 mt-2 text-sm">
                    Modern solutions for modern farming.
                </p>
            </div>

            <div class="p-6 bg-gray-50 rounded-xl shadow text-center">
                <h4 class="font-bold text-green-700">Farmer Support</h4>
                <p class="text-gray-600 mt-2 text-sm">
                    Partnership with farmers at every step.
                </p>
            </div>

        </div>
    </div>
</section>

@endsection
