<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* logo */
        .logo-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
        }

        /* Responsive hero video */
        .hero-video {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
        }

        /* slider animation */
        #videoSlider {
            display: flex;
            transition: transform 0.8s ease-in-out;
        }

        .slide {
            min-width: 100%;
            position: relative;
        }

        .caption {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.45);
            padding: 10px;
            border-radius: 8px;
        }
    </style>

</head>

<body class="bg-gray-50">

<!-- ============================= -->
<!--            HEADER           -->
<!-- ============================= -->
<header class="bg-green-700 text-white sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

        <!-- Logo + Title -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo.jpeg') }}" class="logo-img" alt="logo">

            <div>
                <h1 class="font-bold text-lg">Premium Farming Feeds</h1>
                <p class="text-xs text-gray-200">Quality • Nutrition • Growth</p>
            </div>
        </div>

        <!-- Desktop nav -->
        <nav class="hidden md:flex space-x-6 text-lg font-semibold">
            <a href="/pos" class="hover:text-yellow-300">Home</a>
            <a href="/shop" class="hover:text-yellow-300">Shop</a>
            <a href="/about" class="hover:text-yellow-300">About</a>
            <a href="/contact" class="hover:text-yellow-300">Contact</a>
        </nav>

        <!-- Mobile menu button -->
        <button onclick="toggleMenu()" class="md:hidden text-3xl">
            ☰
        </button>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden bg-green-600 px-4 pb-4 space-y-2 md:hidden">
        <a href="/pos" class="block py-1 hover:text-yellow-300">Home</a>
        <a href="/shop" class="block py-1 hover:text-yellow-300">Shop</a>
        <a href="/about" class="block py-1 hover:text-yellow-300">About</a>
        <a href="/contact" class="block py-1 hover:text-yellow-300">Contact</a>
    </div>
</header>

<script>
    function toggleMenu() {
        document.getElementById("mobileMenu").classList.toggle("hidden");
    }
</script>

<!-- ============================= -->
<!--        HERO VIDEO SLIDER    -->
<!-- ============================= -->
<section class="max-w-7xl mx-auto px-4 mt-8">

    <h2 class="text-2xl font-bold text-blue-700 mb-4">
        Videos From Our Daily Operations
    </h2>

    <div class="overflow-hidden rounded-xl shadow-lg">

        <div id="videoSlider">

            <!-- Slide 1 -->
            <div class="slide">
                <video src="{{ asset('videos/all feeds.mov') }}" autoplay muted loop class="hero-video"></video>

                <div class="caption text-white">
                    <strong>Animals Feeding</strong>
                    <p class="text-sm">Healthy animals enjoying our feed.</p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <video src="{{ asset('videos/ikinu prem1.mp4') }}" autoplay muted loop class="hero-video"></video>

                <div class="caption text-white">
                    <strong>Delivery in Progress</strong>
                    <p class="text-sm">Reliable distribution to farmers.</p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <video src="{{ asset('videos/cows eating.mov') }}" autoplay muted loop class="hero-video"></video>

                <div class="caption text-white">
                    <strong>Feed Preparation</strong>
                    <p class="text-sm">Balanced nutrition for livestock.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    let index = 0;
    const slider = document.getElementById("videoSlider");
    const total = slider.children.length;

    setInterval(() => {
        index = (index + 1) % total;
        slider.style.transform = `translateX(-${index * 100}%)`;
    }, 4500);
</script>

<!-- ============================= -->
<!--            FOOTER           -->
<!-- ============================= -->
<footer class="bg-gray-900 text-white mt-16 py-10">

    <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-3 gap-8">

        <!-- About -->
        <div>
            <h3 class="text-xl font-bold mb-3">Premium Farming Feeds</h3>
            <p class="text-gray-300">
                High-quality livestock feeds for farmers across Kenya.
            </p>
        </div>

        <!-- Links -->
        <div>
            <h3 class="text-xl font-bold mb-3">Quick Links</h3>
            <ul class="space-y-2 text-gray-300">
                <li><a href="/" class="hover:text-green-400">Home</a></li>
                <li><a href="/shop" class="hover:text-green-400">Shop</a></li>
                <li><a href="/contact" class="hover:text-green-400">Contact</a></li>
            </ul>
        </div>

        <!-- Social -->
        <div>
            <h3 class="text-xl font-bold mb-3">Follow Us</h3>

            <div class="flex space-x-4">

                <a href="#" class="w-10 h-10 flex items-center justify-center bg-white text-blue-600 rounded-full hover:scale-110">
                    F
                </a>

                <a href="#" class="w-10 h-10 flex items-center justify-center bg-white text-pink-500 rounded-full hover:scale-110">
                    I
                </a>

                <a href="#" class="w-10 h-10 flex items-center justify-center bg-white text-green-600 rounded-full hover:scale-110">
                    W
                </a>

            </div>
        </div>

    </div>

    <p class="text-center text-gray-400 text-sm mt-8">
        © {{ date('Y') }} Premium Farming Feeds. All Rights Reserved.
    </p>

</footer>

</body>
</html>
