<?php

namespace App\Http\Controllers\Monolith;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * all in one controller
 * no mater his role
 */
class Aione extends Controller
{
    public function dashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return view('admin.dashboard');
            } else if ($user->hasRole('guru')) {
                return view('guru.dashboard');
            } else if ($user->hasRole('siswa')) {
                return view('siswa.dashboard');
            }
        }
    }


}
