<?php



use Shop\App\Http\Controllers\Admin\CustomerController;
use Shop\App\Http\Controllers\Admin\OrderController;
use Shop\App\Http\Controllers\Admin\ProductController;
use Shop\App\Http\Controllers\Admin\CategoryController;
use Shop\App\Http\Controllers\Admin\DashboardController;

Route::middleware(['throttle:third-party:shop:admin'])->group(function () {

    Route::get("/", [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->only('index', 'create', 'edit');
    Route::resource('products', ProductController::class)->only('index', 'create', 'edit');
    Route::get(
        'products/preview/{category}/{product}',
        [ProductController::class, 'viewAsUser']
    )->name('product.preview');

    Route::get('orders', [OrderController::class, 'complete'])->name('orders.complete');
    Route::get('orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('orders/customers', [CustomerController::class, 'index'])->name('orders.customers');
});
