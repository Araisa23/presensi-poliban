<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\KalenderAkademik;
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

        // =========================
        // ADMIN
        // =========================
        if ($role === 'admin') {

            $totalPegawai = TenagaKependidikan::count();

            $totalUnit = UnitKerja::count();

            $hadirHariIni = Presensi::whereDate('tanggal', $hariIni)
                ->count();

            $totalAlfa = $totalPegawai - $hadirHariIni;

            $presensiHariIni = Presensi::with([
                    'tenagaKependidikan.unitKerja'
                ])
                ->whereDate('tanggal', $hariIni)
                ->latest()
                ->get();


            $grafikKehadiran = [];
            $labelHari = [];

            for ($i = 6; $i >= 0; $i--) {

                $tanggal = Carbon::now()->subDays($i);

                $labelHari[] = $tanggal->translatedFormat('D');

                $grafikKehadiran[] = Presensi::whereDate(
                    'tanggal',
                    $tanggal
                )
                ->whereNotNull('jam_masuk')
                ->count();
            }
            return view('dashboard.admin', compact(
                'totalPegawai',
                'totalUnit',
                'hadirHariIni',
                'totalAlfa',
                'presensiHariIni',
                'grafikKehadiran',
                'labelHari'
            ));
        }

       // =========================
        // PEGAWAI
        // =========================
        elseif ($role === 'pegawai') {

            $presensiHariIni = Presensi::where('user_id', $user->id)
                ->where('tanggal', $hariIni)
                ->first();

            $pengumumans = Pengumuman::where('status', 1)
                ->whereDate('tanggal', '>=', now())
                ->latest()
                ->get();
                
            $kalenders = KalenderAkademik::whereMonth('tanggal_mulai', now()->month)
                ->whereYear('tanggal_mulai', now()->year)
                ->get();

            return view('dashboard.pegawai', compact(
                'presensiHariIni',
                'pengumumans',
                'kalenders'
            ));
        }

        // =========================
        // PIMPINAN
        // =========================
    elseif ($role === 'pimpinan') {

        $totalPegawai = TenagaKependidikan::count();

        $hadirHariIni = Presensi::whereDate('tanggal', $hariIni)
            ->count();

        $tidakHadir = $totalPegawai - $hadirHariIni;

        $grafikKehadiran = [];
        $labelHari = [];

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = Carbon::now()->subDays($i);

            $labelHari[] = $tanggal->translatedFormat('D');

            $grafikKehadiran[] = Presensi::whereDate(
                'tanggal',
                $tanggal
            )
            ->whereNotNull('jam_masuk')
            ->count();
        }

        return view('dashboard.pimpinan', compact(
            'totalPegawai',
            'hadirHariIni',
            'tidakHadir',
            'grafikKehadiran',
            'labelHari'
        ));
    }

        return abort(403);
    }
}