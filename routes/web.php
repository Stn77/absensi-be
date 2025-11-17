<?php

use App\Http\Controllers\Monolith\Auth\WebAuthController;
use App\Http\Controllers\Monolith\TestController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TestController::class, 'test_send_message']);

Route::prefix('auth')->middleware('guest')->controller(WebAuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login.page');
    Route::get('login/s', 'loginSubmit')->name('login.submit');

    Route::get('register', 'showRegistrationForm')->name('register.page');
    Route::get('register/s', 'registrationSubmit')->name('register.submit');
});

Route::prefix('dashboard')->middleware('auth')->group(function () {

});

Route::prefix('whatsapp')->group(function () {
    Route::get('/send', [WhatsAppController::class, 'index'])->name('whatsapp.index');
    Route::post('/send-s', [WhatsAppController::class, 'send'])->name('whatsapp.send');
    Route::post('/send-bulk', [WhatsAppController::class, 'sendBulk'])->name('whatsapp.send-bulk');
});
