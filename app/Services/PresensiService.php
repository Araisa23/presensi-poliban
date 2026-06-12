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

        return $earth_radius * $c; // dalam meter
    }

    /**
     * Cek apakah tanggal tersebut adalah hari libur (dari tabel HariLibur)
     */
    public function isHoliday($tanggal)
    {
        $libur = HariLibur::whereDate('tanggal', $tanggal)->first();

        if ($libur) {
            return [
                'status'      => true,
                'keterangan'  => $libur->keterangan,
            ];
        }

        return [
            'status'     => false,
            'keterangan' => null,
        ];
    }

    /**
     * Cek apakah tanggal adalah libur nasional dari tabel kalender_akademiks
     */
    public function isNationalHoliday($tanggal)
    {
        $date = Carbon::parse($tanggal);

        $libur = KalenderAkademik::where('jenis', 'nasional')
            ->whereDate('tanggal_mulai', '<=', $date->toDateString())
            ->whereDate('tanggal_selesai', '>=', $date->toDateString())
            ->first();

        return $libur !== null;
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
     * Validasi waktu presensi (Masuk / Pulang)
     */
    public function validateTime(
        $type,
        $currentTime,
        $jamMasuk,
        $jamPulang,
        $batasAwal  = null,
        $batasAkhir = null
    ) {
        $now    = Carbon::parse($currentTime);
        $masuk  = Carbon::parse($jamMasuk);
        $pulang = Carbon::parse($jamPulang);

        if ($type === 'masuk') {
            $windowStart = $batasAwal  ? Carbon::parse($batasAwal)  : $masuk->copy()->subHour();
            $windowEnd   = $batasAkhir ? Carbon::parse($batasAkhir) : $masuk->copy();

            if ($now->lessThan($windowStart)) {
                throw new Exception("Belum waktunya presensi masuk (Mulai: " . $windowStart->format('H:i') . ")");
            }

            if ($now->greaterThan($windowEnd)) {
                throw new Exception("Waktu presensi masuk sudah habis (Batas Akhir: " . $windowEnd->format('H:i') . ")");
            }

            return;
        }

        if ($type === 'pulang') {
            $windowStart = $batasAwal  ? Carbon::parse($batasAwal)  : $pulang->copy();
            $windowEnd   = $batasAkhir ? Carbon::parse($batasAkhir) : $pulang->copy()->addHour();

            if ($now->lessThan($windowStart)) {
                throw new Exception("Belum waktunya presensi pulang (Mulai: " . $windowStart->format('H:i') . ")");
            }

            if ($now->greaterThan($windowEnd)) {
                throw new Exception("Batas waktu presensi pulang sudah habis (Batas Akhir: " . $windowEnd->format('H:i') . ")");
            }
        }
    }

    /**
     * Cek apakah tanggal tersebut adalah hari kerja (Senin-Jumat, bukan hari libur)
     */
    public function isWorkingDay($tanggal)
    {
        $date = Carbon::parse($tanggal);
        $dayOfWeek = $date->dayOfWeek;

        // Skip Sabtu (6) dan Minggu (0)
        if ($dayOfWeek === 0 || $dayOfWeek === 6) {
            return [
                'status' => false,
                'keterangan' => $this->getIndonesianDayName($dayOfWeek)
            ];
        }

        // Cek hari libur
        $checkLibur = $this->isHoliday($tanggal);
        if ($checkLibur['status']) {
            return [
                'status' => false,
                'keterangan' => $checkLibur['keterangan']
            ];
        }

        return [
            'status' => true,
            'keterangan' => null
        ];
    }

    /**
     * Hitung total hari kerja dalam satu bulan.
     * Aturan:
     *   ✅ Hanya Senin–Jumat (isWeekday())
     *   ✅ Exclude libur dari tabel HariLibur
     *   ✅ Exclude libur nasional dari tabel KalenderAkademik (jenis = 'nasional')
     * Hari kerja = Senin-Jumat, kecuali hari libur/tanggal merah.
     */
    public function getWorkingDays($bulan, $tahun)
    {
        $startDate = Carbon::create($tahun, $bulan, 1)->startOfDay();
        $endDate   = $startDate->copy()->endOfMonth();

        // Ambil semua libur nasional di bulan ini sekaligus (efisien, 1 query)
        $liburNasional = KalenderAkademik::where('jenis', 'nasional')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_mulai', [$startDate->toDateString(), $endDate->toDateString()])
                  ->orWhereBetween('tanggal_selesai', [$startDate->toDateString(), $endDate->toDateString()])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('tanggal_mulai', '<=', $startDate->toDateString())
                         ->where('tanggal_selesai', '>=', $endDate->toDateString());
                  });
            })
            ->get();

        // Expand range libur nasional jadi array tanggal individual
        $liburNasionalDates = [];
        foreach ($liburNasional as $libur) {
            $cur = Carbon::parse($libur->tanggal_mulai);
            $end = Carbon::parse($libur->tanggal_selesai ?? $libur->tanggal_mulai);
            while ($cur->lte($end)) {
                $liburNasionalDates[] = $cur->toDateString();
                $cur->addDay();
            }
        }
        $liburNasionalDates = array_unique($liburNasionalDates);

        $workingDaysArr = [];

        while ($startDate->lte($endDate)) {
            $check = $this->isWorkingDay($startDate->toDateString());
            if ($check['status']) {
                $workingDaysArr[] = $startDate->toDateString();
            }

            $workingDaysArr[] = $current->toDateString();
            $current->addDay();
        }

        return $workingDaysArr;
    }
}