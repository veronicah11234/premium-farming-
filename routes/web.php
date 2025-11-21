<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ShopController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [POSController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| POS Routes
|--------------------------------------------------------------------------
*/
Route::prefix('pos')->name('pos.')->group(function() {
    Route::get('/', [POSController::class,'index'])->name('index');
    Route::post('/', [POSController::class, 'store'])->name('store');

    Route::get('/sell', [POSController::class,'sell'])->name('sell');
    Route::get('/categories', [POSController::class,'categories'])->name('categories');
    Route::get('/items', [POSController::class,'items'])->name('items');
    Route::get('/stores', [POSController::class,'stores'])->name('stores');
    Route::get('/update-prices', [POSController::class,'updatePrices'])->name('update-prices');

    Route::get('/goods-received', [POSController::class,'goodsReceived'])->name('goods-received');
    Route::get('/returns', [POSController::class,'returns'])->name('returns');
    Route::get('/issues', [POSController::class,'issues'])->name('issues');
    Route::get('/stock-take', [POSController::class,'stockTake'])->name('stock-take');

    Route::get('/best-seller', [POSController::class,'bestSeller'])->name('best-seller');
    Route::get('/goods-received-report', [POSController::class,'goodsReceivedReport'])->name('goods-received-report');
    Route::get('/issued-stock', [POSController::class,'issuedStock'])->name('issued-stock');
    Route::get('/stock-level', [POSController::class,'stockLevel'])->name('stock-level');

    Route::get('/clients', [POSController::class,'clients'])->name('clients');
    Route::get('/client-terms', [POSController::class,'clientTerms'])->name('client-terms');
    Route::get('/transactions', [POSController::class,'transactions'])->name('transactions');
});

/*
|--------------------------------------------------------------------------
| Online Shop Routes
|--------------------------------------------------------------------------
*/
Route::prefix('shop')->name('shop.')->group(function () {

    // Specific pages first
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/products', [ShopController::class, 'products'])->name('products');
    Route::get('/products/create', [ShopController::class, 'create'])->name('products.create');
    Route::post('/products/create', [ShopController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [ShopController::class, 'edit'])->name('products.edit');
    Route::put('/products/edit/{id}', [ShopController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ShopController::class, 'delete'])->name('products.delete');

    Route::get('/order', [ShopController::class, 'order'])->name('orders');
    Route::get('/customer', [ShopController::class, 'customer'])->name('customers');
    Route::get('/report', [ShopController::class, 'report'])->name('reports');

    // Dynamic product route **at the bottom**
    Route::get('/{product}', [ShopController::class, 'show'])->name('show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pos/sell', [POSController::class, 'sell'])->name('pos.sell');
    Route::post('/pos/sell', [POSController::class, 'storeSale'])->name('pos.storeSale');

});
require __DIR__.'/auth.php';
