<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PresensiHarianExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $presensi;

    public function __construct($presensi)
    {
        $this->presensi = $presensi;
    }

    public function collection()
    {
        return $this->presensi;
    }

    public function map($p): array
    {
        return [
            (string) ($p->user->tenagaKependidikan->nip ?? '-'),
            $p->user->tenagaKependidikan->nama ?? '-',
            $p->tanggal,
            $p->jam_masuk ?? '-',
            $p->jam_pulang ?? '-',
            $p->foto->count() ?? 0,
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
            'Jumlah Foto',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // NIP biar tidak E+17
        ];
    }
}