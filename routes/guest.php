<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Routes for the fronted / guests.
|
*/

Route::controller(\App\Http\Controllers\Guest\GuestController::class)->group(function () {

    Route::get('/', 'homepage')->name('homepage');

    Route::get('about', 'about')->name('about');

    Route::get('contact', 'contact')->name('contact');

    Route::post('contact', 'submitContact');

});


Route::controller(\App\Http\Controllers\Guest\TestController::class)->prefix('test')->name('test.')->group(function () {

    Route::get('/', 'playground')->name('playground');

    Route::get('mail', 'testMail')->name('mail');

    Route::get('otp', 'otpForm')->name('otp');

});