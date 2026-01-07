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
                return $this->adminDashboard();
            } else if ($user->hasRole('guru')) {
                return $this->guruDashboard();
            } else if ($user->hasRole('siswa')) {
                return $this->siswaDashboard();
            }
        }
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function siswaDashboard()
    {
        return view('siswa.dashboard');
    }

    public function guruDashboard()
    {
        return view('guru.dashboard');
    }

}
