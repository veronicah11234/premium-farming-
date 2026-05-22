@extends('layouts.app')

@section('title', ucfirst($slug) . ' Feeds | Premium Farming Feeds')

@section('content')

<section class="products-section py-5" id="products">

    <div class="container">

        {{-- Category Title --}}
        <div class="text-center mb-5">

            <h2 class="section-title capitalize">
                {{ str_replace('-', ' ', $slug) }} Feeds
            </h2>

            <p class="section-subtitle">
                Premium quality feeds for your farming needs
            </p>

        </div>

        @if(!empty($products) && count($products) > 0)

            <div class="row g-4">

                @foreach($products as $product)

                    <div class="col-md-3 col-sm-6">

                        <div class="product-card">

                            <div class="product-image-wrapper">

                                <!-- <div class="product-badge">
                                    New
                                </div> -->

                                <img
                                    src="{{ $product['image'] ?? $product['image_url'] ?? asset('images/no-image.png') }}"
                                    alt="{{ $product['name'] ?? 'Product' }}"
                                    class="product-image"
                                    loading="lazy"
                                >

                                <div class="product-overlay">

                                    <a
                                        href="/products/{{ $product['slug'] ?? $product['id'] }}"
                                        class="quick-view-btn text-decoration-none"
                                    >
                                        <i class="bi bi-eye"></i>
                                        View Product
                                    </a>

                                </div>

                            </div>

                            <div class="product-content">

                                <h3 class="product-title">
                                    {{ $product['name'] ?? 'Unknown Product' }}
                                </h3>

                                <div class="product-price">

                                    <span class="currency">
                                        KES
                                    </span>

                                    <span class="amount">
                                        {{ number_format($product['unit_price'] ?? 0, 2) }}
                                    </span>

                                </div>

                                <div class="product-actions">

                                    <button
                                        class="btn-add-to-cart"
                                        data-product-id="{{ $product['id'] }}"
                                        data-product-name="{{ $product['name'] ?? $product['product_name'] }}"
                                        onclick="addItem(event, {{ $product['id'] }}, 1)">
                                        <i class="bi bi-cart-plus"></i>
                                        <span>Add to Cart</span>
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            {{-- View Cart --}}
            <div class="text-center mt-5">

                <a
                    href="{{ route('cart.view') }}"
                    class="btn-view-cart"
                >

                    <i class="bi bi-cart3 me-2"></i>

                    View Cart

                    <i class="bi bi-arrow-right ms-2"></i>

                </a>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-state-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <h4>
                    No products available
                </h4>

                <p>
                    Please check back later or contact us for assistance.
                </p>

            </div>

        @endif

    </div>

</section>

@endsection

<style>
    .hero-section-products {
        position: relative;
        min-height: 60vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        color: white;
        margin-top: 76px;
    }

    /* Single Banner Background */
    .hero-banner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        overflow: hidden;
    }

    .banner-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.45);
        z-index: 2;
        pointer-events: none;
    }

    .hero-overlay {
        position: relative;
        z-index: 3;
        padding: 90px 0;
        width: 100%;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
        animation: fadeInUp 1s ease;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.4);
        animation: fadeInUp 1s ease 0.2s both;
    }

    .hero-overlay .btn-success {
        animation: fadeInUp 1s ease 0.4s both;
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .hero-overlay .btn-success:hover {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ── Products Section ── */
    .products-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .section-title {
        color: #2a6e3f;
        font-weight: 700;
        font-size: 2.5rem;
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .section-title::after {
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

    .section-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .product-image-wrapper {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ff6b6b, #ff4757);
        color: white;
        padding: 5px 12px;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(255, 71, 87, 0.3);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 3;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .quick-view-btn {
        background: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        color: #2a6e3f;
        font-weight: 600;
        font-size: 0.9rem;
        transform: translateY(20px);
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .product-card:hover .quick-view-btn {
        transform: translateY(0);
    }

    .quick-view-btn:hover {
        background: #2a6e3f;
        color: white;
    }

    .product-content {
        padding: 20px;
    }

    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        line-height: 1.4;
        height: 2.8em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-meta {
        margin-bottom: 15px;
    }

    .product-sku {
        font-size: 0.8rem;
        color: #999;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f8f9fa;
        padding: 4px 10px;
        border-radius: 15px;
    }

    .product-price {
        margin-bottom: 20px;
        display: flex;
        align-items: baseline;
        gap: 5px;
    }

    .product-price .currency {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .product-price .amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2a6e3f;
        line-height: 1;
    }

    .product-actions {
        width: 100%;
    }

    .btn-add-to-cart {
        width: 100%;
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(42, 110, 63, 0.2);
    }

    .btn-add-to-cart:hover:not(:disabled) {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(42, 110, 63, 0.3);
    }

    .btn-add-to-cart:disabled {
        opacity: 0.75;
        cursor: not-allowed;
        transform: none;
    }

    .btn-add-to-cart i {
        font-size: 1.2rem;
    }

    .btn-view-cart {
        display: inline-flex;
        align-items: center;
        padding: 15px 40px;
        background: linear-gradient(135deg, #1a6eb5, #2a8fd4);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(26, 110, 181, 0.3);
    }

    .btn-view-cart:hover {
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(26, 110, 181, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .empty-state h4 {
        color: #495057;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #868e96;
        margin-bottom: 0;
    }

    /* ── Cart Toast Notification ── */
    .cart-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #fff;
        border: none;
        border-left: 5px solid #2a6e3f;
        border-radius: 15px;
        padding: 16px 24px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #1a1a1a;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        z-index: 9999;
        display: flex;
        align-items: center;
        animation: slideInRight 0.3s ease;
        max-width: 380px;
    }

    .cart-toast.error {
        border-left-color: #dc3545;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .hero-section-products {
            min-height: 50vh;
            margin-top: 56px;
        }

        .hero-overlay { padding: 60px 0; }
        .hero-title { font-size: 2.2rem; }
        .hero-subtitle { font-size: 1rem; }
        
        .section-title { font-size: 2rem; }
        .section-subtitle { font-size: 1rem; }
        
        .cart-toast {
            bottom: 15px;
            right: 15px;
            left: 15px;
            max-width: 100%;
        }
    }

    @media (max-width: 576px) {
        .hero-title { font-size: 1.8rem; }
        .hero-section-products { min-height: 40vh; }
        .hero-overlay { padding: 50px 0; }
        
        .section-title { font-size: 1.8rem; }
        .product-title { font-size: 1rem; }
        .product-price .amount { font-size: 1.3rem; }
    }
</style>

@push('scripts')
<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

   
    window.addItem = async function (event, productId, quantity) {
        const btn = event.currentTarget;
        const originalHTML = btn.innerHTML;
        const productName = btn.getAttribute('data-product-name') || 'Item';

        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';
        btn.disabled = true;

        try {
            const response = await fetch('/proxy/cart/items/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ product: productId, quantity: quantity }),
            });

            const data = await response.json();

            if (response.ok) {
                btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Added!';
                btn.style.background = 'linear-gradient(135deg, #28a745, #34ce57)';
                
                showToast(`${productName} added to cart!`, 'success');
                updateCartBadge(data.total_items ?? null);

                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-cart-plus"></i><span>Add to Cart</span>';
                    btn.style.background = '';
                    btn.disabled = false;
                }, 2500);

            } else if (response.status === 401) {
                
                showToast('Could not add to cart. Please refresh and try again.', 'error');
                btn.innerHTML = originalHTML;
                btn.disabled = false;

            } else {
                const msg = data?.detail || data?.message || 'Could not add to cart. Try again.';
                showToast(msg, 'error');
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }

        } catch (err) {
            console.error('[addItem] Network error:', err);
            showToast('Network error. Please check your connection.', 'error');
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        }
    };

    function updateCartBadge(count) {
        if (count === null || count === undefined) return;
        const badge = document.querySelector('.cart-badge');
        if (!badge) return;
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    }

    window.quickView = function (productId) {
        console.log('Quick view for product:', productId);
    };

    function showToast(message, type = 'success') {
        const toast = document.getElementById('cart-toast');
        const msg   = document.getElementById('cart-toast-msg');
        const icon  = toast.querySelector('i');

        msg.textContent = message;
        toast.className = 'cart-toast' + (type === 'error' ? ' error' : '');
        
        icon.className = type === 'error'
            ? 'bi bi-exclamation-circle-fill me-2 text-danger'
            : 'bi bi-check-circle-fill me-2 text-success';

        toast.style.display = 'flex';
        toast.style.opacity = '1';

        clearTimeout(toast._hideTimer);
        toast._hideTimer = setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.style.display = 'none';
                toast.style.opacity = '1';
            }, 300);
        }, 3000);
    }

    setTimeout(function () {
        document.querySelectorAll('.alert').forEach(function (alert) {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        });
    }, 5000);

})();
</script>
@endpush