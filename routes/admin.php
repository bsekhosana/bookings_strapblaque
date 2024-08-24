<?php

use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPlanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for the Admin.
|
*/

Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');

Route::resource('contact_forms', \App\Http\Controllers\Admin\ContactFormController::class)->only(['index', 'show', 'destroy']);


Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);

Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class)->except(['create', 'store', 'destroy']);

Route::resource('organization_settings', \App\Http\Controllers\Admin\OrganizationSettingsController::class);


Route::controller(\App\Http\Controllers\Admin\ProfileController::class)->prefix('profile')->name('profile.')->group(function () {

    Route::get('account', 'account')->name('account');

    Route::put('account', 'updateAccount');

    Route::get('security', 'security')->name('security');

    Route::put('security', 'updateSecurity');

});

Route::middleware(['auth', 'can:admin'])->group(function () {
    // Route::resource('subscription_plans', SubscriptionPlanController::class);
    Route::resource('organizations', OrganizationController::class);
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
