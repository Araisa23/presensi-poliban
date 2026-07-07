<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Presensi Harian - {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</title>

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

        .kosong {
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
        <h3>Laporan Presensi Harian</h3>
    </div>

    <!-- INFORMASI -->
    <table class="info">
        <tr>
            <td width="80">Periode</td>
            <td width="10">:</td>
            <td><strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong></td>
        </tr>
    </table>

    <!-- RINGKASAN -->
    <div class="summary">
        <table>
            <tr>
                <td width="180">Total Pegawai Presensi</td>
                <td>: <strong>{{ count($presensi) }}</strong></td>
            </tr>

            <tr>
                <td>Sudah Presensi Pulang</td>
                <td>: <strong>{{ collect($presensi)->whereNotNull('jam_pulang')->count() }}</strong></td>
            </tr>

            <tr>
                <td>Belum Presensi Pulang</td>
                <td>: <strong>{{ collect($presensi)->whereNull('jam_pulang')->count() }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- TABEL -->
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">NIP</th>
                <th width="25%">Nama Pegawai</th>
                <th width="17%">Tanggal</th>
                <th width="16%">Jam Masuk</th>
                <th width="17%">Jam Pulang</th>
            </tr>
        </thead>

        <tbody>
            @forelse($presensi as $index => $p)
                <tr>
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $p->user->tenagaKependidikan->nip ?? '-' }}
                    </td>

                    <td>
                        {{ $p->user->tenagaKependidikan->nama ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                    </td>

                    <td class="text-center">
                        {{ $p->jam_masuk ?? '-' }}
                    </td>

                    <td class="text-center">
                        <span class="{{ !$p->jam_pulang ? 'kosong' : '' }}">
                            {{ $p->jam_pulang ?? '-' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada data presensi
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