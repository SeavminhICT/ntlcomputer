<?php

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\CatalogController as CatalogApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('catalog')->group(function () {
    Route::get('categories', [CatalogApiController::class, 'categories']);
    Route::get('products', [CatalogApiController::class, 'products']);
    Route::get('products/{product}', [CatalogApiController::class, 'show']);
});

Route::prefix('admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::apiResource('categories', AdminCategoryController::class)->except(['show']);
        Route::apiResource('products', AdminProductController::class);
        Route::delete('products/{product}/images/{image}', [AdminProductController::class, 'destroyImage']);
    });
});
