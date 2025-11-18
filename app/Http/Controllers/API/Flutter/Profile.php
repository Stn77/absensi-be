<?php

namespace App\Http\Controllers\API\Flutter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Profile extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $siswa = $user->siswa()->with(['kelas', 'jurusan'])->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'siswa' => $siswa,
            ],
        ], 200);
    }
}
