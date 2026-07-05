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
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function exportMonitoringPdf(Request $request)
    {
        $tanggal = $request->get(
            'tanggal',
            Carbon::today()->toDateString()
        );

        $presensi = Presensi::with('tenagaKependidikan.unitKerja')
            ->where('tanggal', $tanggal)
            ->get();

        $pdf = Pdf::loadView(
            'presensi.monitoring_pdf',
            compact('presensi', 'tanggal')
        );

        return $pdf->download("monitoring_{$tanggal}.pdf");
    }

    public function index(Request $request)
    {
        $tanggal  = $request->get('tanggal', Carbon::today()->toDateString());
        $presensi = Presensi::with('tenagaKependidikan.unitKerja')
            ->where('tanggal', $tanggal)
            ->get();

        return view('presensi.laporan', compact('presensi', 'tanggal'));
    }

    public function rekap(Request $request)
    {
        $bulan  = $request->query('bulan', Carbon::now()->month);
        $tahun  = $request->query('tahun', Carbon::now()->year);
        $userId = $request->query('user_id');

        $result         = $this->calculateRekap($bulan, $tahun, $userId);
        $rekapAll       = $result['data'];
        $totalHariKerja = $result['total_hari_kerja'];
        $totalPegawai   = count($rekapAll);

        // ===== PAGINATION MANUAL UNTUK ARRAY =====
        $perPage    = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage('page');
        $itemsForCurrentPage = array_slice($rekapAll, ($currentPage - 1) * $perPage, $perPage);

        $rekap = new LengthAwarePaginator(
            $itemsForCurrentPage,
            count($rekapAll),
            $perPage,
            $currentPage,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        $pegawaiList = TenagaKependidikan::whereNotNull('user_id')->get();

        return view('presensi.rekap', compact(
            'rekap',
            'bulan',
            'tahun',
            'pegawaiList',
            'userId',
            'totalHariKerja',
            'totalPegawai'
        ));
    }

    public function exportExcel(Request $request)
    {
        $bulan  = $request->input('bulan', Carbon::now()->month);
        $tahun  = $request->input('tahun', Carbon::now()->year);
        $userId = $request->input('user_id');

        $result = $this->calculateRekap($bulan, $tahun, $userId);

        return Excel::download(
            new PresensiExport($result['data']),
            "rekap_presensi_{$bulan}_{$tahun}.xlsx"
        );
    }

    public function exportPdf(Request $request)
    {
        set_time_limit(300);

        $bulan  = $request->input('bulan', Carbon::now()->month);
        $tahun  = $request->input('tahun', Carbon::now()->year);
        $userId = $request->input('user_id');

        $result    = $this->calculateRekap($bulan, $tahun, $userId);
        $rekap     = $result['data'];
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        $pdf = Pdf::loadView(
            'presensi.rekap_pdf',
            compact('rekap', 'bulan', 'tahun', 'namaBulan')
        );

        return $pdf->download("rekap_presensi_{$bulan}_{$tahun}.pdf");
    }

    /**
     * Hitung rekapitulasi presensi per pegawai.
     *
     * Hari kerja = Senin–Jumat, exclude libur nasional (HariLibur & KalenderAkademik).
     * Alpha      = hari kerja dari tanggal bergabung - jumlah hadir (minimum 0).
     *
     * Perubahan: Alfa hanya dihitung dari tanggal pegawai dibuat/bergabung ke sistem,
     * bukan dari awal bulan. Pegawai baru tidak akan dihitung alfa untuk hari sebelum bergabung.
     *
     * @return array{data: array, total_hari_kerja: int}
     */
    private function calculateRekap($bulan, $tahun, $userId = null): array
    {
        // ✅ Hari kerja sudah benar: Senin-Jumat, exclude libur
        $workingDays      = $this->presensiService->getWorkingDays($bulan, $tahun);
        $totalWorkingDays = count($workingDays);

        $query = TenagaKependidikan::with([
            'presensi' => function ($q) use ($bulan, $tahun, $workingDays) {
                $q->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun)
                  // Hanya hitung presensi yang jatuh di hari kerja valid
                  ->whereIn('tanggal', $workingDays);
            },
            'unitKerja',
        ])
        // Ambil semua pegawai yang punya user_id (bukan hanya yang sudah presensi)
        ->whereNotNull('user_id');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $pegawai = $query->get();
        $data    = [];

        foreach ($pegawai as $p) {
            // Hanya hitung presensi di hari kerja valid (sudah difilter di query)
            $hadir = $p->presensi->count();

            // Hitung hari kerja hanya dari tanggal pegawai dibuat/bergabung
            $tanggalBergabung = Carbon::parse($p->created_at)->toDateString();
            $awalBulan = Carbon::create($tahun, $bulan, 1)->toDateString();
            $akhirBulan = Carbon::create($tahun, $bulan, 1)->endOfMonth()->toDateString();

            // Jika pegawai dibuat setelah awal bulan, gunakan tanggal bergabung
            $tanggalMulaiHitung = $tanggalBergabung > $awalBulan ? $tanggalBergabung : $awalBulan;

            // Filter hari kerja hanya dari tanggal mulai hitung
            $workingDaysPegawai = array_filter($workingDays, function($hari) use ($tanggalMulaiHitung, $akhirBulan) {
                return $hari >= $tanggalMulaiHitung && $hari <= $akhirBulan;
            });

            $totalHariKerjaPegawai = count($workingDaysPegawai);

            // Alfa = hari kerja dari tanggal bergabung - jumlah hadir
            $alfa = max(0, $totalHariKerjaPegawai - $hadir);

            $data[] = [
                'nip'        => $p->nip,
                'nama'       => $p->nama,
                'unit'       => $p->unitKerja->nama_unit ?? '-',
                'hadir'      => $hadir,
                'alfa'       => $alfa,
                'total_hari' => $totalHariKerjaPegawai,
                'user_id'    => $p->user_id,
                'tanggal_bergabung' => $tanggalBergabung,
            ];
        }

        // Urutkan: alpha terbanyak di atas (pegawai yang paling sering absen)
        usort($data, fn($a, $b) => $b['alfa'] <=> $a['alfa']);

        return [
            'data'             => $data,
            'total_hari_kerja' => $totalWorkingDays,
        ];
    }
}