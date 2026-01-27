<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nisn' => fake()->unique()->numerify('##########'),
            'alamat' => fake()->address(),
            'nik' => fake()->unique()->numerify('################'),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->date('Y-m-d', '-15 years'),
            'no_telepon' => fake()->phoneNumber(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'foto' => 'default.jpg',
            'kelas_id' => fake()->numberBetween(1, 3),
            'jurusan_id' => fake()->numberBetween(1, 7),
        ];
    }
}
