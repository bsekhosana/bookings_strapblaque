<?php

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
