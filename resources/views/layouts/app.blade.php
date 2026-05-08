
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Premium Farming Feeds | Quality Livestock Nutrition')</title>
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    @php
        $cartCount = 0;
        $cartTotal = 0;
        $cartItems = [];
        
        if (session()->has('cart')) {
            $cartItems = session('cart', []);
            $cartCount = count($cartItems);
            
            foreach ($cartItems as $item) {
                $cartTotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
        }
    @endphp
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    @stack('styles')
    
    <style>
        /* ============================
           CSS VARIABLES & RESET
           ============================ */
        :root {
            --primary-blue: #1e3a8a;       /* Deep classic blue */
            --secondary-blue: #2563eb;     /* Bright blue */
            --light-blue: #60a5fa;         /* Light blue */
            --navy-blue: #0f172a;          /* Dark navy */
            --accent-gold: #d4af37;        /* Classic gold accent */
            --warm-gold: #b8860b;          /* Warm gold */
            --pure-white: #ffffff;
            --off-white: #f8fafc;
            --cream-white: #faf9f6;        /* Cream white */
            --text-dark: #1e293b;
            --text-light: #64748b;
            --shadow-soft: 0 8px 30px rgba(30, 58, 138, 0.08);
            --shadow-medium: 0 15px 40px rgba(30, 58, 138, 0.12);
            --logo-border-color: #b8860b;  /* Darker gold for better contrast */
            --success-green: #198754;
            --danger-red: #dc2626;
            --border-light: rgba(30, 58, 138, 0.08);
            --border-medium: rgba(30, 58, 138, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: var(--cream-white);
            overflow-x: hidden;
            line-height: 1.6;
            padding-top: 76px; /* Account for fixed navbar */
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }
        
        /* ============================
           UTILITY CLASSES
           ============================ */
        .text-gold {
            color: var(--accent-gold) !important;
        }
        
        .bg-gradient-blue {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        }
        
        .bg-gradient-gold {
            background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
        }
        
        /* ============================
           NAVIGATION - CLASSIC BLUE STYLE
           ============================ */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-medium);
            padding: 0.5rem 0;
            box-shadow: 0 2px 20px rgba(30, 58, 138, 0.05);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            padding: 5px 0;
        }
        
        .logo-image {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--logo-border-color);
            padding: 2px;
            background: white !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3),
                        0 0 0 2px rgba(255, 255, 255, 0.8) inset;
            transition: all 0.3s ease;
        }
        
        .logo-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4),
                        0 0 0 2px rgba(255, 255, 255, 0.9) inset;
            border-color: var(--accent-gold);
        }
        
        .company-name {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--navy-blue);
            letter-spacing: 0.3px;
            line-height: 1.2;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.05);
        }
        
        .nav-link {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: var(--text-dark) !important;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            font-size: 0.95rem;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-blue) !important;
            background: rgba(30, 58, 138, 0.05);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 70%;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }
        
        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-medium);
            border-radius: 8px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            border-top: 3px solid var(--accent-gold);
        }
        
        .dropdown-item {
            padding: 0.6rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(30, 58, 138, 0.05);
            color: var(--primary-blue);
            padding-left: 2rem;
        }
        
        .dropdown-divider {
            border-color: var(--border-light);
            margin: 0.5rem 0;
        }
        
        /* ============================
           CART IN NAVIGATION - PREMIUM STYLE
           ============================ */
        .navbar-cart-container {
            position: relative;
            margin-left: 1rem;
        }
        
        .navbar-cart-btn {
            background: transparent;
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            padding: 0;
        }
        
        .navbar-cart-btn:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.25);
            border-color: var(--secondary-blue);
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
            color: var(--navy-blue);
            font-weight: 700;
            font-size: 0.7rem;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
            border: 2px solid white;
            animation: pulse-gold 2s infinite;
        }
        
        @keyframes pulse-gold {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        /* ============================
           CART MODAL STYLES
           ============================ */
        .modal-header.bg-success {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)) !important;
            border-bottom: 3px solid var(--accent-gold);
        }
        
        .modal-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .modal-title .badge {
            background: white !important;
            color: var(--primary-blue) !important;
            font-weight: 600;
        }
        
        .modal-body {
            max-height: 400px;
            overflow-y: auto;
            padding: 0;
        }
        
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: var(--light-blue);
            border-radius: 3px;
        }
        
        .modal-body::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-blue);
        }
        
        .list-group-item {
            border: none;
            border-bottom: 1px solid var(--border-light);
            padding: 1rem 1.25rem;
            transition: all 0.3s ease;
        }
        
        .list-group-item:hover {
            background: var(--off-white);
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }
        
        .btn-outline-danger {
            border-color: var(--danger-red);
            color: var(--danger-red);
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .btn-outline-danger:hover {
            background: var(--danger-red);
            color: white;
            border-color: var(--danger-red);
        }
        
        .bg-light {
            background-color: var(--off-white) !important;
        }
        
        .text-success {
            color: var(--primary-blue) !important;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border: none;
            color: white;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, var(--secondary-blue), var(--primary-blue));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.3);
        }
        
        .btn-outline-secondary {
            border: 2px solid var(--text-light);
            color: var(--text-light);
            font-weight: 500;
        }
        
        .btn-outline-secondary:hover {
            background: var(--text-light);
            color: white;
            border-color: var(--text-light);
        }
        
        /* ============================
           MAIN CONTENT AREA
           ============================ */
        .main-content {
            min-height: 60vh;
            width: 100%;
            padding: 2rem 0;
        }
        
        /* ============================
           FOOTER STYLES
           ============================ */
        .footer {
            background: linear-gradient(135deg, var(--navy-blue), var(--primary-blue));
            color: white;
            padding: 4rem 0 2rem;
            position: relative;
            overflow: hidden;
            margin-top: 3rem;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-gold), var(--warm-gold));
        }
        
        .footer h6 {
            color: white;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .footer h6::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--accent-gold);
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .footer a:hover {
            color: var(--accent-gold);
            padding-left: 5px;
        }
        
        .footer .text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        .footer .bi {
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .footer .bi:hover {
            color: var(--accent-gold);
            transform: translateY(-3px);
        }
        
        .border-top {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* ============================
           RESPONSIVE DESIGN
           ============================ */
        @media (max-width: 1200px) {
            .company-name {
                font-size: 1.4rem;
            }
        }
        
        @media (max-width: 992px) {
            body {
                padding-top: 70px;
            }
            
            .navbar-collapse {
                background: white;
                padding: 1rem;
                border-radius: 8px;
                box-shadow: var(--shadow-soft);
                margin-top: 0.5rem;
            }
            
            .nav-link {
                padding: 0.5rem 1rem !important;
            }
            
            .nav-link::after {
                display: none;
            }
            
            .navbar-cart-container {
                margin: 0.5rem 0 0;
                width: 100%;
            }
            
            .navbar-cart-btn {
                width: 100%;
                border-radius: 8px;
            }
            
            .company-name {
                font-size: 1.2rem;
            }
            
            .logo-image {
                width: 55px;
                height: 55px;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-brand {
                gap: 10px;
            }
            
            .logo-image {
                width: 50px;
                height: 50px;
            }
            
            .company-name {
                font-size: 1rem;
            }
            
            .modal-dialog {
                margin: 0.5rem;
            }
            
            .modal-body {
                max-height: 350px;
            }
        }
        
        @media (max-width: 576px) {
            .company-name {
                font-size: 0.95rem;
            }
            
            .list-group-item {
                padding: 0.75rem 1rem;
            }
            
            .btn-success,
            .btn-outline-secondary {
                width: 100%;
                margin: 0.25rem 0;
            }
        }
        
        @media (max-width: 480px) {
            .company-name {
                display: none !important;
            }
            
            .logo-image {
                width: 45px;
                height: 45px;
            }
        }
        
        /* ============================
           PREMIUM BUTTON STYLES
           ============================ */
        .btn-premium {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.2);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }
        
        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-premium:hover::before {
            left: 100%;
        }
        
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
            color: white;
        }
        
        .btn-premium-outline {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        
        .btn-premium-outline:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.2);
        }
        
        /* ============================
           PREMIUM CARD STYLES
           ============================ */
        .premium-card {
            background: white;
            border-radius: 10px;
            padding: 2.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border-medium);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .premium-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
        }
        
        .premium-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-medium);
        }
        
        /* ============================
           SECTION STYLES
           ============================ */
        .section {
            padding: 6rem 0;
            position: relative;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }
        
        .section-title h2 {
            font-size: 2.8rem;
            color: var(--navy-blue);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
            border-radius: 2px;
        }
        
        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 2rem auto 0;
            font-family: 'Inter', sans-serif;
            line-height: 1.7;
        }
        
        /* ============================
           SCROLL TO TOP BUTTON
           ============================ */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-blue);
            color: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.2);
            font-size: 1.2rem;
            border: none;
        }
        
        .scroll-top.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .scroll-top:hover {
            background: var(--secondary-blue);
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="logo-image">
                <span class="company-name">Premium Farming Feeds</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPremium" aria-controls="navbarPremium" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            
            
            <div class="collapse navbar-collapse" id="navbarPremium">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu">

                            {{-- All Products --}}
                            <li>
                                <a class="dropdown-item" href="{{ route('products') }}">
                                    All Products
                                </a>
                            </li>

                            {{-- Divider --}}
                            <li>
                                <hr class="dropdown-divider">
                            </li>


                            {{-- Categories --}}
                            @forelse($globalCategories ?? [] as $category)

                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('category.show', $category['slug']) }}"
                                    >
                                        {{ $category['name'] }}
                                    </a>
                                </li>

                            @empty

                                <li>
                                    <span class="dropdown-item text-muted">
                                        No categories available
                                    </span>
                                </li>

                            @endforelse

                        </ul>
                        
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="/about">About</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="/contact">Contact</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reviews') ? 'active' : '' }}" href="/reviews">Reviews</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}" href="/orders">My Orders</a>
                    </li>
                    
                    {{-- <li class="nav-item">
                        <div class="navbar-cart-container">
                            <button class="navbar-cart-btn" data-bs-toggle="modal" data-bs-target="#cartModal" aria-label="Shopping Cart">
                                <i class="bi bi-cart3"></i>
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </button>
                        </div>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <!-- Company Info -->
                <div class="col-lg-4">
                    <div class="mb-3">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="logo-image mb-3">
                        <h6>Premium Farming Feeds</h6>
                        <p class="text-white-50 small mb-3">
                            Leading provider of premium livestock nutrition solutions in Kenya. 
                            Committed to quality, innovation, and customer satisfaction.
                        </p>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="https://www.facebook.com/profile.php?id=61587310585524" target="_blank" aria-label="Facebook" class="text-white me-2">
                            <i class="bi bi-facebook"></i>
                        </a>     
                        <a href="https://www.instagram.com/premiumfarmingfeeds/" target="_blank" aria-label="Instagram" class="text-white me-2">
                            <i class="bi bi-instagram"></i>
                        </a>       
                        <a href="https://wa.me/254700680017" target="_blank" aria-label="WhatsApp" class="text-white">
                            <i class="bi bi-whatsapp"></i>
                        </a>  
                        <a href="https://www.youtube.com/@PremiumFeeds1" target="_blank" aria-label="YouTube" class="text-white">
                            <i class="bi bi-youtube"></i>
                        </a>                  
                    </div>
                                        
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                        <li class="mb-2"><a href="{{ route('products') }}" class="text-white-50">Products</a></li>
                        <li class="mb-2"><a href="/about" class="text-white-50">About Us</a></li>
                        <li class="mb-2"><a href="/contact" class="text-white-50">Contact</a></li>
                        <li class="mb-2"><a href="/reviews" class="text-white-50">Reviews</a></li>
                        <li class="mb-2"><a href="/orders" class="text-white-50">My Orders</a></li>
                    </ul>
                </div>
                
                {{-- <!-- Categories -->
                <div class="col-lg-3 col-md-6">
                    <h6>Categories</h6>

                    <ul class="list-unstyled">

                        <li class="mb-2">
                            <a
                                href="{{ route('category.show', 'poultry') }}"
                                class="text-white-50"
                            >
                                Poultry Feeds
                            </a>
                        </li>

                        <li class="mb-2">
                            <a
                                href="{{ route('category.show', 'dairy') }}"
                                class="text-white-50"
                            >
                                Dairy Feeds
                            </a>
                        </li>

                        <li class="mb-2">
                            <a
                                href="{{ route('category.show', 'swine') }}"
                                class="text-white-50"
                            >
                                Swine Feeds
                            </a>
                        </li>

                        <li class="mb-2">
                            <a
                                href="{{ route('category.show', 'pet-feeds') }}"
                                class="text-white-50"
                            >
                                Pet Feeds
                            </a>
                        </li>

                        <li class="mb-2">
                            <a
                                href="{{ route('category.show', 'by-products') }}"
                                class="text-white-50"
                            >
                                Raw Materials
                            </a>
                        </li>

                    </ul>
                </div> --}}
                
                <!-- Contact Info -->
                <div class="col-lg-3">
                    <h6>Contact Info</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3 text-white-50 small">
                            <i class="bi bi-geo-alt me-2"></i>Kiambu, Kenya
                        </li>
                        <li class="mb-3 text-white-50 small">
                            <i class="bi bi-telephone me-2"></i>+254 700 680 017
                        </li>
                       <li class="mb-3 text-white-50 small">
                        <i class="bi bi-envelope me-2"></i>
                        <a href="https://mail.google.com/mail/?view=cm&to=premiumfarmingf@gmail.com" target="_blank" class="text-white-50 text-decoration-none">
                            premiumfarming@gmail.com
                        </a>
                     </li>
                        <li class="text-white-50 small">
                            <i class="bi bi-clock me-2"></i>Mon-Sat: 8AM - 6PM
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="text-center mt-5 pt-4 border-top">
                <p class="mb-0 small text-white-50">
                    &copy; {{ date('Y') }} Premium Farming Feeds. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="cartModalLabel">
                        <i class="bi bi-cart3 me-2"></i>Shopping Cart
                        @if($cartCount > 0)
                            <span class="badge ms-2">{{ $cartCount }}</span>
                        @endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    @if($cartCount > 0)
                        <div class="list-group list-group-flush">
                            @foreach($cartItems as $id => $item)
                                @php
                                    $lineTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                @endphp
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ $item['name'] ?? 'Product' }}</h6>
                                            <small class="text-muted d-block">
                                                Qty: {{ $item['quantity'] ?? 1 }} × KSh {{ number_format($item['price'] ?? 0) }}
                                            </small>
                                        </div>
                                        <div class="text-end ms-3">
                                            <div class="fw-bold text-success mb-2">
                                                KSh {{ number_format($lineTotal) }}
                                            </div>
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="removeFromCart('{{ $id }}')"
                                                    aria-label="Remove item">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="p-3 bg-light">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="fw-bold">KSh {{ number_format($cartTotal) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>VAT (16%):</span>
                                <span>KSh {{ number_format($cartTotal * 0.16) }}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="fw-bold h6 mb-0">Total:</span>
                                <span class="fw-bold text-success h6 mb-0">KSh {{ number_format($cartTotal * 1.16) }}</span>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 p-3">
                            <a href="{{ route('checkout') }}" class="btn btn-success">
                                <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                            </a>
                            <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-bag me-2"></i>Continue Shopping
                            </button>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x display-1 text-muted"></i>
                            <p class="mt-3 text-muted">Your shopping cart is empty</p>
                            <a href="{{ route('products') }}" class="btn btn-success mt-2">
                                <i class="bi bi-bag me-2"></i>Browse Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTop" aria-label="Scroll to top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
        // Remove from cart function
        function removeFromCart(id) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                return;
            }
            
            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to remove item. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
        
        // Scroll to top functionality
        document.addEventListener('DOMContentLoaded', function() {
            const scrollTopBtn = document.getElementById('scrollTop');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            });
            
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const dropdowns = document.querySelectorAll('.dropdown-menu');
            const toggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target) && !e.target.classList.contains('dropdown-toggle')) {
                    const bsDropdown = bootstrap.Dropdown.getInstance(dropdown.previousElementSibling);
                    if (bsDropdown) {
                        bsDropdown.hide();
                    }
                }
            });
        });
        
        // Navbar active link handling
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
