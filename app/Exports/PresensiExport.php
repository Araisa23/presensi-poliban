<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PresensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama Pegawai',
            'Unit Kerja',
            'Hadir',
            'Alfa',
            'Total Hari Kerja',
        ];
    }

    public function map($row): array
    {
        return [
            $row['nip'],
            $row['nama'],
            $row['unit_kerja'],
            $row['hadir'],
            $row['alfa'],
            $row['total_hari'],
        ];
    }
}
