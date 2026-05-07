<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\RekapPresensi as RekapModel;
use App\Services\PresensiService;
use Carbon\Carbon;

class RekapPresensi extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'rekap:presensi';

    /**
     * The console command description.
     */
    protected $description = 'Otomatisasi perhitungan rekap harian (Hadir & Alfa) tiap pegawai.';

    /**
     * Execute the console command.
     */
    public function handle(PresensiService $presensiService)
    {
        $this->info('Memulai kalkulasi rekap presensi...');

        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        $today = Carbon::now()->toDateString();
        
        $workingDaysArr = $presensiService->getWorkingDays($bulan, $tahun);
        
        // Hanya hitung hari kerja yang sudah terlewati (termasuk hari ini)
        $elapsedWorkingDays = array_filter($workingDaysArr, function($date) use ($today) {
            return $date <= $today;
        });
        $totalWorkingDaysSoFar = count($elapsedWorkingDays);

        $pegawaiUsers = User::whereHas('role', function($q) {
            $q->where('name', 'pegawai');
        })->get();

        $bar = $this->output->createProgressBar(count($pegawaiUsers));
        $bar->start();

        foreach ($pegawaiUsers as $user) {
            $hadir = $user->presensi()
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->count();

            $alfa = $totalWorkingDaysSoFar - $hadir;

            RekapModel::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'hadir' => $hadir,
                    'alfa' => $alfa > 0 ? $alfa : 0,
                ]
            );

            $bar->advance();
        }

        $bar->finish();
        $this->newline();
        $this->info("Berhasil memproses " . count($pegawaiUsers) . " pegawai.");
    }
}
