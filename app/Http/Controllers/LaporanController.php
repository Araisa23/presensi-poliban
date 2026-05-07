<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\RekapPresensi;
use App\Models\User;
use App\Models\TenagaKependidikan;
use App\Services\PresensiService;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    protected $presensiService;

    public function __construct(PresensiService $presensiService)
    {
        $this->presensiService = $presensiService;
    }

    public function monitoring(Request $request)
    {
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());
        $presensi = Presensi::with('tenagaKependidikan.unitKerja')
            ->where('tanggal', $tanggal)
            ->get();
            
        return view('presensi.monitoring', compact('presensi', 'tanggal'));
    }

    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());
        $presensi = Presensi::with('tenagaKependidikan.unitKerja')
            ->where('tanggal', $tanggal)
            ->get();

        return view('presensi.laporan', compact('presensi', 'tanggal'));
    }

    public function rekap(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $userId = $request->get('user_id');

        $rekap = $this->calculateRekap($bulan, $tahun, $userId);
        $pegawaiList = TenagaKependidikan::all();

        return view('presensi.rekap', compact('rekap', 'bulan', 'tahun', 'pegawaiList', 'userId'));
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $userId = $request->get('user_id');

        $rekap = $this->calculateRekap($bulan, $tahun, $userId);
        return Excel::download(new PresensiExport($rekap), "rekap_presensi_{$bulan}_{$tahun}.xlsx");
    }

    public function exportPdf(Request $request)
    {
        set_time_limit(300);
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $userId = $request->get('user_id');

        $rekap = $this->calculateRekap($bulan, $tahun, $userId);
        $namaBulan = Carbon::create()->month($bulan)->monthName;

        $pdf = Pdf::loadView('presensi.rekap_pdf', compact('rekap', 'bulan', 'tahun', 'namaBulan'));
        return $pdf->download("rekap_presensi_{$bulan}_{$tahun}.pdf");
    }

    private function calculateRekap($bulan, $tahun, $userId = null)
    {
        $workingDays = $this->presensiService->getWorkingDays($bulan, $tahun);
        $totalWorkingDays = count($workingDays);

        $query = TenagaKependidikan::with(['presensi' => function($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }, 'unitKerja']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $pegawai = $query->get();
        $data = [];

        foreach ($pegawai as $p) {
            $hadir = $p->presensi->count();
            $alfa = $totalWorkingDays - $hadir;

            $data[] = [
                'nip' => $p->nip,
                'nama' => $p->nama,
                'unit' => $p->unitKerja->nama_unit ?? '-',
                'hadir' => $hadir,
                'alfa' => $alfa > 0 ? $alfa : 0,
                'total_hari' => $totalWorkingDays,
            ];
        }

        return $data;
    }
}