@extends('layouts.shop')

@section('title', 'Shop Home')

@section('content')
<style>
    /* Slider Wrapper */
    #staffSlider {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 10px;
        scrollbar-width: none; /* Firefox */
    }
    #staffSlider::-webkit-scrollbar {
        display: none; /* Chrome */
    }

    /* Each Team Card */
    .team-card {
        flex-shrink: 0;
        width: 220px; /* Perfect size */
        text-align: center;
    }

    /* Image Styling */
    .team-card img {
        width: 100%;
        height: 310px;
        object-fit: cover;
        border-radius: 18px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.3);
    }

    /* Name + Role */
    .team-name {
        font-weight: bold;
        margin-top: 8px;
        color: #0d4e14; /* Deep green */
    }
    .team-role {
        color: #444;
        font-size: 14px;
    }

    /* Auto Slide Effect */
    @keyframes autoSlide {
        0% { transform: translateX(0); }
        50% { transform: translateX(-40%); }
        100% { transform: translateX(0); }
    }
    #staffSlider {
        animation: autoSlide 12s infinite linear;
    }
         /* Smooth slider animation */
    @keyframes slide {
        0%   { transform: translateX(0); }
        33%  { transform: translateX(-33.33%); }
        66%  { transform: translateX(-66.66%); }
        100% { transform: translateX(0); }
    }

    .slider-container {
        overflow: hidden;
        width: 100%;
        position: relative;
    }

    .slider-track {
        display: flex;
        gap: 2rem;
        animation: slide 12s infinite ease-in-out;
    }

    .slider-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        width: 320px;
        flex-shrink: 0;
        padding-bottom: 15px;
        text-align: center;
    }

    .slider-image,
    .slider-video {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #065f46; /* green-700 */
        margin-top: 10px;
    }

    .subtitle {
        font-size: 0.9rem;
        color: #555;
    }

</style>

<!-- ========================= -->
<!--   HERO / INTRO SECTION   -->
<!-- ========================= -->
<div class="bg-gradient-to-r">

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-green-700 mb-4 border-l-4 border-green-700 pl-3">
        Welcome to Premium Farming Feeds
    </h1>

    <!-- Description -->
    <p class="text -black">
        At Premium Farming Feeds, we are dedicated to offering high-quality, affordable,
        and reliable animal feeds trusted by farmers across Kenya. Our formulations are
        carefully balanced to support dairy, poultry, and pig farming—ensuring optimal
        animal health, faster growth, and increased farm productivity.
    </p>

    <!-- Call to action -->
    {{-- <div class="mt-8">
        <a href="#products"
           class="inline-block bg-black text-green-400 font-semibold px-8 py-3 rounded-full shadow-lg hover:bg-gray-900 transition duration-300">
            Explore Our Products
        </a>
    </div> --}}
</div><br><br>


<!-- ========================= -->
<!--   ABOUT US SECTION       -->
<!-- ========================= -->
<section class="mb-14">
    <h2 class="text-3xl font-bold text-green-700 mb-4 border-l-4 border-green-700 pl-3">
        About Us
    </h2>

    <p class="text-gray-700 leading-relaxed max-w-4xl mb-4">
        For over <strong>5 years</strong>, Premium Farming Feeds has supplied top-quality livestock feeds 
        to farmers across Kenya. Our commitment is simple:  
        <strong>Affordable, nutritious, and reliable feeds delivered straight to your farm.</strong>
    </p>

    <ul class="text-gray-700 space-y-2 ml-5">
        <li>✔ High-quality ingredients for maximum animal performance</li>
        <li>✔ Trusted by farmers across Kenya</li>
        <li>✔ Fast and reliable delivery</li>
        <li>✔ Experienced feed production team</li>
    </ul>
</section><br><br>

<!-- ========================= -->
<!--   TRANSPORT SLIDER       -->
<!-- ========================= -->
<section class="mb-14">
    <h2 class="text-3xl font-bold text-green-700 mb-6 border-l-4 border-green-700 pl-3">
        Meet Our Team
    </h2>

    <p class="text-gray-600 mb-5">Our dedicated team ensures every feed meets premium quality standards.</p>

    <div id="staffSlider">

        <div class="team-card">
            <img src="{{ asset('images/boss.jpeg') }}" alt="Madam Boss">
            <p class="team-name">Paul Mbua</p>
            <p class="team-role">CEO AND FOUNDER</p>
        </div>

        <div class="team-card">
            <img src="{{ asset('images/md boss.jpeg') }}" alt="Madam Boss">
            <p class="team-name">Joyce Mbua</p>
            <p class="team-role">Founder & Vision Lead</p>
        </div>

        <div class="team-card">
            <img src="{{ asset('images/manager.jpeg') }}" alt="Manager">
            <p class="team-name">Naomi</p>
            <p class="team-role">Branch Manager</p>
        </div>

    </div>
</section>


<!-- ========================= -->
<!--   VIDEOS SLIDER (AUTO-PLAY) -->
<!-- ========================= -->
<section class="mb-16">
    <h2 class="text-3xl font-extrabold text-green-700 mb-6 border-l-4 border-green-700 pl-3">
        Animals Feeding on Our Products
    </h2>

    <p class="text-gray-700 mb-6 text-lg">
        Real clips from our farmers using Premium Farming Feeds.
    </p>

    <!-- Wrapper -->
    <div class="relative overflow-hidden rounded-2xl shadow-xl border border-green-200 p-3 bg-white">

        <!-- Slider Row -->
        <div id="videoSlider" class="flex space-x-8 animate-video-scroll">

            <!-- Video 1 -->
            <video autoplay loop muted playsinline
                   class="rounded-2xl shadow-lg h-72 w-96 object-cover flex-shrink-0 hover:scale-105 transition-transform duration-500">
                <source src="{{ asset('images/all feeds.mov') }}">
            </video>

            <!-- Video 2 -->
            <video autoplay loop muted playsinline
                   class="rounded-2xl shadow-lg h-72 w-96 object-cover flex-shrink-0 hover:scale-105 transition-transform duration-500">
                <source src="{{ asset('images/ikinu prem1.mp4') }}">
            </video>

            <!-- Video 3 -->
            <video autoplay loop muted playsinline
                   class="rounded-2xl shadow-lg h-72 w-96 object-cover flex-shrink-0 hover:scale-105 transition-transform duration-500">
                <source src="{{ asset('images/chicken 2.mov') }}">
            </video>

            <!-- Video 4 -->
            <video autoplay loop muted playsinline
                   class="rounded-2xl shadow-lg h-72 w-96 object-cover flex-shrink-0 hover:scale-105 transition-transform duration-500">
                <source src="{{ asset('images/cows eating.mov') }}">
            </video>

            <!-- Video 5 -->
            <video autoplay loop muted playsinline
                   class="rounded-2xl shadow-lg h-72 w-96 object-cover flex-shrink-0 hover:scale-105 transition-transform duration-500">
                <source src="{{ asset('images/pig eating.mov') }}">
            </video>

        </div>
    </div>
</section>

<section class="mb-14">
    <h2 class="text-3xl font-bold text-green-700 mb-6 border-l-4 border-green-700 pl-3">
        Meet Our Team
    </h2>

    <p class="text-gray-600 mb-5">
        Our dedicated team ensures every feed meets premium quality standards.
    </p>

    <div class="slider-container">
        <div class="slider-track">

            <!-- Boss -->
            <div class="slider-card">
                <img src="{{ asset('images/ikinu prem.jpeg') }}" class="slider-image">
            </div>

            <!-- Boss second photo -->
            <div class="slider-card">
                <img src="{{ asset('images/transport2.jpeg') }}" class="slider-image">
            </div>

            <!-- Manager -->
            <div class="slider-card">
                <img src="{{ asset('images/transport1.jpeg') }}" class="slider-image">
            </div>

            <!-- Staff Video -->
            <div class="slider-card">
                <img src="{{ asset('images/counter3.jpeg') }}" class="slider-image">
            </div>

        </div>
    </div>
</section>


<!-- ========================= -->
<!--   AUTO SLIDER SCRIPT      -->
<!-- ========================= -->
<script>
    function autoSlide(containerId) {
        const container = document.getElementById(containerId);
    
        let scrollAmount = 0;
        const slideWidth = 330; // Adjust if needed
    
        setInterval(() => {
            if (scrollAmount >= container.scrollWidth - container.clientWidth) {
                scrollAmount = 0;
            } else {
                scrollAmount += slideWidth;
            }
    
            container.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
    
        }, 3000);
    }
    
    autoSlide("staffSlider");
    autoSlide("transportSlider");
    autoSlide("videoSlider");
    </script>
    

@endsection
