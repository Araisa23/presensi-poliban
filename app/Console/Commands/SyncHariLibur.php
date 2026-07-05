<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HariLibur;
use Illuminate\Support\Facades\Http;

class SyncHariLibur extends Command
{
    protected $signature = 'hari-libur:sync {year?}';

    protected $description = 'Sinkronisasi hari libur nasional Indonesia menggunakan API (otomatis)';

    public function handle()
    {
        $year = $this->argument('year') ?? now()->year;

        $this->info("Mengambil hari libur nasional Indonesia untuk tahun {$year}...");

        try {
            // Gunakan API Nager.at (gratis dan reliable)
            $response = Http::timeout(30)->get("https://date.nager.at/Api/v3/PublicHolidays/{$year}/ID");

            if (!$response->successful()) {
                $this->error("Gagal mengambil data dari API. Status: " . $response->status());
                $this->error("Pastikan koneksi internet aktif.");
                return 1;
            }

            $data = $response->json();

            if (!is_array($data)) {
                $this->error("Format data API tidak valid.");
                return 1;
            }

            $count = 0;
            foreach ($data as $holiday) {
                HariLibur::updateOrCreate(
                    [
                        'tanggal' => $holiday['date']
                    ],
                    [
                        'keterangan' => $holiday['name'] ?? $holiday['localName'] ?? 'Hari Libur',
                        'is_nasional' => true,
                    ]
                );
                $count++;
            }

            $this->info("Berhasil menyinkronkan {$count} hari libur nasional untuk tahun {$year}.");
            $this->info('Hari kerja: Senin-Jumat (kecuali hari libur nasional).');

        } catch (\Exception $e) {
            $this->error("Gagal menyinkronkan hari libur: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}