<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresensiRequest;
use App\Models\JadwalKerja;
use App\Models\LokasiKantor;
use App\Models\Presensi;
use App\Services\PresensiService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\PresensiFoto;

class PresensiController extends Controller
{
    protected $presensiService;

    public function __construct(PresensiService $presensiService)
    {
        $this->presensiService = $presensiService;
    }

    public function create()
    {
        $namaHari = $this->presensiService
            ->getIndonesianDayName(Carbon::today()->dayOfWeek);

        $jadwal = JadwalKerja::get()->first(function ($item) use ($namaHari) {

            $hariArray = array_map('trim', explode(',', $item->hari));

            return in_array($namaHari, $hariArray);
        });

        return view('presensi.create', compact('jadwal'));
    }

    public function index()
    {
        $presensi = Presensi::with('user.tenagaKependidikan')
            ->latest()
            ->paginate(10);

        return view('admin.presensi.index', compact('presensi'));
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
            | CEK HARI LIBUR / PENGUMUMAN
            |--------------------------------------------------------------------------
            */

            $checkLibur = $this->presensiService->isHoliday($tanggalHariIni);

            if ($checkLibur['status']) {
                return response()->json([
                    'message' => 'Hari ini libur: ' . $checkLibur['keterangan']
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
                    'message' => $jadwal->is_wfh
                        ? 'Berhasil presensi masuk WFH.'
                        : 'Berhasil presensi masuk.'
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
                'message' => $jadwal->is_wfh
                    ? 'Berhasil presensi pulang WFH.'
                    : 'Berhasil presensi pulang.'
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