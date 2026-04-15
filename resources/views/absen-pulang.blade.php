@extends('layouts.user')

@section('breadcrumb', 'Absen Pulang')

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
            <i class="fas fa-sunset"></i> Absen Pulang
        </div>
        <div class="time-date" id="timeDate">
            Memuat waktu...
        </div>
    </div>

    <div class="row g-4">
        <!-- MAIN ABSEN PULANG CARD -->
        <div class="col-lg-8">
            <div class="card-custom p-5">
                <div class="form-header" style="text-align: center; margin-bottom: 40px;">
                    <div class="form-icon" style="width: 100px; height: 100px; border-radius: 20px; background: linear-gradient(135deg, #f093fb, #f5576c); color: white; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 20px;">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <h2 style="color: #2d3748; margin-bottom: 10px;">Catat Waktu Kepulangan</h2>
                    <p style="color: #718096; font-size: 1.1rem;">Konfirmasi jam pulang Anda hari ini</p>
                </div>

                @if(!$absenHariIni)
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Anda belum melakukan absen masuk hari ini</strong>
                        <br>
                        <small>Silakan lakukan absen masuk terlebih dahulu sebelum absen pulang</small>
                    </div>
                    <a href="{{ route('absen.show-masuk') }}" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i> Ke Halaman Absen Masuk
                    </a>
                @elseif($absenHariIni->jam_pulang)
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle"></i> <strong>Anda sudah melakukan absen pulang hari ini</strong>
                        <br>
                        <small>Jam Masuk: <strong>{{ date('H:i', strtotime($absenHariIni->jam_masuk)) }}</strong> | 
                        Jam Pulang: <strong>{{ date('H:i', strtotime($absenHariIni->jam_pulang)) }}</strong></small>
                    </div>
                @else
                    <form action="{{ route('absen.pulang') }}" method="POST">
                        @csrf

                        <!-- RINGKASAN ABSEN MASUK -->
                        <div class="ringkasan-masuk mb-5">
                            <h5 style="color: #2d3748; margin-bottom: 20px; font-weight: 700;">
                                <i class="fas fa-history"></i> Ringkasan Absen Hari Ini
                            </h5>
                            <div class="status-grid">
                                <div class="status-item">
                                    <div class="status-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div class="status-info">
                                        <div class="status-label">Jam Masuk</div>
                                        <div class="status-value">{{ date('H:i:s', strtotime($absenHariIni->jam_masuk)) }}</div>
                                    </div>
                                </div>
                                <div class="status-item">
                                    <div class="status-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                                        <i class="fas fa-badge-check"></i>
                                    </div>
                                    <div class="status-info">
                                        <div class="status-label">Status</div>
                                        <div class="status-value" style="color: {{ $absenHariIni->status == 'Hadir' ? '#43e97b' : ($absenHariIni->status == 'Terlambat' ? '#f093fb' : '#4facfe') }};">
                                            {{ $absenHariIni->status }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- JAM DISPLAY UNTUK PULANG -->
                        <div class="jam-display-wrapper mb-4">
                            <div class="jam-display">
                                <div style="font-size: 3rem; font-weight: 700; color: #f5576c; font-family: 'Courier New', monospace;" id="jamDisplay">
                                    00:00:00
                                </div>
                                <div style="color: #718096; font-size: 0.9rem; margin-top: 5px;">Jam Pulang</div>
                            </div>
                        </div>

                        <!-- DURASI KERJA CALCULATION (info saja) -->
                        <div class="durasi-kerja mb-4">
                            <div style="background: #f9fbfd; border: 1px solid #e8eef5; border-radius: 12px; padding: 15px;">
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <i class="fas fa-hourglass-end" style="color: #f5576c; margin-right: 10px;"></i>
                                    <strong style="color: #2d3748;">Durasi Kerja</strong>
                                </div>
                                <div id="durasi-text" style="color: #718096; font-size: 0.95rem;">
                                    Durasi akan ditampilkan setelah Anda melakukan absen pulang
                                </div>
                            </div>
                        </div>

                        <!-- LOKASI DISPLAY -->
                        <div class="lokasi-display mb-4">
                            <div style="background: #f9fbfd; border: 1px solid #e8eef5; border-radius: 12px; padding: 15px;">
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <i class="fas fa-map-marker-alt" style="color: #f5576c; margin-right: 10px;"></i>
                                    <strong style="color: #2d3748;">Lokasi Kepulangan</strong>
                                </div>
                                <div id="lokasi-text" style="color: #718096; font-size: 0.95rem;">
                                    Memuat lokasi Anda...
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="lokasi" id="lokasi">

                        <!-- SUBMIT BUTTON -->
                        <button type="submit" class="btn btn-pulang-large w-100" style="padding: 15px; font-size: 1.1rem; font-weight: 600;">
                            <i class="fas fa-check-circle"></i> Konfirmasi Absen Pulang
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- INFO SIDEBAR -->
        <div class="col-lg-4">
            <!-- SISWA INFO CARD -->
            <div class="card-custom p-4 mb-4">
                <h5 style="color: #2d3748; margin-bottom: 20px; font-weight: 700;">
                    <i class="fas fa-user"></i> Data Siswa
                </h5>
                <div class="siswa-info">
                    <div class="info-item">
                        <span class="info-label">Nama:</span>
                        <span class="info-value">{{ $siswa->nama ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">NIS:</span>
                        <span class="info-value">{{ $siswa->nis ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jurusan:</span>
                        <span class="info-value">{{ $siswa->jurusan ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tempat Magang:</span>
                        <span class="info-value">{{ $siswa->tempat_magang ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- TIPS CARD -->
            <div class="card-custom p-4">
                <h5 style="color: #2d3748; margin-bottom: 15px; font-weight: 700;">
                    <i class="fas fa-lightbulb"></i> Catatan
                </h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #f5576c; font-weight: bold; margin-right: 10px;">•</span>
                        Absen pulang hanya bisa dilakukan après absen masuk
                    </li>
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #f5576c; font-weight: bold; margin-right: 10px;">•</span>
                        Sistem akan menghitung durasi kerja Anda hari ini
                    </li>
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #f5576c; font-weight: bold; margin-right: 10px;">•</span>
                        Lokasi akan dicatat otomatis saat Anda melakukan absen pulang
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <style>
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

        .alert-warning {
            background: linear-gradient(135deg, #ffa500, #ff8c00);
            color: white;
            border-color: #ff8c00;
        }

        .status-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .status-item {
            display: flex;
            align-items: center;
            background: #f9fbfd;
            border: 1px solid #e8eef5;
            border-radius: 12px;
            padding: 15px;
        }

        .status-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .status-info {
            flex: 1;
        }

        .status-label {
            font-size: 0.85rem;
            color: #718096;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .status-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            font-family: 'Courier New', monospace;
        }

        .jam-display-wrapper {
            text-align: center;
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border: 1px solid #e8eef5;
            border-radius: 12px;
            padding: 30px;
        }

        .jam-display {
            text-align: center;
        }

        .siswa-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: #f9fbfd;
            border-radius: 8px;
            border-left: 3px solid #f5576c;
        }

        .info-label {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
        }

        .info-value {
            color: #f5576c;
            font-weight: 600;
            text-align: right;
        }

        .btn-pulang-large {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-pulang-large:hover {
            background: linear-gradient(135deg, #f5576c, #f093fb);
            box-shadow: 0 8px 24px rgba(245, 87, 108, 0.4);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
            color: white;
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
            .status-grid {
                grid-template-columns: 1fr;
            }

            .form-icon {
                width: 80px !important;
                height: 80px !important;
                font-size: 2rem !important;
            }
        }
    </style>

    <script>
        // Update jam real-time
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('jamDisplay').textContent = `${hours}:${minutes}:${seconds}`;
            document.getElementById('timeDate').textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            // Calculate durasi kerja
            @if($absenHariIni && !$absenHariIni->jam_pulang)
            const jamMasukStr = '{{ $absenHariIni->jam_masuk }}';
            const [jam, menit, detik] = jamMasukStr.split(':').map(Number);
            const jamMasuk = new Date();
            jamMasuk.setHours(jam, menit, detik);
            
            const durasiMs = now - jamMasuk;
            const durasiJam = Math.floor(durasiMs / (1000 * 60 * 60));
            const durasiMenit = Math.floor((durasiMs % (1000 * 60 * 60)) / (1000 * 60));
            const durasiDetik = Math.floor((durasiMs % (1000 * 60)) / 1000);
            
            const durasiText = `${durasiJam} jam ${durasiMenit} menit ${durasiDetik} detik`;
            document.getElementById('durasi-text').textContent = 'Durasi kerja: ' + durasiText;
            @endif
        }
        setInterval(updateTime, 1000);
        updateTime();

        // Get lokasi
        function getLokasi() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    document.getElementById('lokasi').value = `${lat},${lng}`;
                    document.getElementById('lokasi-text').textContent = `Latitude: ${lat.toFixed(4)}, Longitude: ${lng.toFixed(4)}`;
                }, function(error) {
                    document.getElementById('lokasi-text').textContent = 'Lokasi tidak dapat diakses';
                });
            }
        }
        getLokasi();
    </script>

@endsection
