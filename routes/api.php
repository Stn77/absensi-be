<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/hallo', function (Request $request) {
    return response()->json([
        'title' => 'hello all',
        'status' => true,
        'userId' => 1,
        'id' => 10,
    ]);
});
