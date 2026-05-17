<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UnitKerja;
use App\Models\TenagaKependidikan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;

class PegawaiImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // skip header
            if ($index == 0) {
                continue;
            }

            // skip kalau nip kosong
            if (empty($row[0])) {
                continue;
            }

            // cek user sudah ada
            $existingUser = User::where('nip', $row[0])->first();

            if ($existingUser) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | AUTO CREATE UNIT KERJA
            |--------------------------------------------------------------------------
            */

            $unitKerja = UnitKerja::firstOrCreate([
                'nama_unit' => trim($row[4])
            ]);

            /*
            |--------------------------------------------------------------------------
            | CREATE USER
            |--------------------------------------------------------------------------
            */

            $user = User::create([
                'nip' => $row[0],
                'name' => $row[1],
                'jenis_kelamin' => $row[2],
                'pangkat' => $row[3] ?? null,
                'unit_kerja_id' => $unitKerja->id,
                'password' => Hash::make($row[0]),
                'role_id' => 2,
                'is_first_login' => true,
            ]);

            /*
            |--------------------------------------------------------------------------
            | CREATE TENAGA KEPENDIDIKAN
            |--------------------------------------------------------------------------
            */

            TenagaKependidikan::create([
                'user_id' => $user->id,
                'nip' => $row[0],
                'nama' => $row[1],
                'jenis_kelamin' => $row[2],
                'pangkat' => $row[3] ?? null,
                'unit_kerja_id' => $unitKerja->id,
            ]);
        }
    }
}