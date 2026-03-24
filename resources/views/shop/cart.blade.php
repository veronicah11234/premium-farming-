@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="container my-5">

    {{-- ─── Page Header ─── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h3 class="mb-0 fw-bold" style="color:#2a6e3f;">
            <i class="bi bi-cart3 me-2"></i>Your Cart
        </h3>
        {{-- ✅ Continue Shopping — always visible, never forces login --}}
        <a href="{{ route('products') }}" class="btn btn-outline-success">
            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
        </a>
    </div>

    {{-- ─── Notification Alert ─── --}}
    <div id="notificationAlert" class="alert d-none"></div>

    {{-- ─── Cart Contents ─── --}}
    <div id="cart" class="mt-3">
        <div class="text-center py-5">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading…</span>
            </div>
            <p class="text-muted mt-2">Loading your cart…</p>
        </div>
    </div>

    {{-- ─── Checkout Form (hidden until cart has items) ─── --}}
    <div id="checkoutSection" class="mt-5 d-none">
        <h4 class="fw-bold mb-4" style="color:#2a6e3f;">
            <i class="bi bi-bag-check me-2"></i>Checkout
        </h4>

        <form id="checkoutForm">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Full Name *</label>
                    <input type="text" class="form-control" name="name"
                           value="{{ session('django_user.full_name') ?? session('django_user.username') ?? '' }}"
                           required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone Number *</label>
                    <input type="tel" class="form-control" name="phone" placeholder="2547XXXXXXXX" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address *</label>
                <input type="email" class="form-control" name="email"
                       value="{{ session('django_user.email') ?? '' }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Delivery Address *</label>
                <textarea class="form-control" name="address" rows="3" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">County *</label>
                    <select class="form-control" name="county" required>
                        <option value="">Select County</option>
                        <option value="Nairobi">Nairobi</option>
                        <option value="Kiambu">Kiambu</option>
                        <option value="Nakuru">Nakuru</option>
                        <option value="Eldoret">Eldoret</option>
                        <option value="Kisumu">Kisumu</option>
                        <option value="Mombasa">Mombasa</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Town *</label>
                    <input type="text" class="form-control" name="town" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Delivery Type *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery_type" value="farm_delivery" checked>
                    <label class="form-check-label">Farm Delivery</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery_type" value="pickup_station">
                    <label class="form-check-label">Pickup Station</label>
                </div>
            </div>

            {{-- M-Pesa only --}}
            <input type="hidden" name="payment_method" value="mpesa">

            <div id="mpesaDetails" class="mb-4 border p-3 rounded bg-light">
                <label class="form-label fw-semibold">
                    <i class="bi bi-phone me-1 text-success"></i>M-Pesa Phone Number *
                </label>
                <input type="tel" class="form-control" name="mpesa_number"
                       placeholder="2547XXXXXXXX" required>
                <small class="text-muted">Enter the number that will receive the STK push prompt.</small>
            </div>

            <input type="hidden" name="total" id="checkoutTotal">

            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                    <i class="bi bi-phone me-2"></i>Pay with M-Pesa
                </button>
                <!-- <a href="{{ route('products') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a> -->
            </div>
        </form>
    </div>
</div>

<style>
    .table th { background-color: #f8fdf9; color: #2a6e3f; font-weight: 600; }
    .table td { vertical-align: middle; }

    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        font-weight: 600;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-1px);
    }
    .btn-outline-success {
        border-color: #2a6e3f;
        color: #2a6e3f;
        font-weight: 600;
    }
    .btn-outline-success:hover {
        background: #2a6e3f;
        color: white;
    }

    /* Empty cart state */
    .empty-cart-icon {
        font-size: 4rem;
        color: #c8e6c9;
    }
</style>

<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const API = {
        load:   '/proxy/cart',
        update: '/proxy/cart/update',
        remove: '/proxy/cart/remove',
    };

    let cart = { items: [], subtotal: 0, total_items: 0 };

    /* ─── Notification ─── */
    function showAlert(message, type = 'danger') {
        const el = document.getElementById('notificationAlert');
        el.className = `alert alert-${type}`;
        el.textContent = message;
        el.classList.remove('d-none');
        setTimeout(() => el.classList.add('d-none'), 4000);
    }

    /* ─── Load Cart ─── */
    async function loadCart() {
        try {
            const res = await fetch(API.load, {
                headers: {
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                credentials: 'same-origin',
            });

            // ✅ If not authenticated (no active token), show empty cart
            // gracefully — do NOT redirect to login
            if (res.status === 401) {
                renderEmpty();
                return;
            }

            if (!res.ok) {
                showAlert('Could not load cart. Please try again.');
                renderEmpty();
                return;
            }

            cart = await res.json();
            renderCart();
            renderCheckout();
            updateCartBadge();

        } catch (err) {
            console.error('[loadCart]', err);
            showAlert('Network error loading cart.');
            renderEmpty();
        }
    }

    /* ─── Render: Empty State ─── */
    function renderEmpty() {
        document.getElementById('cart').innerHTML = `
            <div class="text-center py-5">
                <i class="bi bi-cart-x empty-cart-icon d-block mb-3"></i>
                <h5 class="text-muted">Your cart is empty</h5>
                <p class="text-muted mb-4">Browse our products and add items to get started.</p>
                <a href="{{ route('products') }}" class="btn btn-success px-4">
                    <i class="bi bi-bag me-2"></i>Shop Now
                </a>
            </div>
        `;
        document.getElementById('checkoutSection').classList.add('d-none');
    }

    /* ─── Render: Cart Table ─── */
    function renderCart() {
        const container = document.getElementById('cart');

        if (!cart.items || cart.items.length === 0) {
            renderEmpty();
            return;
        }

        let rows = '';
        cart.items.forEach(item => {
            rows += `
                <tr>
                    <td>${item.product_name}</td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm btn-outline-secondary"
                                onclick="changeQuantity(${item.product}, ${item.quantity - 1})">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" min="1" value="${item.quantity}"
                                class="form-control text-center"
                                style="width:65px"
                                onchange="changeQuantity(${item.product}, this.value)">
                            <button class="btn btn-sm btn-outline-secondary"
                                onclick="changeQuantity(${item.product}, ${item.quantity + 1})">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>KES ${Number(item.unit_price).toLocaleString()}</td>
                    <td class="fw-semibold">KES ${(item.unit_price * item.quantity).toLocaleString(undefined, {minimumFractionDigits:2})}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="removeItem(${item.product})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        container.innerHTML = `
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="min-width:170px">Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
            <div class="text-end mt-2">
                <span class="fs-5 fw-bold" style="color:#2a6e3f;">
                    Subtotal: KES ${Number(cart.subtotal).toLocaleString(undefined, {minimumFractionDigits:2})}
                </span>
            </div>
        `;
    }

    function renderCheckout() {
        if (cart.items && cart.items.length > 0) {
            document.getElementById('checkoutSection').classList.remove('d-none');
            document.getElementById('checkoutTotal').value = cart.subtotal;
        } else {
            document.getElementById('checkoutSection').classList.add('d-none');
        }
    }

    /* ─── Change Quantity ─── */
    window.changeQuantity = async function (productId, quantity) {
        if (quantity <= 0) {
            removeItem(productId);
            return;
        }

        await fetch(API.update, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ product: productId, quantity: Number(quantity) }),
        });

        loadCart();
    };

    /* ─── Remove Item ─── */
    window.removeItem = async function (productId) {
        await fetch(API.remove, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ product: productId }),
        });

        loadCart();
    };

    /* ─── Cart Badge in Navbar ─── */
    function updateCartBadge() {
        const badge = document.querySelector('.cart-badge');
        if (!badge) return;
        badge.textContent   = cart.total_items;
        badge.style.display = cart.total_items ? 'flex' : 'none';
    }

    /* ─── Checkout Submit ─── */
    document.getElementById('checkoutForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const btn = this.querySelector('button[type="submit"]');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing…';
        btn.disabled  = true;

        try {
            const res = await fetch('/proxy/checkout/mpesa', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF },
                credentials: 'same-origin',
                body: new FormData(this),
            });

            if (!res.ok) {
                const err = await res.json().catch(() => ({}));
                showAlert(err.message || 'Checkout failed. Please try again.', 'danger');
                btn.innerHTML = '<i class="bi bi-phone me-2"></i>Pay with M-Pesa';
                btn.disabled  = false;
                return;
            }

            window.location.href = '/orders';

        } catch (err) {
            console.error('[checkout]', err);
            showAlert('Network error during checkout.', 'danger');
            btn.innerHTML = '<i class="bi bi-phone me-2"></i>Pay with M-Pesa';
            btn.disabled  = false;
        }
    });

    /* ─── Boot ─── */
    document.addEventListener('DOMContentLoaded', loadCart);

})();
</script>

@endsection