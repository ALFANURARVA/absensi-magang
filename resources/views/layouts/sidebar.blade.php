<aside class="sidebar">
    <div class="sidebar-header">
        <h5>Menu</h5>
        <button class="btn-close-sidebar" id="closeSidebar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user') }}" class="nav-link {{ request()->routeIs('user') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('siswa.edit') }}" class="nav-link {{ request()->routeIs('siswa.edit') ? 'active' : '' }}">
                    <i class="fas fa-edit"></i>
                    <span>Edit Data</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('absen.show-masuk') }}" class="nav-link {{ request()->routeIs('absen.show-masuk') ? 'active' : '' }}">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Absen Masuk</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('absen.show-pulang') }}" class="nav-link {{ request()->routeIs('absen.show-pulang') ? 'active' : '' }}">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Absen Pulang</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('laporan') }}" class="nav-link {{ request()->routeIs('laporan') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('riwayat') }}" class="nav-link {{ request()->routeIs('riwayat') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Riwayat</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<button class="btn-toggle-sidebar" id="toggleSidebar">
    <i class="fas fa-bars"></i>
</button>

<style>
    .sidebar {
        width: 260px;
        background: linear-gradient(180deg, #ffffff 0%, #f9fbfd 100%);
        border-right: 1px solid #e8eef5;
        box-shadow: 2px 0 8px rgba(102, 126, 234, 0.08);
        padding: 20px 0;
        height: calc(100% - 70px);
        overflow-y: auto;
        transition: all 0.3s ease;
        position: relative;
    }

    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #e8eef5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .sidebar-header h5 {
        margin: 0;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.2rem;
    }

    .btn-close-sidebar {
        display: none;
        background: none;
        border: none;
        color: #667eea;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-close-sidebar:hover {
        color: #764ba2;
    }

    .sidebar-nav {
        padding: 10px 0;
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin: 5px 0;
        padding: 0 10px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #666;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 500;
        margin: 0 10px;
    }

    .nav-link:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        color: #667eea;
        transform: translateX(4px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        font-weight: 600;
    }

    .nav-link i {
        margin-right: 12px;
        min-width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    .nav-link span {
        flex: 1;
    }

    .btn-toggle-sidebar {
        display: none;
        position: fixed;
        top: 80px;
        left: 20px;linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 10px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
    }

    .btn-toggle-sidebar:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.5)
    .btn-toggle-sidebar:hover {
        background: #2c3e50;
    }

    /* Scrollbar Styling */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }
transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #667eea, #764ba2);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        opacity: 0.8
    .sidebar::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            height: calc(100vh - 70px);
            width: 260px;
            z-index: 1000;
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .btn-close-sidebar {
            display: block;
        }

        .btn-toggle-sidebar {
            display: flex;
        }

        .content-area {
            margin-left: 0 !important;
        }

        .sidebar.active ~ .content-wrapper {
            filter: brightness(0.8);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        const sidebar = document.querySelector('.sidebar');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                sidebar.classList.remove('active');
            });
        }

        // Close sidebar when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                }
            });
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    });
</script>
