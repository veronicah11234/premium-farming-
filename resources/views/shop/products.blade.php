{{-- product.blade --}}
@extends('layouts.app')

@section('title', 'Our Products | Premium Farming Feeds')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="hero-section-products">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="{{ asset('videos/kkk.mp4') }}" type="video/mp4">
    </video>

    <div class="hero-overlay">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-3">Premium Farming Products</h1>
                    <p class="hero-subtitle mb-4">
                        Quality feeds for all your livestock needs
                    </p>
                    <a href="#products" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-arrow-down me-2"></i> Browse Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Flash Messages -->
@if(session('success'))
<div class="container mt-4">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@if(session('error'))
<div class="container mt-4">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<!-- Products Section -->
<div class="container my-5" id="products">
    <h2 class="mb-4 text-center section-title">Our Products</h2>

    @if($products->isNotEmpty())
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm product-card">

                <!-- Image -->
                <div class="card-img-top-container">
                    <img
                        class="card-img-top"
                        src="{{ $product['image'] ?? asset('images/no-image.png') }}"
                        alt="{{ $product['name'] }}">
                </div>

                <!-- Body -->
                <div class="card-body d-flex flex-column">
                    <h5 class="fw-bold">{{ $product['name'] }}</h5>

                    <p class="price-tag text-success fw-bold">
                        KES {{ number_format($product['unit_price'], 2) }}
                    </p>

                    @if(!empty($product['sku']))
                    <small class="text-muted mb-2">SKU: {{ $product['sku'] }}</small>
                    @endif

                    <div class="mt-auto">
                        @if(request()->hasCookie('access_token'))
                        <!-- User is authenticated via cookie -->
                        <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <input type="hidden" name="quantity" value="1">

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-cart-plus me-2"></i> Add to Cart
                            </button>
                        </form>
                        @else
                        <!-- User is not authenticated -->
                        <button
                            class="btn btn-outline-success w-100 login-prompt-btn"
                            data-product-id="{{ $product['id'] }}"
                            data-product-name="{{ $product['name'] }}">
                            <i class="bi bi-cart-plus me-2"></i> Add to Cart
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
        <h4 class="text-muted">No products available</h4>
    </div>
    @endif
</div>

<!-- Login/Signup Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="authModalLabel">
                    <i class="bi bi-lock-fill me-2 text-success"></i>Login Required
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                <h5 class="mb-3">Please log in to add items to your cart</h5>
                <p class="text-muted mb-4" id="productMessage"></p>

                <div class="d-grid gap-2">
                    <a href="{{ route('login') }}" class="btn btn-success btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg">
                        <i class="bi bi-person-plus me-2"></i> Create Account
                    </a>
                </div>

                <p class="text-muted mt-3 mb-0 small">
                    Create an account to enjoy a seamless shopping experience
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hero Section with Video */
    .hero-section-products {
        position: relative;
        min-height: 60vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        color: white;
        margin-top: 76px;
    }

    .hero-video {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.45);
    }

    .hero-overlay {
        position: relative;
        z-index: 2;
        padding: 90px 0;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
    }

    .hero-subtitle {
        font-size: 1.2rem;
    }

    .product-card {
        border-radius: 15px;
        transition: 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .card-img-top-container {
        height: 200px;
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .price-tag {
        font-size: 1.2rem;
    }

    .section-title {
        font-weight: 700;
        color: #2a6e3f;
    }

    .price-tag {
        font-size: 1.3rem;
        margin: 0.5rem 0;
    }

    .section-title {
        color: #2a6e3f;
        font-weight: 700;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(to right, #2a6e3f, #4caf50);
        border-radius: 2px;
    }

    /* Button Improvements */
    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-shadow: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(42, 110, 63, 0.3);
    }

    .btn-outline-success {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        border-width: 2px;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background: #2a6e3f;
        transform: translateY(-2px);
    }

    /* Loading state for forms */
    .add-to-cart-form.loading button {
        position: relative;
        color: transparent;
    }

    .add-to-cart-form.loading button:after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spinner 0.6s linear infinite;
    }

    @keyframes spinner {
        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section-products {
            min-height: 50vh;
            margin-top: 56px;
        }

        .hero-overlay {
            padding: 60px 0;
        }

        .hero-title {
            font-size: 2.2rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .card-img-top-container {
            height: 180px;
        }

        .col-md-3 {
            margin-bottom: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.8rem;
        }

        .hero-section-products {
            min-height: 40vh;
        }

        .hero-overlay {
            padding: 50px 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle login prompt buttons
        const loginPromptButtons = document.querySelectorAll('.login-prompt-btn');
        const authModal = new bootstrap.Modal(document.getElementById('authModal'));
        const productMessage = document.getElementById('productMessage');

        loginPromptButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productName = this.getAttribute('data-product-name');
                productMessage.textContent = `You're trying to add "${productName}" to your cart.`;
                authModal.show();
            });
        });

        // Handle add to cart forms with loading state
        const addToCartForms = document.querySelectorAll('.add-to-cart-form');

        addToCartForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                button.disabled = true;
                this.classList.add('loading');
            });
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>

@endsection