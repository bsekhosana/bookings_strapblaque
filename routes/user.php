<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Routes for the signed-in User.
|
*/

Route::get('/', [\App\Http\Controllers\User\DashboardController::class, 'dashboard'])->name('dashboard');


Route::prefix('settings')->name('settings.')->group(function () {

    Route::get('/', [\App\Http\Controllers\User\ProfileController::class, 'redirect'])->name('redirect');

    Route::singleton('profile', \App\Http\Controllers\User\ProfileController::class)->except(['edit']);

    Route::put('profile/password', [\App\Http\Controllers\User\ProfileController::class, 'password'])->name('profile.password');

});
