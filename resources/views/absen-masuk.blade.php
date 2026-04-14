@extends('layouts.app')

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
            <i class="fas fa-sunrise"></i> Absen Masuk
        </div>
        <div class="time-date" id="timeDate">
            Memuat waktu...
        </div>
    </div>

    <div class="row g-4">
        <!-- MAIN ABSEN MASUK CARD -->
        <div class="col-lg-8">
            <div class="card-custom p-5">
                <div class="form-header" style="text-align: center; margin-bottom: 30px;">
                    <div class="form-icon" style="width: 100px; height: 100px; border-radius: 20px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 20px;">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <h2 style="color: #2d3748; margin-bottom: 10px;">Catat Waktu Kedatangan</h2>
                    <p style="color: #718096; font-size: 1.1rem;">Ambil foto dan catat jam masuk Anda hari ini</p>
                </div>

                @if($absenHariIni)
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> <strong>Anda sudah melakukan absen masuk hari ini</strong>
                        <br>
                        <small>Jam Masuk: <strong>{{ date('H:i', strtotime($absenHariIni->jam_masuk)) }}</strong> | 
                        Status: <strong>{{ $absenHariIni->status }}</strong></small>
                    </div>
                @else
                    <form action="{{ route('absen.masuk') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- FOTO PREVIEW -->
                        <div class="foto-preview-wrapper mb-4">
                            <div id="foto-preview" class="foto-preview" style="display: none;">
                                <img id="preview-img" src="" alt="Preview">
                                <button type="button" class="btn-remove" onclick="removeFoto()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div id="foto-input-area" class="foto-input-area">
                                <label for="foto-masuk" class="file-input-label-large">
                                    <div style="font-size: 3rem; color: #667eea;">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <span style="font-size: 1.1rem; font-weight: 600; color: #667eea;">Ambil atau Pilih Foto</span>
                                    <small style="color: #718096; display: block; margin-top: 10px;">Klik untuk membuka kamera atau pilih dari galeri</small>
                                </label>
                                <input type="file" id="foto-masuk" name="foto" accept="image/*" capture="environment" required>
                            </div>
                        </div>

                        @error('foto')
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror

                        <!-- JAM DISPLAY -->
                        <div class="jam-display-wrapper mb-4">
                            <div class="jam-display">
                                <div style="font-size: 3rem; font-weight: 700; color: #667eea; font-family: 'Courier New', monospace;" id="jamDisplay">
                                    00:00:00
                                </div>
                                <div style="color: #718096; font-size: 0.9rem; margin-top: 5px;">Jam Masuk</div>
                            </div>
                        </div>

                        <!-- LOKASI DISPLAY -->
                        <div class="lokasi-display mb-4">
                            <div style="background: #f9fbfd; border: 1px solid #e8eef5; border-radius: 12px; padding: 15px;">
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <i class="fas fa-map-marker-alt" style="color: #667eea; margin-right: 10px;"></i>
                                    <strong style="color: #2d3748;">Lokasi</strong>
                                </div>
                                <div id="lokasi-text" style="color: #718096; font-size: 0.95rem;">
                                    Memuat lokasi Anda...
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="lokasi" id="lokasi">

                        <!-- SUBMIT BUTTON -->
                        <button type="submit" class="btn btn-masuk-large w-100" style="padding: 15px; font-size: 1.1rem; font-weight: 600;">
                            <i class="fas fa-check-circle"></i> Konfirmasi Absen Masuk
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
                    <i class="fas fa-lightbulb"></i> Tips
                </h5>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #43e97b; font-weight: bold; margin-right: 10px;">✓</span>
                        Pastikan pencahayaan cukup untuk hasil foto yang baik
                    </li>
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #43e97b; font-weight: bold; margin-right: 10px;">✓</span>
                        Gunakan kamera depan untuk selfie atau belakang untuk foto lingkungan
                    </li>
                    <li style="padding: 10px 0; color: #718096; display: flex; align-items: flex-start;">
                        <span style="color: #43e97b; font-weight: bold; margin-right: 10px;">✓</span>
                        Sistem akan otomatis mendeteksi waktu dan lokasi Anda
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

        .alert-info {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            border-color: #00f2fe;
        }

        .foto-preview-wrapper {
            position: relative;
        }

        .foto-preview {
            position: relative;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            background: #f9fbfd;
        }

        .foto-preview img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        .btn-remove {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #f5576c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-remove:hover {
            background: #e63946;
            transform: scale(1.1);
        }

        .foto-input-area {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            border: 2px dashed #667eea;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .foto-input-area:hover {
            border-color: #764ba2;
            background: linear-gradient(135deg, #eff0f7 0%, #e9ecef 100%);
        }

        .file-input-label-large {
            cursor: pointer;
            display: block;
        }

        #foto-masuk {
            display: none;
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
            border-left: 3px solid #667eea;
        }

        .info-label {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
        }

        .info-value {
            color: #667eea;
            font-weight: 600;
            text-align: right;
        }

        .btn-masuk-large {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-masuk-large:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
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
            .foto-preview img {
                height: 250px;
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
        }
        setInterval(updateTime, 1000);
        updateTime();

        // Preview foto
        document.getElementById('foto-masuk').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('preview-img').src = event.target.result;
                    document.getElementById('foto-preview').style.display = 'block';
                    document.getElementById('foto-input-area').style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });

        function removeFoto() {
            document.getElementById('foto-masuk').value = '';
            document.getElementById('foto-preview').style.display = 'none';
            document.getElementById('foto-input-area').style.display = 'block';
        }

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
