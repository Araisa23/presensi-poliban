<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UnitKerja;
use App\Models\TenagaKependidikan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $requiredHeaders = [
            'nip',
            'nama',
            'jenis_kelamin',
            'unit_kerja'
        ];

        if ($rows->isEmpty()) {
            
            throw ValidationException::withMessages([
                'file' => 'File Excel kosong.'
            ]);
        }

        foreach ($rows as $index => $row) {

        // ============================
        // SKIP BARIS KOSONG
        // ============================

        if (
            collect($row)
                ->filter(fn($value) => trim((string)$value) !== '')
                ->isEmpty()
        ) {
            continue;
        }

            // ============================
            // VALIDASI FIELD WAJIB
            // ============================

            foreach ($requiredHeaders as $header) {

                if (!isset($row[$header]) || trim($row[$header]) == '') {

                    throw ValidationException::withMessages([
                        'file' => "Baris ".($index+2)." : Kolom '{$header}' wajib diisi."
                    ]);

                }

            }

            // ============================
            // VALIDASI DUPLIKAT NIP
            // ============================

            if (User::where('nip', trim($row['nip']))->exists()) {

                throw ValidationException::withMessages([
                    'file' => "NIP {$row['nip']} sudah terdaftar."
                ]);

            }

            // ============================
            // VALIDASI JENIS KELAMIN
            // ============================

            $jk = strtoupper(trim($row['jenis_kelamin']));

            if (in_array($jk, ['LAKI-LAKI', 'LAKI LAKI'])) {
                $jk = 'L';
            }

            if ($jk == 'PEREMPUAN') {
                $jk = 'P';
            }

            if (!in_array($jk, ['L', 'P'])) {

                throw ValidationException::withMessages([
                    'file' => "Jenis Kelamin pada NIP {$row['nip']} harus L atau P."
                ]);

            }

            // ============================
            // VALIDASI UNIT KERJA
            // ============================

            $unitKerja = UnitKerja::where(
                'nama_unit',
                trim($row['unit_kerja'])
            )->first();

            if (!$unitKerja) {

                throw ValidationException::withMessages([
                    'file' => "Unit Kerja '{$row['unit_kerja']}' belum terdaftar di sistem."
                ]);

            }

            // ============================
            // CREATE USER
            // ============================

            $user = User::create([

                'nip' => trim($row['nip']),
                'name' => trim($row['nama']),
                'password' => Hash::make(trim($row['nip'])),
                'role_id' => 2,
                'is_first_login' => true,

            ]);

            // ============================
            // CREATE PEGAWAI
            // ============================

            TenagaKependidikan::create([

                'user_id' => $user->id,
                'nip' => trim($row['nip']),
                'nama' => trim($row['nama']),
                'jenis_kelamin' => $jk,
                'pangkat' => !empty($row['pangkat'])
                    ? trim($row['pangkat'])
                    : null,
                'unit_kerja_id' => $unitKerja->id,

            ]);
        }
    }
}