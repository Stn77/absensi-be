<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $guru = Role::create(['name' => 'guru']);
        $siswa = Role::create(['name' => 'siswa']);
        $scanner = Role::create(['name' => 'scanner']);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole($admin);

        User::create([
            'name' => 'guru-1',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('12345678')
        ])->assignRole($guru)->guru()->create([
            'nip' => '1234',
            'name' => 'guru-1',
        ]);

        User::create([
            'name' => 'siswa-1',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('12345678')
        ])->assignRole($siswa)->siswa()->create([
            'nisn' => '1234',
            'name' => 'siswa-1',
            'kelas_id' => '1',
            'jurusan_id' => '1',
        ]);
    }
}
