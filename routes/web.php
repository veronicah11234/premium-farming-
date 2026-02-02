<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\PosReturnController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::get('/about', fn () => view('about'))->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/cart/count', [CartController::class, 'count']);


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

 

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');



 Route::prefix('checkout')->group(function () {
        // User order history (authenticated only)
        Route::get('/orders', [CheckoutController::class, 'orders'])->name('checkout.orders');
        Route::get('/orders/{orderId}', [CheckoutController::class, 'viewOrder'])->name('checkout.order.view');
        Route::get('/mpesa/{order}', [CheckoutController::class, 'showMpesaInstructions'])->name('checkout.mpesa');
    Route::get('/cheque/{order}', [CheckoutController::class, 'showChequeInstructions'])->name('checkout.cheque');
    Route::get('/bank-transfer/{order}', [CheckoutController::class, 'showBankTransferInstructions'])->name('checkout.bank-transfer');

    
Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/receipt/{orderId}', [CheckoutController::class, 'receipt'])->name('checkout.receipt');
    Route::get('/print-receipt/{orderId}', [CheckoutController::class, 'printReceipt'])->name('checkout.print.receipt');
    Route::get('/download-receipt/{orderId}', [CheckoutController::class, 'downloadReceipt'])->name('checkout.download.receipt');
    Route::get('/track', [CheckoutController::class, 'trackOrder'])->name('checkout.track');
    Route::post('/track', [CheckoutController::class, 'trackOrder'])->name('checkout.track.post');
    Route::post('/confirm-payment/{orderId}', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm.payment');
    Route::get('/generate-receipt/{orderId}', [CheckoutController::class, 'generateReceipt'])->name('checkout.generate.receipt');

        // Saved addresses and preferences (authenticated only)
        Route::get('/addresses', function () {
            return view('checkout.addresses');
        })->name('checkout.addresses');
        Route::post('/addresses', [CheckoutController::class, 'saveAddress'])->name('checkout.save.address');
    });


    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/orders', [ShopController::class, 'orders'])->name('orders');
        Route::get('/reports', function () {
            return view('shop.reports');
        })->name('reports');
        
        // Customer Management (authenticated only)
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        
        // Orders (authenticated only)
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    });
/*
|--------------------------------------------------------------------------
| CATEGORIES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::view('/category/poultry', 'categories.poultry')->name('category.poultry');
Route::view('/category/dairy', 'categories.dairy')->name('category.dairy');
Route::view('/category/swine', 'categories.swine')->name('category.swine');
Route::view('/category/pet-feeds', 'categories.pet-feeds')->name('category.pet-feeds');
Route::view('/category/by-products', 'categories.by-products')->name('category.by-products');
Route::view('/category/goat-feeds', 'categories.goat-feeds')->name('category.goat-feeds');

/*
|--------------------------------------------------------------------------
| CART (COOKIE AUTH)
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth'])->group(function () {
    // Cart page view
    Route::get('/cart/view', [CartController::class, 'view'])->name('cart.view');
    
    // Cart JSON API
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    
    // Cart operations
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/increment', [CartController::class, 'increment']);
    Route::post('/cart/decrement', [CartController::class, 'decrement']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);
});

 Route::prefix('products')->name('products.')->group(function () {
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        });

        // CATEGORY MANAGEMENT (Admin only)
        Route::get('/categories/store', [CategoryController::class, 'create'])->name('categories.store');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');

        // ITEMS CRUD (POS Items - Admin only)
        Route::prefix('pos/items')->name('items.')->group(function () {
            Route::get('/', [ItemController::class, 'index'])->name('index');
            Route::post('/', [ItemController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ItemController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ItemController::class, 'update'])->name('update');
            Route::delete('/{id}', [ItemController::class, 'destroy'])->name('destroy');
        });

/*
|--------------------------------------------------------------------------
| CHECKOUT (COOKIE AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.cookie')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| DEBUG ROUTES (REMOVE IN PRODUCTION)
|--------------------------------------------------------------------------
*/
Route::get('/debug-django-real', function() {
    return "Debug route active";
});

require __DIR__.'/auth.php';
