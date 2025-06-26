<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Interface\Http\Controllers\Api\V1\StoreController;
use App\Interface\Http\Controllers\Api\V1\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/stores', [StoreController::class, 'index']);
    Route::post('/stores', [StoreController::class, 'store']);
    Route::post('/stores/update', [StoreController::class, 'update']);
    Route::post('/stores/show', [StoreController::class, 'show']);
    Route::delete('/stores', [StoreController::class, 'destroy']);

    Route::post('/products/sell', [ProductController::class, 'sell']);
});