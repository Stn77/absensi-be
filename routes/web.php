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
    Route::post('login/s', 'loginSubmit')->name('login.submit');

    Route::get('register', 'showRegistrationForm')->name('register.page');
    Route::post('register/s', 'registrationSubmit')->name('register.submit');
});

Route::post('logout', [WebAuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('dashboard')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');


});

// Route::prefix('dashboard')->middleware(['auth', 'role:siswa'])->group(function () {
//     Route::get('/', function () {
//         return view('dashboard.index');
//     })->name('home');


// });

// Route::prefix('dashboard')->middleware(['auth', 'role:guru'])->group(function () {
//     Route::get('/', function () {
//         return view('dashboard.index');
//     })->name('home');


// });

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('profile.index');
    })->name('profile.index');
});

Route::prefix('whatsapp')->group(function () {
    Route::get('/send', [WhatsAppController::class, 'index'])->name('whatsapp.index');
    Route::post('/send-s', [WhatsAppController::class, 'send'])->name('whatsapp.send');
    Route::post('/send-bulk', [WhatsAppController::class, 'sendBulk'])->name('whatsapp.send-bulk');
});
