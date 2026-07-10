<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePresensiRequest;
use App\Models\JadwalKerja;
use App\Models\LokasiKantor;
use App\Models\Presensi;
use App\Models\TenagaKependidikan;
use App\Services\PresensiService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\PresensiFoto;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresensiHarianExport;
use App\Exports\PresensiExport;

class PresensiController extends Controller
{
    protected $presensiService;

    public function __construct(PresensiService $presensiService)
    {
        $this->presensiService = $presensiService;
    }

    public function create()
    {
        $tanggalHariIni = Carbon::today()->toDateString();

        // Cek apakah hari ini adalah hari kerja
        $checkWorkingDay = $this->presensiService->isWorkingDay($tanggalHariIni);

        if (!$checkWorkingDay['status']) {
            return redirect()->back()->with(
                'error',
                'Hari ini bukan hari kerja: ' . $checkWorkingDay['keterangan']
            );
        }

        $namaHari = $this->presensiService
            ->getIndonesianDayName(Carbon::today()->dayOfWeek);

        $jadwal = JadwalKerja::get()->first(function ($item) use ($namaHari) {

            $hariArray = array_map('trim', explode(',', $item->hari));

            return in_array($namaHari, $hariArray);
        });

        return view('presensi.create', compact('jadwal'));
    }

public function index(Request $request)
{
    // Default: bulan & tahun berjalan
    $bulan = $request->bulan ?? now()->month;
    $tahun = $request->tahun ?? now()->year;

    $query = Presensi::with([
        'user.tenagaKependidikan',
        'foto'
    ])
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun);

    // Filter pegawai tertentu (jika dipilih)
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    $presensi = $query->latest()->paginate(10)->withQueryString();

    // Untuk dropdown filter pegawai
    $pegawaiList = TenagaKependidikan::select('user_id', 'nama')
        ->orderBy('nama')
        ->get();

    return view('admin.presensi.index', compact(
        'presensi',
        'bulan',
        'tahun',
        'pegawaiList'
    ));
}

    public function history()
    {
        $user = auth()->user();

        $presensi = Presensi::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('presensi.history', compact('presensi'));
    }

    public function show($id)
    {
        $presensi = Presensi::with([
            'user.tenagaKependidikan',
            'foto'
        ])->findOrFail($id);

        return view('admin.presensi.show', compact('presensi'));
    }

    /**
     * Halaman Rekapitulasi Presensi Bulanan.
     *
     * NOTE (asumsi model, sesuaikan jika beda di project kamu):
     * - Model TenagaKependidikan punya kolom: nip, nama, user_id, unit_kerja_id
     * - Ada relasi TenagaKependidikan::unitKerja() ke model UnitKerja (kolom: nama)
     */
    public function rekap(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Untuk dropdown filter pegawai
        $pegawaiList = TenagaKependidikan::select('user_id', 'nama')
            ->orderBy('nama')
            ->get();

        $namaBulan = Carbon::create($tahun, $bulan, 1)
            ->translatedFormat('F');

        $rekap = $this->buildRekapData($bulan, $tahun, $request->user_id);

        $totalPegawai = count($rekap);

        return view('admin.presensi.rekap', compact(
            'rekap',
            'bulan',
            'tahun',
            'namaBulan',
            'totalPegawai',
            'pegawaiList'
        ));
    }

    public function exportExcel(Request $request)
    {
        // Mode rekap bulanan
        if ($request->export === 'rekap') {

            $bulan = $request->bulan ?? now()->month;
            $tahun = $request->tahun ?? now()->year;

            $rekap = $this->buildRekapData($bulan, $tahun, $request->user_id);

            return Excel::download(
                new PresensiExport($rekap),
                "rekap_presensi_{$tahun}-{$bulan}.xlsx"
            );
        }

        // Mode harian (default, per tanggal)
        $tanggal = $request->tanggal ?? now()->toDateString();

        $presensi = Presensi::with(['user.tenagaKependidikan'])
            ->whereDate('tanggal', $tanggal)
            ->when($request->filled('user_id'), function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            })
            ->get();

        return Excel::download(
            new PresensiHarianExport($presensi),
            "presensi_{$tanggal}.xlsx"
        );
    }

    public function exportPdf(Request $request)
    {
        // Mode rekap bulanan
        if ($request->export === 'rekap') {

            $bulan = $request->bulan ?? now()->month;
            $tahun = $request->tahun ?? now()->year;

            $namaBulan = Carbon::create($tahun, $bulan, 1)
                ->translatedFormat('F');

            $rekap = $this->buildRekapData($bulan, $tahun, $request->user_id);

            $pdf = Pdf::loadView(
                'admin.presensi.rekap_pdf',
                compact('rekap', 'bulan', 'tahun', 'namaBulan')
            );

            return $pdf->download("rekap_presensi_{$tahun}-{$bulan}.pdf");
        }

        // Mode harian (default, per tanggal)
        $tanggal = $request->tanggal ?? now()->toDateString();

        $presensi = Presensi::with([
            'user.tenagaKependidikan',
            'foto'
        ])
            ->whereDate('tanggal', $tanggal)
            ->when($request->filled('user_id'), function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            })
            ->get();

        $pdf = Pdf::loadView(
            'admin.presensi.presensi_pdf',
            compact('presensi', 'tanggal')
        );

        return $pdf->download(
            "presensi_{$tanggal}.pdf"
        );
    }

    /**
     * Hitung data rekap per pegawai untuk satu bulan.
     * Dipakai bareng oleh rekap(), exportExcel(), dan exportPdf().
     */
    private function buildRekapData($bulan, $tahun, $userId = null): array
    {
        $tenagaQuery = TenagaKependidikan::with(['unitKerja']);

        if (!empty($userId)) {
            $tenagaQuery->where('user_id', $userId);
        }

        $tenagaKependidikan = $tenagaQuery->orderBy('nama')->get();

        // Hitung total hari kerja dalam bulan tsb berdasarkan JadwalKerja
        $totalHariKerja = 0;
        $startDate = Carbon::create($tahun, $bulan, 1);
        $endDate   = $startDate->copy()->endOfMonth();

        for ($tgl = $startDate->copy(); $tgl->lte($endDate); $tgl->addDay()) {
            $cek = $this->presensiService->isWorkingDay($tgl->toDateString());

            if ($cek['status']) {
                $totalHariKerja++;
            }
        }

        $rekap = [];

        foreach ($tenagaKependidikan as $pegawai) {

            $hadir = Presensi::where('tenaga_kependidikan_id', $pegawai->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->count();

            $alfa = max($totalHariKerja - $hadir, 0);

            $rekap[] = [
                'nama'       => $pegawai->nama,
                'nip'        => $pegawai->nip,
                'unit_kerja' => $pegawai->unitKerja->nama_unit ?? '-',
                'hadir'      => $hadir,
                'alfa'       => $alfa,
                'total_hari' => $totalHariKerja,
            ];
        }

        return $rekap;
    }

    public function store(StorePresensiRequest $request)
    {
        try {

            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $pegawai = $user->tenagaKependidikan;

            if (!$pegawai) {
                return response()->json([
                    'message' => 'User belum punya data pegawai.'
                ], 400);
            }

            $tanggalHariIni = Carbon::today()->toDateString();
            $waktuSekarang  = Carbon::now()->toTimeString();

            /*
            |--------------------------------------------------------------------------
            | CEK HARI KERJA (Senin-Jumat, bukan hari libur)
            |--------------------------------------------------------------------------
            */

            $checkWorkingDay = $this->presensiService->isWorkingDay($tanggalHariIni);

            if (!$checkWorkingDay['status']) {
                return response()->json([
                    'message' => 'Hari ini bukan hari kerja: ' . $checkWorkingDay['keterangan']
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | AMBIL JADWAL
            |--------------------------------------------------------------------------
            */

            $namaHari = $this->presensiService
                ->getIndonesianDayName(Carbon::today()->dayOfWeek);

            $jadwal = JadwalKerja::get()->first(function ($item) use ($namaHari) {

                $hariArray = array_map('trim', explode(',', $item->hari));

                return in_array($namaHari, $hariArray);
            });

            $lokasi = LokasiKantor::first();

            if (!$jadwal || !$lokasi) {
                return response()->json([
                    'message' => 'Jadwal kerja atau lokasi kantor belum diatur admin.'
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | VALIDASI LOKASI (selain Jumat)
            |--------------------------------------------------------------------------
            */

            if ($jadwal->use_location) {

                $jarak = $this->presensiService->calculateDistance(
                    (float) $lokasi->latitude,
                    (float) $lokasi->longitude,
                    (float) $request->latitude,
                    (float) $request->longitude
                );

                $batasRadius = $lokasi->radius ?? 200;

                if ($jarak > $batasRadius) {
                    return response()->json([
                        'message' => 'Anda berada di luar jangkauan area presensi.',
                        'jarak_meter' => round($jarak)
                    ], 400);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | CEK PRESENSI HARI INI
            |--------------------------------------------------------------------------
            */

            $presensiHariIni = Presensi::where(
                    'tenaga_kependidikan_id',
                    $pegawai->id
                )
                ->where('tanggal', $tanggalHariIni)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | PRESENSI MASUK
            |--------------------------------------------------------------------------
            */

            if (!$presensiHariIni) {

                $this->presensiService->validateTime(
                    'masuk',
                    $waktuSekarang,
                    $jadwal->jam_masuk,
                    $jadwal->jam_pulang,
                    $jadwal->batas_awal_masuk,
                    $jadwal->batas_akhir_masuk
                );

                if ($jadwal->use_camera && !$request->foto) {
                    return response()->json([
                        'message' => 'Selfie wajib dilakukan sebelum presensi.'
                    ], 400);
                }

                // Verifikasi liveness (kedipan mata) untuk presensi masuk
                if ($jadwal->use_camera && (int) $request->is_live !== 1) {
                    return response()->json([
                        'message' => 'Verifikasi liveness (kedipan mata) gagal. Silakan ulangi.'
                    ], 400);
                }

                $presensi = Presensi::create([
                    'user_id'                 => $user->id,
                    'tenaga_kependidikan_id' => $pegawai->id,
                    'tanggal'                => $tanggalHariIni,
                    'jam_masuk'              => $waktuSekarang,
                    'lat'                    => $request->latitude,
                    'lng'                    => $request->longitude,
                ]);

                /*
                |--------------------------------------------------------------------------
                | SAVE FOTO (selain Jumat)
                |--------------------------------------------------------------------------
                */

                if ($jadwal->use_camera && $request->foto) {
                    $this->saveFoto($presensi->id, $request->foto);
                }

                return response()->json([
                    'message' => 'Presensi masuk telah berhasil.',
                    'type'    => 'masuk',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | SUDAH PRESENSI PULANG
            |--------------------------------------------------------------------------
            */

            if ($presensiHariIni->jam_pulang) {
                return response()->json([
                    'message' => 'Anda sudah melakukan presensi pulang hari ini.'
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | PRESENSI PULANG
            |--------------------------------------------------------------------------
            */

            $this->presensiService->validateTime(
                'pulang',
                $waktuSekarang,
                $jadwal->jam_masuk,
                $jadwal->jam_pulang,
                $jadwal->batas_awal_pulang,
                $jadwal->batas_akhir_pulang
            );

            if ($jadwal->use_camera && !$request->foto) {

                return response()->json([
                    'message' => 'Selfie wajib dilakukan sebelum presensi pulang.'
                ], 400);
            }

            // Verifikasi liveness (kedipan mata) untuk presensi pulang
            if ($jadwal->use_camera && (int) $request->is_live !== 1) {
                return response()->json([
                    'message' => 'Verifikasi liveness (kedipan mata) gagal. Silakan ulangi.'
                ], 400);
            }

            $presensiHariIni->update([
                'jam_pulang' => $waktuSekarang,
                'lat'        => $request->latitude,
                'lng'        => $request->longitude,
            ]);

            /*
            |--------------------------------------------------------------------------
            | SAVE FOTO PULANG
            |--------------------------------------------------------------------------
            */

            if ($jadwal->use_camera && $request->foto) {
                $this->saveFoto($presensiHariIni->id, $request->foto);
            }

            return response()->json([
                'message' => 'Presensi pulang telah berhasil.',
                'type'    => 'pulang',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(Presensi $presensi)
    {
        try {

            foreach ($presensi->foto as $pFoto) {

                if (Storage::disk('public')->exists('presensi/' . $pFoto->foto)) {

                    Storage::disk('public')->delete(
                        'presensi/' . $pFoto->foto
                    );
                }
            }

            $presensi->delete();

            return redirect()
                ->back()
                ->with('success', 'Data presensi berhasil dihapus.');

        } catch (Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    private function saveFoto($presensiId, $base64Image)
    {
        $image = str_replace(
            ['data:image/png;base64,', 'data:image/jpeg;base64,'],
            '',
            $base64Image
        );

        $image = str_replace(' ', '+', $image);

        $imageName = 'presensi_' . $presensiId . '_' . time() . '.png';

        Storage::disk('public')->put(
            'presensi/' . $imageName,
            base64_decode($image)
        );

        PresensiFoto::create([
            'presensi_id' => $presensiId,
            'foto'        => $imageName,
        ]);
    }
}