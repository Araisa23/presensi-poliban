<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PresensiHarianExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        return Presensi::with(['user.tenagaKependidikan', 'foto'])
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