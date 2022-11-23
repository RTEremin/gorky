<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);


Route::middleware('auth:api')->group(function() {
   Route::resource('booking', BookingController::class);
   Route::post('booking/{booking}/status', [BookingController::class, 'status']);
   Route::get('/user/{user}/booking', [UserController::class, 'userBookings']);
});
