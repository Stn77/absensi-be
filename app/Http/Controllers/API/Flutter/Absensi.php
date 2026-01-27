<?php

namespace App\Http\Controllers\API\Flutter;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAbsen;
use App\Models\Siswa;
use App\Services\FonnteService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Absensi extends Controller
{
    public $fonte;

    public function __construct(FonnteService $fonte) {
        $this->fonte = $fonte;
    }

    /**
     * Handle absen submission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * usage example:
     * POST /api/absen/submit
     * Headers: Authorization: Bearer {token}
     * Body: {
     *  "latitude": "-6.200000",
     *  "longitude": "106.816666",
     *  "time": "08:15:00",
     *  "hari": "Monday",
     *  "tanggal": "2025-10-21"
     * }
     */
    public function absen(Request $request)
    {
        $user = $request->user();
        $siswa = $user->siswa()->first();
        $jenis = 'datang';

        // Log::debug($user);
        Log::debug($siswa);

        $riwayatAbsenHistory = RiwayatAbsen::where('siswa_id', $siswa->id)->where('tanggal', $request->tanggal)->latest()->first();

        if($riwayatAbsenHistory && $riwayatAbsenHistory->jenis === 'datang') {
            $jenis = 'pulang';
        }

        else if($riwayatAbsenHistory && $riwayatAbsenHistory->jenis === 'pulang') {
            return response()->json([
                'status' => '202',
                'message' => 'anda sudah melakukan absen hari ini',
            ], 201);
        }

        $riwayatAbsen = RiwayatAbsen::create([
            'tanggal' => $request->tanggal,
            'hari' => $request->hari,
            'waktu_absen' => $request->time,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_late' => $request->time > '08:00:00' ? 'Terlambat' : 'Tepat Waktu',
            'siswa_id' => $siswa->id,
            'jenis' => $jenis,
        ]);

        // $phone = $this->fonte->formatPhone($siswa->no_telepon);

        // $message = $this->fonte->sendMessage($phone, 'telah absen pada '.$jenis.' ' . time());

        return response()->json([
            'status' => '200',
            'message' => 'Absen berhasil untuk user: ' . $user->name,
            'data' => [
                'riwayat_absen_id' => $riwayatAbsen->id,
                'tanggal' => $riwayatAbsen->tanggal,
                'hari' => $riwayatAbsen->hari,
                'waktu_absen' => $riwayatAbsen->waktu_absen,
                'is_late' => $riwayatAbsen->is_late,
            ]
        ]);
    }

    public function history(Request $request)
    {
        $user = $request->user()->siswa()->first();

        $history = RiwayatAbsen::where('siswa_id', $user->id)->orderBy('tanggal', 'desc')->get();

        return response()->json([
            'status' => '200',
            'message' => 'Riwayat absen untuk user: ' . $user->name,
            'data' => $history
        ]);
    }
}
