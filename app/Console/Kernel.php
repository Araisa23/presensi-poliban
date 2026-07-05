<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan setiap hari untuk memperbarui rekap bulanan
        $schedule->command('rekap:presensi')->daily();

        // Sync hari libur nasional otomatis setiap tanggal 1 Januari untuk tahun berjalan
        $schedule->command('hari-libur:sync')->yearly()->at('00:00');

        // Sync hari libur untuk tahun depan setiap tanggal 1 Desember
        $schedule->command('hari-libur:sync ' . (now()->year + 1))->yearly()->month(12)->day(1)->at('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
