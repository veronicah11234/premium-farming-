{{-- home.blade.php --}}
@extends('layouts.app')

@section('title', 'Premium Farming Feeds | Quality Livestock Nutrition Solutions')

@push('styles')
<style>
    /* CSS Variables for Green Theme */
    :root {
        --primary-green: #2a6e3f;
        --secondary-green: #38a169;
        --light-green: #68d391;
        --dark-green: #22543d;
        --accent-green: #10b981;
        --navy-green: #1e422e;
        --gold-green: #d4af37;
        --text-light: #4a5568;
        --off-white: #f7fafc;
        --card-bg: #ffffff;
        
        --gradient-green: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        --gradient-dark-green: linear-gradient(135deg, var(--navy-green), var(--primary-green));
        
        --shadow-soft: 0 4px 20px rgba(42, 110, 63, 0.1);
        --shadow-medium: 0 8px 30px rgba(42, 110, 63, 0.15);
    }

    /* Hero Section */
    .hero-section {
        min-height: 90vh;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
    }
    
    .hero-image-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background-image: url('{{ asset('images/bann.jpeg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        filter: contrast(1.05) brightness(1.05) saturate(1.1);
    }
    
    .hero-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.15);
        z-index: 1;
        pointer-events: none;
    }
    
    /* Hero Content - Button at Bottom Left */
    .hero-content {
        position: relative;
        z-index: 3;
        height: 90vh;
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
        padding-bottom: 5rem;
    }
    
    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: flex-start;
    }
    
    .btn-premium {
        background: var(--gradient-green);
        border: none;
        color: white;
        transition: all 0.3s ease;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-premium:hover {
        background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(42, 110, 63, 0.4);
    }

    /* Stats Section */
    .stats-section {
        background: var(--off-white);
        padding: 5rem 0;
        border-bottom: 1px solid rgba(42, 110, 63, 0.1);
    }
    
    .stat-card {
        text-align: center;
        padding: 2.5rem 1.5rem;
        background: var(--card-bg);
        border-radius: 8px;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        border: 1px solid rgba(42, 110, 63, 0.08);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-green);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
        border-color: var(--light-green);
    }
    
    .stat-number {
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--navy-green);
        margin-bottom: 0.5rem;
        font-family: 'Cormorant Garamond', serif;
    }
    
    .stat-label {
        color: var(--text-light);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 500;
    }
    
    /* Features Section */
    .feature-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--gradient-green);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 20px rgba(42, 110, 63, 0.2);
        transition: all 0.3s ease;
    }
    
    .feature-icon {
        font-size: 1.8rem;
        color: white;
    }
    
    .premium-card:hover .feature-icon-wrapper {
        transform: rotate(10deg) scale(1.1);
    }

    .premium-card {
        transition: all 0.3s ease;
        padding: 2rem;
        border-radius: 8px;
        background: var(--card-bg);
        border: 1px solid rgba(42, 110, 63, 0.08);
        height: 100%;
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }
    
    /* Category Cards */
    .category-card {
        background: var(--card-bg);
        border-radius: 8px;
        padding: 2.5rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid rgba(42, 110, 63, 0.08);
        position: relative;
        overflow: hidden;
    }
    
    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-green);
        transform: translateX(-100%);
        transition: transform 0.4s ease;
    }
    
    .category-card:hover::before {
        transform: translateX(0);
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        border-color: var(--light-green);
        box-shadow: var(--shadow-medium);
    }
    
    .category-icon {
        font-size: 3rem;
        margin-bottom: 1.5rem;
        display: inline-block;
        transition: transform 0.3s ease;
        color: var(--primary-green);
        animation: leafFloat 3s ease-in-out infinite;
    }

    @keyframes leafFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }
    
    .category-card:hover .category-icon {
        transform: scale(1.2);
    }
    
    /* CTA Section */
    .cta-section {
        background: var(--gradient-dark-green);
        color: white;
        padding: 6rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
    
    .cta-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .cta-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }
    
    .cta-text {
        font-family: 'Inter', sans-serif;
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        line-height: 1.7;
        font-weight: 300;
    }

    /* Section Styles */
    .section-title h2 {
        color: var(--navy-green);
        position: relative;
        padding-bottom: 1rem;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gradient-green);
        border-radius: 2px;
    }

    .section-title.text-center h2::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .bg-light {
        background-color: #f8faf7 !important;
        position: relative;
        overflow: hidden;
    }

    .bg-light::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M41 28c-2 0-4 2-4 4s2 4 4 4 4-2 4-4-2-4-4-4zM11 58c-2 0-4 2-4 4s2 4 4 4 4-2 4-4-2-4-4-4zm68-20c-2 0-4 2-4 4s2 4 4 4 4-2 4-4-2-4-4-4zm-48 40c-2 0-4 2-4 4s2 4 4 4 4-2 4-4-2-4-4-4z' fill='%232a6e3f' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.1;
        z-index: 1;
    }

    .bg-light > * {
        position: relative;
        z-index: 2;
    }

    .text-green {
        color: var(--primary-green) !important;
    }

    .text-dark-green {
        color: var(--navy-green) !important;
    }

    .border-green {
        border-color: rgba(42, 110, 63, 0.1) !important;
    }

    @media (max-width: 768px) {
        .hero-content {
            padding-bottom: 3rem;
        }
        
        .hero-buttons .btn {
            width: 100%;
            max-width: 280px;
        }
        
        .stat-number {
            font-size: 3rem;
        }
        
        .cta-title {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-content {
            padding-bottom: 2rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
        }
        
        .cta-title {
            font-size: 1.8rem;
        }
        
        .cta-text {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section - Button at Bottom Left -->
    <section class="hero-section">
        <div class="hero-image-bg"></div>
        <div class="hero-image-overlay"></div>
        
        <div class="container">
            <div class="hero-content">
                <div class="hero-buttons animate__animated animate__fadeInUp">
                    <a href="{{ route('products') }}" class="btn btn-premium btn-lg">
                        <i class="bi bi-cart-plus me-2"></i>
                        Browse Products
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Categories Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-title animate-on-scroll text-center">
                <h2>Our Product Categories</h2>
                <p>Comprehensive nutrition solutions for all livestock types</p>
            </div>
            
            <div class="row g-4">
                @foreach([
                    ['name' => 'Poultry Feeds', 'slug' => 'poultry', 'icon' => '🐔', 'desc' => 'Broiler, layers & kienyeji feeds for optimal growth'],
                    ['name' => 'Dairy Feeds', 'slug' => 'dairy', 'icon' => '🐄', 'desc' => 'Specialized feeds for higher milk production'],
                    ['name' => 'Swine Feeds', 'slug' => 'swine', 'icon' => '🐖', 'desc' => 'Complete nutrition for pigs at all growth stages'],
                    ['name' => 'Pet Feeds', 'slug' => 'pet-feeds', 'icon' => '🐶', 'desc' => 'Premium nutrition for dogs, cats & rabbits'],
                    ['name' => 'By-products', 'slug' => 'by-products', 'icon' => '🌾', 'desc' => 'Maize germ, wheat bran & supplements'],
                    ['name' => 'Goat Feeds', 'slug' => 'goat-feeds', 'icon' => '🐐', 'desc' => 'Specialized feeds for dairy & meat goats'],
                ] as $cat)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('category.show', $cat['slug']) }}" class="text-decoration-none">
                        <div class="category-card animate-on-scroll">
                            <div class="category-icon mb-3">
                                {{ $cat['icon'] }}
                            </div>
                            <h4 class="fw-bold mb-2 text-dark-green">{{ $cat['name'] }}</h4>
                            <p class="text-muted mb-0">{{ $cat['desc'] }}</p>
                            <div class="mt-3">
                                <span class="text-green fw-bold">Explore →</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section> --}}

    <!-- Features Section -->
    <section class="section">
        <div class="container">
            <div class="section-title animate-on-scroll text-center">
                <h2>Why Choose Premium Feeds?</h2>
                <p>Our commitment to excellence sets us apart in livestock nutrition</p>
            </div>
            
            <div class="row g-4">
                @foreach([
                    ['icon' => 'award', 'title' => 'Premium Quality', 'desc' => 'Scientifically formulated for optimal livestock performance and health.'],
                    ['icon' => 'clipboard-check', 'title' => 'Quality Control', 'desc' => 'Rigorous testing at every production stage ensures consistency.'],
                    ['icon' => 'truck', 'title' => 'Nationwide Delivery', 'desc' => 'Reliable supply chain serving farmers across Kenya.'],
                    ['icon' => 'people', 'title' => 'Expert Support', 'desc' => 'Dedicated agricultural experts for personalized advice.'],
                    ['icon' => 'leaf', 'title' => 'Natural Ingredients', 'desc' => 'Made from high-quality, locally-sourced natural ingredients.'],
                    ['icon' => 'graph-up', 'title' => 'Proven Results', 'desc' => 'Documented improvements in yield and livestock health.'],
                ] as $feature)
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card animate-on-scroll">
                        <div class="feature-icon-wrapper">
                            <i class="bi bi-{{ $feature['icon'] }} feature-icon"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark-green">{{ $feature['title'] }}</h4>
                        <p class="text-muted mb-0">{{ $feature['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="text-dark-green">Trusted by Farmers Nationwide</h2>
                <p class="text-muted">Excellence in quality and service since 2020</p>
            </div>
            
            <div class="row g-4">
                @foreach([
                    ['number' => '4.8/5', 'label' => 'Average Rating', 'icon' => 'star-fill', 'color' => 'gold-green'],
                    ['number' => '500+', 'label' => 'Satisfied Farmers', 'icon' => 'people-fill', 'color' => 'primary-green'],
                    ['number' => '5+', 'label' => 'Years Experience', 'icon' => 'award-fill', 'color' => 'secondary-green'],
                    ['number' => '98%', 'label' => 'Recommend Us', 'icon' => 'hand-thumbs-up-fill', 'color' => 'accent-green'],
                    ['number' => '50+', 'label' => 'Quality Products', 'icon' => 'basket2-fill', 'color' => 'light-green'],
                    ['number' => '24/7', 'label' => 'Support', 'icon' => 'headset', 'color' => 'dark-green'],
                ] as $stat)
                <div class="col-md-4 col-lg-2">
                    <div class="stat-card animate-on-scroll">
                        <div class="mb-3">
                            <i class="bi bi-{{ $stat['icon'] }} fs-2" style="color: var(--{{ $stat['color'] }});"></i>
                        </div>
                        <div class="stat-number">{{ $stat['number'] }}</div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="row mt-5 pt-5">
                <div class="col-12">
                    <div class="text-center">
                        <h4 class="mb-4 text-dark-green">Why Farmers Trust Us</h4>
                        <div class="row g-3 justify-content-center">
                            @foreach([
                                ['icon' => 'shield-check', 'title' => 'Premium Quality', 'desc' => 'Guaranteed'],
                                ['icon' => 'truck', 'title' => 'Reliable Delivery', 'desc' => 'On-time service'],
                                ['icon' => 'cash-coin', 'title' => 'Competitive Prices', 'desc' => 'Best value'],
                                ['icon' => 'award', 'title' => 'Expert Advice', 'desc' => 'Professional support'],
                            ] as $trust)
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-4 bg-light border-green">
                                    <i class="bi bi-{{ $trust['icon'] }} text-green d-block fs-4 mb-3"></i>
                                    <h6 class="fw-bold mb-2 text-dark-green">{{ $trust['title'] }}</h6>
                                    <p class="text-muted small mb-0">{{ $trust['desc'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-on-scroll">
                <h2 class="cta-title">Ready to Transform Your Farm?</h2>
                <p class="cta-text">
                    Join thousands of successful farmers who trust Premium Farming Feeds. 
                    Experience the difference in quality, yield, and profitability.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold text-green">
                        <i class="bi bi-cart-check me-2"></i>
                        Start Buying Now
                    </a>
                    <a href="/contact" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold border-2">
                        <i class="bi bi-telephone me-2"></i>
                        Get Expert Advice
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statNumbers = document.querySelectorAll('.stat-number');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const text = target.textContent;
                    if (text.includes('/')) {
                        const parts = text.split('/');
                        const value = parseFloat(parts[0]);
                        const total = parts[1];
                        let current = 0;
                        const increment = value / 30;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= value) {
                                target.textContent = value.toFixed(1) + '/' + total;
                                clearInterval(timer);
                            } else {
                                target.textContent = current.toFixed(1) + '/' + total;
                            }
                        }, 30);
                    } else if (text.includes('%')) {
                        const value = parseInt(text);
                        let current = 0;
                        const increment = value / 30;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= value) {
                                target.textContent = value + '%';
                                clearInterval(timer);
                            } else {
                                target.textContent = Math.floor(current) + '%';
                            }
                        }, 30);
                    } else {
                        const finalValue = parseInt(text);
                        let currentValue = 0;
                        const increment = finalValue / 30;
                        const timer = setInterval(() => {
                            currentValue += increment;
                            if (currentValue >= finalValue) {
                                target.textContent = finalValue + '+';
                                clearInterval(timer);
                            } else {
                                target.textContent = Math.floor(currentValue) + '+';
                            }
                        }, 30);
                    }
                    observer.unobserve(target);
                }
            });
        }, { threshold: 0.5 });
        
        statNumbers.forEach(stat => observer.observe(stat));
    });
</script>
@endpush