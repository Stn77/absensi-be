<?php

use App\Http\Controllers\Monolith\Auth\WebAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->middleware('guest')->controller(WebAuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login.page');
    Route::get('login/s', 'loginSubmit')->name('login.submit');

    Route::get('register', 'showRegistrationForm')->name('register.page');
    Route::get('register/s', 'registrationSubmit')->name('register.submit');
});

Route::prefix('dashboard')->middleware('auth')->group(function () {

});
