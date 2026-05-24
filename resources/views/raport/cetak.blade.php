<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport - {{ $student->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 3px solid #1e40af; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 16px; color: #1e40af; font-weight: bold; }
        .header h2 { font-size: 14px; color: #374151; margin-top: 4px; }
        .header p { font-size: 11px; color: #6b7280; margin-top: 2px; }
        .info-siswa { display: flex; justify-content: space-between; margin-bottom: 20px; background: #f8fafc; padding: 12px; border-radius: 8px; }
        .info-siswa div { flex: 1; }
        .info-siswa p { margin-bottom: 4px; font-size: 11px; }
        .info-siswa strong { color: #1e40af; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead tr { background: #1e40af; color: white; }
        thead th { padding: 8px; text-align: center; font-size: 11px; }
        thead th:first-child { text-align: left; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 7px 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        .tuntas { color: #059669; font-weight: bold; }
        .belum { color: #dc2626; font-weight: bold; }
        .footer-table { background: #eff6ff !important; }
        .footer-table td { font-weight: bold; color: #1e40af; }
        .prestasi-box { margin-top: 20px; padding: 15px; border-radius: 8px; border: 2px solid #1e40af; }
        .prestasi-box h3 { color: #1e40af; font-size: 13px; margin-bottom: 8px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .amat-baik { background: #d1fae5; color: #065f46; }
        .baik { background: #dbeafe; color: #1e40af; }
        .cukup { background: #fef3c7; color: #92400e; }
        .kurang { background: #fee2e2; color: #991b1b; }
        .ttd { display: flex; justify-content: flex-end; margin-top: 40px; }
        .ttd div { text-align: center; }
        .ttd p { font-size: 11px; }
        .ttd .garis { margin-top: 60px; border-top: 1px solid #333; padding-top: 4px; width: 150px; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>LAPORAN HASIL BELAJAR SISWA (RAPORT)</h1>
        <h2>Madrasah Ibtidaiyah</h2>
        <p>Sistem Pakar Prestasi Siswa | Tahun Ajaran {{ $semester }}</p>
    </div>

    {{-- Info Siswa --}}
    <div class="info-siswa">
        <div>
            <p><strong>Nama Siswa</strong> : {{ $student->nama }}</p>
            <p><strong>Kelas</strong> : {{ $student->kelas }}</p>
            @if($student->nisn)
            <p><strong>NISN</strong> : {{ $student->nisn }}</p>
            @endif
        </div>
        <div>
            <p><strong>Semester</strong> : {{ $semester }}</p>
            <p><strong>Tanggal Cetak</strong> : {{ date('d F Y') }}</p>
        </div>
    </div>

    {{-- Tabel Nilai --}}
    <table>
        <thead>
            <tr>
                <th style="text-align:left; width:30%">Mata Pelajaran</th>
                <th style="width:8%">KKM</th>
                <th style="width:12%">Nilai Harian</th>
                <th style="width:12%">Nilai UTS</th>
                <th style="width:12%">Nilai UAS</th>
                <th style="width:12%">Nilai Akhir</th>
                <th style="width:14%">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($raport as $index => $r)
            <tr>
                <td>{{ $r->mataPelajaran->nama }}</td>
                <td style="text-align:center">{{ $r->mataPelajaran->kkm }}</td>
                <td style="text-align:center">{{ $r->nilai_harian }}</td>
                <td style="text-align:center">{{ $r->nilai_uts }}</td>
                <td style="text-align:center">{{ $r->nilai_uas }}</td>
                <td style="text-align:center; font-weight:bold; color:{{ $r->nilai_akhir >= $r->mataPelajaran->kkm ? '#059669' : '#dc2626' }}">
                    {{ $r->nilai_akhir }}
                </td>
                <td style="text-align:center" class="{{ $r->nilai_akhir >= $r->mataPelajaran->kkm ? 'tuntas' : 'belum' }}">
                    {{ $r->nilai_akhir >= $r->mataPelajaran->kkm ? 'Tuntas' : 'Belum Tuntas' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding: 20px; color: #6b7280">Belum ada nilai</td>
            </tr>
            @endforelse
            @if($raport->count() > 0)
            <tr class="footer-table">
                <td colspan="5" style="text-align:right; font-weight:bold">Rata-rata Nilai Akhir</td>
                <td style="text-align:center; font-weight:bold; color:#1e40af">{{ number_format($raport->avg('nilai_akhir'), 2) }}</td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- Prestasi C4.5 --}}
    @if($penilaian && $penilaian->hasil_prestasi)
    <div class="prestasi-box">
        <h3>Hasil Klasifikasi Prestasi (Algoritma C4.5)</h3>
        <p style="margin-bottom: 8px; font-size: 11px; color: #6b7280;">
            Berdasarkan analisis algoritma Decision Tree C4.5
        </p>
        <span class="badge {{ strtolower(str_replace(' ', '-', $penilaian->hasil_prestasi)) }}">
            {{ $penilaian->hasil_prestasi }}
        </span>
        <span style="margin-left: 10px; font-size: 11px; color: #6b7280;">
            Skor: {{ $penilaian->skor }}
        </span>
    </div>
    @endif

    {{-- TTD --}}
    <div class="ttd">
        <div>
            <p>Mengetahui,</p>
            <p>Wali Kelas {{ $student->kelas }}</p>
            <div class="garis">
                <p>( _________________ )</p>
            </div>
        </div>
    </div>

</body>
</html> 