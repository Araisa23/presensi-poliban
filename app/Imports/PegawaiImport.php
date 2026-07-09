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
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class PegawaiImport extends DefaultValueBinder implements ToCollection, WithHeadingRow, WithCustomValueBinder
{
    /**
     * Paksa semua kolom yang berpotensi berisi angka panjang
     * (NIP) dibaca sebagai STRING, bukan numeric/scientific.
     */
    public function bindValue(Cell $cell, $value)
    {
        // Ambil nama kolom heading pada baris pertama (opsional, kalau mau spesifik per kolom)
        // Tapi cara paling simpel & aman: kalau value berupa angka panjang, paksa jadi string.

        if (is_numeric($value) && strlen((string)$value) >= 8) {
            $cell->setValueExplicit((string)$value, DataType::TYPE_STRING);
            return true;
        }

        // Selain itu, pakai binding default dari PhpSpreadsheet
        return parent::bindValue($cell, $value);
    }

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

                if (!isset($row[$header]) || trim((string)$row[$header]) == '') {

                    throw ValidationException::withMessages([
                        'file' => "Baris ".($index+2)." : Kolom '{$header}' wajib diisi."
                    ]);

                }

            }

            // ============================
            // NORMALISASI NIP (JAGA-JAGA JIKA MASIH SCIENTIFIC NOTATION)
            // ============================

            $nipRaw = trim((string)$row['nip']);

            // Jika masih lolos dalam bentuk notasi ilmiah (misal: 9.970428202321E+19)
            if (preg_match('/^\d+(\.\d+)?E\+\d+$/i', $nipRaw)) {

                throw ValidationException::withMessages([
                    'file' => "Baris ".($index+2)." : NIP '{$nipRaw}' terbaca dalam format notasi ilmiah dan datanya tidak akurat. ".
                              "Silakan format ulang kolom NIP di Excel sebagai 'Text' sebelum mengetik ulang NIP, lalu upload kembali."
                ]);

            }

            $nip = $nipRaw;

            // ============================
            // VALIDASI FORMAT NIP (HARUS 18 DIGIT ANGKA)
            // ============================

            if (!ctype_digit($nip)) {

                throw ValidationException::withMessages([
                    'file' => "Baris ".($index+2)." : NIP '{$nip}' harus berupa angka."
                ]);

            }

            if (strlen($nip) !== 18) {

                throw ValidationException::withMessages([
                    'file' => "Baris ".($index+2)." : NIP '{$nip}' harus terdiri dari 18 digit angka."
                ]);

            }

            // ============================
            // VALIDASI DUPLIKAT NIP
            // ============================

            if (User::where('nip', $nip)->exists()) {

                throw ValidationException::withMessages([
                    'file' => "NIP {$nip} sudah terdaftar."
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
                    'file' => "Jenis Kelamin pada NIP {$nip} harus L atau P."
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

                'nip' => $nip,
                'name' => trim($row['nama']),
                'password' => Hash::make($nip),
                'role_id' => 2,
                'is_first_login' => true,

            ]);

            // ============================
            // CREATE PEGAWAI
            // ============================

            TenagaKependidikan::create([

                'user_id' => $user->id,
                'nip' => $nip,
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