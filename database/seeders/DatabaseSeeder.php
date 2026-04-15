<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call AdminSeeder
        $this->call(AdminSeeder::class);

        // Create siswa data FIRST if not exists
        if (Siswa::count() === 0) {
            Siswa::create([
                'nama' => 'Muhammad Ali',
                'nis' => '001',
                'jurusan' => 'Teknik Informatika',
                'tempat_magang' => 'PT. Maju Jaya'
            ]);

            Siswa::create([
                'nama' => 'Siti Nurhaliza',
                'nis' => '002',
                'jurusan' => 'Sistem Informasi',
                'tempat_magang' => 'PT. Digital Indonesia'
            ]);

            Siswa::create([
                'nama' => 'Ahmad Reza',
                'nis' => '003',
                'jurusan' => 'Teknik Komputer',
                'tempat_magang' => 'CV. Digital Maju'
            ]);

            $this->command->info('Siswa data created successfully!');
        }

        // Create test user AFTER siswa if not exists
        if (!User::where('email', 'test@example.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'siswa_id' => 1,
                'role' => 'siswa'
            ]);

            $this->command->info('Test user created successfully!');
        }
    }
}

