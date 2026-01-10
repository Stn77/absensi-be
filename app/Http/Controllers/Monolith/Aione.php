<?php

namespace App\Http\Controllers\Monolith;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function profile()
    {
        $idUser = Auth::user()->id;
        $user = Auth::user();

        if ($user->hasRole('admin')) {

            $data = Auth::user();
            return view('aio.profile', compact(['data']));

        } else if ($user->hasRole('guru')) {

            $data = User::with(['guru'])->find($idUser);
            return view('aio.profile', compact(['data']));

        } else if ($user->hasRole('siswa')) {

            $data = User::with(['siswa', 'siswa.kelas', 'siswa.jurusan'])->find($idUser);
            return view('aio.profile', compact(['data']));

        }

    }
}
