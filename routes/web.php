<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QrCodeController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('catalog.index');
});

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/products/{product}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])
        ->name('admin.products.images.destroy');
    Route::get('qr', [QrCodeController::class, 'show'])->name('admin.qr.show');
    Route::get('qr/download', [QrCodeController::class, 'download'])->name('admin.qr.download');
});
