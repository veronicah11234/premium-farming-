@extends('layouts.app')

@section('title', 'Shopping Cart - Premium Farming Feeds')

@section('content')
<div class="min-vh-100 pt-24" style="background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4 fw-bold">
                    <i class="bi bi-cart3 me-2"></i>
                    Your Shopping Cart
                </h1>
            </div>
        </div>

        <!-- Cart Items Container -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div id="cart-items-container">
                            <!-- Cart items will be loaded here via AJAX -->
                            <div class="text-center py-5">
                                <div class="spinner-border text-success" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted">Loading your cart...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span id="cart-subtotal">KES 0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span class="text-success">Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong id="cart-total" class="text-success">KES 0.00</strong>
                        </div>

                        <button class="btn btn-success w-100 fw-semibold mb-3" id="checkout-btn">
                            <i class="bi bi-credit-card me-2"></i>
                            Proceed to Checkout
                        </button>

                        <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cart-item {
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem 0;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

    .quantity-input {
        width: 80px;
        text-align: center;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 0.5rem;
    }

    .btn-quantity {
        border: 1px solid #dee2e6;
        background: white;
        width: 35px;
        height: 35px;
        border-radius: 6px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-quantity:hover:not(:disabled) {
        background: #f8f9fa;
        border-color: #2d6e4f;
    }

    .btn-quantity:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-remove {
        color: #dc3545;
        background: none;
        border: none;
        padding: 0.5rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-remove:hover {
        color: #bd2130;
        transform: scale(1.1);
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-cart-icon {
        font-size: 5rem;
        color: #dee2e6;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }
</style>

@endsection

@push('scripts')
<script>
(function() {
    'use strict';
    
    // Cart state
    let cartData = null;

    // Load cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCart();
    });

    // Load cart from Laravel backend (which fetches from Django)
    async function loadCart() {
        try {
            const response = await fetch('/cart', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            });

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                console.error('Response is not JSON. Status:', response.status);
                
                // Session expired or not authenticated
                if (response.status === 401 || response.status === 302 || response.redirected) {
                    console.log('Authentication required. Redirecting to login...');
                    window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
                    return;
                }
                
                throw new Error('Invalid response format. Expected JSON but got: ' + contentType);
            }

            const data = await response.json();
            
            if (response.ok && data.success) {
                cartData = data;
                renderCart();
            } else if (response.status === 401 || !data.authenticated) {
                // Unauthenticated - redirect to login
                console.log('Not authenticated. Redirecting to login...');
                window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
            } else {
                showError(data.message || 'Failed to load cart');
                renderEmptyCart();
            }
        } catch (error) {
            console.error('Error loading cart:', error);
            showError('Error loading cart. Please refresh the page.');
            renderEmptyCart();
        }
    }

    // Render cart items
    function renderCart() {
        const container = document.getElementById('cart-items-container');
        
        if (!cartData || !cartData.items || cartData.items.length === 0) {
            renderEmptyCart();
            return;
        }

        // Clear container
        container.innerHTML = '';
        
        let subtotal = 0;

        // Create items
        cartData.items.forEach(function(item) {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            const cartItemDiv = document.createElement('div');
            cartItemDiv.className = 'cart-item';
            cartItemDiv.setAttribute('data-item-id', item.id);
            
            cartItemDiv.innerHTML = 
                '<div class="row align-items-center">' +
                    '<div class="col-md-2 mb-3 mb-md-0">' +
                        '<img src="' + (item.image || '{{ asset("images/no-image.png") }}') + '" ' +
                             'alt="' + escapeHtml(item.name) + '" ' +
                             'class="cart-item-image" ' +
                             'onerror="this.src=\'{{ asset("images/no-image.png") }}\'">' +
                    '</div>' +
                    '<div class="col-md-4 mb-3 mb-md-0">' +
                        '<h6 class="mb-1 fw-semibold">' + escapeHtml(item.name) + '</h6>' +
                        '<p class="text-muted small mb-0">' + escapeHtml(item.description || '') + '</p>' +
                    '</div>' +
                    '<div class="col-md-2 mb-3 mb-md-0">' +
                        '<span class="fw-semibold">KES ' + parseFloat(item.price).toLocaleString() + '</span>' +
                    '</div>' +
                    '<div class="col-md-3 mb-3 mb-md-0">' +
                        '<div class="d-flex align-items-center gap-2">' +
                            '<button class="btn-quantity decrement-btn" data-id="' + item.id + '" ' + (item.quantity <= 1 ? 'disabled' : '') + '>' +
                                '<i class="bi bi-dash"></i>' +
                            '</button>' +
                            '<input type="number" class="quantity-input" value="' + item.quantity + '" min="1" readonly>' +
                            '<button class="btn-quantity increment-btn" data-id="' + item.id + '">' +
                                '<i class="bi bi-plus"></i>' +
                            '</button>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-1 text-end">' +
                        '<button class="btn-remove remove-item-btn" data-id="' + item.id + '" title="Remove item">' +
                            '<i class="bi bi-trash"></i>' +
                        '</button>' +
                    '</div>' +
                '</div>';
            
            container.appendChild(cartItemDiv);
        });

        // Add event listeners
        attachEventListeners();
        
        updateSummary(subtotal, subtotal);
    }

    // Attach event listeners to dynamically created buttons
    function attachEventListeners() {
        // Increment buttons
        document.querySelectorAll('.increment-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                updateQuantity(itemId, 'increment', this);
            });
        });

        // Decrement buttons
        document.querySelectorAll('.decrement-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                updateQuantity(itemId, 'decrement', this);
            });
        });

        // Remove buttons
        document.querySelectorAll('.remove-item-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                removeItem(itemId);
            });
        });
    }

    // Render empty cart
    function renderEmptyCart() {
        const container = document.getElementById('cart-items-container');
        container.innerHTML = 
            '<div class="empty-cart">' +
                '<i class="bi bi-cart-x empty-cart-icon"></i>' +
                '<h3 class="mt-4 mb-2">Your cart is empty</h3>' +
                '<p class="text-muted mb-4">Add some products to get started!</p>' +
                '<a href="{{ route("products") }}" class="btn btn-success">' +
                    '<i class="bi bi-arrow-left me-2"></i>' +
                    'Browse Products' +
                '</a>' +
            '</div>';
        updateSummary(0, 0);
    }

    // Update cart summary
    function updateSummary(subtotal, total) {
        document.getElementById('cart-subtotal').textContent = 'KES ' + subtotal.toLocaleString();
        document.getElementById('cart-total').textContent = 'KES ' + total.toLocaleString();
    }

    // Update item quantity
    async function updateQuantity(itemId, action, button) {
        const endpoint = action === 'increment' ? '/cart/increment' : '/cart/decrement';
        
        // Show loading state
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="bi bi-hourglass-split"></i>';
        button.disabled = true;
        
        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    id: itemId,
                    index: 0
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Reload entire cart to ensure consistency
                await loadCart();
                
                // Update header cart count
                updateCartCount();
                
                showSuccess('Cart updated');
            } else {
                showError(data.message || 'Failed to update cart');
                button.innerHTML = originalHTML;
                button.disabled = false;
            }
        } catch (error) {
            console.error('Error updating cart:', error);
            showError('Error updating cart');
            button.innerHTML = originalHTML;
            button.disabled = false;
        }
    }

    // Remove item from cart
    async function removeItem(itemId) {
        if (!confirm('Remove this item from cart?')) return;

        try {
            const response = await fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    id: itemId,
                    index: 0
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Reload cart
                await loadCart();
                
                // Update header cart count
                updateCartCount();
                
                showSuccess('Item removed from cart');
            } else {
                showError(data.message || 'Failed to remove item');
            }
        } catch (error) {
            console.error('Error removing item:', error);
            showError('Error removing item');
        }
    }

    // Update cart count in header
    function updateCartCount() {
        fetch('/cart/count', {
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            const badge = document.querySelector('.cart-count-badge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(function(err) {
            console.error('Error updating cart count:', err);
        });
    }

    // Show success message
    function showSuccess(message) {
        const toast = document.createElement('div');
        toast.className = 'alert alert-success position-fixed top-0 end-0 m-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = '<i class="bi bi-check-circle me-2"></i>' + escapeHtml(message);
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 3000);
    }

    // Show error message
    function showError(message) {
        const toast = document.createElement('div');
        toast.className = 'alert alert-danger position-fixed top-0 end-0 m-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>' + escapeHtml(message);
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 3000);
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Checkout button
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (!cartData || !cartData.items || cartData.items.length === 0) {
                alert('Your cart is empty');
                return;
            }
            window.location.href = '{{ route("checkout") }}';
        });
    }
})();
</script>
@endpush