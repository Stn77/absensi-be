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
            'until_date' => 'required|date',
            'jenis' => 'required',
            'keperluan' => 'required',
            'catatan' => 'required',
            'file_pendukung' => 'nullable|mimes:jpg,jpeg,png,pdf'
        ], [
            'from_date.required' => 'Tanggal mulai izin harus diisi',
            'until_date.required' => 'Tanggal sampai izin harus diisi',
            'jenis.required' => 'Jenis izin harus diisi',
            'keperluan.required' => 'Keperluan izin harus diisi',
            'catatan.required' => 'Catatan izin harus diisi',
            'file_pendukung.mimes' => 'File pendukung harus berupa gambar atau PDF'
        ]);

        try {
            $siswa = Auth::user()->siswa->id;

            if ($request->hasFile('file_pendukung')) {
                $file_name = time() . ' ' . generateRandomString(12) . '.' . $request->file('file_pendukung')->extension();
                $file_pendukung = $request->file('file_pendukung')->storeAs('izin', $file_name, 'public');
            }

            $create = IzinModel::create([
                'siswa_id' => $siswa,
                'from_date' => $request->from_date,
                'until_date' => $request->until_date,
                'jenis' => $request->jenis,
                'keperluan' => $request->keperluan,
                'catatan' => $request->catatan,
                'file_pendukung' => $file_name
            ]);

            if(!$create) {
                return response()->json([
                    'message' => 'gagal menyimpan izin'
                ], 500);
            }

            return response()->json([
                'message' => 'izin berhasil disimpan',
                'status' => 200
            ], 200);
        }catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'terjadi kesalahan pada server'
            ], 500);
        }

    }
}
