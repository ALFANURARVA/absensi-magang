@extends('layouts.admin')

@section('breadcrumb', 'Data Absensi')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-calendar-check"></i> Data Absensi</h1>
    <p class="page-subtitle">Lihat dan filter data absensi seluruh siswa magang</p>
</div>

<!-- FILTER CARD -->
<div class="table-card mb-30" style="margin-bottom: 24px;">
    <div class="table-header">
        <h3 class="table-title">Filter Data</h3>
    </div>
    <div style="padding: 24px; border-top: 1px solid #e5e7eb;">
        <form action="{{ route('admin.absensi') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151; font-size: 0.9rem;">Siswa</label>
                    <select class="form-select" name="siswa_id" style="padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px;">
                        <option value="">Semua Siswa</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" @if(request('siswa_id') == $siswa->id) selected @endif>
                                {{ $siswa->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151; font-size: 0.9rem;">Status</label>
                    <select class="form-select" name="status" style="padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px;">
                        <option value="">Semua Status</option>
                        <option value="hadir" @if(request('status') === 'hadir') selected @endif>Hadir</option>
                        <option value="tidak hadir" @if(request('status') === 'tidak hadir') selected @endif>Tidak Hadir</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151; font-size: 0.9rem;">Dari Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_dari" value="{{ request('tanggal_dari') }}" style="padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px;">
                </div>

                <div class="col-md-2">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151; font-size: 0.9rem;">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" style="padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px;">
                </div>

                <div class="col-md-3 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn-primary" style="flex: 1;">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.absensi') }}" class="btn-info" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                    <a href="{{ route('admin.export-absensi', array_merge(request()->query())) }}" class="btn-success" style="flex: 1; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-download"></i> Export
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABLE -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title"><i class="fas fa-list"></i> Daftar Absensi</h3>
    </div>

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
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
                        <td>{{ $absensi->siswa->nis }}</td>
                        <td><strong>{{ $absensi->siswa->nama }}</strong></td>
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
                        <td colspan="7" class="empty-state">
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

    .btn-info {
        background: #3b82f6;
    }

    .btn-success {
        background: #10b981;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
</style>
@endsection
