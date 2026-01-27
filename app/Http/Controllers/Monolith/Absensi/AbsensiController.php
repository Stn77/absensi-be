<?php

namespace App\Http\Controllers\Monolith\Absensi;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\RiwayatAbsen;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\DataTables;

class AbsensiController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();

        return view('absensi.index', compact('kelas', 'jurusan'));
    }

    public function exportPage()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();

        return view('absensi.export', compact('kelas', 'jurusan'));
    }
}
