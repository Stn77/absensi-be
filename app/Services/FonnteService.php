<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;
    protected $url;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->url = config('services.fonnte.url');
    }

    /**
     * Kirim pesan WhatsApp
     *
     * @param string $target Nomor tujuan (format: 628xxx)
     * @param string $message Pesan yang akan dikirim
     * @return array
     */
    public function sendMessage($target, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->url, [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Kode negara Indonesia
            ]);

            $result = $response->json();

            // Log response untuk debugging
            Log::info('Fonnte Response', $result);

            return [
                'success' => $response->successful(),
                'data' => $result,
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Fonnte Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Format nomor telepon ke format WhatsApp
     *
     * @param string $phone
     * @return string
     */
    public function formatPhone($phone)
    {
        // Hapus karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika diawali 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika belum diawali 62, tambahkan
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Kirim pesan ke multiple nomor
     *
     * @param array $targets Array nomor tujuan
     * @param string $message Pesan yang akan dikirim
     * @return array
     */
    public function sendBulkMessage($targets, $message)
    {
        $results = [];

        foreach ($targets as $target) {
            $results[] = $this->sendMessage($target, $message);

            // Delay 1 detik untuk menghindari rate limit
            sleep(1);
        }

        return $results;
    }
}
