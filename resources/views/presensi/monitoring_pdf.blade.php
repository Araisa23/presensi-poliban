<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Presensi Harian - {{ $tanggal }}</title>

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
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .table th {
            background: #e8edf5;
            color: #0b2c52;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }

        .table td {
            font-size: 10px;
        }

        .table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-center {
            text-align: center;
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
        <h3>Laporan Presensi Harian</h3>
    </div>

    <!-- INFORMASI -->
    <table class="info">
        <tr>
            <td width="100">Tanggal</td>
            <td width="10">:</td>
            <td>
                <strong>
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                </strong>
            </td>
        </tr>
    </table>

    <!-- RINGKASAN -->
    <div class="summary">
        <table>
            <tr>
                <td width="200">
                    Total Pegawai Hadir
                </td>
                <td>
                    : <strong>{{ count($presensi) }}</strong>
                </td>
            </tr>
        </table>
    </div>

    <!-- TABEL -->
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Pegawai</th>
                <th width="20%">NIP</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Jam Masuk</th>
                <th width="15%">Jam Pulang</th>
            </tr>
        </thead>

        <tbody>
            @forelse($presensi as $index => $p)
                <tr>
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $p->tenagaKependidikan->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $p->tenagaKependidikan->nip ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}
                    </td>

                    <td class="text-center">
                        {{ $p->jam_masuk ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $p->jam_pulang ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada data presensi pada tanggal ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
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