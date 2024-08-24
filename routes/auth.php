<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Routes for the login / register etc.
|
*/

Route::get('otp', [\App\Http\Controllers\Auth\OtpController::class, 'showOtpForm'])->name('otp');

Route::post('otp', [\App\Http\Controllers\Auth\OtpController::class, 'submitOtp']);

Route::post('otp/resend', [\App\Http\Controllers\Auth\OtpController::class, 'resendOtp'])->name('otp.resend');


Route::post('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');


Route::controller(\App\Http\Controllers\Auth\AdminLoginController::class)->prefix('admin')->name('admin.')->group(function () {

    Route::get('login', 'showLoginForm')->name('login');

    Route::get('register', 'showRegForm')->name('register');

    Route::post('login', 'login');

    Route::post('register', 'register');

});

Route::controller(\App\Http\Controllers\Auth\LoginController::class)->group(function () {

    Route::get('login', 'showLoginForm')->name('login');

    Route::post('login', 'login');

});

Route::controller(\App\Http\Controllers\Auth\RegisterController::class)->group(function () {

    Route::get('register', 'showRegistrationForm')->name('register');

    Route::post('register', 'register');

});

Route::controller(\App\Http\Controllers\Auth\ForgotPasswordController::class)->group(function () {

    Route::get('password/reset', 'showLinkRequestForm')->name('password.request');

    Route::post('password/email', 'sendResetLinkEmail')->name('password.email');

});

Route::controller(\App\Http\Controllers\Auth\ResetPasswordController::class)->group(function () {

    Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');

    Route::post('password/reset', 'reset')->name('password.update');

});

Route::controller(\App\Http\Controllers\Auth\ConfirmPasswordController::class)->group(function () {

    Route::get('password/confirm', 'showConfirmForm')->name('password.confirm');

    Route::post('password/confirm', 'confirm');

});

Route::controller(\App\Http\Controllers\Auth\VerificationController::class)->group(function () {

    Route::get('email/verify', 'show')->name('verification.notice');

    Route::get('email/verify/{id}/{hash}', 'verify')->name('verification.verify');

    Route::post('email/resend', 'resend')->name('verification.resend');

});
