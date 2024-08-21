<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\SubscriptionController;
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

Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::put('/bookings/{id}', [BookingController::class, 'update']);
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

Route::get('/subscription/plans', [SubscriptionController::class, 'showPlans'])->name('subscription.plans');
Route::post('/subscription/payment', [SubscriptionController::class, 'initiatePayment'])->name('subscription.payment');
Route::get('/payment/success', [SubscriptionController::class, 'paymentSuccess'])->name('subscription.payment.success');
Route::get('/payment/cancel', [SubscriptionController::class, 'paymentCancel'])->name('subscription.payment.cancel');
Route::post('/payment/notify', [SubscriptionController::class, 'paymentNotify'])->name('subscription.payment.notify');
