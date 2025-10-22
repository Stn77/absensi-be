<?php

namespace App\Http\Controllers\API\IoT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Absensi extends Controller
{
    /**
     * @param $rfId for id in card
     * @param $time time absens
     */

    public function absen(Request $request)
    {
        return response()->json([
            'data' => 'all',
            'status' => 200
        ]);
    }

    
}
