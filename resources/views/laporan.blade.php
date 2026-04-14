@extends('layouts.app')

@section('content')

<style>
    .laporan-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 40px 30px;
        border-radius: 16px;
        margin-bottom: 30px;
        text-align: center;
    }

    .laporan-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .laporan-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .laporan-container {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
        border: 1px solid #e8eef5;
        overflow-x: auto;
    }

    .laporan-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }

    .laporan-table thead {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .laporan-table thead th {
        color: white;
        font-weight: 700;
        padding: 15px;
        text-align: left;
        border: none;
        font-size: 0.95rem;
    }

    .laporan-table tbody tr {
        border-bottom: 1px solid #e8eef5;
        transition: all 0.3s ease;
    }

    .laporan-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
    }

    .laporan-table tbody td {
        padding: 15px;
        font-size: 0.95rem;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        text-align: center;
        min-width: 80px;
    }

    .status-hadir {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .status-terlambat {
        background: linear-gradient(135deg, #f093fb, #f5576c);
        color: white;
    }

    .status-izin {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
    }

    .laporan-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .summary-item {
        background: linear-gradient(135deg, #f5f7fa, #e9ecef);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid #e8eef5;
    }

    .summary-item .number {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .summary-item .label {
        color: #666;
        font-weight: 600;
        font-size: 0.9rem;
        margin-top: 8px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #899;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .print-btn {
        margin: 20px 0;
        text-align: right;
    }

    @media print {
        .print-btn {
            display: none;
        }
        body {
            background: white;
        }
    }

    @media (max-width: 768px) {
        .laporan-header {
            padding: 25px 15px;
        }

        .laporan-header h2 {
            font-size: 1.8rem;
        }

        .laporan-container {
            padding: 15px;
        }

        .laporan-table thead th,
        .laporan-table tbody td {
            padding: 10px;
            font-size: 0.85rem;
        }

        .laporan-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- HEADER -->
<div class="laporan-header">
    <h2>📊 Laporan Absensi</h2>
    <p>Ringkasan kehadiran Anda</p>
    @if($siswa)
        <div style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 15px;">
            <small style="display: block;"><strong>Nama:</strong> {{ $siswa->nama }}</small>
            <small style="display: block;"><strong>NIS:</strong> {{ $siswa->nis }}</small>
            <small style="display: block;"><strong>Jurusan:</strong> {{ $siswa->jurusan }}</small>
        </div>
    @endif
</div>

<!-- PRINT BUTTON -->
<div class="print-btn">
    <button onclick="window.print()" class="btn btn-custom btn-masuk">
        <i class="fas fa-print"></i> Cetak Laporan
    </button>
</div>

<!-- SUMMARY STATISTICS -->
<div class="laporan-summary">
    <div class="summary-item">
        <div class="number">{{ $data->where('status', 'Hadir')->count() }}</div>
        <div class="label">Hadir</div>
    </div>
    <div class="summary-item">
        <div class="number">{{ $data->where('status', 'Terlambat')->count() }}</div>
        <div class="label">Terlambat</div>
    </div>
    <div class="summary-item">
        <div class="number">{{ $data->where('status', 'Izin')->count() }}</div>
        <div class="label">Izin</div>
    </div>
    <div class="summary-item">
        <div class="number">{{ $data->count() }}</div>
        <div class="label">Total Absensi</div>
    </div>
    <div class="summary-item">
        <div class="number">
            @if($data->count() > 0)
                {{ round(($data->where('status', 'Hadir')->count() / $data->count()) * 100) }}%
            @else
                0%
            @endif
        </div>
        <div class="label">Tingkat Kehadiran</div>
    </div>
    <div class="summary-item">
        <div class="number">{{ $data->where('jam_pulang', '!=', null)->count() }}</div>
        <div class="label">Pulang Tercatat</div>
    </div>
</div>

<!-- TABLE -->
<div class="laporan-container">
    @if($data->count() > 0)
        <table class="laporan-table">
            <thead>
                <tr>
                    <th><i class="fas fa-calendar-alt"></i> Tanggal</th>
                    <th><i class="fas fa-sign-in-alt"></i> Jam Masuk</th>
                    <th><i class="fas fa-sign-out-alt"></i> Jam Pulang</th>
                    <th><i class="fas fa-hourglass-end"></i> Durasi</th>
                    <th><i class="fas fa-check-square"></i> Status</th>
                    <th><i class="fas fa-map-marker-alt"></i> Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hitung_hadir = 0;
                    $hitung_terlambat = 0;
                    $hitung_izin = 0;
                @endphp
                
                @foreach($data as $d)
                    @php
                        if($d->status == 'Hadir') $hitung_hadir++;
                        elseif($d->status == 'Terlambat') $hitung_terlambat++;
                        else $hitung_izin++;
                        
                        // Calculate durasi
                        $durasi = '-';
                        if($d->jam_masuk && $d->jam_pulang) {
                            $masuk = \Carbon\Carbon::createFromFormat('H:i:s', $d->jam_masuk);
                            $pulang = \Carbon\Carbon::createFromFormat('H:i:s', $d->jam_pulang);
                            $diff = $pulang->diff($masuk);
                            $durasi = $diff->h . 'h ' . $diff->i . 'm';
                        }
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') ?? '-' }}</td>
                        <td>{{ $d->jam_masuk ?? '-' }}</td>
                        <td>{{ $d->jam_pulang ?? '-' }}</td>
                        <td>{{ $durasi }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '', $d->status ?? 'Izin')) }}">
                                {{ $d->status ?? 'Izin' }}
                            </span>
                        </td>
                        <td><small>{{ $d->lokasi ?? '-' }}</small></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h5>Belum Ada Data Laporan</h5>
            <p>Mulai lakukan absensi untuk membuat laporan</p>
        </div>
    @endif
</div>

@endsection