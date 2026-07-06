<?php

namespace App\Exports;

use App\Models\Presensi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PresensiHarianExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected ?string $tanggal = null;

    protected ?Collection $presensi = null;

    public function __construct(string|Collection $source)
    {
        if ($source instanceof Collection) {
            $this->presensi = $source;
            return;
        }

        $this->tanggal = $source;
    }

    public function collection()
    {
        if ($this->presensi !== null) {
            return $this->presensi;
        }

        return Presensi::with(['user.tenagaKependidikan'])
            ->whereDate('tanggal', $this->tanggal)
            ->get();
    }

    public function map($p): array
    {
        return [
            (string) ($p->user->tenagaKependidikan->nip ?? '-'),
            $p->user->tenagaKependidikan->nama ?? '-',
            $p->tanggal,
            $p->jam_masuk ?? '-',
            $p->jam_pulang ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama Pegawai',
            'Tanggal',
            'Masuk',
            'Pulang',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
