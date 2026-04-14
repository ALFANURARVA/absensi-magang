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
            <i class="fas fa-wave-hand"></i> Selamat Datang, {{ $siswa->nama ?? 'Pengguna' }}!
        </div>
        <div class="time-date" id="timeDate">
            Memuat waktu...
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="quick-actions">
        <a href="{{ route('absen.show-masuk') }}" class="quick-action-btn masuk">
            <i class="fas fa-sign-in-alt"></i>
            <span>Absen Masuk</span>
        </a>
        <a href="{{ route('absen.show-pulang') }}" class="quick-action-btn pulang">
            <i class="fas fa-sign-out-alt"></i>
            <span>Absen Pulang</span>
        </a>
        <a href="{{ route('laporan') }}" class="quick-action-btn laporan">
            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>
        <a href="{{ route('user') }}" class="quick-action-btn profil">
            <i class="fas fa-user-circle"></i>
            <span>Profil</span>
        </a>
    </div>

    <!-- STATISTICS CARDS -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-number">{{ $hadir }}</div>
            <div class="stat-label">Hadir</div>
        </div>
        <div class="stat-box" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
            <div class="stat-number">{{ $terlambat }}</div>
            <div class="stat-label">Terlambat</div>
        </div>
        <div class="stat-box" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <div class="stat-number">{{ $izin }}</div>
            <div class="stat-label">Izin</div>
        </div>
        <div class="stat-box" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
            <div class="stat-number">{{ $persentase == 0 && $hadir == 0 ? '-' : $persentase }}{{ $persentase != 0 || $hadir != 0 ? '%' : '' }}</div>
            <div class="stat-label">Tingkat Kehadiran</div>
        </div>
    </div>

    <!-- EMPTY STATE OR CHART SECTION -->
    @if($hadir + $terlambat + $izin == 0)
        <div class="empty-state-card">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h4>Belum Ada Data Absensi</h4>
            <p>Mulai lakukan absensi hari ini untuk melihat statistik Anda</p>
            <div class="tips-section">
                <p><strong>💡 Tips:</strong></p>
                <ul>
                    <li>Klik tombol "Absen Masuk" saat tiba di tempat magang</li>
                    <li>Klik tombol "Absen Pulang" saat meninggalkan tempat magang</li>
                    <li>Data absensi Anda akan muncul di sini setelah selesai</li>
                </ul>
            </div>
        </div>
    @else
        <div class="chart-card">
            <h3 class="chart-title">
                <i class="fas fa-chart-bar"></i> Statistik Kehadiran
            </h3>
            <div style="position: relative; height: 300px;">
                <canvas id="chart"></canvas>
            </div>
        </div>
    @endif

    <style>
        /* QUICK ACTIONS */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
        }

        .quick-action-btn {
            background: linear-gradient(135deg, #f5f7fa, #e9ecef);
            border: 2px solid #e8eef5;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: #667eea;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .quick-action-btn i {
            font-size: 1.8rem;
        }

        .quick-action-btn:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .quick-action-btn.masuk {
            border-color: #667eea;
            color: #667eea;
        }

        .quick-action-btn.masuk:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        }

        .quick-action-btn.pulang {
            border-color: #f5576c;
            color: #f5576c;
        }

        .quick-action-btn.pulang:hover {
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.1), rgba(245, 87, 108, 0.1));
        }

        .quick-action-btn.laporan {
            border-color: #4facfe;
            color: #4facfe;
        }

        .quick-action-btn.laporan:hover {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1), rgba(0, 242, 254, 0.1));
        }

        .quick-action-btn.profil {
            border-color: #43e97b;
            color: #43e97b;
        }

        .quick-action-btn.profil:hover {
            background: linear-gradient(135deg, rgba(67, 233, 123, 0.1), rgba(56, 249, 215, 0.1));
        }

        /* STATISTICS CARDS */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-box {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 16px;
            padding: 30px 20px;
            color: white;
            text-align: center;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .stat-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.35);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 0.95rem;
            font-weight: 600;
            opacity: 0.95;
        }

        /* CHART CARD */
        .chart-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
            border: 1px solid #e8eef5;
            margin-top: 20px;
        }

        .chart-title {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-title i {
            color: #667eea;
        }

        /* ALERTS */
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

        /* EMPTY STATE */
        .empty-state-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border: 2px dashed #e8eef5;
            border-radius: 16px;
            padding: 60px 30px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
            margin-top: 20px;
        }

        .empty-icon {
            font-size: 5rem;
            color: #cbd5e0;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        .empty-state-card h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .empty-state-card p {
            color: #718096;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .tips-section {
            background: white;
            border-left: 4px solid #667eea;
            border-radius: 12px;
            padding: 25px;
            text-align: left;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .tips-section p {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
        }

        .tips-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tips-section li {
            padding: 10px 0;
            color: #718096;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .tips-section li:before {
            content: "→";
            color: #667eea;
            font-weight: bold;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* ANIMATIONS */
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

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .quick-action-btn {
                padding: 15px;
                font-size: 0.85rem;
            }

            .quick-action-btn i {
                font-size: 1.5rem;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .empty-state-card {
                padding: 40px 20px;
            }

            .tips-section {
                max-width: 100%;
            }
        }
    </style>

    <script>
        // Update waktu real-time
        function updateTime() {
            const now = new Date();
            document.getElementById('timeDate').textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        setInterval(updateTime, 1000);
        updateTime();

        // Chart - only render if there's data
        @if($hadir + $terlambat + $izin > 0)
        const chartCtx = document.getElementById("chart");
        if (chartCtx) {
            new Chart(chartCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Terlambat', 'Izin'],
                    datasets: [{
                        label: 'Statistik Kehadiran',
                        data: [{{ $hadir }}, {{ $terlambat }}, {{ $izin }}],
                        backgroundColor: [
                            'rgba(102, 126, 234, 0.8)',
                            'rgba(240, 147, 251, 0.8)',
                            'rgba(79, 172, 254, 0.8)'
                        ],
                        borderColor: [
                            'rgba(102, 126, 234, 1)',
                            'rgba(240, 147, 251, 1)',
                            'rgba(79, 172, 254, 1)'
                        ],
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 13,
                                    weight: '600'
                                },
                                color: '#2d3748',
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
        @endif
    </script>

@endsection