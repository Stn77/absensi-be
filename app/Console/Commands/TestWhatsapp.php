<?php

namespace App\Console\Commands;

use App\Services\FonnteService;
use Illuminate\Console\Command;

class TestWhatsApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {phone} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test kirim pesan WhatsApp via Fonnte';

    /**
     * Execute the console command.
     */
    public function handle(FonnteService $fonnte)
    {
        $phone = $this->argument('phone');
        $message = $this->argument('message');

        $this->info('Mengirim pesan WhatsApp...');
        $this->info('Nomor: ' . $phone);
        $this->info('Pesan: ' . $message);
        $this->newLine();

        // Format nomor
        $formattedPhone = $fonnte->formatPhone($phone);
        $this->info('Nomor terformat: ' . $formattedPhone);
        $this->newLine();

        // Kirim pesan
        $result = $fonnte->sendMessage($formattedPhone, $message);

        if ($result['success']) {
            $this->info('✅ Pesan berhasil dikirim!');
            $this->table(
                ['Key', 'Value'],
                collect($result['data'])->map(function ($value, $key) {
                    return [$key, is_array($value) ? json_encode($value) : $value];
                })->toArray()
            );
        } else {
            $this->error('❌ Gagal mengirim pesan!');
            $this->error('Error: ' . ($result['message'] ?? 'Unknown error'));

            if (isset($result['data'])) {
                $this->line(json_encode($result['data'], JSON_PRETTY_PRINT));
            }
        }

        return $result['success'] ? 0 : 1;
    }
}
