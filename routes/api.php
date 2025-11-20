<?php

use App\Http\Controllers\API\Flutter\Absensi as FlutterAbsensi;
use App\Http\Controllers\API\Flutter\Auth\AnrdAuthController;
use App\Http\Controllers\API\Flutter\Profile;
use App\Http\Controllers\API\IoT\Absensi;
use App\Http\Controllers\API\IoT\Auth\DeviceAuthController;
use App\Http\Controllers\API\Test\Auth as TestAuth;
use App\Http\Controllers\API\Test\BarangController;
use App\Http\Controllers\WhatsAppController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/hallo', function (Request $request) {
    return response()->json([
        'title' => 'hello all',
        'status' => true,
        'userId' => 1,
        'id' => 10,
    ]);
});

Route::prefix('iot/absen')->group(function () {
    Route::post('/submit', [Absensi::class, 'absen'])->name('send.absen');
    Route::post('/login', [DeviceAuthController::class, 'login']);
    Route::post('/register', [DeviceAuthController::class, 'register']);
    Route::post('/logout', [DeviceAuthController::class, 'logout'])->middleware('auth:sanctum');
});

// ⭐ PENTING: Route Login (tanpa middleware)
Route::post('/test/login', [TestAuth::class, 'login']);

// ⭐ PENTING: Route yang memerlukan autentikasi (sanctum)
Route::prefix('test')->middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [TestAuth::class, 'logout']);

    // ⭐ PENTING: CRUD Barang
    Route::apiResource('barang', BarangController::class);
});

// API untuk WhatsApp
Route::prefix('whatsapp')->group(function () {
    Route::post('/send', [WhatsAppController::class, 'apiSend']);
    Route::post('/send-bulk', [WhatsAppController::class, 'sendBulk']);
});

Route::prefix('user')->middleware('auth:sanctum')->group(function (){
    Route::get('profile', [Profile::class, 'index']);
});

Route::prefix('/absen')->group(function () {
    Route::post('/login', [AnrdAuthController::class, 'login']);
    Route::post('/logout', [AnrdAuthController::class, 'logout']);
});

Route::prefix('absen')->middleware('auth:sanctum')->group(function () {
    Route::post('/submit', [FlutterAbsensi::class, 'absen']);
    Route::get('/history', [FlutterAbsensi::class, 'history']);
});
