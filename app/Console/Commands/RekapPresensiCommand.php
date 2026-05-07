<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RekapPresensiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:rekap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rekapitulasi ketidakhadiran dan rekap bulanan (Alfa)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = \Carbon\Carbon::now()->toDateString();
        $month = \Carbon\Carbon::now()->month;
        $year = \Carbon\Carbon::now()->year;

        $pegawais = \App\Models\TenagaKependidikan::all();

        foreach ($pegawais as $pegawai) {
            $user_id = $pegawai->user_id;

            $hasPresensi = \App\Models\Presensi::where('user_id', $user_id)
                ->where('tanggal', $today)->exists();

            if (!$hasPresensi) {
                // Tandai alfa
                \App\Models\Presensi::create([
                    'user_id' => $user_id,
                    'tanggal' => $today,
                    'status_kehadiran' => 'alfa'
                ]);
            }

            // Update/Create Rekap Bulanan
            $totalHadir = \App\Models\Presensi::where('user_id', $user_id)
                ->whereMonth('tanggal', $month)->whereYear('tanggal', $year)
                ->where('status_kehadiran', 'hadir')->count();

            $totalAlfa = \App\Models\Presensi::where('user_id', $user_id)
                ->whereMonth('tanggal', $month)->whereYear('tanggal', $year)
                ->where('status_kehadiran', 'alfa')->count();

            \App\Models\RekapPresensi::updateOrCreate(
                ['user_id' => $user_id, 'bulan' => $month, 'tahun' => $year],
                ['total_hadir' => $totalHadir, 'total_alfa' => $totalAlfa]
            );
        }

        $this->info('Rekap presensi berhasil dijalankan.');
    }
}
