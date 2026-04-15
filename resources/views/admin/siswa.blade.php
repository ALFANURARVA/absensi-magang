@extends('layouts.admin')

@section('breadcrumb', 'Data Siswa')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-users"></i> Data Siswa Magang</h1>
    <p class="page-subtitle">Kelola dan lihat data semua siswa magang</p>
</div>

<!-- SEARCH AND FILTER -->
<div class="table-card mb-30" style="margin-bottom: 24px;">
    <div class="table-header">
        <h3 class="table-title">Filter Data</h3>
    </div>
    <div style="padding: 24px; border-top: 1px solid #e5e7eb;">
        <form action="{{ route('admin.siswa') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-5">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151; font-size: 0.9rem;">Cari Siswa</label>
                    <input type="text" class="form-control" name="search" placeholder="Cari nama atau NISN..." value="{{ request('search') }}" style="padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 8px;">
                </div>
                
                <div class="col-md-5">
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

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn-primary" style="width: 100%;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABLE -->
<div class="table-card">
    <div class="table-header">
        <div>
            <h3 class="table-title"><i class="fas fa-list"></i> Daftar Siswa</h3>
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
                        <td class="fw-bold">{{ ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1 }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td><strong>{{ $siswa->nama }}</strong></td>
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
                Menampilkan {{ $siswas->count() }} siswa
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

    .form-control, .form-select {
        font-size: 0.9rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
</style>
@endsection
