@extends('layouts.admin')

@section('breadcrumb', 'Laporan Kehadiran')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-file-pdf"></i> Laporan Kehadiran</h1>
    <p class="page-subtitle">Laporan kehadiran per siswa magang</p>
</div>

<!-- FILTER CARD -->
<div class="table-card mb-30" style="margin-bottom: 24px;">
    <div class="table-header">
        <h3 class="table-title">Filter Laporan</h3>
    </div>
    <div style="padding: 24px; border-top: 1px solid #e5e7eb;">
        <form action="{{ route('admin.laporan') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-6">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151; font-size: 0.9rem;">Jurusan</label>
                    <select class="form-select" name="jurusan" style="padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px;">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j }}" @if(request('jurusan') === $j) selected @endif>
                                {{ $j }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn-primary" style="flex: 1;">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('admin.laporan') }}" class="btn-info" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- REPORT TABLE -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title"><i class="fas fa-chart-bar"></i> Ringkasan Kehadiran</h3>
    </div>

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Jurusan</th>
                    <th>Total Absensi</th>
                    <th>Hadir</th>
                    <th>Tidak Hadir</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $index => $siswa)
                    @php
                        $total = $siswa->total_absensi;
                        $hadir = $siswa->total_hadir;
                        $tidakHadir = $siswa->total_tidak_hadir;
                        $percentage = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;
                    @endphp
                    <tr>
                        <td class="fw-bold">{{ $index + 1 }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>
                            <a href="{{ route('admin.siswa-detail', $siswa->id) }}" style="text-decoration: none; color: #6366f1; font-weight: 600;">
                                {{ $siswa->nama }}
                            </a>
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $siswa->jurusan }}</span>
                        </td>
                        <td class="fw-bold">{{ $total }}</td>
                        <td>
                            <span class="badge badge-success">{{ $hadir }}</span>
                        </td>
                        <td>
                            <span class="badge badge-danger">{{ $tidakHadir }}</span>
                        </td>
                        <td>
                            <span class="badge" style="
                                @if($percentage >= 80)
                                    background: rgba(16, 185, 129, 0.1); color: #10b981;
                                @elseif($percentage >= 60)
                                    background: rgba(245, 158, 11, 0.1); color: #f59e0b;
                                @else
                                    background: rgba(239, 68, 68, 0.1); color: #ef4444;
                                @endif
                            ">
                                {{ $percentage }}%
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
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
</div>

<style>
    .mb-30 {
        margin-bottom: 30px;
    }

    .btn-info {
        background: #3b82f6;
    }

    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
</style>
@endsection
