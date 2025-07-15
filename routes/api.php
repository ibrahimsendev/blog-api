<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:60,1');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:60,1');

    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::apiResource('posts', PostController::class)
    ->only(['index', 'show'])
    ->middleware('throttle:60,1');

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::apiResource('posts', PostController::class)
        ->only(['store', 'update', 'destroy']);
});

Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show'])
    ->middleware('throttle:60,1');

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::apiResource('categories', CategoryController::class)
        ->only(['store', 'update', 'destroy']);
});

Route::get('/comments', [CommentController::class, 'index'])
    ->middleware('throttle:60,1');

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});
