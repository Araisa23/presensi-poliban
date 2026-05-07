<!DOCTYPE html>
<html>
<head>
    <title>Laporan Presensi</title>
    <style>
        body{ font-family: sans-serif; font-size:12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align:left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Presensi Tenaga Kependidikan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presensis as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->jam_masuk ?? '-' }}</td>
                <td>{{ $p->jam_pulang ?? '-' }}</td>
                <td>{{ strtoupper($p->status_kehadiran) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>