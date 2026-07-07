<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function monitoring(Request $request)
    {
        $query = Presensi::with(['user.tenagaKependidikan', 'foto']);

        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $presensi = $query->latest()->paginate(10);

        return view('presensi.monitoring', compact('presensi'));
    }

    public function showPresensi($id)
    {
        $presensi = Presensi::with([
            'user.tenagaKependidikan',
            'foto'
        ])->findOrFail($id);

        return view('presensi.show', compact('presensi'));
    }
}