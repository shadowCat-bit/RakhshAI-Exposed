<?php

use App\Http\Controllers\User\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/{imageUUId?}', [ImageController::class, 'index'])->name('image');

Route::prefix('img')->group(function () {
    Route::get('/list', [ImageController::class, 'list']);
    Route::post('/store', [ImageController::class, 'store']);
    Route::get('/public-show', [ImageController::class, 'publicShow']);
    Route::get('/pin', [ImageController::class, 'pin']);
    Route::get('/delete', [ImageController::class, 'delete']);
    Route::get('/delete/all', [ImageController::class, 'deleteAll']);
});
