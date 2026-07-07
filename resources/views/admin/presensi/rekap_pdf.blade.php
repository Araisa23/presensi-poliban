<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Presensi - {{ $namaBulan }} {{ $tahun }}</title>

    <style>
        @page {
            margin: 15px;
        }

        body {  
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
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
            margin: 5px 0;
            font-size: 13px;
            font-weight: normal;
        }

        .header h3 {
            margin-top: 12px;
            font-size: 15px;
            color: #0b2c52;
        }

        .info {
            width: 100%;
            margin-bottom: 15px;
        }

        .info td {
            padding: 4px 0;
        }

        .summary {
            border: 1px solid #dbe4f0;
            background: #f8fafc;
            padding: 10px;
            margin-bottom: 15px;
        }

        .summary table {
            width: 100%;
        }

        .summary td {
            padding: 4px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th,
        .table td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .table th {
            background: #e8edf5;
            color: #0b2c52;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
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
            color: red;
            font-weight: bold;
        }

        tfoot th {
            background: #e8edf5;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
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

    <!-- INFORMASI -->
    <table class="info">
        <tr>
            <td width="80">Periode</td>
            <td width="10">:</td>
            <td><strong>{{ $namaBulan }} {{ $tahun }}</strong></td>
        </tr>
    </table>

    <!-- RINGKASAN -->
    <div class="summary">
        <table>
            <tr>
                <td width="180">Total Pegawai</td>
                <td>: <strong>{{ count($rekap) }}</strong></td>
            </tr>

            <tr>
                <td>Total Kehadiran</td>
                <td>: <strong>{{ collect($rekap)->sum('hadir') }}</strong></td>
            </tr>

            <tr>
                <td>Total Alfa</td>
                <td>: <strong>{{ collect($rekap)->sum('alfa') }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- TABEL -->
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="24%">NIP</th>
                <th width="22%">Nama Pegawai</th>
                <th width="23%">Unit Kerja</th>
                <th width="8%">Hadir</th>
                <th width="8%">Alfa</th>
                <th width="10%">Total Hari</th>
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
                        {{ $r['unit_kerja'] }}
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