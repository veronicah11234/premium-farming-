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
    }

    .btn-quantity:hover {
        background: #f8f9fa;
        border-color: #2d6e4f;
    }

    .btn-remove {
        color: #dc3545;
        background: none;
        border: none;
        padding: 0.5rem;
    }

    .btn-remove:hover {
        color: #bd2130;
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-cart-icon {
        font-size: 5rem;
        color: #dee2e6;
    }
</style>

<script>
    // Cart state
    let cartData = null;

    // Load cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCart();
    });

    // Load cart from API
    async function loadCart() {
        try {
            const response = await fetch('/api/cart', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin' // Include cookies
            });

            if (response.ok) {
                cartData = await response.json();
                renderCart();
            } else if (response.status === 401) {
                // Not authenticated
                window.location.href = '{{ route("login") }}';
            } else {
                showError('Failed to load cart');
            }
        } catch (error) {
            console.error('Error loading cart:', error);
            showError('Error loading cart');
        }
    }

    // Render cart items
    function renderCart() {
        const container = document.getElementById('cart-items-container');
        
        if (!cartData || !cartData.items || cartData.items.length === 0) {
            container.innerHTML = `
                <div class="empty-cart">
                    <i class="bi bi-cart-x empty-cart-icon"></i>
                    <h3 class="mt-4 mb-2">Your cart is empty</h3>
                    <p class="text-muted mb-4">Add some products to get started!</p>
                    <a href="{{ route('products') }}" class="btn btn-success">
                        <i class="bi bi-arrow-left me-2"></i>
                        Browse Products
                    </a>
                </div>
            `;
            updateSummary(0, 0);
            return;
        }

        let html = '';
        let subtotal = 0;

        cartData.items.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            html += `
                <div class="cart-item" data-item-id="${item.id}">
                    <div class="row align-items-center">
                        <div class="col-md-2 mb-3 mb-md-0">
                            <img src="${item.image || '/images/placeholder.jpg'}" alt="${item.name}" class="cart-item-image">
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="mb-1 fw-semibold">${item.name}</h6>
                            <p class="text-muted small mb-0">${item.description || ''}</p>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <span class="fw-semibold">KES ${parseFloat(item.price).toFixed(2)}</span>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn-quantity" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="quantity-input" value="${item.quantity}" min="1" 
                                    onchange="updateQuantity(${item.id}, this.value)" readonly>
                                <button class="btn-quantity" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-1 text-end">
                            <button class="btn-remove" onclick="removeItem(${item.id})" title="Remove item">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        updateSummary(subtotal, subtotal);
    }

    // Update cart summary
    function updateSummary(subtotal, total) {
        document.getElementById('cart-subtotal').textContent = `KES ${subtotal.toFixed(2)}`;
        document.getElementById('cart-total').textContent = `KES ${total.toFixed(2)}`;
    }

    // Update item quantity
    async function updateQuantity(itemId, newQuantity) {
        if (newQuantity < 1) {
            removeItem(itemId);
            return;
        }

        try {
            const response = await fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: newQuantity
                })
            });

            if (response.ok) {
                loadCart(); // Reload cart
                showSuccess('Cart updated');
            } else {
                showError('Failed to update cart');
            }
        } catch (error) {
            console.error('Error updating cart:', error);
            showError('Error updating cart');
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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    item_id: itemId
                })
            });

            if (response.ok) {
                loadCart(); // Reload cart
                updateCartCount(); // Update header cart count
                showSuccess('Item removed from cart');
            } else {
                showError('Failed to remove item');
            }
        } catch (error) {
            console.error('Error removing item:', error);
            showError('Error removing item');
        }
    }

    // Update cart count in header
    function updateCartCount() {
        // This will call your existing cart count endpoint
        fetch('/cart/count', {
            credentials: 'same-origin'
        })
        .then(r => r.json())
        .then(data => {
            const badge = document.querySelector('.cart-count-badge');
            if (badge) {
                badge.textContent = data.count || 0;
            }
        });
    }

    // Show success message
    function showSuccess(message) {
        // You can use Bootstrap toast or simple alert
        const toast = document.createElement('div');
        toast.className = 'alert alert-success position-fixed top-0 end-0 m-3';
        toast.style.zIndex = '9999';
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Show error message
    function showError(message) {
        const toast = document.createElement('div');
        toast.className = 'alert alert-danger position-fixed top-0 end-0 m-3';
        toast.style.zIndex = '9999';
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Checkout button
    document.getElementById('checkout-btn').addEventListener('click', function() {
        if (!cartData || !cartData.items || cartData.items.length === 0) {
            alert('Your cart is empty');
            return;
        }
        // Redirect to checkout page
        window.location.href = '/checkout';
    });
</script>
@endsection