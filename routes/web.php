<?php

use Illuminate\Support\Facades\Route;

// Register
Route::get('/register', function () {
    return view('register');
});

// Login
Route::get('/', function () {
    return view('login');
});

// Create Service
Route::get('/create-service', function () {
    return view('create-service');
});


// Show all services
Route::get('/services', function () {
    return view('services');
});

// Show user subscriptions
Route::get('/subscriptions', function () {
    return view('user-subscription');
});

// Services/Calculator
Route::get('/service/calculator', function () {
    return view('services.calculator');
});