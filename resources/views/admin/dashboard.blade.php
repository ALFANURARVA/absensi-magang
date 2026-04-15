@extends('layouts.admin')

@section('breadcrumb', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
    <p class="page-subtitle">Selamat datang di admin dashboard absensi siswa magang</p>
</div>

<!-- STATISTICS ROW -->
<div class="row mb-30">
    <div class="col-md-3 mb-24">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value" style="color: #667eea;">{{ $totalSiswa }}</div>
            <div class="stat-label">Total Siswa Magang</div>
        </div>
    </div>

    <div class="col-md-3 mb-24">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value" style="color: #10b981;">{{ $totalHadir }}</div>
            <div class="stat-label">Total Hadir</div>
        </div>
    </div>

    <div class="col-md-3 mb-24">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-value" style="color: #ef4444;">{{ $totalTidakHadir }}</div>
            <div class="stat-label">Total Tidak Hadir</div>
        </div>
    </div>

    <div class="col-md-3 mb-24">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white;">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-value" style="color: #3b82f6;">{{ $totalAbsensi }}</div>
            <div class="stat-label">Total Data Absensi</div>
        </div>
    </div>
</div>

<!-- DAFTAR SISWA TABLE -->
<div class="table-card">
    <div class="table-header">
        <div>
            <h3 class="table-title"><i class="fas fa-list"></i> Daftar Siswa Magang</h3>
        </div>
        <div class="table-header-right">
            <a href="{{ route('admin.siswa') }}" class="btn-info">
                <i class="fas fa-eye"></i> Lihat Semua
            </a>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Jurusan</th>
                    <th>Tempat Magang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $index => $siswa)
                    <tr>
                        <td><strong>{{ ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1 }}</strong></td>
                        <td>{{ $siswa->nis }}</td>
                        <td>
                            <strong>{{ $siswa->nama }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $siswa->jurusan }}</span>
                        </td>
                        <td>{{ $siswa->tempat_magang }}</td>
                        <td>
                            <a href="{{ route('admin.siswa-detail', $siswa->id) }}" class="btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <div>
                                <i class="fas fa-inbox"></i>
                                <p style="margin-top: 10px;">Tidak ada data siswa</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($siswas->count() > 0)
        <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <span style="color: #6b7280; font-size: 0.9rem;">
                Menampilkan {{ $siswas->count() }} siswa dari total
            </span>
            <nav>
                {{ $siswas->links() }}
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
