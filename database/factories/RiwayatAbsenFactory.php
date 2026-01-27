<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiwayatAbsen>
 */
class RiwayatAbsenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggal = fake()->dateTimeBetween('-1 month', 'now');
        return [
            'siswa_id' => fake()->numberBetween(1, 50),
            'tanggal' => $tanggal,
            'hari' => $tanggal->format('l'),
            'is_late' => fake()->randomElement(['Terlambat', 'Tepat Waktu']),
            'waktu_absen' => $tanggal->format('H:i:s'),
            'latitude' => fake()->latitude(-6.200000, -6.300000),
            'longitude' => fake()->longitude(106.800000, 106.900000),
            'jenis' => fake()->randomElement(['masuk', 'pulang']),
        ];
    }
}
