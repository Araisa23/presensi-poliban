<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        \App\Models\JadwalKerja::truncate();

        foreach ($days as $day) {
            \App\Models\JadwalKerja::create([
                'hari' => $day,
                'jam_masuk' => '08:00',
                'jam_pulang' => '16:00',
                'is_libur' => in_array($day, ['Sabtu', 'Minggu']),
            ]);
        }
    }
}
