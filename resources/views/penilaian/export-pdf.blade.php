<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Prestasi Siswa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1e40af; padding-bottom: 15px; }
        .header h1 { font-size: 18px; color: #1e40af; margin-bottom: 5px; }
        .header p { font-size: 11px; color: #666; }
        .statistik { display: flex; gap: 10px; margin-bottom: 20px; }
        .stat-box { flex: 1; padding: 10px; border-radius: 6px; text-align: center; }
        .stat-box.amat-baik { background: #d1fae5; border: 1px solid #10b981; }
        .stat-box.baik { background: #dbeafe; border: 1px solid #3b82f6; }
        .stat-box.cukup { background: #fef3c7; border: 1px solid #f59e0b; }
        .stat-box.kurang { background: #fee2e2; border: 1px solid #ef4444; }
        .stat-box p { font-size: 10px; color: #555; }
        .stat-box h3 { font-size: 20px; font-weight: bold; margin-top: 3px; }
        .stat-box.amat-baik h3 { color: #065f46; }
        .stat-box.baik h3 { color: #1e40af; }
        .stat-box.cukup h3 { color: #92400e; }
        .stat-box.kurang h3 { color: #991b1b; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead tr { background: #1e40af; color: white; }
        thead th { padding: 8px 10px; text-align: left; font-size: 11px; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:nth-child(odd) { background: #ffffff; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; }
        .badge.amat-baik { background: #d1fae5; color: #065f46; }
        .badge.baik { background: #dbeafe; color: #1e40af; }
        .badge.cukup { background: #fef3c7; color: #92400e; }
        .badge.kurang { background: #fee2e2; color: #991b1b; }
        .footer { text-align: center; font-size: 10px; color: #999; margin-top: 20px; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>LAPORAN PRESTASI AKADEMIK SISWA</h1>
        <p>Sistem Pakar Menggunakan Algoritma Decision Tree C4.5</p>
        @if($semester)
        <p>Semester: {{ $semester }}</p>
        @endif
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    {{-- Statistik --}}
    <div class="statistik">
        <div class="stat-box amat-baik">
            <p>Amat Baik</p>
            <h3>{{ $statistik['amat_baik'] }}</h3>
        </div>
        <div class="stat-box baik">
            <p>Baik</p>
            <h3>{{ $statistik['baik'] }}</h3>
        </div>
        <div class="stat-box cukup">
            <p>Cukup</p>
            <h3>{{ $statistik['cukup'] }}</h3>
        </div>
        <div class="stat-box kurang">
            <p>Kurang</p>
            <h3>{{ $statistik['kurang'] }}</h3>
        </div>
    </div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Nilai</th>
                <th>Kehadiran</th>
                <th>Keaktifan</th>
                <th>Sikap</th>
                <th>Skor</th>
                <th>Prestasi</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penilaian as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->student->nama }}</td>
                <td>{{ $item->student->kelas }}</td>
                <td>{{ $item->nilai }}</td>
                <td>{{ $item->kehadiran }}%</td>
                <td>{{ $item->keaktifan }}</td>
                <td>{{ $item->sikap }}</td>
                <td><strong>{{ $item->skor }}</strong></td>
                <td>
                    <span class="badge {{ strtolower(str_replace(' ', '-', $item->hasil_prestasi)) }}">
                        {{ $item->hasil_prestasi }}
                    </span>
                </td>
                <td>{{ $item->semester }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center; padding: 20px; color: #999;">
                    Belum ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <p>Laporan ini digenerate otomatis oleh Sistem Pakar Prestasi Siswa &copy; {{ date('Y') }}</p>
    </div>

</body>
</html>