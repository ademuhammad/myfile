<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Classroom;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Kelas Dummy terlebih dahulu (karena siswa butuh classroom_id)
        $kelas = Classroom::create([
            'name' => 'Kelas 7A',
            'academic_year' => '2026/2027',
        ]);

        // 2. Buat Akun Guru
        User::create([
            'name' => 'Guru Informatika',
            'username' => 'guru01', // Gunakan ini untuk login
            'password' => Hash::make('password123'), // Password dummy
            'role' => 'guru',
        ]);

        // 3. Buat Akun Siswa 1
        User::create([
            'name' => 'Andi (Siswa)',
            'username' => '1001', // Anggap ini NIS
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'classroom_id' => $kelas->id,
        ]);

        // 4. Buat Akun Siswa 2
        User::create([
            'name' => 'Budi (Siswa)',
            'username' => '1002', // Anggap ini NIS
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'classroom_id' => $kelas->id,
        ]);
    }
}
