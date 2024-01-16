<?php

/**
 * Areeb Hussain
 */

use App\Filament\Resources\Shop\BrandResource;
use App\Filament\Resources\Shop\CategoryResource;
use App\Filament\Resources\Shop\CustomerResource;
use App\Filament\Resources\Shop\OrderResource;
use App\Filament\Resources\Shop\ProductResource;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

    // Customer API routes defined individually
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::put('/customers/{customer}', [CustomerController::class, 'update']);
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);

    // Products API route
    Route::apiResource('products', ProductController::class);

    // API Resource routes for Brands, Categories, and Orders.
    // Automatically create standard endpoints for each resource.
    Route::apiResource('brands', BrandResource::class);
    Route::apiResource('categories', CategoryResource::class);
    Route::apiResource('orders', OrderResource::class);

    // This also works
    // Route::apiResource('customers', CustomerController::class);

    Route::post('/products/{product}/upload-image', [ProductImageController::class, 'uploadImage'])
        ->name('api.products.upload-image');

});

