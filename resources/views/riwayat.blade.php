@extends('layouts.user')

@section('breadcrumb', 'Riwayat Absensi')

@section('content')

<style>
    .header-riwayat {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
    }

    .header-riwayat h2 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 10px;
    }

    .header-riwayat p {
        color: #718096;
        margin-bottom: 20px;
    }

    .table-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    .table-custom {
        margin-bottom: 0;
    }

    .table-custom thead {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .table-custom thead th {
        color: white;
        font-weight: 700;
        border: none;
        padding: 15px;
        font-size: 0.95rem;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .table-custom tbody tr:hover {
        background-color: #f7fafc;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table-custom tbody td {
        padding: 15px;
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .foto-absen {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .foto-absen:hover {
        border-color: #667eea;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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

    .jam-text {
        font-weight: 600;
        color: #2d3748;
    }

    .tanggal-text {
        font-weight: 600;
        color: #667eea;
    }

    .lokasi-text {
        color: #718096;
        word-break: break-word;
        max-width: 150px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #718096;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .filter-section {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 16px;
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        background: white;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-color: transparent;
    }

    @media (max-width: 768px) {
        .table-container {
            padding: 15px;
        }

        .table-custom thead th,
        .table-custom tbody td {
            padding: 10px;
            font-size: 0.85rem;
        }

        .foto-absen {
            width: 50px;
            height: 50px;
        }

        .lokasi-text {
            max-width: 100px;
            font-size: 0.85rem;
        }
    }
</style>

<!-- HEADER SECTION -->
<div class="header-riwayat">
    <h2>
        <i class="fas fa-history"></i> Riwayat Absensi
    </h2>
    <p>Lihat detail absensi harian Anda</p>
</div>

<!-- TABLE SECTION -->
<div class="table-container">
    @if($data->count() > 0)
        <div class="filter-section">
            <button class="filter-btn active" onclick="filterStatus('semua')">
                <i class="fas fa-list"></i> Semua
            </button>
            <button class="filter-btn" onclick="filterStatus('hadir')">
                <i class="fas fa-check-circle"></i> Hadir
            </button>
            <button class="filter-btn" onclick="filterStatus('terlambat')">
                <i class="fas fa-clock"></i> Terlambat
            </button>
            <button class="filter-btn" onclick="filterStatus('izin')">
                <i class="fas fa-file-alt"></i> Izin
            </button>
        </div>

        <table class="table table-custom">
            <thead>
                <tr>
                    <th><i class="fas fa-calendar-alt"></i> Tanggal</th>
                    <th><i class="fas fa-sign-in-alt"></i> Masuk</th>
                    <th><i class="fas fa-sign-out-alt"></i> Pulang</th>
                    <th><i class="fas fa-check-square"></i> Status</th>
                    <th><i class="fas fa-camera"></i> Foto</th>
                    <th><i class="fas fa-map-marker-alt"></i> Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr class="status-row" data-status="{{ strtolower($d->status) }}">
                    <td class="tanggal-text">{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</td>
                    <td class="jam-text">{{ $d->jam_masuk ?? '-' }}</td>
                    <td class="jam-text">{{ $d->jam_pulang ?? '-' }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '', $d->status)) }}">
                            {{ $d->status }}
                        </span>
                    </td>
                    <td>
                        @if($d->foto_absen)
                            <img src="/foto_absen/{{ $d->foto_absen }}" 
                                 class="foto-absen" 
                                 alt="Foto {{ $d->tanggal }}"
                                 onclick="showModal('/foto_absen/{{ $d->foto_absen }}')">
                        @else
                            <span style="color: #cbd5e0;">
                                <i class="fas fa-image"></i> Tidak ada
                            </span>
                        @endif
                    </td>
                    <td class="lokasi-text">
                        {{ $d->lokasi ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h5>Belum ada data absensi</h5>
            <p style="color: #cbd5e0;">Mulai lakukan absensi dari dashboard untuk melihat riwayat</p>
        </div>
    @endif
</div>

<!-- Image Modal -->
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="position: relative;">
        <img id="modalImage" src="" style="max-width: 90vw; max-height: 90vh; border-radius: 15px;">
        <button onclick="closeModal()" style="position: absolute; top: -40px; right: 0; background: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 20px;">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<script>
    function filterStatus(status) {
        const rows = document.querySelectorAll('.status-row');
        const buttons = document.querySelectorAll('.filter-btn');
        
        // Update button active state
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.closest('.filter-btn').classList.add('active');
        
        // Filter rows
        rows.forEach(row => {
            if (status === 'semua') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.status === status ? '' : 'none';
            }
        });
    }

    function showModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    // Close modal saat klik di luar gambar
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close modal dengan Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>

@endsection