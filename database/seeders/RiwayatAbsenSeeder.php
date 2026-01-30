<?php

namespace Database\Seeders;

use App\Models\RiwayatAbsen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiwayatAbsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RiwayatAbsen::factory()->count(100)->create();
    }
}
