<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UnitKerja;
use App\Models\JadwalKerja;
use App\Models\LokasiKantor;
use App\Models\TenagaKependidikan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PolibanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Lokasi Kantor: Politeknik Negeri Banjarmasin
        $lokasi = LokasiKantor::updateOrCreate(
            ['nama_lokasi' => 'Kampus UTAMA POLIBAN'],
            [
                'latitude' => '-3.2958',
                'longitude' => '114.5816',
                'radius' => 200,
            ]
        );

        // 2. Jadwal Kerja
        $jadwal = JadwalKerja::updateOrCreate(
            ['jam_masuk' => '07:30:00', 'jam_pulang' => '16:00:00'],
            []
        );

        // 3. Unit Kerja (Jurusan)
        $units = [
            'Jurusan Teknologi Informasi',
            'Jurusan Teknik Sipil',
            'Jurusan Teknik Mesin',
            'Jurusan Teknik Elektro',
            'Jurusan Akuntansi',
            'Jurusan Administrasi Bisnis',
        ];

        $unitIds = [];
        foreach ($units as $u) {
            $unit = UnitKerja::updateOrCreate(['nama_unit' => $u], []);
            $unitIds[$u] = $unit->id;
        }

        // 4. Pegawai Contoh (Satu tiap Jurusan)
        $rolePegawai = Role::where('name', 'pegawai')->first();
        
        $pegawaiSamples = [
            ['nama' => 'Budi TI', 'email' => 'buditi@poliban.ac.id', 'unit' => 'Jurusan Teknologi Informasi', 'nip' => '19900101202001001'],
            ['nama' => 'Siti Sipil', 'email' => 'sitisipil@poliban.ac.id', 'unit' => 'Jurusan Teknik Sipil', 'nip' => '19900101202001002'],
            ['nama' => 'Andi Mesin', 'email' => 'andimesin@poliban.ac.id', 'unit' => 'Jurusan Teknik Mesin', 'nip' => '19900101202001003'],
            ['nama' => 'Lutfi Elektro', 'email' => 'lutfielektro@poliban.ac.id', 'unit' => 'Jurusan Teknik Elektro', 'nip' => '19900101202001004'],
            ['nama' => 'Wati Akuntansi', 'email' => 'watiakun@poliban.ac.id', 'unit' => 'Jurusan Akuntansi', 'nip' => '19900101202001005'],
            ['nama' => 'Rudi Adbis', 'email' => 'rudiadbis@poliban.ac.id', 'unit' => 'Jurusan Administrasi Bisnis', 'nip' => '19900101202001006'],
        ];

        foreach ($pegawaiSamples as $p) {
            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['nama'],
                    'password' => Hash::make($p['nip']),
                    'role_id' => $rolePegawai->id,
                ]
            );

            TenagaKependidikan::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $p['nip'],
                    'nama' => $p['nama'],
                    'unit_kerja_id' => $unitIds[$p['unit']],
                ]
            );
        }
    }
}
