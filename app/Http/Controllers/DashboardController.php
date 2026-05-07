<?php

namespace App\Http\Controllers;

use App\Models\TenagaKependidikan;
use App\Models\UnitKerja;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->name ?? '';
        $hariIni = Carbon::today()->toDateString();

        if ($role === 'admin') {
            $totalPegawai = TenagaKependidikan::count();
            $totalUnit = UnitKerja::count();
            $hadirHariIni = Presensi::where('tanggal', $hariIni)->count();
            
            return view('dashboard.admin', compact('totalPegawai', 'totalUnit', 'hadirHariIni'));
        } elseif ($role === 'pegawai') {
            $presensiHariIni = Presensi::where('user_id', $user->id)
                ->where('tanggal', $hariIni)
                ->first();

            return view('dashboard.pegawai', compact('presensiHariIni'));
        } elseif ($role === 'pimpinan') {
            $totalPegawai = TenagaKependidikan::count();
            $hadirHariIni = Presensi::where('tanggal', $hariIni)->count();
            $tidakHadir = $totalPegawai - $hadirHariIni;

            return view('dashboard.pimpinan', compact('totalPegawai', 'hadirHariIni', 'tidakHadir'));
        }

        return abort(403);
    }
}