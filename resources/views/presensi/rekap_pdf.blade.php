<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Presensi - {{ $namaBulan }} {{ $tahun }}</title>

    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0b2c52;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 4px 0;
            font-size: 14px;
            font-weight: normal;
        }

        .header h3 {
            margin: 10px 0 0;
            font-size: 15px;
            font-weight: bold;
            color: #0b2c52;
        }

        .info {
            width: 100%;
            margin-bottom: 15px;
        }

        .info td {
            padding: 3px 0;
        }

        .summary {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #dbe4f0;
            background: #f8fafc;
        }

        .summary table {
            width: 100%;
        }

        .summary td {
            padding: 2px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #cbd5e1;
            padding: 8px;
        }

        .table th {
            background: #e8edf5;
            color: #0b2c52;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }

        .table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .alfa {
            color: #dc2626;
            font-weight: bold;
        }

        tfoot th {
            background: #f1f5f9;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .print-info {
            font-size: 9px;
            color: #666;
        }

        .signature {
            width: 250px;
            float: right;
            text-align: center;
        }

        .signature-name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h1>POLITEKNIK NEGERI BANJARMASIN</h1>
        <h2>Sistem Informasi Presensi Tenaga Kependidikan</h2>
        <h3>Laporan Rekapitulasi Presensi Bulanan</h3>
    </div>

    <!-- INFORMASI PERIODE -->
    <table class="info">
        <tr>
            <td width="100">Periode</td>
            <td width="10">:</td>
            <td>
                <strong>{{ $namaBulan }} {{ $tahun }}</strong>
            </td>
        </tr>
    </table>

    <!-- RINGKASAN -->
    <div class="summary">
        <table>
            <tr>
                <td width="200">
                    Total Pegawai
                </td>
                <td>
                    : <strong>{{ count($rekap) }}</strong>
                </td>
            </tr>

            <tr>
                <td>
                    Total Kehadiran
                </td>
                <td>
                    : <strong>{{ collect($rekap)->sum('hadir') }}</strong>
                </td>
            </tr>

            <tr>
                <td>
                    Total Alfa
                </td>
                <td>
                    : <strong>{{ collect($rekap)->sum('alfa') }}</strong>
                </td>
            </tr>
        </table>
    </div>

    <!-- TABEL -->
    <table class="table">
        <thead>
            <tr>
                <th width="35">No</th>
                <th width="110">NIP</th>
                <th>Nama Pegawai</th>
                <th width="140">Unit Kerja</th>
                <th width="60">Hadir</th>
                <th width="60">Alfa</th>
                <th width="70">Total Hari</th>
            </tr>
        </thead>

        <tbody>
            @foreach($rekap as $index => $r)
                <tr>
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $r['nip'] }}
                    </td>

                    <td>
                        {{ $r['nama'] }}
                    </td>

                    <td>
                        {{ $r['unit'] }}
                    </td>

                    <td class="text-center">
                        {{ $r['hadir'] }}
                    </td>

                    <td class="text-center">
                        <span class="{{ $r['alfa'] > 0 ? 'alfa' : '' }}">
                            {{ $r['alfa'] }}
                        </span>
                    </td>

                    <td class="text-center">
                        {{ $r['total_hari'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th colspan="4" class="text-right">
                    TOTAL
                </th>

                <th>
                    {{ collect($rekap)->sum('hadir') }}
                </th>

                <th>
                    {{ collect($rekap)->sum('alfa') }}
                </th>

                <th>
                    {{ collect($rekap)->sum('total_hari') }}
                </th>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER -->
    <div class="footer">

        <p class="print-info">
            Dicetak pada:
            {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
        </p>

        <div class="signature">
            <p>
                Banjarmasin,
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>

            <p><strong>Pimpinan</strong></p>

            <div class="signature-name">
                (........................................)
            </div>

            <p>
                NIP. ........................................
            </p>
        </div>

    </div>

</body>
</html>