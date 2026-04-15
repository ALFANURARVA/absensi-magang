@extends('layouts.user')

@section('breadcrumb', 'Dashboard')

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
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --light: #f9fafb;
            --border: #e5e7eb;
            --text: #374151;
            --text-muted: #6b7280;
        }

        /* PAGE HEADER */
        .header-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .greeting-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 10px;
        }

        .greeting-text i {
            color: var(--primary);
            margin-right: 10px;
        }

        .time-date {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        /* QUICK ACTIONS */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
        }

        .quick-action-btn {
            background: white;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .quick-action-btn i {
            font-size: 1.8rem;
        }

        .quick-action-btn:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(99, 102, 241, 0.15);
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
        }

        .quick-action-btn.masuk {
            border-color: var(--primary);
            color: var(--primary);
        }

        .quick-action-btn.pulang {
            border-color: var(--danger);
            color: var(--danger);
        }

        .quick-action-btn.pulang:hover {
            box-shadow: 0 12px 24px rgba(239, 68, 68, 0.15);
        }

        .quick-action-btn.laporan {
            border-color: var(--warning);
            color: var(--warning);
        }

        .quick-action-btn.laporan:hover {
            box-shadow: 0 12px 24px rgba(245, 158, 11, 0.15);
        }

        .quick-action-btn.profil {
            border-color: var(--success);
            color: var(--success);
        }

        .quick-action-btn.profil:hover {
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.15);
        }

        /* STATISTICS CARDS */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-box {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            padding: 30px 20px;
            color: white;
            text-align: center;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.2);
            transition: all 0.3s ease;
            border: none;
        }

        .stat-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(99, 102, 241, 0.35);
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
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-top: 20px;
        }

        .chart-title {
            color: var(--text);
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-title i {
            color: var(--primary);
        }

        /* ALERTS */
        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
            animation: slideDown 0.3s ease-out;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        /* EMPTY STATE */
        .empty-state-card {
            background: white;
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 60px 30px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
            color: var(--text);
            margin-bottom: 10px;
        }

        .empty-state-card p {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .tips-section {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
            border-left: 4px solid var(--primary);
            border-radius: 12px;
            padding: 25px;
            text-align: left;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
        }

        .tips-section p {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 15px;
        }

        .tips-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tips-section li {
            padding: 10px 0;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .tips-section li:before {
            content: "→";
            color: var(--primary);
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