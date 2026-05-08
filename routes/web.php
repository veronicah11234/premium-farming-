<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartProxyController;
use App\Http\Controllers\CheckoutProxyController;
use App\Http\Controllers\WhatsAppRedirectController;
use App\Http\Controllers\CheckoutResumeController;
use App\Http\Controllers\WhatsAppOrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\{
    HomeController, ProfileController, ProductController, ShopController, TransactionController, ReportController, AccountController,
    SalesReportController, ItemController, InvoiceController, ReceiptController,
    CreditNoteController, PettyCashController, PosReturnController, ContactController,
    CategoryController, CartController, ConversionController, PosProductController,
    PosSellController, CustomerController, OrderController, CheckoutController,
    ReviewController,
};

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout',[AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register',  fn () => view('auth.register'))->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/proxy/signup',  fn () => view('auth.proxy-signup'))->name('proxy.signup.form');
Route::post('/proxy/signup', [RegisteredUserController::class, 'proxySignup'])->name('proxy.signup');

Route::get('/forgot-password',  fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::get('/',        [HomeController::class, 'index'])->name('home');
Route::get('/about',   fn() => view('about'))->name('about');
Route::get('/gallery', fn () => view('gallery'))->name('gallery');

Route::get('/contact',       [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/reviews',  [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| SHOP
|--------------------------------------------------------------------------
*/
Route::get('/shop',           [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/products',  [ShopController::class, 'products'])->name('shop.products');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');

// $categories = ['poultry','dairy','swine','pet-feeds','by-products','goat-feeds','pig','cattle','concentrates'];
// foreach ($categories as $cat) {
//     Route::view("/category/$cat", "categories.$cat")->name("category.$cat");
// }

// Route::get('/products/{category}', [ShopController::class, 'category'])
//     ->whereIn('category', ['pig', 'pet', 'poultry', 'byproduct'])
//     ->name('shop.category');

Route::get('/products',          [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}',[ProductController::class, 'show'])->name('products.show');

Route::get('/categories',            [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/
Route::get('/cart',           [CartController::class, 'view'])->name('cart.view');
Route::get('/cart/load',      [CartController::class, 'load']);
Route::post('/cart/add',      [CartController::class, 'add']);
Route::patch('/cart/update',  [CartController::class, 'update']);
Route::delete('/cart/remove', [CartController::class, 'remove']);

/*
|--------------------------------------------------------------------------
| DJANGO CART PROXY
|--------------------------------------------------------------------------
*/
Route::prefix('proxy/cart')->group(function () {
    Route::get('/',          [CartProxyController::class, 'load']);
    Route::post('/add',      [CartProxyController::class, 'add']);
    Route::patch('/update',  [CartProxyController::class, 'update']);
    Route::delete('/remove', [CartProxyController::class, 'remove']);
});

/*
|--------------------------------------------------------------------------
| DJANGO CHECKOUT PROXY
|--------------------------------------------------------------------------
*/
Route::prefix('proxy/checkout')->group(function () {
    Route::post('/mpesa', [CheckoutProxyController::class, 'mpesa'])->name('proxy.checkout.mpesa');
    Route::get('/status/{checkoutRequestId}', [CheckoutProxyController::class, 'paymentStatus'])->name('proxy.checkout.status');
});

/*
|--------------------------------------------------------------------------
| DJANGO ORDERS PROXY
|--------------------------------------------------------------------------
*/
Route::prefix('proxy/orders')->group(function () {
    Route::get('/',             [CheckoutProxyController::class, 'orders'])->name('proxy.orders');
    Route::get('/{orderNumber}',[CheckoutProxyController::class, 'orderDetail'])->name('proxy.orders.detail');
});

Route::get('/orders', fn() => view('shop.orders'))->name('orders');

/*
|--------------------------------------------------------------------------
| CHECKOUT (Laravel-side)
|--------------------------------------------------------------------------
*/
// web.php
Route::get('/checkout/details', function () {
    $cartId = session('cart_id');
    return view('checkout.details', compact('cartId'));
})->name('checkout.details'); 
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

Route::prefix('checkout')->group(function () {
    Route::get('/',                    [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/calculate-delivery', [CheckoutController::class, 'calculateDelivery'])->name('checkout.calculate.delivery');
    Route::post('/place-order',        [CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('/success/{order}',     [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/receipt/{orderId}',   [CheckoutController::class, 'receipt'])->name('checkout.receipt');
    Route::get('/track',               [CheckoutController::class, 'trackOrder'])->name('checkout.track');
    Route::post('/track',              [CheckoutController::class, 'trackOrder'])->name('checkout.track.post');
});

/*
|--------------------------------------------------------------------------
| ORDER FLOW (Django-backed)
|--------------------------------------------------------------------------
*/
// Step 3: Place order
Route::post('/api/ecommerce/place-order/', [OrderController::class, 'createOrder']);

// Step 4: Order confirmation page
Route::get('/order/confirmation/{orderId}', [OrderController::class, 'showConfirmation'])->name('order.confirmation');

// Step 5: Prepare WhatsApp message
Route::post('/api/order/whatsapp', [OrderController::class, 'prepareWhatsApp'])->name('api.order.whatsapp');

// Final confirmed page
Route::get('/order/confirmed/{orderId}', [OrderController::class, 'finalConfirmation'])->name('order.confirmed');

// CSRF token endpoint
Route::get('/ecommerce/csrf-token/', [OrderController::class, 'getCsrfToken']);

/*
|--------------------------------------------------------------------------
| PAYMENT FLOW
|
| Step 1: Customer clicks WhatsApp link → GET /api/ecommerce/pay/{id}?token=
|         → redirects to the Blade payment page
| Step 2: Blade page loads → JS fires POST /api/ecommerce/pay/
|         → PaymentController proxies to Django STK push
| Step 3: JS polls GET /api/payment/status/{orderId}?token=
|         → PaymentController proxies to Django status check
| Step 4: Safaricom fires POST /api/mpesa/callback → forwarded to Django
|--------------------------------------------------------------------------
*/

// WhatsApp link entry point → redirect to Blade payment page
Route::get('/api/ecommerce/pay/{orderId}', function ($orderId) {
    return redirect()->route('payment.page', [
        'orderId' => $orderId,
        'token'   => request()->get('token', ''),
    ]);
});

// Blade payment page
Route::get('/payment/{orderId}', [PaymentController::class, 'showPaymentPage'])->name('payment.page');

// Blade JS: trigger STK push
Route::post('/api/ecommerce/pay/', [PaymentController::class, 'initiatePayment'])->name('api.pay');

// Blade JS: poll payment status
Route::get('/api/ecommerce/payment/status/{orderId}', [PaymentController::class, 'checkPaymentStatus'])->name('payment.status');

// Safaricom M-Pesa callback (CSRF excluded in VerifyCsrfToken.php)
Route::post('/api/mpesa/callback', [PaymentController::class, 'paymentCallback'])->name('mpesa.callback');

/*
|--------------------------------------------------------------------------
| WHATSAPP ROUTES (authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/whatsapp/redirect',     [WhatsAppRedirectController::class, 'redirectToWhatsApp'])->name('whatsapp.redirect');
    Route::post('/api/whatsapp/redirect', [WhatsAppRedirectController::class, 'apiRedirect'])->name('api.whatsapp.redirect');
    Route::get('/checkout/resume/{orderId}',  [CheckoutResumeController::class, 'resumeCheckout'])->name('checkout.resume');
    Route::post('/api/checkout/complete',     [CheckoutResumeController::class, 'completeCheckout'])->name('api.checkout.complete');
    Route::post('/api/webhook/update-delivery', [CheckoutResumeController::class, 'webhookUpdateDelivery'])->name('api.webhook.update-delivery');
});

Route::post('/api/whatsapp/prepare-order',      [WhatsAppOrderController::class, 'prepareWhatsAppOrder']);
Route::post('/api/checkout/complete-whatsapp',  [WhatsAppOrderController::class, 'completeCheckout']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (admin/staff)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-profile', fn() => view('profile-page'))->name('my.profile');
});