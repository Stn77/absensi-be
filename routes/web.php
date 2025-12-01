<?php

use App\Http\Controllers\Monolith\Auth\WebAuthController;
use App\Http\Controllers\Monolith\TestController;
use App\Http\Controllers\Monolith\Admin\AbsensiController;
use App\Http\Controllers\Monolith\Admin\Dashboard;
use App\Http\Controllers\Monolith\Aione;
use App\Http\Controllers\Monolith\Data\Absensi as MonolithAbsensi;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TestController::class, 'test_send_message']);

Route::prefix('auth')->middleware('guest')->controller(WebAuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login/s', 'loginSubmit')->name('login.submit');

    Route::get('register', 'showRegistrationForm')->name('register.page');
    Route::post('register/s', 'registrationSubmit')->name('register.submit');
});

Route::post('logout', [WebAuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('dashboard', [Aione::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/absensi/siswa', [AbsensiController::class, 'index'])->name('admin.absensi.index');
    Route::get('/absensi/data/siswa', [MonolithAbsensi::class, 'getData'])->name('admin.absensi.data');
    Route::get('/analytics', [Dashboard::class, 'analytics']);
});

Route::middleware(['auth', 'role:guru|admin'])->group(function () {

});

Route::middleware(['auth', 'role:siswa|admin'])->group(function () {

});

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
