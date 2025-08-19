<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ConversationMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/auth/login', [LoginController::class, 'login']);

Route::prefix('auth')->middleware(['guest'])->group(function () {

    Route::prefix('register')->group(function () {
        Route::get('/step1', [RegisterController::class, 'step1']);
        Route::get('/step2', [RegisterController::class, 'step2']);
    });

    Route::prefix('forgot-password')->group(function () {
        Route::get('/step1', [ForgotPasswordController::class, 'step1']);
        Route::get('/step2', [ForgotPasswordController::class, 'step2']);
    });
});

Route::prefix('home')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/user-data', [UserController::class, 'userDataHome']);
    Route::get('/slider', [HomeController::class, 'slider']);
});

Route::prefix('packages')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [PackageController::class, 'packages']);
    Route::get('/payment-methods', [PackageController::class, 'paymentMethods']);
});

// Route::prefix('chat')->middleware(['auth:sanctum'])->group(function () {
//     Route::get('/index', [ChatController::class, 'index']);
//     Route::post('/store', [ConversationMessageController::class, 'conversationMessageStore']);
// });
