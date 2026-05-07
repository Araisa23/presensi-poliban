<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UnitKerja;
use App\Models\TenagaKependidikan;
use Illuminate\Database\Seeder;

class KioskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'pegawai@admin.com')->first();
        if (!$user) {
            return;
        }

        $unit = UnitKerja::first() ?? UnitKerja::create(['nama_unit' => 'Unit Testing']);

        echo "Generating 66 dummy employees for account: {$user->email}...\n";

        for ($i = 1; $i <= 66; $i++) {
            $nip = "DUMMY" . str_pad($i, 3, '0', STR_PAD_LEFT);
            $nama = "Pegawai Percobaan " . $i;

            TenagaKependidikan::updateOrCreate(
                ['nip' => $nip],
                [
                    'user_id' => $user->id,
                    'nama' => $nama,
                    'unit_kerja_id' => $unit->id,
                ]
            );
        }

        echo "66 employees generated successfully.\n";
    }
}
