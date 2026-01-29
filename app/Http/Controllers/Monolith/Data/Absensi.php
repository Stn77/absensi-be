<?php

namespace App\Http\Controllers\Monolith\Data;

use App\Export\ExcellExportAbsenSiswa;
use App\Http\Controllers\Controller;
use App\Models\RiwayatAbsen;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class Absensi extends Controller
{
    public function __construct() {}

    // tambahno filter by kelas dan jurusan
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
                return strtoupper($data->siswa->kelas->name . ' ' . $data->siswa->jurusan->name);
            })
            ->addColumn('koordinat', function ($data) {
                return "https://www.google.com/maps/place/$data->latitude,$data->longitude";
            })
            ->make(true);
    }


    // Export excell, haduhh ribet wokkk
    public function export(Request $request)
    {
        $request->validate([
            'kelas' => 'required|exists:kelas,id',
            'jurusan' => 'required|exists:jurusans,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'file_type' => 'required|in:pdf,xlsx',
        ]);

        try {
            // Ambil siswa berdasarkan kelas dan jurusan
            $siswaIds = Siswa::where('kelas_id', $request->kelas)
                ->where('jurusan_id', $request->jurusan)
                ->pluck('id')
                ->toArray();

            if (empty($siswaIds)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Tidak ada siswa ditemukan.',
                ], 404);
            }

            // Query data absen
            $absenQuery = RiwayatAbsen::whereIn('siswa_id', $siswaIds)
                ->select('hari', 'waktu_absen', 'jenis', 'is_late', 'siswa_id', 'created_at')
                ->with(['siswa' => function($query) {
                    $query->select('id', 'name', 'nisn', 'kelas_id', 'jurusan_id');
                }, 'siswa.kelas' => function($query) {
                    $query->select('id', 'name');
                }, 'siswa.jurusan' => function($query) {
                    $query->select('id', 'name');
                }]);

            // Filter tanggal jika ada
            if ($request->from_date && $request->to_date) {
                $absenQuery->whereDate('created_at', '>=', $request->from_date)
                    ->whereDate('created_at', '<=', $request->to_date);
            }

            $absen = $absenQuery->get()
                ->map(function ($item) {
                    return [
                        'hari' => $item->hari,
                        'waktu_absen' => $item->waktu_absen,
                        'jenis' => $item->jenis,
                        'is_late' => $item->is_late,
                        'nama_siswa' => $item->siswa->name,
                        'nisn' => $item->siswa->nisn,
                        'jurusan' => $item->siswa->jurusan->name ?? null,
                        'kelas' => $item->siswa->kelas->name ?? null,
                        'created_at' => $item->created_at, // Pastikan ini ada
                    ];
                })
                ->toArray();

            if (empty($absen)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Tidak ada data absensi ditemukan.',
                ], 404);
            }

            Log::info('Data absen ditemukan: ' . count($absen) . ' record');

            if ($request->file_type === 'pdf') {
                return $this->exportPdf($absen, 'Data_Absensi_Siswa');
            } else if ($request->file_type === 'xlsx') {
                return $this->exportExcel($absen, 'Data_Absensi_Siswa');
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Tipe file tidak valid. Pilih antara pdf atau excel.',
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Error exporting attendance data: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan saat mengekspor data absensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function exportPdf($data, $filename)
    {
        $pdf = Pdf::loadView('data.export-pdf', compact('data'))
            ->setPaper('a4', 'landscape');

        $filename = $filename . '.pdf';

        // Untuk API response, gunakan stream dengan proper headers
        return $pdf->stream($filename);
    }

    public function exportExcel($data, $filename)
    {
        $exporter = new ExcellExportAbsenSiswa($data, $filename);
        return $exporter->export();
    }

    public function tested($data) {
        Log::info('data received in tested function', ['data' => $data]);
        foreach($data as $item) {
            Log::info('Item:', (array) $item);
        }
    }
}
