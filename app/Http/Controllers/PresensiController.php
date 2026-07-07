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
        $query = Presensi::with(['user.tenagaKependidikan', 'foto']);

        // Default tanggal hari ini jika tidak ada filter
        if ($request->filled('tanggal')) {

            $query->whereDate('tanggal', $request->tanggal);

            $bulan = now()->month;
            $tahun = now()->year;

        } else {

            $bulan = $request->input('bulan', now()->month);
            $tahun = $request->input('tahun', now()->year);

            $query->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $presensi = $query->latest()->paginate(10);

        $pegawaiList = TenagaKependidikan::with('unitKerja')->get();

        return view('admin.presensi.index', compact(
            'presensi',
            'pegawaiList',
            'bulan',
            'tahun'
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

    public function rekap(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);
        $userId = $request->input('user_id');

        $result = $this->calculateRekap($bulan, $tahun, $userId);

        $pegawaiList = TenagaKependidikan::whereNotNull('user_id')
            ->with('unitKerja')
            ->get();

        return view('admin.presensi.rekap', [
            'rekap'          => $result['data'],
            'bulan'          => $bulan,
            'tahun'          => $tahun,
            'userId'         => $userId,
            'pegawaiList'    => $pegawaiList,
            'totalHariKerja' => $result['total_hari_kerja'],
            'totalPegawai'   => count($result['data']),
        ]);
    }

    public function exportExcel(Request $request)
    {
        if ($this->isRekapExport($request)) {
            $bulan  = (int) $request->input('bulan', Carbon::now()->month);
            $tahun  = (int) $request->input('tahun', Carbon::now()->year);
            $userId = $request->input('user_id');

            $result = $this->calculateRekap($bulan, $tahun, $userId);

            return Excel::download(
                new PresensiExport($result['data']),
                "rekap_presensi_{$bulan}_{$tahun}.xlsx"
            );
        }

        $presensi = $this->buildPresensiExportQuery($request)->get();
        $filename = $this->buildPresensiExportFilename($request, 'xlsx');

        return Excel::download(
            new PresensiHarianExport($presensi),
            $filename
        );
    }

    public function exportPdf(Request $request)
    {
        if ($this->isRekapExport($request)) {
            set_time_limit(300);

            $bulan  = (int) $request->input('bulan', Carbon::now()->month);
            $tahun  = (int) $request->input('tahun', Carbon::now()->year);
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

        $presensi = $this->buildPresensiExportQuery($request)->get();
        $meta     = $this->buildPresensiExportMeta($request);

        $pdf = Pdf::loadView(
            'admin.presensi.presensi_pdf',
            [
                'presensi' => $presensi,
                'tanggal'  => $meta['tanggal'],
                'periode'  => $meta['periode'],
            ]
        );

        return $pdf->download($this->buildPresensiExportFilename($request, 'pdf'));
    }

    private function isRekapExport(Request $request): bool
    {
        return $request->get('export') === 'rekap';
    }

    private function buildPresensiExportQuery(Request $request)
    {
        $query = Presensi::with(['user.tenagaKependidikan'])->latest();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } elseif ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun)
                  ->whereMonth('tanggal', $request->bulan);
        } else {
            $query->whereDate('tanggal', now()->toDateString());
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return $query;
    }

    private function buildPresensiExportMeta(Request $request): array
    {
        if ($request->filled('tanggal')) {
            $tanggal = $request->tanggal;

            return [
                'tanggal' => $tanggal,
                'periode' => Carbon::parse($tanggal)->translatedFormat('d F Y'),
            ];
        }

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $bulan = (int) $request->bulan;
            $tahun = (int) $request->tahun;

            return [
                'tanggal' => Carbon::create($tahun, $bulan, 1)->toDateString(),
                'periode' => Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y'),
            ];
        }

        $tanggal = now()->toDateString();

        return [
            'tanggal' => $tanggal,
            'periode' => Carbon::parse($tanggal)->translatedFormat('d F Y'),
        ];
    }

    private function buildPresensiExportFilename(Request $request, string $extension): string
    {
        if ($request->filled('tanggal')) {
            return "presensi_{$request->tanggal}.{$extension}";
        }

        if ($request->filled('bulan') && $request->filled('tahun')) {
            return "presensi_{$request->bulan}_{$request->tahun}.{$extension}";
        }

        return 'presensi_' . now()->toDateString() . ".{$extension}";
    }

    private function calculateRekap(int $bulan, int $tahun, $userId = null): array
    {
        $workingDays      = $this->presensiService->getWorkingDays($bulan, $tahun);
        $totalWorkingDays = count($workingDays);

        $query = TenagaKependidikan::with([
            'presensi' => function ($q) use ($bulan, $tahun, $workingDays) {
                $q->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun)
                  ->whereIn('tanggal', $workingDays);
            },
            'unitKerja',
        ])->whereNotNull('user_id');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $pegawai = $query->get();
        $data    = [];

        foreach ($pegawai as $p) {
            $hadir = $p->presensi->count();
            $tanggalBergabung = Carbon::parse($p->created_at)->toDateString();
            $awalBulan = Carbon::create($tahun, $bulan, 1)->toDateString();
            $akhirBulan = Carbon::create($tahun, $bulan, 1)->endOfMonth()->toDateString();
            $tanggalMulaiHitung = $tanggalBergabung > $awalBulan ? $tanggalBergabung : $awalBulan;

            $workingDaysPegawai = array_filter($workingDays, function ($hari) use ($tanggalMulaiHitung, $akhirBulan) {
                return $hari >= $tanggalMulaiHitung && $hari <= $akhirBulan;
            });

            $totalHariKerjaPegawai = count($workingDaysPegawai);
            $alfa = max(0, $totalHariKerjaPegawai - $hadir);

            $data[] = [
                'nip'        => $p->nip,
                'nama'       => $p->nama,
                'unit_kerja' => $p->unitKerja->nama_unit ?? '-',
                'hadir'      => $hadir,
                'alfa'       => $alfa,
                'total_hari' => $totalHariKerjaPegawai,
            ];
        }

        usort($data, fn ($a, $b) => $b['alfa'] <=> $a['alfa']);

        return [
            'data'             => $data,
            'total_hari_kerja' => $totalWorkingDays,
        ];
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

            if (!$jadwal) {
                return response()->json([
                    'message' => 'Jadwal kerja belum diatur admin.'
                ], 400);
            }

            if ($jadwal->use_location && !$lokasi) {
                return response()->json([
                    'message' => 'Lokasi kantor belum diatur admin.'
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | VALIDASI LOKASI
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