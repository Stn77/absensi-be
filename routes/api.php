<?php

use App\Http\Controllers\API\Flutter\Absensi as FlutterAbsensi;
use App\Http\Controllers\API\Flutter\Auth\AnrdAuthController;
use App\Http\Controllers\API\Flutter\Profile;
use App\Http\Controllers\API\IoT\Absensi;
use App\Http\Controllers\API\IoT\Auth\DeviceAuthController;
use App\Http\Controllers\API\Test\Auth as TestAuth;
use App\Http\Controllers\API\Test\BarangController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==================== ROUTE TEST & UTILITY ====================
Route::get('/hallo', function (Request $request) {
    return response()->json([
        'title' => 'hello all',
        'status' => true,
        'userId' => 1,
        'id' => 10,
    ]);
});

Route::get('test-connect', function () {
    return response()->json([
        'message' => 'API is working',
        'status' => 'connected',
    ]);
});

// ==================== ROUTE IOT / DEVICE ====================
Route::prefix('iot')->group(function () {
    Route::prefix('absen')->group(function () {
        Route::post('/login', [DeviceAuthController::class, 'login']);
        Route::post('/register', [DeviceAuthController::class, 'register']);
        Route::post('/logout', [DeviceAuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::post('/submit', [Absensi::class, 'absen'])->name('send.absen');
    });
});

// ==================== ROUTE TEST API ====================
Route::post('/test/login', [TestAuth::class, 'login']);

Route::prefix('test')->middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [TestAuth::class, 'logout']);
    Route::apiResource('barang', BarangController::class);
});

// ==================== ROUTE WHATSAPP ====================
Route::prefix('whatsapp')->group(function () {
    Route::post('/send', [WhatsAppController::class, 'apiSend']);
    Route::post('/send-bulk', [WhatsAppController::class, 'sendBulk']);
});

// ==================== ROUTE FLUTTER / MOBILE APP ====================
// Authentication Routes
Route::prefix('absen')->group(function () {
    Route::post('/login', [AnrdAuthController::class, 'login']);
    Route::post('/logout', [AnrdAuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/checktoken', function (Request $request) {
        return response()->json([
            'message' => 'Token masih aktif',
            'user' => $request->user(),
        ]);
    })->middleware('auth:sanctum');
});

// Authenticated Routes for Flutter
Route::prefix('absen')->middleware('auth:sanctum')->group(function () {
    Route::post('/submit', [FlutterAbsensi::class, 'absen']);
    Route::get('/history', [FlutterAbsensi::class, 'history']);
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('profile', [Profile::class, 'index']);
});
