<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- TailwindCSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Logo size */
        img {
            width: 130px;
            object-fit: contain;
            border-radius: 6px;
        }
    
        /* UPDATED VIDEO SIZING */
        .hero-video {
            width: 100%;              /* makes it responsive */
            height: 550px;           /* increased height */
            object-fit: cover;       /* fills area without distortion */
            opacity: 1;
            transition: opacity 1.2s ease-in-out;
            z-index: 10;
        }
    
        /* Fade animation for active video */
        .hero-video.active {
            opacity: 1;
        }
    
        /* Smooth fade-in animation for text */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    
        .animate-fadeIn {
            animation: fadeIn 1.3s ease-out forwards;
        }
    </style>
    
</head>

<body class="bg-gray-50">

    <!-- ========================================= -->
    <!--                HEADER                     -->
    <!-- ========================================= -->
    <header class="bg-green-700 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">

            <a href="/" class="text-2xl font-bold tracking-wide">
                Premium Farming Feeds
            </a>

            <!-- Navigation -->
            <nav class="space-x-6 text-lg font-semibold">
                <a href="/pos" class="hover:text-yellow-300">Home</a>
                <a href="/shop" class="hover:text-yellow-300">Shop</a>
                <a href="/about" class="hover:text-yellow-300">About</a>
                <a href="/contact" class="hover:text-yellow-300">Contact</a>
            </nav>
        </div>
    </header>


    <!-- =============================== -->
    <!--      FULL-SCREEN HERO SLIDER    -->
    <!-- =============================== -->
   <!-- ANIMAL FEEDING VIDEO SHOWCASE -->
<!-- ANIMAL FEEDING VIDEO SHOWCASE -->
<!-- =============================== -->
<!--      FULL-SCREEN HERO SLIDER    -->
<!-- =============================== -->

<!-- =============================== -->
<!--  PREMIUM VIDEO SHOWCASE SLIDER  -->
<!-- =============================== -->
<section class="mb-16">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 border-l-4 border-green-600 pl-3">
        Videos From Our Daily Operations
    </h2>

    <p class="text-gray-600 mb-5">
        See how we prepare, test, and deliver high-quality feeds to our farmers.
    </p>

    <!-- VIDEO SLIDER WRAPPER -->
    <div class="relative overflow-hidden rounded-2xl shadow-2xl">

        <!-- Slider container -->
        <div id="videoSlider" class="flex transition-all duration-700">

            <!-- Video 1 -->
            <div class="w-full flex-shrink-0 relative">
                <video src="{{ asset('videos/all feeds.mov') }}" 
                       autoplay muted loop class="w-full h-80 object-cover rounded-xl"></video>

                <div class="absolute bottom-4 left-4 bg-black/60 text-blue p-3 rounded-lg backdrop-blur">
                    <h4 class="text-lg font-semibold">Animals Feeding</h4>
                    <p class="text-sm text-gray-200">Healthy animals enjoying our premium formulated feed.</p>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="w-full flex-shrink-0 relative">
                <video src="{{ asset('videos/ikinu prem1.mp4') }}" 
                       autoplay muted loop class="w-full h-80 object-cover rounded-xl"></video>

                <div class="absolute bottom-4 left-4 bg-black/60 text-blue p-3 rounded-lg backdrop-blur">
                    <h4 class="text-lg font-semibold">Delivery in Progress</h4>
                    <p class="text-sm text-gray-200">Fast & reliable delivery straight to our farmers.</p>
                </div>
            </div>
            <div class="w-full flex-shrink-0 relative">
                <video src="{{ asset('videos/chicken 2.mov') }}" 
                       autoplay muted loop class="w-full h-80 object-cover rounded-xl"></video>

                <div class="absolute bottom-4 left-4 bg-black/60 text-blue p-3 rounded-lg backdrop-blur">
                    <h4 class="text-lg font-semibold">Delivery in Progress</h4>
                    <p class="text-sm text-gray-200">Fast & reliable delivery straight to our farmers.</p>
                </div>
            </div>
            <div class="w-full flex-shrink-0 relative">
                <video src="{{ asset('videos/cows eating.mov') }}" 
                       autoplay muted loop class="w-full h-80 object-cover rounded-xl"></video>

                <div class="absolute bottom-4 left-4 bg-black/60 text-blue p-3 rounded-lg backdrop-blur">
                    <h4 class="text-lg font-semibold">Delivery in Progress</h4>
                    <p class="text-sm text-gray-200">Fast & reliable delivery straight to our farmers.</p>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="w-full flex-shrink-0 relative">
                <video src="{{ asset('videos/ikinu prem1.mp4') }}"
                       autoplay muted loop class="w-full h-80 object-cover rounded-xl"></video>

                <div class="absolute bottom-4 left-4 bg-black/60 text-black p-3 rounded-lg backdrop-blur">
                    <h4 class="text-lg font-semibold">Feed Preparation</h4>
                    <p class="text-sm text-gray-200">Skilled workers mixing balanced nutritional feed.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    // SIMPLE AUTO SLIDE
    let index = 0;
    const slider = document.getElementById('videoSlider');
    const total = slider.children.length;

    setInterval(() => {
        index = (index + 1) % total;
        slider.style.transform = `translateX(-${index * 100}%)`;
    }, 5000); // slide every 5 seconds
</script>









    <!-- ========================================= -->
    <!--                FOOTER                     -->
    <!-- ========================================= -->
    <footer class="bg-gray-900 text-white mt-20 pt-12 pb-6">

        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10">

            <!-- About -->
            <div>
                <h3 class="text-xl font-bold mb-3">Premium Farming Feeds</h3>
                <p class="text-gray-300">
                    High-quality and affordable livestock feeds for farmers all across Kenya.
                </p>
            </div>

            <!-- Quick links -->
            <div>
                <h3 class="text-xl font-bold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-gray-300">
                    <li><a href="/" class="hover:text-green-400">Home</a></li>
                    <li><a href="/shop" class="hover:text-green-400">Shop</a></li>
                    <li><a href="/contact" class="hover:text-green-400">Contact</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div>
                <h3 class="text-xl font-bold mb-3">Follow Us</h3>
                <div class="flex space-x-4 mt-3">

                    <a href="https://www.facebook.com/" class="w-10 h-10 flex items-center justify-center bg-white text-blue-700 rounded-full shadow hover:scale-110 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <a href="#" class="w-10 h-10 flex items-center justify-center bg-white text-pink-600 rounded-full shadow hover:scale-110 transition">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <a href="https://web.whatsapp.com/" class="w-10 h-10 flex items-center justify-center bg-white text-green-600 rounded-full shadow hover:scale-110 transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>

                </div>
            </div>

        </div>

        <div class="text-center text-gray-400 text-sm mt-8 border-t border-gray-700 pt-4">
            © {{ date('Y') }} Premium Farming Feeds. All Rights Reserved.
        </div>
    </footer>

    <!-- Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

</body>
</html>
