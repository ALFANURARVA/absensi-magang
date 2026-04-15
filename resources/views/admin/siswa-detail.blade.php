@extends('layouts.admin')

@section('breadcrumb', 'Detail Siswa: ' . $siswa->nama)

@section('content')
<div class="page-header mb-30">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 class="page-title"><i class="fas fa-user-circle"></i> {{ $siswa->nama }}</h1>
            <p class="page-subtitle">Informasi detail dan riwayat absensi siswa</p>
        </div>
        <a href="{{ route('admin.siswa') }}" class="btn-info">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- STUDENT INFO CARD -->
<div class="row mb-30" style="margin-bottom: 24px;">
    <div class="col-md-4">
        <div class="stat-card" style="height: 100%;">
            <h6 style="font-weight: 700; margin-bottom: 20px; color: #374151;">INFORMASI SISWA</h6>
            
            <div style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #6b7280; font-size: 0.85rem;">NISN</label>
                <p style="margin: 4px 0; color: #374151; font-weight: 500;">{{ $siswa->nis }}</p>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #6b7280; font-size: 0.85rem;">Nama Lengkap</label>
                <p style="margin: 4px 0; color: #374151; font-weight: 500;">{{ $siswa->nama }}</p>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-weight: 600; color: #6b7280; font-size: 0.85rem;">Jurusan</label>
                <p style="margin: 4px 0;">
                    <span class="badge badge-primary">{{ $siswa->jurusan }}</span>
                </p>
            </div>

            <div>
                <label style="font-weight: 600; color: #6b7280; font-size: 0.85rem;">Tempat Magang</label>
                <p style="margin: 4px 0; color: #374151; font-weight: 500;">{{ $siswa->tempat_magang }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6 mb-24" style="margin-bottom: 24px;">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value" style="color: #10b981;">{{ $siswa->absensi->where('status', 'hadir')->count() }}</div>
                    <div class="stat-label">Total Hadir</div>
                </div>
            </div>

            <div class="col-md-6 mb-24" style="margin-bottom: 24px;">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-value" style="color: #ef4444;">{{ $siswa->absensi->where('status', 'tidak hadir')->count() }}</div>
                    <div class="stat-label">Total Tidak Hadir</div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <h6 style="font-weight: 700; margin-bottom: 16px; color: #374151;">STATISTIK ABSENSI</h6>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #6b7280;">Total Rekaman Absensi:</span>
                <strong style="color: #374151;">{{ $siswa->absensi->count() }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #6b7280;">Persentase Kehadiran:</span>
                <div>
                    @php
                        $total = $siswa->absensi->count();
                        $hadir = $siswa->absensi->where('status', 'hadir')->count();
                        $percentage = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;
                    @endphp
                    <span class="badge" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                        {{ $percentage }}%
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ATTENDANCE TABLE -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title"><i class="fas fa-calendar-check"></i> Riwayat Absensi</h3>
    </div>

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $index => $absensi)
                    <tr>
                        <td class="fw-bold">{{ ($absensis->currentPage() - 1) * $absensis->perPage() + $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</td>
                        <td>{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i:s') : '-' }}</td>
                        <td>{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i:s') : '-' }}</td>
                        <td>
                            @if($absensi->status === 'hadir')
                                <span class="badge badge-success"><i class="fas fa-check"></i> Hadir</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-times"></i> Tidak Hadir</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <div>
                                <i class="fas fa-inbox"></i>
                                <p style="margin-top: 10px;">Tidak ada data absensi</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($absensis->count() > 0)
        <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <span style="color: #6b7280; font-size: 0.9rem;">
                Menampilkan {{ $absensis->count() }} absensi
            </span>
            <nav>
                {{ $absensis->links() }}
            </nav>
        </div>
    @endif
</div>

<style>
    .mb-30 {
        margin-bottom: 30px;
    }

    .mb-24 {
        margin-bottom: 24px;
    }
</style>
@endsection
