<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\LoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Register
Route::post('/register', [RegisterController::class, 'register']);

// Login
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout']);


// Subscription
Route::middleware('auth:sanctum')->group(function () {
    // Protected routes for user subscriptions

    Route::get('/mySubscriptions/active', [SubscriptionController::class, 'showActiveSubscription']);
    Route::get('/mySubscriptions', [SubscriptionController::class, 'showUserSubscription']);

    Route::get('/subscriptions/{id}', [SubscriptionController::class, 'singleSubscription']);
    Route::get('/subscriptions', [SubscriptionController::class, 'showAllSubscription']);

    Route::post('/subscriptions/subscribe/{service}', [SubscriptionController::class, 'subscribe']);
    Route::post('/subscriptions/cancel/{id}', [SubscriptionController::class, 'cancelSubscription']);
});

// Service

Route::get('/services', [ServiceController::class, 'index']); // Public access for services
Route::get('/services/{service}', [ServiceController::class, 'show']); // Public access for service details

Route::post('/services', [ServiceController::class, 'create'])->middleware('auth:sanctum'); 

Route::put('/services/{id}', [ServiceController::class, 'update']); 

Route::delete('/services/{id}', [ServiceController::class, 'destroy']); 

Route::delete('/services', [ServiceController::class, 'clear']); 


