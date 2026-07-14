<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserDeviceController extends Controller
{
    public function resetDevice(User $user)
    {
        $user->update([
            'device_id'            => null,
            'device_registered_at' => null,
        ]);

        return redirect()->back()->with(
            'success',
            "Device untuk {$user->name} berhasil direset. Pegawai bisa presensi dari device baru."
        );
    }
}