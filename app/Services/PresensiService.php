<?php

namespace App\Services;

use App\Models\HariLibur;
use App\Models\KalenderAkademik;
use Carbon\Carbon;
use Exception;

class PresensiService
{
    /**
     * Hitung jarak dua titik dengan Haversine Formula (dalam meter)
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth_radius * $c;
    }

    /**
     * Cek apakah tanggal tersebut adalah hari libur (dari tabel HariLibur lama)
     */
    public function isHoliday($tanggal)
    {
        $libur = HariLibur::whereDate('tanggal', $tanggal)->first();

        if ($libur) {
            return [
                'status'     => true,
                'keterangan' => $libur->keterangan,
            ];
        }

        return [
            'status'     => false,
            'keterangan' => null,
        ];
    }

    /**
     * Cek apakah tanggal adalah hari libur dari KalenderAkademik.
     *
     * FIX: Gunakan is_libur = true, BUKAN jenis = 'nasional'
     * Karena event akademik seperti Dies Natalis atau Minggu UAS
     * bukan hari libur pegawai tetap wajib presensi.
     */
    public function isKalenderLibur($tanggal)
    {
        $date = Carbon::parse($tanggal)->toDateString();

        $libur = KalenderAkademik::where('is_libur', true)
            ->whereDate('tanggal_mulai', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereDate('tanggal_selesai', '>=', $date)
                  ->orWhere(function ($q2) use ($date) {
                      $q2->whereNull('tanggal_selesai')
                         ->whereDate('tanggal_mulai', $date);
                  });
            })
            ->first();

        return [
            'status'     => $libur !== null,
            'keterangan' => $libur?->judul ?? null,
        ];
    }

    /**
     * @deprecated Gunakan isKalenderLibur()
     */
    public function isNationalHoliday($tanggal)
    {
        return $this->isKalenderLibur($tanggal)['status'];
    }

    public function getIndonesianDayName($dayOfWeek)
    {
        $days = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        return $days[$dayOfWeek];
    }

    /**
     * Validasi waktu presensi (Masuk / Pulang).
     * $timezone: IANA timezone identifier milik LokasiKantor terkait
     * (contoh: 'Asia/Makassar', 'Asia/Jakarta', 'Asia/Jayapura').
     */
    public function validateTime(
        $type,
        $currentTime,
        $jamMasuk,
        $jamPulang,
        $batasAwal  = null,
        $batasAkhir = null,
        $timezone   = 'Asia/Makassar'
    ) {
        $now    = Carbon::parse($currentTime, $timezone);
        $masuk  = Carbon::parse($jamMasuk, $timezone);
        $pulang = Carbon::parse($jamPulang, $timezone);

        if ($type === 'masuk') {
            $windowStart = $batasAwal  ? Carbon::parse($batasAwal, $timezone)  : $masuk->copy()->subHour();
            $windowEnd   = $batasAkhir ? Carbon::parse($batasAkhir, $timezone) : $masuk->copy();

            if ($now->lessThan($windowStart)) {
                throw new Exception("Belum waktunya presensi masuk (Mulai: " . $windowStart->format('H:i') . " " . $timezone . ")");
            }

            if ($now->greaterThan($windowEnd)) {
                throw new Exception("Waktu presensi masuk sudah habis (Batas Akhir: " . $windowEnd->format('H:i') . " " . $timezone . ")");
            }

            return;
        }

        if ($type === 'pulang') {
            $windowStart = $batasAwal  ? Carbon::parse($batasAwal, $timezone)  : $pulang->copy();
            $windowEnd   = $batasAkhir ? Carbon::parse($batasAkhir, $timezone) : $pulang->copy()->addHour();

            if ($now->lessThan($windowStart)) {
                throw new Exception("Belum waktunya presensi pulang (Mulai: " . $windowStart->format('H:i') . " " . $timezone . ")");
            }

            if ($now->greaterThan($windowEnd)) {
                throw new Exception("Batas waktu presensi pulang sudah habis (Batas Akhir: " . $windowEnd->format('H:i') . " " . $timezone . ")");
            }
        }
    }

    /**
     * Ambil tanggal & waktu sekarang berdasarkan timezone lokasi tertentu.
     * Dipakai supaya presensi valid sesuai zona waktu setempat lokasi kantor,
     * bukan timezone server.
     */
    public function getCurrentDateTimeForTimezone($timezone = 'Asia/Makassar')
    {
        $now = Carbon::now($timezone);

        return [
            'tanggal' => $now->toDateString(),
            'waktu'   => $now->toTimeString(),
        ];
    }

    /**
     * Cek apakah tanggal tersebut adalah hari kerja.
     *
     * Hari kerja = Senin-Jumat, BUKAN hari libur.
     * Libur = HariLibur ATAU KalenderAkademik dengan is_libur = true
     * Event akademik (is_libur = false) TIDAK dihitung libur.
     */
    public function isWorkingDay($tanggal)
    {
        $date = Carbon::parse($tanggal);

        // Weekend bukan hari kerja
        if ($date->isWeekend()) {
            return [
                'status'     => false,
                'keterangan' => $this->getIndonesianDayName($date->dayOfWeek),
            ];
        }

        // Cek HariLibur (tabel lama)
        $hariLibur = $this->isHoliday($tanggal);
        if ($hariLibur['status']) {
            return [
                'status'     => false,
                'keterangan' => $hariLibur['keterangan'],
            ];
        }

        // FIX: Cek KalenderAkademik dengan is_libur = true saja
        $kalenderLibur = $this->isKalenderLibur($tanggal);
        if ($kalenderLibur['status']) {
            return [
                'status'     => false,
                'keterangan' => $kalenderLibur['keterangan'],
            ];
        }

        return [
            'status'     => true,
            'keterangan' => null,
        ];
    }

    /**
     * Hitung total hari kerja dalam satu bulan.
     * - Hanya Senin-Jumat
     * - Exclude HariLibur
     * - Exclude KalenderAkademik dengan is_libur = true
     * - Event akademik (is_libur = false) TIDAK dikecualikan
     */
    public function getWorkingDays($bulan, $tahun)
    {
        $startDate = Carbon::create($tahun, $bulan, 1)->startOfDay();
        $endDate   = $startDate->copy()->endOfMonth();

        $workingDaysArr = [];
        $current        = $startDate->copy();

        while ($current->lte($endDate)) {
            $check = $this->isWorkingDay($current->toDateString());

            if ($check['status']) {
                $workingDaysArr[] = $current->toDateString();
            }

            $current->addDay();
        }

        return $workingDaysArr;
    }

    /**
     * Cek apakah akurasi GPS terlalu buruk (indikasi lokasi tidak stabil/dipalsukan).
     * Semakin kecil angka accuracy = semakin presisi (dalam meter).
     */
    public function isAccuracyTooLow($accuracy, $thresholdMeter = 50)
    {
        if ($accuracy === null) {
            return false; // tidak ada data, jangan asumsikan curiga
        }

        return (float) $accuracy > $thresholdMeter;
    }

    /**
     * Cek apakah koordinat presensi user beberapa hari terakhir
     * selalu identik persis (indikasi fake GPS dengan titik statis).
     */
    public function isStaticCoordinateSuspicious($tenagaKependidikanId, $lat, $lon, $minSampleSamaCount = 5, $checkLastN = 10)
    {
        $riwayat = \App\Models\Presensi::where('tenaga_kependidikan_id', $tenagaKependidikanId)
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->orderByDesc('tanggal')
            ->limit($checkLastN)
            ->get(['lat', 'lng']);

        if ($riwayat->count() < $minSampleSamaCount) {
            return false; // data belum cukup untuk disimpulkan
        }

        $samaPersisCount = 0;

        foreach ($riwayat as $item) {
            $sama = abs((float) $item->lat - (float) $lat) < 0.000001
                 && abs((float) $item->lng - (float) $lon) < 0.000001;

            if ($sama) {
                $samaPersisCount++;
            }
        }

        return $samaPersisCount >= $minSampleSamaCount;
    }

    /**
     * Cek lompatan lokasi yang mustahil secara fisik (kecepatan > threshold km/jam)
     * dibanding presensi terakhir milik pegawai yang sama.
     */
    public function isSuspiciousJump($tenagaKependidikanId, $newLat, $newLon, $newDateTime, $maxSpeedKmh = 150)
    {
        $last = \App\Models\Presensi::where('tenaga_kependidikan_id', $tenagaKependidikanId)
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->orderByDesc('tanggal')
            ->first();

        if (!$last || !$last->lat || !$last->lng) {
            return false;
        }

        $lastDateTime = Carbon::parse(Carbon::parse($last->tanggal)->format('Y-m-d') . ' ' . ($last->jam_pulang ?? $last->jam_masuk));
        $newDateTimeCarbon = Carbon::parse($newDateTime);

        $detikBerlalu = abs($newDateTimeCarbon->diffInSeconds($lastDateTime));

        if ($detikBerlalu <= 0) {
            return false;
        }

        $jarakMeter = $this->calculateDistance(
            (float) $last->lat,
            (float) $last->lng,
            (float) $newLat,
            (float) $newLon
        );

        $kecepatanKmh = ($jarakMeter / $detikBerlalu) * 3.6;

        return $kecepatanKmh > $maxSpeedKmh;
    }

    /**
     * Kumpulkan semua pengecekan kecurigaan GPS jadi satu hasil ringkas.
     * Tidak menolak presensi, hanya menandai untuk direview admin.
     */
    public function evaluateGpsSuspicion($tenagaKependidikanId, $lat, $lon, $accuracy, $dateTime)
    {
        $alasan = [];

        if ($this->isAccuracyTooLow($accuracy)) {
            $alasan[] = "Akurasi GPS buruk ({$accuracy}m)";
        }

        if ($this->isStaticCoordinateSuspicious($tenagaKependidikanId, $lat, $lon)) {
            $alasan[] = "Koordinat identik berulang kali";
        }

        if ($this->isSuspiciousJump($tenagaKependidikanId, $lat, $lon, $dateTime)) {
            $alasan[] = "Lompatan lokasi tidak wajar dibanding presensi sebelumnya";
        }

        return [
            'is_suspicious' => count($alasan) > 0,
            'reason'        => implode('; ', $alasan) ?: null,
        ];
    }
}