<?php

namespace App\Http\Controllers;

use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhatsAppController extends Controller
{
    protected $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    /**
     * Form untuk mengirim pesan
     */
    public function index()
    {
        return view('testing.send');
    }

    /**
     * Kirim pesan WhatsApp
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'message' => 'required|string|min:1',
        ], [
            'phone.required' => 'Nomor telepon wajib diisi',
            'message.required' => 'Pesan wajib diisi',
            'message.min' => 'Pesan minimal 1 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Format nomor telepon
        $phone = $this->fonnte->formatPhone($request->phone);

        // Kirim pesan
        $result = $this->fonnte->sendMessage($phone, $request->message);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim!',
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim pesan',
            'error' => $result['data'] ?? $result['message']
        ], 500);
    }

    /**
     * Kirim pesan ke multiple nomor
     */
    public function sendBulk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phones' => 'required|array',
            'phones.*' => 'required|string',
            'message' => 'required|string|min:1',
        ], [
            'phones.required' => 'Nomor telepon wajib diisi',
            'phones.array' => 'Format nomor telepon tidak valid',
            'message.required' => 'Pesan wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Format semua nomor
        $phones = array_map(function($phone) {
            return $this->fonnte->formatPhone($phone);
        }, $request->phones);

        // Kirim pesan bulk
        $results = $this->fonnte->sendBulkMessage($phones, $request->message);

        $successCount = count(array_filter($results, function($result) {
            return $result['success'];
        }));

        return response()->json([
            'success' => true,
            'message' => "Berhasil mengirim {$successCount} dari " . count($phones) . " pesan",
            'results' => $results
        ]);
    }

    /**
     * API endpoint untuk kirim pesan (untuk testing via API)
     */
    public function apiSend(Request $request)
    {
        return $this->send($request);
    }
}
