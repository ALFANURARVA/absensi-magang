@extends('layouts.user')

@section('breadcrumb', 'Edit Profil')

@section('content')

    <!-- FLASH MESSAGES -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- HEADER SECTION -->
    <div class="header-section">
        <div class="greeting-text">
            <i class="fas fa-edit"></i> Edit Data Siswa
        </div>
        <div class="time-date" id="timeDate">
            Memuat waktu...
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8 mx-auto">
            <div class="card-custom p-5">
                <h4 style="color: #2d3748; margin-bottom: 30px; font-weight: 700;">
                    <i class="fas fa-user-check"></i> Lengkapi Data Pribadi Anda
                </h4>

                <form action="{{ route('siswa.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- NAMA -->
                    <div class="form-group mb-4">
                        <label for="nama" class="form-label">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('nama') is-invalid @enderror" 
                            id="nama" 
                            name="nama" 
                            value="{{ old('nama', $siswa->nama) }}"
                            placeholder="Masukkan nama lengkap Anda"
                            required
                        >
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIS -->
                    <div class="form-group mb-4">
                        <label for="nis" class="form-label">
                            <i class="fas fa-id-card"></i> NIS (Nomor Induk Siswa)
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('nis') is-invalid @enderror" 
                            id="nis" 
                            name="nis" 
                            value="{{ old('nis', $siswa->nis) }}"
                            placeholder="Contoh: 001"
                            required
                        >
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">NIS harus unik</small>
                    </div>

                    <!-- JURUSAN -->
                    <div class="form-group mb-4">
                        <label for="jurusan" class="form-label">
                            <i class="fas fa-graduation-cap"></i> Jurusan
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('jurusan') is-invalid @enderror" 
                            id="jurusan" 
                            name="jurusan" 
                            value="{{ old('jurusan', $siswa->jurusan) }}"
                            placeholder="Contoh: Teknik Informatika"
                            required
                        >
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TEMPAT MAGANG -->
                    <div class="form-group mb-4">
                        <label for="tempat_magang" class="form-label">
                            <i class="fas fa-building"></i> Tempat/Perusahaan Magang
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('tempat_magang') is-invalid @enderror" 
                            id="tempat_magang" 
                            name="tempat_magang" 
                            value="{{ old('tempat_magang', $siswa->tempat_magang) }}"
                            placeholder="Contoh: PT. Maju Jaya"
                            required
                        >
                        @error('tempat_magang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- BUTTONS -->
                    <div style="display: flex; gap: 15px; margin-top: 30px;">
                        <button type="submit" class="btn btn-masuk-large" style="flex: 1; padding: 15px; font-size: 1rem; font-weight: 600;">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <a href="{{ route('user') }}" class="btn btn-secondary" style="flex: 1; padding: 15px; font-size: 1rem; font-weight: 600; text-decoration: none; border-radius: 12px; background: #e8eef5; color: #667eea; text-align: center; transition: all 0.3s; border: 1px solid #e8eef5;">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- INFO CARD -->
            <div class="card-custom p-4 mt-4">
                <h5 style="color: #2d3748; margin-bottom: 15px; font-weight: 700;">
                    <i class="fas fa-info-circle"></i> Informasi
                </h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #667eea; font-weight: bold; margin-right: 10px;">ℹ</span>
                        Data yang Anda isi akan digunakan untuk laporan kehadiran
                    </li>
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #667eea; font-weight: bold; margin-right: 10px;">ℹ</span>
                        NIS harus unik dan tidak boleh sama dengan siswa lain
                    </li>
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #667eea; font-weight: bold; margin-right: 10px;">ℹ</span>
                        Pastikan semua data sudah benar sebelum menyimpan
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <style>
        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: #667eea;
            font-size: 1.1rem;
        }

        .form-control {
            border: 1px solid #e8eef5;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fbfd;
        }

        .form-control:focus {
            background: white;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #f5576c;
            background: #fff5f5;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(245, 87, 108, 0.1);
        }

        .invalid-feedback {
            display: block;
            color: #f5576c;
            font-size: 0.9rem;
            margin-top: 5px;
            font-weight: 500;
        }

        .btn {
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-masuk-large {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 12px;
        }

        .btn-masuk-large:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #d8e0f7 !important;
            color: #764ba2 !important;
        }

        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid;
            animation: slideDown 0.3s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
            color: white;
            border-color: #38f9d7;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            border-color: #f5576c;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .form-control {
                padding: 10px 12px;
                font-size: 0.95rem;
            }
        }
    </style>

    <script>
        function updateTime() {
            const now = new Date();
            document.getElementById('timeDate').textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
        updateTime();
    </script>

@endsection
