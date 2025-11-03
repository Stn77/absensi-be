<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = [
            'mp',
            'ak',
            'bd',
            'tsm',
            'dkv',
            'pplg',
            'tkkr'
        ];

        $kelas = [
            'X',
            'XI',
            'XII',
        ];

        foreach ($jurusan as $j) {
            Jurusan::create(['name' => $j]);
        }

        foreach ($kelas as $k) {
            Kelas::create(['name' => $k]);
        }
    }
}
