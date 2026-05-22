@extends('layouts.app')

@section('title', 'Cart | Premium Farming Feeds')

@section('content')
<div class="container my-5">

    {{-- ─── Page Header ─── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h3 class="mb-0 fw-bold" style="color:#2a6e3f;">
            <i class="bi bi-cart3 me-2"></i>Your Cart
        </h3>
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

    {{-- ─── Action Buttons (hidden until cart has items) ─── --}}
    <div id="cartActions" class="mt-4 text-center d-none">
        <button type="button" id="confirmOrderBtn" class="btn btn-success btn-lg px-5"
                onclick="window.location.href='/checkout/details'">
            <i class="bi bi-bag-check me-2"></i>Proceed to Checkout
        </button>
    </div>
</div>

<style>
    .table th { background-color: #f8fdf9; color: #2a6e3f; font-weight: 600; }
    .table td { vertical-align: middle; }

    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-success:hover:not(:disabled) {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-1px);
    }
    .btn-success:disabled {
        opacity: 0.7;
        cursor: not-allowed;
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

    .empty-cart-icon {
        font-size: 4rem;
        color: #c8e6c9;
    }

    .cart-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: white;
        border-left: 5px solid #25D366;
        border-radius: 10px;
        padding: 15px 25px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
    }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0);    opacity: 1; }
    }

    .qty-input {
        width: 65px;
        text-align: center;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 4px 6px;
        font-size: 0.95rem;
    }

    .qty-input:focus {
        outline: none;
        border-color: #2a6e3f;
        box-shadow: 0 0 0 2px rgba(42,110,63,0.15);
    }

    .btn-qty {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        background: #fff;
        color: #495057;
        cursor: pointer;
        transition: all 0.15s ease;
        padding: 0;
        font-size: 0.9rem;
    }

    .btn-qty:hover {
        background: #f0f9f3;
        border-color: #2a6e3f;
        color: #2a6e3f;
    }

    @media (max-width: 576px) {
        .cart-toast {
            bottom: 15px;
            right: 15px;
            left: 15px;
            max-width: 100%;
        }
    }
</style>

<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

   
    const API = {
        load:   '/proxy/cart',
        update: '/proxy/cart/items/update',
        remove: '/proxy/cart/items/remove',
    };

    let cart = { id: null, items: [], subtotal: 0, total_items: 0 };

    // ─── Toast ─────────────────────────────────────────────────────────────────
    function showToast(message, type = 'success', duration = 4000) {
        const existingToast = document.querySelector('.cart-toast');
        if (existingToast) existingToast.remove();

        const toast = document.createElement('div');
        toast.className = 'cart-toast';

        const icon = document.createElement('i');
        icon.className = type === 'success' ? 'bi bi-check-circle-fill text-success'
                       : type === 'error'   ? 'bi bi-exclamation-circle-fill text-danger'
                       :                      'bi bi-info-circle-fill text-info';

        const text = document.createElement('span');
        text.textContent = message;

        toast.appendChild(icon);
        toast.appendChild(text);
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.transition = 'opacity 0.3s ease';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    // ─── Load Cart ─────────────────────────────────────────────────────────────
    async function loadCart() {
        try {
            const res = await fetch(API.load, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                credentials: 'same-origin',
            });

            if (!res.ok) {
                console.warn('[loadCart] Cart endpoint returned', res.status);
                renderEmpty();
                return;
            }

            cart = await res.json();

            // Persist cart ID for checkout page
            if (cart.id) {
                sessionStorage.setItem('cart_id', cart.id);
            }

            renderCart();
            updateCartBadge();

        } catch (err) {
            console.error('[loadCart] Network error:', err);
            renderEmpty();
        }
    }

    // ─── Render: Empty State ───────────────────────────────────────────────────
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
        document.getElementById('cartActions').classList.add('d-none');
    }

    // ─── Render: Cart Table ────────────────────────────────────────────────────
    function renderCart() {
        const container = document.getElementById('cart');

        if (!cart.items || cart.items.length === 0) {
            renderEmpty();
            return;
        }

        let rows = '';
        cart.items.forEach(item => {
            const lineTotal = (item.unit_price * item.quantity).toLocaleString('en-KE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
            const unitPrice = Number(item.unit_price).toLocaleString('en-KE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            rows += `
                <tr>
                    <td class="fw-semibold">${escapeHtml(item.product_name)}</td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <button class="btn-qty" onclick="changeQuantity(${item.product}, ${item.quantity - 1})" title="Decrease">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input
                                type="number"
                                min="1"
                                value="${item.quantity}"
                                class="qty-input"
                                onchange="changeQuantity(${item.product}, parseInt(this.value) || 1)"
                                onblur="if(!this.value || this.value < 1) this.value = 1">
                            <button class="btn-qty" onclick="changeQuantity(${item.product}, ${item.quantity + 1})" title="Increase">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>KES ${unitPrice}</td>
                    <td class="fw-semibold text-success">KES ${lineTotal}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${item.product})" title="Remove">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        const subtotal = Number(cart.subtotal).toLocaleString('en-KE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });

        container.innerHTML = `
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="min-width:170px">Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th style="width:50px"></th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
            <div class="text-end mt-3">
                <span class="text-muted me-2">Subtotal (${cart.total_items ?? cart.items.length} item${(cart.total_items ?? cart.items.length) !== 1 ? 's' : ''}):</span>
                <span class="fs-4 fw-bold" style="color:#2a6e3f;">KES ${subtotal}</span>
            </div>
        `;

        document.getElementById('cartActions').classList.remove('d-none');
    }

    // ─── Change Quantity ───────────────────────────────────────────────────────
    window.changeQuantity = async function (productId, quantity) {
        quantity = parseInt(quantity);

        if (isNaN(quantity) || quantity <= 0) {
            removeItem(productId);
            return;
        }

        try {
            await fetch(API.update, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ product: productId, quantity }),
            });

            await loadCart();

        } catch (err) {
            console.error('[changeQuantity]', err);
            showToast('Could not update quantity. Try again.', 'error');
        }
    };

    // ─── Remove Item ───────────────────────────────────────────────────────────
    window.removeItem = async function (productId) {
        try {
            await fetch(API.remove, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ product: productId }),
            });

            await loadCart();
            showToast('Item removed from cart.', 'success');

        } catch (err) {
            console.error('[removeItem]', err);
            showToast('Could not remove item. Try again.', 'error');
        }
    };

    // ─── Update navbar cart badge ──────────────────────────────────────────────
    function updateCartBadge() {
        const badge = document.querySelector('.cart-badge');
        if (!badge) return;
        const count = cart.total_items ?? (cart.items ? cart.items.length : 0);
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    }

    // ─── Escape HTML ───────────────────────────────────────────────────────────
    function escapeHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    // ─── Init ──────────────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadCart();
    });

})();
</script>

@endsection