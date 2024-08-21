<?php

use App\Http\Controllers\Admin\OrganizationController;
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


Route::controller(\App\Http\Controllers\Admin\ProfileController::class)->prefix('profile')->name('profile.')->group(function () {

    Route::get('account', 'account')->name('account');

    Route::put('account', 'updateAccount');

    Route::get('security', 'security')->name('security');

    Route::put('security', 'updateSecurity');

});

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::resource('subscription_plans', SubscriptionPlanController::class);
    Route::resource('organizations', OrganizationController::class);
});
