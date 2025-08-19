<?php

use App\Http\Controllers\Api\PackageController as ApiPackageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PublicChatController;
use App\Http\Controllers\TempController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ChatController;

Route::get('/tmp', [TempController::class, 'index']);
// Route::post('/test-ext', [TempController::class, 'testExt']);
// Route::get('/get-stream', [TempController::class, 'getStream']);

Route::get('/login-user-6548', [TempController::class, 'loginUser']);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/public-chat', [PublicChatController::class, 'publicChat'])->name('home.public.chat');

Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'registerStep1'])->name('register.step1');
    Route::get('/register/confirm', [AuthController::class, 'registerStep2'])->name('register.step2');
    Route::post('/register-process', [AuthController::class, 'registerProcess'])->name('register.process');
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordStep1'])->name('forgot-password.step1');
    Route::get('/forgot-password/confirm', [AuthController::class, 'forgotPasswordStep2'])->name('forgot-password.step2');
    Route::post('/forgot-password-process', [AuthController::class, 'forgotPasswordProcess'])->name('forgot-password.process');
});
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('plans')->middleware('auth')->group(function () {
    Route::get('/', [PackageController::class, 'index'])->withoutMiddleware('auth')->name('packages');
    Route::get('/payment-methods/{tokenPackage}', [PackageController::class, 'paymentMethod'])->name('packages.payment-method');
    Route::post('/purchase/{tokenPackage}', [PackageController::class, 'purchase'])->name('packages.purchase');
});

Route::match(['get', 'post'], '/payment/callback', [PackageController::class, 'callback']);
Route::match(['get', 'post'], '/payment/callback2', [PackageController::class, 'callback2']);

Route::get('api-package-purchase', [ApiPackageController::class, 'purchase'])->middleware(['authByToken']);
Route::get('app-chat/{convUUId?}', [ChatController::class, 'index'])->middleware(['authByToken']);;

Route::get('/about-us', function () {
    return view('about-us');
});

Route::get('/terms', function () {
    return view('terms');
});

Route::get('/faq', function () {
    return view('faq');
});

Route::get('/versions', function () {
    return view('versions');
});

Route::get('/contact-us', function () {
    return view('contact-us');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/payment-successfull', function () {
    return view('payment-successfull');
});

Route::get('/payment-unsuccessfull', function () {
    return view('payment-unsuccessfull');
});

// Route::get('/admin', function () {
//     return view('admin.dashboard');
// });

// Route::get('/admin-users', function () {
//     return view('admin.users.list');
// });

// Route::get('/admin-chats', function () {
//     return view('admin.chats.chats');
// });

Route::prefix('explore')->group(function () {
    Route::get('/', [ExploreController::class, 'explore']);
    Route::get('/image/other-images', [ExploreController::class, 'otherImages']);
    Route::get('/image/{uuid}', [ExploreController::class, 'single']);
});

Route::get('/profile', function () {
    return view('/user/profile');
});

Route::get('/zalplus-llm', function () {
    return view('zalplus-llm');
});
