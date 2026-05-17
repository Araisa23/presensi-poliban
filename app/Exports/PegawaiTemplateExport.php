<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class PegawaiTemplateExport implements FromArray
{
    public function array(): array
    {
        return [
            [
                'NIP',
                'Nama',
                'Jenis Kelamin',
                'Pangkat',
                'Unit Kerja',
            ],
        ];
    }
}