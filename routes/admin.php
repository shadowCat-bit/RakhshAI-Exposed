<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\UserAiController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('admin.index');

Route::get('/users', [UserController::class, 'list'])->name('admin.users.list');

Route::prefix('/chats')->group(function () {
    Route::get('/', [ChatController::class, 'list'])->name('admin.chats.list');
    Route::get('/public', [ChatController::class, 'public'])->name('admin.chats.public');
});

Route::prefix('/users-ai')->group(function () {
    Route::get('/', [UserAiController::class, 'list'])->name('admin.users-ai.list');
    Route::get('/show', [UserAiController::class, 'show'])->name('admin.users-ai.show');
});

Route::prefix('/finance')->group(function () {
    Route::get('/', [FinanceController::class, 'purchased'])->name('admin.finance.purchased');
    Route::get('/period', [FinanceController::class, 'purchasedPeriod'])->name('admin.finance.purchased.period');
});
