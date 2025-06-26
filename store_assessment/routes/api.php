<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StoreController;
use App\Http\Controllers\Api\V1\ProductController;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/stores', [StoreController::class, 'index']);
    Route::post('/stores', [StoreController::class, 'store']);
    Route::put('/stores', [StoreController::class, 'update']);
    Route::post('/stores/show', [StoreController::class, 'show']);
    Route::delete('/stores', [StoreController::class, 'destroy']);

    Route::post('/products/sell', [ProductController::class, 'sell']);
});