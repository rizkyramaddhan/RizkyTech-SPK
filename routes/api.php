<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\BomController;

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('materials')->group(function () {
    Route::get('/', [MaterialController::class, 'index']);
    Route::get('/{id}', [MaterialController::class, 'show']);
    Route::post('/', [MaterialController::class, 'store']);
    Route::put('/{id}', [MaterialController::class, 'update']);
    Route::delete('/{id}', [MaterialController::class, 'destroy']);
});

Route::prefix('boms')->group(function () {
    Route::get('/', [BomController::class, 'index']);
    Route::get('/{id}', [BomController::class, 'show']);
    Route::post('/', [BomController::class, 'store']);
    Route::put('/{id}', [BomController::class, 'update']);
    Route::delete('/{id}', [BomController::class, 'destroy']);
});
