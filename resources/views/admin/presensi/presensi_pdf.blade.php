<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Presensi Harian</title>

    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header h2 {
            margin: 3px 0;
            font-size: 12px;
            font-weight: normal;
        }

        .header h3 {
            margin-top: 8px;
            font-size: 13px;
            font-weight: bold;
        }

        .line {
            border-top: 1px solid #000;
            margin: 10px 0 15px;
        }

        .info {
            margin-bottom: 10px;
            font-size: 11px;
        }

        /* 🔥 penting: bikin tabel lebih rapi */
        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* BIAR KOLOM TIDAK ACAK */
        }

        .table th,
        .table td {
            border: 1px solid #bfc7d1;
            padding: 6px;
            font-size: 10px;
            word-wrap: break-word;
        }

        .table th {
            background: #e9eef5;
            text-transform: uppercase;
            text-align: center;
            font-size: 10px;
        }

        .table td {
            vertical-align: middle;
        }

        /* 🔥 penting: cegah teks turun baris aneh */
        .nowrap {
            white-space: nowrap;
            overflow: hidden;
        }

        .text-center {
            text-align: center;
        }

        /* 🔥 kolom lebih presisi seperti di foto */
        th.no { width: 10px; }
        th.nama { width: 200px; }
        th.nip { width: 170px; }
        th.tanggal { width: 110px; }
        th.masuk { width: 100px; }
        th.pulang { width: 100px; }

    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <h1>POLITEKNIK NEGERI BANJARMASIN</h1>
        <h2>Sistem Informasi Presensi Tenaga Kependidikan</h2>
        <h3>Laporan Presensi Harian</h3>
    </div>

    <div class="line"></div>

    <!-- INFO -->
    <div class="info">
        Periode: <strong>{{ $periode ?? \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong>
    </div>

    <!-- TABLE -->
    <table class="table">
        <thead>
            <tr>
                <th class="no">NO</th>
                <th class="nama">NAMA</th>
                <th class="nip">NIP</th>
                <th class="tanggal">TANGGAL</th>
                <th class="masuk">JAM MASUK</th>
                <th class="pulang">JAM PULANG</th>
            </tr>
        </thead>

        <tbody>
            @forelse($presensi as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>

                    <td class="nowrap">
                        {{ $p->user->tenagaKependidikan->nama ?? '-' }}
                    </td>

                    <td class="nowrap">
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
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada data presensi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>