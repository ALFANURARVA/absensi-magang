@extends('layouts.app')

@section('content')

    <!-- HEADER SECTION -->
    <div class="header-section">
        <div class="greeting-text">
            <i class="fas fa-user-circle"></i> Profil Pengguna
        </div>
        <div class="time-date" id="timeDate">
            Memuat waktu...
        </div>
    </div>

    <div class="row g-4">
        <!-- PROFILE CARD -->
        <div class="col-lg-4">
            <div class="card-custom p-5">
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); color: white; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 20px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 style="color: #2d3748; margin-bottom: 5px;">{{ $siswa->nama ?? 'N/A' }}</h3>
                    <small style="color: #718096;">{{ $siswa->nis ?? 'N/A' }}</small>
                </div>

                <div style="background: #f9fbfd; border-radius: 12px; padding: 20px;">
                    <div class="profile-info-item">
                        <span class="profile-label">NIS</span>
                        <span class="profile-value">{{ $siswa->nis ?? '-' }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-label">Jurusan</span>
                        <span class="profile-value">{{ $siswa->jurusan ?? '-' }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-label">Tempat Magang</span>
                        <span class="profile-value">{{ $siswa->tempat_magang ?? '-' }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-label">Terdaftar Sejak</span>
                        <span class="profile-value">{{ date('d M Y', strtotime($siswa->created_at)) ?? '-' }}</span>
                    </div>
                </div>

                <a href="{{ route('siswa.edit') }}" class="btn btn-primary w-100" style="margin-top: 20px; padding: 12px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; text-decoration: none; border-radius: 12px; border: none; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
            </div>
        </div>

        <!-- ATTENDANCE STATISTICS -->
        <div class="col-lg-8">
            <!-- MAIN STATS -->
            <div class="card-custom p-5 mb-4">
                <h4 style="color: #2d3748; margin-bottom: 25px; font-weight: 700;">
                    <i class="fas fa-chart-pie"></i> Statistik Kehadiran
                </h4>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $hadir }}</div>
                            <div class="stat-text">Hadir</div>
                            <div class="stat-percentage" style="color: #667eea;">{{ $total > 0 ? round(($hadir/$total)*100) : 0 }}%</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $terlambat }}</div>
                            <div class="stat-text">Terlambat</div>
                            <div class="stat-percentage" style="color: #f5576c;">{{ $total > 0 ? round(($terlambat/$total)*100) : 0 }}%</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $izin }}</div>
                            <div class="stat-text">Izin</div>
                            <div class="stat-percentage" style="color: #4facfe;">{{ $total > 0 ? round(($izin/$total)*100) : 0 }}%</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $total }}</div>
                            <div class="stat-text">Total</div>
                            <div class="stat-percentage" style="color: #43e97b;">100%</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ATTENDANCE PERCENTAGE -->
            <div class="card-custom p-5">
                <h4 style="color: #2d3748; margin-bottom: 20px; font-weight: 700;">
                    <i class="fas fa-percentage"></i> Tingkat Kehadiran
                </h4>

                <div style="margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="color: #2d3748; font-weight: 600;">Persentase Kehadiran</span>
                        <span style="color: #667eea; font-weight: 700; font-size: 1.5rem;">
                            {{ $total > 0 ? round(($hadir/$total)*100) : 0 }}%
                        </span>
                    </div>
                    <div style="width: 100%; background: #e8eef5; border-radius: 10px; height: 20px; overflow: hidden;">
                        <div style="width: {{ $total > 0 ? round(($hadir/$total)*100) : 0 }}%; background: linear-gradient(135deg, #667eea, #764ba2); height: 100%; border-radius: 10px; transition: width 0.3s ease;"></div>
                    </div>
                </div>

                <div class="attendance-description">
                    @if($total == 0)
                        <p style="color: #718096; text-align: center;">
                            <i class="fas fa-inbox"></i><br>
                            Belum ada data absensi. Mulai lakukan absensi hari ini!
                        </p>
                    @else
                        <div style="background: #f9fbfd; border-left: 4px solid #667eea; border-radius: 8px; padding: 15px;">
                            <p style="color: #2d3748; margin-bottom: 10px; font-weight: 600;">
                                <i class="fas fa-info-circle"></i> Keterangan Kehadiran
                            </p>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @if($persentase >= 90)
                                    <li style="color: #43e97b; font-weight: 600; margin-bottom: 5px;">
                                        ✓ Kehadiran Sangat Baik (≥ 90%)
                                    </li>
                                @elseif($persentase >= 75)
                                    <li style="color: #667eea; font-weight: 600; margin-bottom: 5px;">
                                        ✓ Kehadiran Baik (75% - 89%)
                                    </li>
                                @elseif($persentase >= 60)
                                    <li style="color: #ffa500; font-weight: 600; margin-bottom: 5px;">
                                        ⚠ Kehadiran Cukup (60% - 74%)
                                    </li>
                                @else
                                    <li style="color: #f5576c; font-weight: 600; margin-bottom: 5px;">
                                        ✗ Kehadiran Kurang (< 60%)
                                    </li>
                                @endif

                                <li style="color: #718096; margin-top: 10px; font-size: 0.9rem;">
                                    Dari {{ $total }} total absensi:
                                    <br>• Hadir: {{ $hadir }} kali
                                    <br>• Terlambat: {{ $terlambat }} kali
                                    <br>• Izin: {{ $izin }} kali
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e8eef5;
        }

        .profile-info-item:last-child {
            border-bottom: none;
        }

        .profile-label {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
        }

        .profile-value {
            color: #667eea;
            font-weight: 600;
            text-align: right;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #f5f7fa, #e9ecef);
            border: 1px solid #e8eef5;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
        }

        .stat-text {
            font-size: 0.9rem;
            color: #718096;
            margin-bottom: 5px;
        }

        .stat-percentage {
            font-size: 1.1rem;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .profile-value {
                text-align: right;
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
        setInterval(updateTime, 1000);
        updateTime();
    </script>

@endsection
