<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ConversationMessageController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\User\AiController;
use App\Http\Controllers\User\ConversationController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\ImageController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/{convUUId?}', [ChatController::class, 'index'])->name('chat');

Route::prefix('user')->group(function () {
    Route::post('/change-name', [UserController::class, 'changeName']);
});

Route::prefix('conv')->group(function () {
    Route::get('/list', [ConversationController::class, 'list']);
    Route::get('/delete', [ConversationController::class, 'delete']);
    Route::get('/delete/all', [ConversationController::class, 'deleteAll']);
    Route::get('/pin', [ConversationController::class, 'pin']);
    Route::get('/messages', [ConversationController::class, 'conversationMessages']);
    Route::get('/change-title', [ConversationController::class, 'changeTitle']);
    Route::get('/remaining-tokens', [ConversationController::class, 'remainingTokens']);

    Route::prefix('msg')->group(function () {
        Route::post('/store', [ConversationMessageController::class, 'conversationMessageStore']);
        Route::post('/stop', [ConversationMessageController::class, 'stop']);
    });
});

Route::prefix('ai')->group(function () {
    Route::get('/list', [AiController::class, 'list']);
    Route::get('/get-ai', [AiController::class, 'getAiById']);
    Route::post('/store', [AiController::class, 'store']);
    Route::post('/update', [AiController::class, 'update']);
    Route::post('/delete', [AiController::class, 'delete']);
});
