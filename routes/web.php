<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\PosReturnController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| HOME & DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [POSController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/about', function () {
    return view('about');
})->name('about');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});


/*
|--------------------------------------------------------------------------
| POS ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('pos')->name('pos.')->group(function () {

    Route::get('/', function () {
        return view('pos.layout');
    })->name('home');
    
    Route::get('/sell', [POSController::class, 'sell'])->name('sell');
    Route::post('/sell', [POSController::class, 'storeSale'])->name('sell.store');

    Route::get('/categories', [StockController::class, 'categories'])->name('categories');

    Route::get('/items', [ItemController::class, 'index'])->name('items');
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

    Route::get('/stores', [StockController::class, 'stores'])->name('stores');
    Route::get('/update-prices', [StockController::class, 'updatePrices'])->name('update-prices');

    Route::get('/goods-received', [TransactionController::class, 'goodsReceived'])->name('goods-received');
    Route::post('/goods-received/store', [TransactionController::class, 'storeGoodsReceived'])->name('goods-received.store');

    Route::get('/transfers', [TransactionController::class, 'transfers'])->name('transfers');
    Route::post('/transfers/store', [TransactionController::class, 'storeTransfer'])->name('transfers.store');

    Route::get('/stock-take', [TransactionController::class, 'stockTake'])->name('stock-take');
    Route::post('/stock-take/store', [TransactionController::class, 'storeStockTake'])->name('stock-take.store');

    Route::get('/reports/best-seller', [ReportController::class, 'bestSeller'])->name('reports.best-seller');
    Route::get('/reports/goods-received', [ReportController::class, 'goodsReceivedReport'])->name('reports.goods-received');
    Route::get('/reports/stock-level', [ReportController::class, 'stockLevel'])->name('reports.stock-level');

    Route::get('/clients', [AccountController::class, 'clients'])->name('clients');
    Route::get('/client-terms', [AccountController::class, 'clientTerms'])->name('client-terms');

    Route::get('/invoices', [AccountController::class, 'invoices'])->name('invoices');
    Route::get('/receipts', [AccountController::class, 'receipts'])->name('receipts');
    Route::get('/credit-notes', [AccountController::class, 'creditNotes'])->name('credit-notes');
    Route::get('/petty-cash', [AccountController::class, 'pettyCash'])->name('petty-cash');

});

/*
|--------------------------------------------------------------------------
| POS Items CRUD
|--------------------------------------------------------------------------
*/

Route::get('/pos/items', [ItemController::class, 'index'])->name('items.index');
Route::post('/pos/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/pos/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/pos/items/{id}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/pos/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

Route::prefix('shop')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

});

/*
|--------------------------------------------------------------------------
| CATEGORY BLADE ROUTES (NEW)
|--------------------------------------------------------------------------
*/

Route::view('/category/poultry', 'categories.poultry')->name('category.poultry');
Route::view('/category/dairy', 'categories.dairy')->name('category.dairy');
Route::view('/category/swine', 'categories.swine')->name('category.swine');
Route::view('/category/pet-feeds', 'categories.pet-feeds')->name('category.pet-feeds');
Route::view('/category/by-products', 'categories.by-products')->name('category.by-products');
Route::view('/category/goat-feeds', 'categories.goat-feeds')->name('category.goat-feeds');

Route::get('/shop/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/shop/orders/store', [OrderController::class, 'store'])->name('orders.store');


/*
|--------------------------------------------------------------------------
| SHOP ROUTES (Front-End Online Shop)
|--------------------------------------------------------------------------
*/

Route::prefix('shop')->name('shop.')->group(function () {

    Route::get('/', [ShopController::class, 'index'])->name('index');

    Route::get('/products', [ShopController::class, 'products'])->name('products');
    Route::get('/orders', [ShopController::class, 'orders'])->name('orders');
    // Route::get('/customers', [ShopController::class, 'customers'])->name('customers');

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('shop.category');

    Route::view('/reports', 'shop.reports')->name('reports');

    Route::get('/product/{id}', [ShopController::class, 'show'])->name('show');
});


/*
|--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/increment', [App\Http\Controllers\CartController::class, 'increment'])->name('cart.increment');
Route::post('/cart/decrement', [App\Http\Controllers\CartController::class, 'decrement'])->name('cart.decrement');
Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');


/*
|--------------------------------------------------------------------------
| OTHER ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/receive-stock', [StockController::class, 'receiveStock'])->name('receive.stock');
Route::post('/receive-stock', [StockController::class, 'receiveStock']);

Route::post('/sell', [StockController::class, 'sell'])->name('sell.product');

Route::get('/sales/report', [SalesReportController::class, 'index'])->name('sales.report');
Route::get('/sales/report/pdf', [SalesReportController::class, 'pdf'])->name('sales.pdf');

Route::get('/reports/sales', [SalesReportController::class, 'index'])->name('reports.sales');

Route::get('/my-profile', function () {
    return view('profile-page');
})->name('my.profile');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::resource('invoices', InvoiceController::class);
Route::resource('receipts', ReceiptController::class);
Route::resource('credit-notes', CreditNoteController::class);
Route::resource('petty-cash', PettyCashController::class);
Route::resource('pos-returns', PosReturnController::class);

require __DIR__.'/auth.php';
