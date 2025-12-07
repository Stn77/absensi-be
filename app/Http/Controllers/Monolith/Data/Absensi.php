<?php

namespace App\Http\Controllers\Monolith\Data;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAbsen;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Absensi extends Controller
{
    public function getData()
    {
        $riwayatAbsens = RiwayatAbsen::with('siswa', 'siswa.kelas', 'siswa.jurusan')->orderBy('created_at', 'desc')->get();

        return DataTables::of($riwayatAbsens)
            ->addIndexColumn()
            ->editColumn('created_at', function (RiwayatAbsen $riwayatAbsen) {
                return $riwayatAbsen->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('coordinates', function (RiwayatAbsen $riwayatAbsen) {
                return $riwayatAbsen->latitude . ', ' . $riwayatAbsen->longitude;
            })
            ->addColumn('kelas', function ($data) {
                return strtoupper($data->siswa->kelas->name.' '.$data->siswa->jurusan->name);
            })
            ->addColumn('koordinat', function($data) {
                return "https://www.google.com/maps/place/$data->latitude,$data->longitude" ;
            })
            ->make(true);
    }
}
