<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Presensi Harian</title>

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
            padding: 3px 0;
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

<!-- INFO -->
<table class="info">
    <tr>
        <td width="100">Tanggal</td>
        <td width="10">:</td>
        <td><strong>{{ now()->translatedFormat('d F Y') }}</strong></td>
    </tr>
</table>

<!-- TABLE -->
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
        </tr>
    </thead>

    <tbody>
        @foreach($presensi as $index => $p)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>

            <td>
                {{ $p->user->tenagaKependidikan->nama ?? '-' }}
            </td>

            <td>
                {{ $p->user->tenagaKependidikan->nip ?? '-' }}
            </td>

            <td class="text-center">
                {{ $p->tanggal }}
            </td>

            <td class="text-center">
                {{ $p->jam_masuk ?? '-' }}
            </td>

            <td class="text-center">
                {{ $p->jam_pulang ?? '-' }}
            </td>
        </tr>
        @endforeach
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

        <p>NIP. ........................................</p>
    </div>

</div>

</body>
</html>