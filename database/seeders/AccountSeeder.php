<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Julia',
            'email' => 'julia@gmail.com',
            'password' => Hash::make('12345678')
        ])->assignRole('siswa')->siswa()->create([
            'nisn' => '3333',
            'name' => 'Julia',
            'kelas_id' => '1',
            'jurusan_id' => '1',
            'no_telepon' => '088989208095'
        ]);

        User::create([
            'name' => 'Agus Salim',
            'email' => 'agussalim@gmail.com',
            'password' => Hash::make('12345678')
        ])->assignRole('siswa')->siswa()->create([
            'nisn' => '2222',
            'name' => 'Agus Salim',
            'kelas_id' => '1',
            'jurusan_id' => '1',
            'no_telepon' => '088989208095'
        ]);

        User::create([
            'name' => 'Juan Cocok',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('12345678')
        ])->assignRole('siswa')->siswa()->create([
            'nisn' => '1111',
            'name' => 'Juan Cocok',
            'kelas_id' => '1',
            'jurusan_id' => '1',
            'no_telepon' => '088989208095'
        ]);
    }
}
