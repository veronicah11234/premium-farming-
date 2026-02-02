<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Premium Farming Feeds | Quality Livestock Nutrition')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    @php
    // Cart data - initialize properly
    $cartCount = 0;
    $cartTotal = 0;
    $cartItems = [];
    
    if(session()->has('cart')) {
        $cartItems = session('cart', []);
        $cartCount = count($cartItems);
        
        foreach($cartItems as $item) {
            $cartTotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }
    }
    @endphp
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    @stack('styles')
    
    <style>
        /* CSS Variables for Green Theme */
        :root {
            /* Green Color Palette */
            --primary-green: #2a6e3f;
            --secondary-green: #38a169;
            --light-green: #68d391;
            --dark-green: #22543d;
            --accent-green: #10b981;
            --navy-green: #1e422e;
            --gold-green: #d4af37;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --pure-white: #ffffff;
            --off-white: #f8fafc;
            --cream-white: #faf9f6;
            
            /* Gradients */
            --gradient-green: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            --gradient-dark-green: linear-gradient(135deg, var(--navy-green), var(--primary-green));
            --gradient-light-green: linear-gradient(135deg, var(--light-green), var(--accent-green));
            
            /* Shadows */
            --shadow-soft: 0 8px 30px rgba(42, 110, 63, 0.08);
            --shadow-medium: 0 15px 40px rgba(42, 110, 63, 0.12);
            --logo-border-color: #d4af37;
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
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }
        
        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(42, 110, 63, 0.1);
            padding: 0.8rem 0;
            box-shadow: 0 2px 20px rgba(42, 110, 63, 0.05);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            padding: 5px 0;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo-image-container {
            position: relative;
            display: inline-block;
        }
        
        .logo-image {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--logo-border-color);
            padding: 2px;
            background: white !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .logo-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }
        
        .company-name {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--navy-green);
            letter-spacing: 0.3px;
            line-height: 1;
            margin-bottom: 3px;
        }
        
        .company-tagline {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 0.7rem;
            color: var(--text-light);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            position: relative;
            padding-top: 5px;
        }
        
        .company-tagline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 25px;
            height: 1px;
            background: var(--gold-green);
        }
        
        .nav-link {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: var(--text-dark) !important;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-green) !important;
            background: rgba(42, 110, 63, 0.05);
        }
        
        /* Buttons */
        .btn-premium {
            background: var(--gradient-green);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(42, 110, 63, 0.2);
        }
        
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(42, 110, 63, 0.3);
            color: white;
        }
        
        .btn-premium-outline {
            background: transparent;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-premium-outline:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Cart in Navigation */
        .navbar-cart-container {
            position: relative;
            margin-left: 1rem;
        }
        
        .navbar-cart-btn {
            background: transparent;
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 0;
        }
        
        .navbar-cart-btn:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(42, 110, 63, 0.25);
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--gradient-green);
            color: white;
            font-weight: 700;
            font-size: 0.7rem;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(42, 110, 63, 0.3);
            border: 2px solid white;
        }
        
        @keyframes pulse-green {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .cart-total-amount {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary-green);
            margin-left: 10px;
        }
        
        /* Cart Modal */
        .cart-modal-header {
            background: var(--gradient-dark-green);
            border-bottom: 3px solid var(--gold-green);
        }
        
        .cart-modal-title {
            color: white;
            font-weight: 600;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
        }
        
        .cart-item-count {
            background: rgba(255, 255, 255, 0.2);
            color: var(--gold-green);
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .cart-modal-body {
            max-height: 400px;
            overflow-y: auto;
            padding: 0 !important;
        }
        
        .cart-items-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(42, 110, 63, 0.08);
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background: #f8fafc;
        }
        
        .cart-item-image {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        
        .cart-item-details {
            flex: 1;
            min-width: 0;
        }
        
        .cart-item-name {
            font-weight: 600;
            color: var(--navy-green);
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }
        
        .cart-item-unit {
            font-size: 0.8rem;
            color: var(--text-light);
            text-transform: uppercase;
        }
        
        .cart-item-price {
            font-weight: 700;
            color: var(--primary-green);
            font-size: 1rem;
            margin-left: 1rem;
        }
        
        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .qty-btn {
            width: 28px;
            height: 28px;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .qty-btn:hover {
            background: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
        }
        
        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .qty-input {
            width: 40px;
            text-align: center;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 0.25rem;
            font-weight: 600;
        }
        
        .cart-item-remove {
            color: #ef4444;
            background: transparent;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-left: 0.5rem;
        }
        
        .cart-item-remove:hover {
            background: #fee2e2;
            transform: rotate(90deg);
        }
        
        /* Cart Summary */
        .cart-summary {
            background: #f8fafc;
            border-top: 1px solid rgba(42, 110, 63, 0.1);
            padding: 1.5rem;
        }
        
        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        
        .cart-total-row {
            border-top: 2px dashed rgba(42, 110, 63, 0.2);
            padding-top: 1rem;
            margin-top: 1rem;
        }
        
        .cart-total-value {
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--primary-green);
        }
        
        /* Cart Footer */
        .cart-modal-footer {
            background: white;
            border-top: 1px solid rgba(42, 110, 63, 0.1);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .cart-btn-clear {
            background: transparent;
            border: 1px solid #dc2626;
            color: #dc2626;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .cart-btn-clear:hover {
            background: #dc2626;
            color: white;
        }
        
        .cart-btn-close {
            background: transparent;
            border: 1px solid var(--text-light);
            color: var(--text-light);
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .cart-btn-close:hover {
            background: var(--text-light);
            color: white;
        }
        
        .cart-btn-checkout {
            background: var(--gradient-green);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(42, 110, 63, 0.2);
        }
        
        .cart-btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(42, 110, 63, 0.3);
        }
        
        /* Cart Notification */
        .cart-notification {
            position: fixed;
            top: 90px;
            right: 20px;
            background: white;
            border-left: 4px solid var(--gold-green);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 1.5rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 1050;
            transform: translateX(120%);
            transition: transform 0.3s ease;
            max-width: 350px;
        }
        
        .cart-notification.show {
            transform: translateX(0);
        }
        
        .cart-notification-icon {
            color: var(--gold-green);
            font-size: 1.5rem;
        }
        
        .cart-notification-title {
            font-weight: 600;
            color: var(--navy-green);
            margin-bottom: 0.25rem;
        }
        
        .cart-notification-message {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        /* Empty Cart */
        .cart-empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        
        .cart-empty-state i {
            font-size: 4rem;
            color: #d1fae5;
            margin-bottom: 1.5rem;
        }
        
        /* Footer */
        .footer {
            background: var(--gradient-dark-green);
            color: white;
            padding: 5rem 0 2rem;
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--gold-green);
            padding-left: 5px;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
            color: white;
        }
        
        .social-icons a:hover {
            background: var(--gold-green);
            transform: translateY(-3px);
            color: var(--navy-green);
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Scroll to Top */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-green);
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
            box-shadow: 0 4px 15px rgba(42, 110, 63, 0.2);
        }
        
        .scroll-top.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .scroll-top:hover {
            background: var(--secondary-green);
            transform: translateY(-5px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-cart-container {
                margin-left: 0.5rem;
            }
            
            .navbar-cart-btn {
                width: 40px;
                height: 40px;
            }
            
            .cart-total-amount {
                display: none;
            }
            
            .logo-image {
                width: 55px;
                height: 55px;
            }
            
            .company-name {
                font-size: 1.2rem;
            }
            
            .company-tagline {
                font-size: 0.65rem;
            }
        }
        
        @media (max-width: 480px) {
            .logo-text-container {
                display: none;
            }
            
            .logo-image {
                width: 45px;
                height: 45px;
            }
        }
    </style>
</head>
<body>
    <!-- Scroll to Top Button -->
    <div class="scroll-top" onclick="scrollToTop()">
        <i class="bi bi-chevron-up"></i>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="logo-container">
                    <div class="logo-wrapper">
                        <div class="logo-image-container">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="logo-image">
                        </div>
                    </div>
                    <div class="logo-text-container d-none d-lg-block">
                        <div class="company-name">Premium Farming Feeds</div>
                        <div class="company-tagline">Quality Livestock Nutrition</div>
                    </div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPremium">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarPremium">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Products
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products') }}">All Products</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.poultry') }}">Poultry Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.dairy') }}">Dairy Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.swine') }}">Swine Feeds</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('category.pet-feeds') }}">Pet Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.by-products') }}">Raw materials</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/reviews">Reviews</a>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/cart">
                                    <i class="bi bi-speedometer2 me-2"></i>Cart
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('checkout.orders') }}">
                                    <i class="bi bi-bag-check me-2"></i>My Orders
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                    @endauth
                    
                    <li class="nav-item">
                        <div class="navbar-cart-container">
                            <button class="navbar-cart-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="bi bi-cart3"></i>
                                @if($cartCount > 0)
                                    <span class="cart-badge cart-count-badge">{{ $cartCount }}</span>
                                @endif
                            </button>
                            @if($cartCount > 0)
                                <span class="cart-total-amount d-none d-lg-inline">
                                    <span class="currency">KSh</span>
                                    {{ number_format($cartTotal) }}
                                </span>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content" style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="logo-wrapper mb-4">
                        <div class="logo-image-container d-inline-block">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" 
                                 class="logo-image mb-3" 
                                 style="border-color: var(--gold-green); filter: brightness(1.1);">
                        </div>
                        <div class="logo-text-container text-center text-lg-start">
                            <div class="company-name" style="color: white; font-size: 1.8rem;">Premium Farming Feeds</div>
                            <div class="company-tagline" style="color: rgba(255,255,255,0.9);">Quality Livestock Nutrition</div>
                        </div>
                    </div>
                    <p class="mb-4" style="color: rgba(255,255,255,0.8);">
                        Leading provider of premium livestock nutrition solutions in Kenya. 
                        We're committed to enhancing agricultural productivity through science-backed feeds.
                    </p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.twitter.com/"><i class="bi bi-twitter"></i></a>
                        <a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/"><i class="bi bi-linkedin"></i></a>
                        <a href="https://wa.me/254700680017" target="_blank"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('products') }}">Products</a></li>
                        <li class="mb-2"><a href="/about">About Us</a></li>
                        <li class="mb-2"><a href="/contact">Contact</a></li>
                        <li class="mb-2"><a href="/reviews">Reviews</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Categories</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('category.poultry') }}">Poultry Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.dairy') }}">Dairy Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.swine') }}">Swine Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.pet-feeds') }}">Pet Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.by-products') }}">Raw materials</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            <span style="color: rgba(255,255,255,0.8);">Nairobi, Kenya</span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone me-2"></i>
                            <span style="color: rgba(255,255,255,0.8);">+254 700 123 456</span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope me-2"></i>
                            <span style="color: rgba(255,255,255,0.8);">info@premiumfeeds.co.ke</span>
                        </li>
                        <li>
                            <i class="bi bi-clock me-2"></i>
                            <span style="color: rgba(255,255,255,0.8);">Mon-Sat: 8AM - 6PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p class="mb-0">&copy; {{ date('Y') }} Premium Farming Feeds. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header cart-modal-header">
                    <h5 class="modal-title cart-modal-title" id="cartModalLabel">
                        <i class="bi bi-cart3"></i>
                        Shopping Cart
                        @if($cartCount > 0)
                            <span class="cart-item-count">{{ $cartCount }} items</span>
                        @endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body cart-modal-body">
                    @if($cartCount > 0)
                        <ul class="cart-items-list" id="cartItemsList">
                            @foreach($cartItems as $id => $item)
                                @php
                                    $lineTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                @endphp
                                <li class="cart-item" id="cartItem-{{ $id }}">
                                    <div class="cart-item-image">
                                        @if(isset($item['image']) && $item['image'])
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                                        @else
                                            <i class="bi bi-box"></i>
                                        @endif
                                    </div>
                                    <div class="cart-item-details">
                                        <div class="cart-item-name">{{ $item['name'] ?? 'Product' }}</div>
                                        <div class="cart-item-unit">{{ strtoupper($item['unit'] ?? 'UNIT') }}</div>
                                        <div class="cart-item-qty">
                                            <button type="button" class="qty-btn decrement-btn" 
                                                    data-id="{{ $id }}"
                                                    data-index="{{ $loop->index }}"
                                                    {{ ($item['quantity'] ?? 1) <= 1 ? 'disabled' : '' }}>
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="text" class="qty-input" id="qty-{{ $id }}" 
                                                   value="{{ $item['quantity'] ?? 1 }}" readonly>
                                            <button type="button" class="qty-btn increment-btn" 
                                                    data-id="{{ $id }}"
                                                    data-index="{{ $loop->index }}">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cart-item-price" id="price-{{ $id }}">
                                        KSh {{ number_format($lineTotal) }}
                                    </div>
                                    <button type="button" class="cart-item-remove remove-btn" 
                                            data-id="{{ $id }}"
                                            data-index="{{ $loop->index }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="cart-empty-state">
                            <i class="bi bi-cart-x"></i>
                            <h5>Your cart is empty</h5>
                            <p>Add products to get started</p>
                            <a href="{{ route('products') }}" class="btn btn-premium-outline mt-3">
                                Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
                
                @if($cartCount > 0)
                    <div class="cart-summary">
                        <div class="cart-summary-row">
                            <span class="cart-summary-label">Subtotal</span>
                            <span class="cart-summary-value" id="cartSubtotal">KSh {{ number_format($cartTotal) }}</span>
                        </div>
                        @php
                            $vatRate = 16;
                            $vat = round(($cartTotal * $vatRate) / 100);
                            $grandTotal = $cartTotal + $vat;
                        @endphp
                        <div class="cart-summary-row">
                            <span class="cart-summary-label">VAT ({{ $vatRate }}%)</span>
                            <span class="cart-summary-value" id="cartVat">KSh {{ number_format($vat) }}</span>
                        </div>
                        <div class="cart-summary-row cart-total-row">
                            <span class="cart-summary-label cart-total-label">Total Amount</span>
                            <span class="cart-summary-value cart-total-value" id="cartGrandTotal">KSh {{ number_format($grandTotal) }}</span>
                        </div>
                    </div>
                    
                    <div class="cart-modal-footer">
                        <div class="cart-actions-left">
                            <button type="button" class="cart-btn-clear" id="clearCartBtn">
                                <i class="bi bi-trash me-1"></i>Clear Cart
                            </button>
                            <a href="{{ route('products') }}" class="cart-btn-close" data-bs-dismiss="modal">
                                Continue Shopping
                            </a>
                        </div>
                        <div class="cart-actions-right">
                            <a href="{{ route('checkout') }}" class="cart-btn-checkout">
                                <i class="bi bi-credit-card me-1"></i>Checkout Now
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cart Notification -->
    <div class="cart-notification" id="cartNotification">
        <div class="cart-notification-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="cart-notification-content">
            <div class="cart-notification-title" id="cartNotificationTitle">Item Added</div>
            <div class="cart-notification-message" id="cartNotificationMessage">Product added to cart successfully</div>
        </div>
        <button type="button" class="btn-close" onclick="hideCartNotification()"></button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
    // =====================================
    // GLOBAL CART FUNCTIONALITY
    // =====================================
    
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // =====================================
        // ADD TO CART FUNCTION (GLOBAL)
        // =====================================
        window.addToCart = async function(productId, quantity = 1) {
            // Check if user is authenticated
            const isAuthenticated = await checkAuth();
            
            if (!isAuthenticated) {
                // User not logged in - store product info and redirect
                localStorage.setItem('pendingCartItem', JSON.stringify({
                    product: productId,
                    quantity: quantity,
                    timestamp: Date.now()
                }));
                
                showCartNotification('Please log in to add items to cart', 'error');
                
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}?redirect=cart';
                }, 1500);
                return;
            }
            
            // User is authenticated - add to cart
            try {
                const response = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showCartNotification('Product added to cart!', 'success');
                    updateCartBadge();
                    pulseCartButton();
                } else if (response.status === 401) {
                    // Session expired
                    localStorage.setItem('pendingCartItem', JSON.stringify({
                        product: productId,
                        quantity: quantity,
                        timestamp: Date.now()
                    }));
                    showCartNotification('Session expired. Redirecting to login...', 'error');
                    setTimeout(() => {
                        window.location.href = '{{ route("login") }}?redirect=cart';
                    }, 1500);
                } else {
                    showCartNotification(data.message || 'Failed to add product', 'error');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                showCartNotification('Network error. Please try again.', 'error');
            }
        };
        
        // Check authentication
        async function checkAuth() {
            try {
                const response = await fetch('/cart/count', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin'
                });
                return response.ok;
            } catch (error) {
                return false;
            }
        }
        
        // Update cart badge
        function updateCartBadge() {
            fetch('/cart/count', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartBadge = document.querySelector('.cart-count-badge');
                    const cartTotalSpan = document.querySelector('.cart-total-amount');
                    
                    if (cartBadge) {
                        if (data.count > 0) {
                            cartBadge.textContent = data.count;
                            cartBadge.style.display = 'flex';
                        } else {
                            cartBadge.style.display = 'none';
                        }
                    }
                    
                    if (cartTotalSpan && data.total) {
                        if (data.total > 0) {
                            cartTotalSpan.innerHTML = `<span class="currency">KSh</span> ${data.total.toLocaleString()}`;
                            cartTotalSpan.style.display = 'inline';
                        } else {
                            cartTotalSpan.style.display = 'none';
                        }
                    }
                }
            })
            .catch(error => console.error('Error updating cart badge:', error));
        }
        
        // Show notification
        window.showCartNotification = function(message, type = 'success') {
            const notification = document.getElementById('cartNotification');
            const title = document.getElementById('cartNotificationTitle');
            const messageEl = document.getElementById('cartNotificationMessage');
            const icon = notification.querySelector('.cart-notification-icon i');
            
            if (type === 'success') {
                title.textContent = 'Success!';
                icon.className = 'bi bi-check-circle-fill';
                notification.style.borderLeftColor = 'var(--accent-green)';
            } else {
                title.textContent = 'Error';
                icon.className = 'bi bi-exclamation-triangle-fill';
                notification.style.borderLeftColor = '#dc2626';
            }
            
            messageEl.textContent = message;
            notification.classList.add('show');
            
            setTimeout(() => hideCartNotification(), 4000);
        };
        
        window.hideCartNotification = function() {
            document.getElementById('cartNotification')?.classList.remove('show');
        };
        
        // Pulse cart button
        function pulseCartButton() {
            const cartBtn = document.querySelector('.navbar-cart-btn');
            if (cartBtn) {
                cartBtn.style.animation = 'pulse-green 0.5s ease';
                setTimeout(() => {
                    cartBtn.style.animation = '';
                }, 500);
            }
        }
        
        // =====================================
        // PROCESS PENDING CART ITEM AFTER LOGIN
        // =====================================
        const pendingItem = localStorage.getItem('pendingCartItem');
        if (pendingItem) {
            try {
                const item = JSON.parse(pendingItem);
                const thirtyMinutes = 30 * 60 * 1000;
                
                if (Date.now() - item.timestamp < thirtyMinutes) {
                    console.log('Adding pending cart item:', item);
                    setTimeout(() => {
                        addToCart(item.product, item.quantity);
                    }, 500);
                }
            } catch (error) {
                console.error('Error processing pending cart item:', error);
            }
            localStorage.removeItem('pendingCartItem');
        }
        
        // =====================================
        // CART MODAL INCREMENT/DECREMENT/REMOVE
        // =====================================
        
        // Increment quantity
        document.querySelectorAll('.increment-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const index = this.getAttribute('data-index');
                const qtyInput = document.getElementById('qty-' + id);
                
                if (!qtyInput) return;
                
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                this.disabled = true;
                
                fetch('/cart/increment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ id, index })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        qtyInput.value = data.quantity;
                        const priceEl = document.getElementById('price-' + id);
                        if (priceEl && data.item_total) {
                            priceEl.textContent = 'KSh ' + data.item_total.toLocaleString();
                        }
                        updateCartTotals();
                        updateCartBadge();
                        
                        const decrementBtn = document.querySelector('.decrement-btn[data-id="' + id + '"]');
                        if (decrementBtn) decrementBtn.disabled = false;
                    }
                })
                .finally(() => {
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                });
            });
        });
        
        // Decrement quantity
        document.querySelectorAll('.decrement-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (this.disabled) return;
                
                const id = this.getAttribute('data-id');
                const index = this.getAttribute('data-index');
                const qtyInput = document.getElementById('qty-' + id);
                const currentQty = parseInt(qtyInput.value) || 1;
                
                if (currentQty <= 1) {
                    if (confirm('Remove this item from cart?')) {
                        removeItem(id, index);
                    }
                    return;
                }
                
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                this.disabled = true;
                
                fetch('/cart/decrement', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ id, index })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.removed) {
                            document.getElementById('cartItem-' + id)?.remove();
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload();
                            }
                        } else {
                            qtyInput.value = data.quantity;
                            const priceEl = document.getElementById('price-' + id);
                            if (priceEl && data.item_total) {
                                priceEl.textContent = 'KSh ' + data.item_total.toLocaleString();
                            }
                            if (data.quantity <= 1) this.disabled = true;
                        }
                        updateCartTotals();
                        updateCartBadge();
                    }
                })
                .finally(() => {
                    if (!this.disabled) this.innerHTML = originalHTML;
                });
            });
        });
        
        // Remove item
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const index = this.getAttribute('data-index');
                
                if (confirm('Remove this item from cart?')) {
                    removeItem(id, index);
                }
            });
        });
        
        function removeItem(id, index) {
            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ id, index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cartItem-' + id)?.remove();
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    }
                    updateCartTotals();
                    updateCartBadge();
                }
            });
        }
        
        // Update cart totals
        function updateCartTotals() {
            let subtotal = 0;
            document.querySelectorAll('.cart-item-price').forEach(priceEl => {
                const match = priceEl.textContent.match(/(\d+[\d,.]*\d+)/);
                if (match) {
                    subtotal += parseFloat(match[1].replace(/,/g, ''));
                }
            });
            
            const vat = Math.round(subtotal * 0.16);
            const total = subtotal + vat;
            
            document.getElementById('cartSubtotal')?.textContent = 'KSh ' + subtotal.toLocaleString();
            document.getElementById('cartVat')?.textContent = 'KSh ' + vat.toLocaleString();
            document.getElementById('cartGrandTotal')?.textContent = 'KSh ' + total.toLocaleString();
        }
        
        // Clear cart
        document.getElementById('clearCartBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Clear entire cart?')) {
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) location.reload();
                });
            }
        });
        
        // Initial cart badge update
        updateCartBadge();
    });
    
    // =====================================
    // SCROLL TO TOP
    // =====================================
    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    window.addEventListener('scroll', function() {
        const scrollTopBtn = document.querySelector('.scroll-top');
        if (scrollTopBtn) {
            scrollTopBtn.classList.toggle('show', window.pageYOffset > 300);
        }
    });
    </script>
</body>
</html>