<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Laravel Sanctum
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('ping', \App\Http\Controllers\Api\PingController::class)->name('ping');


Route::put('admin/theme', [\App\Http\Controllers\Api\Admin\AdminController::class, 'theme']);

Route::put('user/theme', [\App\Http\Controllers\Api\User\UserController::class, 'theme']);

Route::get('user', [\App\Http\Controllers\Api\UserController::class, 'self']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('subscriptions', SubscriptionController::class);
    Route::apiResource('services', ServiceController::class);
});

Route::get('/swagger', function () {
    return response()->file(storage_path('api-docs/swagger.json'));
});

Route::get('/swagger-ui', function () {
    return File::get(public_path('vendor/swagger-api/swagger-ui/dist/index.html'));
});
// Route::get('/bookings', [BookingController::class, 'index']);
// Route::post('/bookings', [BookingController::class, 'store']);
// Route::put('/bookings/{id}', [BookingController::class, 'update']);
// Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

// Route::get('/subscription/plans', [SubscriptionController::class, 'showPlans'])->name('subscription.plans');
// Route::post('/subscription/payment', [SubscriptionController::class, 'initiatePayment'])->name('subscription.payment');
// Route::get('/payment/success', [SubscriptionController::class, 'paymentSuccess'])->name('subscription.payment.success');
// Route::get('/payment/cancel', [SubscriptionController::class, 'paymentCancel'])->name('subscription.payment.cancel');
// Route::post('/payment/notify', [SubscriptionController::class, 'paymentNotify'])->name('subscription.payment.notify');
