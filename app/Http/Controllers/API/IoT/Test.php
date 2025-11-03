<?php

namespace App\Http\Controllers\API\IoT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Test extends Controller
{
    function checkToken(Request $request)
    {
        $user = Auth::user();
    }
}
