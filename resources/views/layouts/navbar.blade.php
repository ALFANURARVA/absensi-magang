<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-clipboard-check"></i> Absen Magang
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        {{ Auth::check() ? Auth::user()->name : 'Profil' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('user') }}"><i class="fas fa-user"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('siswa.edit') }}"><i class="fas fa-edit"></i> Edit Data</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-custom {
        background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
        border-bottom: 2px solid #e8eef5;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.08);
        padding: 15px 0;
        width: 100%;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-decoration: none;
    }

    .navbar-brand:hover {
        opacity: 0.8;
    }

    .navbar-brand i {
        margin-right: 8px;
    }

    .nav-link {
        color: #555 !important;
        font-weight: 600;
        transition: all 0.3s ease;
        padding: 8px 16px !important;
    }

    .nav-link:hover {
        color: #667eea !important;
    }

    .dropdown-menu {
        border: 1px solid #e8eef5;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        border-radius: 10px;
    }

    .dropdown-item {
        color: #555;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .dropdown-item i {
        margin-right: 8px;
        min-width: 20px;
    }
</style>
