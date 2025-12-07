<?php

namespace App\Http\Controllers\Monolith\Siswa;

use App\Http\Controllers\Controller;
use App\Models\IzinModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IzinController extends Controller
{
    public function index()
    {
        return view('siswa.izin');
    }

    public function daftarIzin()
    {
        return view('guru.izin-siswa');
    }

    public function createIzin(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'util_date' => 'required|date',
            'jenis' => 'required',
            'keperluan' => 'required',
            'catatan' => 'required'
        ], [
            'from_date.required' => 'Tanggal mulai izin harus diisi',
            'util_date.required' => 'Tanggal sampai izin harus diisi',
            'jenis.required' => 'Jenis izin harus diisi',
            'keperluan.required' => 'Keperluan izin harus diisi',
            'catatan.required' => 'Catatan izin harus diisi',
        ]);

        try {
            $siswa = Auth::user()->siswa->id;

            $create = IzinModel::create([
                ''
            ]);


        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }

    }
}
