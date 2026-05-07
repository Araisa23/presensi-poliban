<!DOCTYPE html>
<html>
<head>
    <title>Rekap Presensi - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 15px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; font-style: italic; }
        .info { margin-bottom: 20px; width: 100%; }
        .info td { padding: 3px 0; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .text-center { text-align: center; }
        .footer { margin-top: 50px; width: 100%; }
        .signature { float: right; width: 250px; text-align: center; }
        .signature-name { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Rekapitulasi Presensi</h1>
        <p>Sistem Informasi Presensi Tenaga Kependidikan</p>
    </div>

    <table class="info">
        <tr>
            <td width="100">Bulan</td>
            <td width="10">:</td>
            <td><strong>{{ $namaBulan }}</strong></td>
        </tr>
        <tr>
            <td>Tahun</td>
            <td>:</td>
            <td><strong>{{ $tahun }}</strong></td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th width="30" class="text-center">No</th>
                <th width="100">NIP</th>
                <th>Nama Pegawai</th>
                <th width="150">Unit Kerja</th>
                <th width="40" class="text-center">Hadir</th>
                <th width="40" class="text-center">Alfa</th>
                <th width="40" class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $index => $r)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $r['nip'] }}</td>
                    <td>{{ $r['nama'] }}</td>
                    <td>{{ $r['unit'] }}</td>
                    <td class="text-center">{{ $r['hadir'] }}</td>
                    <td class="text-center" style="{{ $r['alfa'] > 0 ? 'color:red;' : '' }}">{{ $r['alfa'] }}</td>
                    <td class="text-center">{{ $r['total_hari'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p style="font-size: 9px; color: #777;">Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        <div class="signature">
            <p>Mengetahui,</p>
            <p>Pimpinan,</p>
            <div class="signature-name">( ........................................ )</div>
            <p>NIP. ........................................</p>
        </div>
    </div>
</body>
</html>
