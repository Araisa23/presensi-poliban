<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HariLibur;

class SyncHariLibur extends Command
{
    protected $signature = 'hari-libur:sync';

    protected $description = 'Sinkronisasi hari libur nasional Indonesia';

    public function handle()
    {
        $year = now()->year;

        $path = storage_path("app/holidays/{$year}.json");

        if (!file_exists($path)) {

            $this->error("File holidays {$year}.json tidak ditemukan.");

            return;
        }

        $json = file_get_contents($path);

        $holidays = json_decode($json, true);

        foreach ($holidays as $holiday) {

            HariLibur::updateOrCreate(
                [
                    'tanggal' => $holiday['tanggal']
                ],
                [
                    'keterangan' => $holiday['keterangan'],
                    'is_nasional' => true,
                ]
            );
        }

        $this->info('Hari libur nasional berhasil disinkronkan.');
    }
}