<?php

use App\Http\Controllers\Monolith\Auth\WebAuthController;
use App\Http\Controllers\Monolith\TestController;
use App\Http\Controllers\Monolith\Absensi\AbsensiController;
use App\Http\Controllers\Monolith\Admin\Dashboard;
use App\Http\Controllers\Monolith\Aione;
use App\Http\Controllers\Monolith\Data\Absensi as MonolithAbsensi;
use App\Http\Controllers\Monolith\Data\Siswa as AkunSiswa;
use App\Http\Controllers\Monolith\Izin\IzinController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/test', [TestController::class, 'index']);

Route::prefix('auth')->middleware('guest')->controller(WebAuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login/s', 'loginSubmit')->name('login.submit');

    Route::get('register', 'showRegistrationForm')->name('register.page');
    Route::post('register/s', 'registrationSubmit')->name('register.submit');
});

Route::post('logout', [WebAuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('dashboard', [Aione::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/absensi/data/siswa', [MonolithAbsensi::class, 'getData'])->name('admin.absensi.data');
});

Route::middleware(['auth', 'role:guru|admin'])->group(function () {
    Route::get('/absensi/siswa', [AbsensiController::class, 'index'])->name('admin.absensi.index');
    Route::get('/absensi/export', [AbsensiController::class, 'exportPage'])->name('admin.absensi.export-page');
    
});

Route::middleware(['auth', 'role:siswa|admin|guru'])->group(function () {
    Route::get('izin', [IzinController::class, 'formIzin'])->name('siswa.izin.create');
    Route::get('daftar-izin', [IzinController::class, 'index'])->name('siswa.izin.list');
    Route::get('daftar-izin-fetch', [IzinController::class, 'fetchIzin'])->name('siswa.izin.list.fetch');
});

Route::middleware(['auth', 'role:siswa|admin'])->group(function () {
    Route::post('izin-post', [IzinController::class, 'createIzin'])->name('siswa.izin.post');
});

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/', [Aione::class, 'profile'])->name('profile.index');
});

// Route::prefix('whatsapp')->group(function () {
//     Route::get('/send', [WhatsAppController::class, 'index'])->name('whatsapp.index');
//     Route::post('/send-s', [WhatsAppController::class, 'send'])->name('whatsapp.send');
//     Route::post('/send-bulk', [WhatsAppController::class, 'sendBulk'])->name('whatsapp.send-bulk');
// });

Route::prefix('data/siswa')->middleware(['auth', 'role:admin|guru'])->group(function(){
    Route::get('/', [AkunSiswa::class, 'index'])->name('data.siswa.index');
    Route::get('/get', [AkunSiswa::class, 'getData'])->name('akun.siswa.get');
    Route::get('/edit/{id}', [AkunSiswa::class, 'edit'])->name('data.siswa.edit');
    Route::post('/update', [AkunSiswa::class, 'update'])->name('data.siswa.update');
    Route::delete('/delete/{id}',[AkunSiswa::class, 'delete'])->name('data.siswa.delete');

    Route::get('/get-data/{id}', [AkunSiswa::class, 'getSingleData'])->name('data.siswa.single');
    Route::post('/store', [AkunSiswa::class, 'store'])->name('akun.siswa.store');
    Route::post('/import', [AkunSiswa::class, 'import'])->name('data.siswa.import');
    Route::get('/template', [AkunSiswa::class, 'getTemplate'])->name('data.siswa.template');
});
