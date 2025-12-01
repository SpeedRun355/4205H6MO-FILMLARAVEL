<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReviewController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Register review resource routes (protected)
Route::middleware('auth:sanctum')->apiResource('review', ReviewController::class);

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [RegisterController::class, 'logout']);
Route::get('/reviews', [RegisterController::class, 'index']);
Route::get('/reviews/{id}', [RegisterController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('reviews', [ReviewController::class, 'store']);
    Route::get('reviews/edit/{id}', [ReviewController::class, 'show']);
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);
    Route::put('reviews/update/{id}', [ReviewController::class, 'update']);
});

Route::middleware('auth:sanctum')->get('/user', function (Illuminate\Http\Request $request) {
    return $request->user();
});