<?php

namespace App\Http\Controllers\Monolith\Izin;

use App\Http\Controllers\Controller;
use App\Models\IzinModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class IzinController extends Controller
{
    public function index()
    {
        return view('izin.index');
    }

    public function formIzin()
    {
        return view('izin.form');
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
        ]);

        try {
            $user = Auth::user();

            // CEK LOGIN
            if (!$user) {
                return response()->json(['message' => 'User tidak login'], 401);
            }

            // CEK ROLE
            if (!$user->hasRole('siswa')) {
                return response()->json(['message' => 'Hanya siswa yang boleh mengajukan izin'], 403);
            }

            // CEK RELASI SISWA
            if (!$user->siswa) {
                return response()->json(['message' => 'Akun siswa belum terhubung, hubungi admin'], 400);
            }

            $file_name = null;

            if ($request->hasFile('file_pendukung')) {
                $file_name = time() . '_' . generateRandomString(12) . '.' . $request->file('file_pendukung')->extension();
                $request->file('file_pendukung')->storeAs('izin', $file_name, 'public');
            }

            IzinModel::create([
                'siswa_id' => $user->siswa->id,
                'from_date' => $request->from_date,
                'until_date' => $request->until_date,
                'jenis' => $request->jenis,
                'keperluan' => $request->keperluan,
                'catatan' => $request->catatan,
                'file_pendukung' => $file_name
            ]);

            return response()->json([
                'message' => 'Izin berhasil dikirim',
                'status' => 200
            ]);

        } catch (\Exception $e) {
            Log::error('IZIN CREATE ERROR: ' . $e->getMessage());

            return response()->json([
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function fetchIzin(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([], 401);
        }

        if ($user->hasRole('admin') || $user->hasRole('guru')) {
            return $this->fetchByGuruAdmin($request);
        }

        return $this->fetchBySiswa();
    }

    public function fetchBySiswa()
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->siswa) {
                return DataTables::of(collect([]))->make(true);
            }

            $query = IzinModel::with('siswa.kelas', 'siswa.jurusan')
                ->where('siswa_id', $user->siswa->id)
                ->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('nama', fn($row) => $row->siswa->name ?? '-')
                ->addColumn('kelas', fn($row) => strtoupper($row->siswa->kelas->name . ' ' . $row->siswa->jurusan->name))
                ->editColumn('from_date', fn($row) => date('d-m-Y', strtotime($row->from_date)))
                ->editColumn('until_date', fn($row) => date('d-m-Y', strtotime($row->until_date)))
                ->addColumn('status', fn() => '<span class="badge bg-warning">Menunggu</span>')
                ->addColumn('action', fn() => '<button class="btn btn-sm btn-info">Detail</button>')
                ->rawColumns(['status', 'action'])
                ->make(true);

        } catch (Exception $e) {
            Log::error('FETCH SISWA IZIN ERROR: ' . $e->getMessage());
            return DataTables::of(collect([]))->make(true);
        }
    }

    public function fetchByGuruAdmin(Request $request)
    {
        $query = IzinModel::with('siswa.kelas', 'siswa.jurusan');

        if ($request->kelas) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas));
        }

        if ($request->jurusan) {
            $query->whereHas('siswa', fn($q) => $q->where('jurusan_id', $request->jurusan));
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama', fn($row) => $row->siswa->name)
            ->addColumn('kelas', fn($row) => strtoupper($row->siswa->kelas->name . ' ' . $row->siswa->jurusan->name))
            ->addColumn('jenis', fn($row) => strtoupper($row->jenis))
            ->addColumn('keperluan', fn($row) => $row->keperluan)
            ->editColumn('from_date', fn($row) => date('d-m-Y', strtotime($row->from_date)))
            ->editColumn('until_date', fn($row) => date('d-m-Y', strtotime($row->until_date)))
            ->addColumn('status', fn() => '<span class="badge bg-warning">Menunggu</span>')
            ->addColumn('action', fn() => '<button class="btn btn-sm btn-info">Detail</button>')
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
