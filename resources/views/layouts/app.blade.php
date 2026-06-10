<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FSB') - BPRS Internal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #2563eb; /* Royal Blue */
            --bg-body: #f1f5f9; /* Slate 100 */
            --text-dark: #1e293b; /* Slate 800 */
            --text-muted: #64748b; /* Slate 500 */
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            background: #0f172a; /* Slate 900 */
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 50;
            transition: all 0.3s;
            overflow-y: auto; /* Agar bisa discroll jika menu banyak */
        }
        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem; /* Sesuaikan padding */
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .nav-link {
            color: #94a3b8;
            padding: 0.8rem 1.5rem;
            font-weight: 500;
            display: flex; align-items: center;
            transition: 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.05);
            border-right: 3px solid var(--primary);
        }
        .sidebar .nav-link i { width: 24px; text-align: center; margin-right: 10px; }
        .sidebar .nav-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            padding: 1.5rem 1.5rem 0.5rem;
            font-weight: 700;
        }

        /* Sidebar Overlay untuk Mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 45;
            display: none; /* Hidden by default */
        }
        body.sidebar-toggled .sidebar-overlay {
            display: block; /* Show when sidebar is toggled */
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
            transition: all 0.3s;
        }
        .top-navbar {
            background: white;
            height: 70px;
            padding: 0 2rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            position: sticky; top: 0; z-index: 40;
        }

        /* Hamburger menu button */
        .sidebar-toggle {
            display: none; /* Hidden by default, only show on mobile */
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
            padding: 0;
            margin-right: 1rem;
        }
        .top-navbar .user-info {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            position: sticky; top: 0; z-index: 40;
        }

        .content-wrapper { padding: 2rem; }

        /* --- COMPONENTS --- */
        .page-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem;
        }
        .page-title {
            font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin: 0;
            letter-spacing: -0.025em;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            background: white;
            overflow: hidden;
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
        }
        .form-control, .form-select {
            padding: 0.6rem 1rem;
            border-color: #e2e8f0;
            border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .btn { padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 500; }
        .btn-primary { background: var(--primary); border: none; }
        .btn-primary:hover { background: #1d4ed8; }

        /* KUSTOMISASI PAGINATION AGAR MODERN */
    .page-item.active .page-link {
        background-color: #2563eb !important; /* Warna Primary Aplikasi */
        border-color: #2563eb !important;
        color: white !important;
        font-weight: bold;
    }
    .page-link {
        color: #2563eb;
        border: 1px solid #dee2e6;
        margin: 0 2px;
        border-radius: 5px; /* Membuat kotak agak tumpul (modern) */
    }
    .page-link:hover {
        color: #1d4ed8;
        background-color: #eff6ff;
    }
    .page-link:focus {
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
    }
    </style>

    <style>
        /* Mobile Responsiveness */
        @media (max-width: 991.98px) { /* Bootstrap's 'lg' breakpoint */
            .sidebar {
                left: calc(-1 * var(--sidebar-width)); /* Hide sidebar off-screen */
            }
            .main-content {
                margin-left: 0; /* Main content takes full width */
            }
            .sidebar-toggle {
                display: block; /* Show hamburger menu */
            }
            body.sidebar-toggled .sidebar {
                left: 0; /* Show sidebar */
            }
            body.sidebar-toggled .main-content {
                /* Optional: push content to the right, or keep it full width and let overlay handle it */
                /* transform: translateX(var(--sidebar-width)); */
            }
            .top-navbar {
                padding: 0 1rem; /* Adjust padding for smaller screens */
            }
            .top-navbar .d-none.d-md-block { display: none !important; } /* Hide user info on small screens */
        }
    </style>
</head>
<body class="">

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-layer-group me-2 text-primary"></i> FSB
        </div>
        <nav class="nav flex-column mt-2">
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('assets.index') }}" class="nav-link {{ request()->routeIs('assets.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Inventaris
            </a>

            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'ga')
            <div class="nav-label">Master Data</div>
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="{{ route('rooms.index') }}" class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i> Ruangan
            </a>
            <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <i class="fas fa-id-card-alt"></i> Data Pegawai
            </a>
            @endif
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'ga')
            <div class="nav-label">Administrasi</div>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> Manajemen User
            </a>
            @endif
            
            <div class="nav-label">Laporan</div>
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'ga')
            <div class="nav-label">Audit & Opname</div>
            
            <a href="{{ route('audits.index') }}" class="nav-link {{ request()->routeIs('audits.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i> Stock Opname
            </a>
            @endif
            <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Laporan Aset
            </a>
        </nav>
    </aside>

    <div class="main-content" id="main-content">
        <header class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="text-muted small">Sistem Informasi Aset Terpadu</span>
            </div>
            <div class="dropdown user-info">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="fw-bold small">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 11px; text-transform:uppercase;">{{ Auth::user()->role }}</div>
                    </div>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const body = document.body;

            sidebarToggle.addEventListener('click', function () {
                body.classList.toggle('sidebar-toggled');
            });

            sidebarOverlay.addEventListener('click', function () {
                body.classList.remove('sidebar-toggled');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>