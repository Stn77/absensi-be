<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);

        $fixedStudents = [
            [
                'name' => 'Siswa Test 1',
                'email' => 'siswa1@gmail.com',
                'nisn' => '111111',
            ],
            [
                'name' => 'Siswa Test 2',
                'email' => 'siswa2@gmail.com',
                'nisn' => '222222',
            ],
        ];

        foreach ($fixedStudents as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('12345678'),
                ]
            );

            $user->assignRole($siswaRole);

            if (!$user->siswa) {
                $user->siswa()->create([
                    'name' => $data['name'],
                    'nisn' => $data['nisn'],
                    'kelas_id' => 1,
                    'jurusan_id' => 1,
                    'no_telepon' => '081234567890'
                ]);
            }
        }

        User::factory()
            ->count(20)
            ->roleSiswa()
            ->has(Siswa::factory())
            ->create();
    }
}
