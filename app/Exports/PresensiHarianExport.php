<?php

namespace App\Exports;

use App\Models\Presensi;
use Illuminate\Support\Collection;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class PresensiHarianExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithCustomValueBinder
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

    public function map($p): array
    {
        return [
            (string) ($p->user->tenagaKependidikan->nip ?? ''),
            $p->user->tenagaKependidikan->nama ?? '-',
            $p->tanggal,
            $p->jam_masuk ?? '-',
            $p->jam_pulang ?? '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() === 'A') {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}