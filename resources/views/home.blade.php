 @extends('layouts.app')

@section('content')

{{-- Include Top Navbar --}}
@include('components.topnav')

{{-- <div class="video-hero relative h-screen w-full overflow-hidden mt-20">

    <!-- Video Slideshow -->
    <video class="active absolute top-0 left-0 w-full h-full object-cover opacity-70 transition-opacity" 
           src="{{ asset('images/all feeds.mov') }}" autoplay muted loop playsinline></video>

    <video class="absolute top-0 left-0 w-full h-full object-cover opacity-0 transition-opacity" 
           src="{{ asset('images/pig eating.mov') }}" autoplay muted loop playsinline></video>

    <video class="absolute top-0 left-0 w-full h-full object-cover opacity-0 transition-opacity" 
           src="{{ asset('images/chicken eating.mov') }}" autoplay muted loop playsinline></video>

    <video class="absolute top-0 left-0 w-full h-full object-cover opacity-0 transition-opacity" 
           src="{{ asset('images/chicken 2.mov') }}" autoplay muted loop playsinline></video>

    <video class="absolute top-0 left-0 w-full h-full object-cover opacity-0 transition-opacity" 
           src="{{ asset('images/cows eating.mov') }}" autoplay muted loop playsinline></video>

    <!-- Overlay Description -->
    <div class="absolute top-0 left-0 z-10 w-full h-full flex flex-col justify-center items-center text-center p-6 text-white">
        <h1 class="text-4xl md:text-5xl font-bold text-green-700 drop-shadow-lg">
            Premium Farming Feeds
        </h1>

        <p class="mt-4 text-lg md:text-2xl font-semibold max-w-3xl drop-shadow-lg">
            We provide Kenya’s farmers with the best feed for pigs, chickens, and cows.
            Premium quality for optimal growth, healthier livestock, and maximum productivity.
            Experience the Premium Farming Feeds difference today!
        </p>
    </div>
</div> --}}

<script>
    const videos = document.querySelectorAll('.video-hero video');
    let current = 0;

    function showNextVideo() {
        videos[current].classList.remove('active');
        videos[current].style.opacity = 0;
        current = (current + 1) % videos.length;
        videos[current].classList.add('active');
        videos[current].style.opacity = 0.7;
    }

    setInterval(showNextVideo, 7000);
</script>

@endsection 
