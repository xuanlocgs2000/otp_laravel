<?php

use App\Http\Controllers\Auth\AuthOtpController;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthOtpController::class)->group(function () {
    Route::get('/otp/login', 'login')->name('otp.login');
    Route::get('/otp/generate', 'generate')->name('otp.generate');
});
