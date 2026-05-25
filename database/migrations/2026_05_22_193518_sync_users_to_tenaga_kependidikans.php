<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $users = User::with('tenagaKependidikan')->get();

        foreach ($users as $user) {

            if (!$user->tenagaKependidikan) {
                continue;
            }

            $pegawai = $user->tenagaKependidikan;

            $pegawai->update([
                'nip' => $pegawai->nip ?: $user->display_nip,
                'nama' => $pegawai->nama ?: $user->display_name,
                'jenis_kelamin' => $pegawai->jenis_kelamin ?: $user->jenis_kelamin,
                'pangkat' => $pegawai->pangkat ?: $user->pangkat,
                'unit_kerja_id' => $pegawai->unit_kerja_id ?: $user->unit_kerja_id,
            ]);
        }
    }

    public function down(): void
    {
        //
    }
};