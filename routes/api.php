<?php



use Shop\App\Http\Controllers\Api\Web\CheckoutController;
use Shop\App\Http\Controllers\Api\Admin\CustomerController;
use Shop\App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use Shop\App\Http\Controllers\Api\Admin\ProductChildrenController;
use Shop\App\Http\Controllers\Api\Admin\ProductVariantController;
use Shop\App\Http\Controllers\Api\Admin\ProductAttributeController;
use Shop\App\Http\Controllers\Api\Admin\ProductTagController;
use Shop\App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use Shop\App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use Shop\App\Http\Controllers\Api\Web\FilterController;
use Shop\App\Http\Controllers\Api\Web\OrderController;
use Shop\App\Http\Controllers\Api\Web\PaymentController;
use Shop\App\Http\Controllers\Api\Web\ProductController;
use Shop\App\Http\Controllers\Api\Web\CategoryController;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['throttle:third-party:shop:api_admin', 'wants.json']
], function () {

    Route::resource('categories', AdminCategoryController::class)->except('create', 'edit', 'update');

    Route::resource('products', AdminProductController::class)->except('create', 'edit', 'update');
    Route::resource('products.tags', ProductTagController::class)->only('destroy');
    Route::resource('products.attributes', ProductAttributeController::class)->only('destroy');
    Route::resource('products.variants', ProductVariantController::class)->only('destroy');
    Route::resource('products.children', ProductChildrenController::class)->only('destroy');

    Route::get('/preview/{category}/{product}', [AdminProductController::class, 'viewAsUser'])->name('preview.product');

    Route::get('orders', [AdminOrderController::class, 'complete'])->name('orders.complete');
    Route::get('orders/pending', [AdminOrderController::class, 'pending'])->name('orders.pending');
    Route::get('orders/customers', [CustomerController::class, 'index'])->name('orders.customers');
});

Route::group(
    [
        'as' => 'web.',
        'middleware' => ['throttle:third-party:shop:api_web', 'wants.json']
    ],
    function () {

        Route::group([
            'prefix' => 'shopping'
        ], function () {

            Route::resource('orders', OrderController::class)->only('index', 'store', 'destroy');

            Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
            Route::get('checkouts', [CheckoutController::class, 'index'])->name('checkouts.index');
        });

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');

        Route::get('/', [ProductController::class, 'index'])->name('search');
        Route::get('/{category}/{product}', [ProductController::class, 'productDetails'])->name('products.show');

        Route::get('/filters', [FilterController::class, 'index'])->name('filters.index');
    }
);

