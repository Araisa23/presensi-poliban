<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UnitKerja;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PimpinanManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with([
            'role',
            'tenagaKependidikan.unitKerja'
        ])
        ->whereHas('role', function ($q) {
            $q->where('name', 'pimpinan');
        });

        // SEARCH
        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhereHas('tenagaKependidikan', function ($pegawai) use ($request) {

                        $pegawai->where('nip', 'like', '%' . $request->search . '%')
                                ->orWhere('nama', 'like', '%' . $request->search . '%');

                    });

            });

        }

        // FILTER UNIT KERJA
        if ($request->unit_kerja) {

            $query->whereHas('tenagaKependidikan', function ($pegawai) use ($request) {

                $pegawai->where('unit_kerja_id', $request->unit_kerja);

            });

        }

        $pimpinan = $query->latest()->paginate(10);

        $unitKerja = UnitKerja::all();

        return view('admin.pimpinan.index', compact(
            'pimpinan',
            'unitKerja'
        ));
    }
}