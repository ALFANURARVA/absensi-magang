<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Absen Magang')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            color: #333;
        }

        .main-container {
            display: flex;
            flex: 1;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .content-area {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .header-section {
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #e8eef5;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
        }

        .greeting-text {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .time-date {
            color: #6c757d;
            font-size: 1rem;
        }16px;
            border: 1px solid #e8eef5;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            height: 100%;
        }

        .card-custom:hover {
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
            transform: translateY(-4px);
        }

        .card-custom:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1
        .card-header-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .icon-masuk {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .icon-pulang {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }

        .icon-laporan {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }

        .btn-masuk {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-masuk:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-pulang {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }

        .btn-pulang:hover {
            background: linear-gradient(135deg, #f5576c, #f093fb);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
        }

        .btn-laporan {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }

        .btn-laporan:hover {
            background: linear-gradient(135deg, #00f2fe, #4facfe);
            color: white;
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
        }

        .card-title {
            font-weight: 700;
            color: #2d3748;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .card-description {
         btn-custom {
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
            cursor: pointer
        .file-input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .file-input-label {
            display: inline-block;
            padding: 15px 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px dashed #667eea;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
            font-weight: 600;
            color: #667eea;
        }

        .file-input-label:hover {
            background: linear-gradient(135deg, #edf2f7 0%, #dfdfdf 100%);
            border-color: #764ba2;
            color: #764ba2;
        }

        .file-input-label i {
            margin-right: 8px;
        }

        input[type="file"] {
            display: none;
        }

        /* Enhanced form styling */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea,
        select {
            border: 1px solid #e8eef5;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .chart-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
            border: 1px solid #e8eef5;
            margin-top: 30px;
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            border-bottom: 3px solid;
            border-image: linear-gradient(90deg, #667eea, #764ba2) 1;
            padding-bottom: 12px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-box {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radiu#f8f9fa;
            color: #2c3e50;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e0e0e0 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .stat-number {
        }

        @media (max-width: 768px) {
            .greeting-text {
                font-size: 1.8rem;
            }

            .header-section {
                padding: 20px;
            }

            .card-custom {
                margin-bottom: 20px;
            }

            .content-area {
                padding: 15px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-section {
            animation: fadeInUp 0.6s ease-out;
        }

        .card-custom {
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-box {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
    @yield('css')
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="main-container">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-area">
                <div class="container-main">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd.min.js"></script>
    <script>
        // Get current time and date
        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const day = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const time = now.toLocaleTimeString('id-ID');
            
            const dateString = `${day}, ${date} ${month} ${year} • ${time}`;
            
            const timeEl = document.getElementById('timeDate');
            if (timeEl) {
                timeEl.textContent = dateString;
            }
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lokasiEl = document.getElementById('lokasi');
                if (lokasiEl) {
                    lokasiEl.value = position.coords.latitude + ',' + position.coords.longitude;
                }
            });
        }

        // File input label update
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const label = this.nextElementSibling;
                if (label && this.files && this.files[0]) {
                    label.textContent = this.files[0].name;
                }
            });
        });
    </script>
    @yield('js')
</body>

</html>