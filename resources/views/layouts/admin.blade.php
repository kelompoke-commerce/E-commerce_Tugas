<!DOCTYPE html>
<html lang="id">
<link rel="icon" type="image/png" href="{{ asset('favicon.jpeg') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Libas Street Coffee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        :root {
            --coffee-dark: #1a0a00;
            --coffee-brown: #6f3d1e;
            --coffee-medium: #a0522d;
            --coffee-light: #d4a373;
            --coffee-cream: #fefae0;
            --coffee-warm: #faedcd;
            --sidebar-width: 260px;
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #f5f0eb; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-width); height: 100vh;
            background: linear-gradient(180deg, var(--coffee-dark) 0%, #2d1200 100%);
            z-index: 1000; overflow-y: auto; transition: transform .3s ease;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .sidebar-brand .logo-text { font-size: 1.1rem; font-weight: 800; color: var(--coffee-light); line-height: 1.2; }
        .sidebar-brand .logo-sub  { font-size: .7rem; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: 2px; }
        .sidebar-nav { padding: 1rem 0; }
        .nav-section-label {
            padding: .5rem 1.25rem .25rem;
            font-size: .65rem; font-weight: 700; color: rgba(255,255,255,.3);
            text-transform: uppercase; letter-spacing: 1.5px;
        }
        .sidebar .nav-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem 1.25rem; color: rgba(255,255,255,.7);
            border-radius: 0; transition: all .2s; font-size: .875rem; font-weight: 500;
            text-decoration: none; border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff; background: rgba(255,255,255,.08);
            border-left-color: var(--coffee-light);
        }
        .sidebar .nav-link .bi { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar .badge-pill { margin-left: auto; }

        /* Main */
        .main-wrapper { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar {
            background: #fff; border-bottom: 1px solid #e8e0d8;
            padding: .875rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 900;
        }
        .topbar .page-title { font-size: 1.1rem; font-weight: 700; color: var(--coffee-dark); margin: 0; }
        .page-content { padding: 1.5rem; }

        /* Cards */
        .card { border: none; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
        .stat-card { border-radius: 16px; padding: 1.25rem; color: #fff; position: relative; overflow: hidden; }
        .stat-card .stat-icon { font-size: 2.5rem; opacity: .25; position: absolute; right: 1rem; top: 1rem; }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 800; }
        .stat-card .stat-label { font-size: .8rem; opacity: .85; }

        .bg-coffee-1 { background: linear-gradient(135deg,#6f3d1e,#a0522d); }
        .bg-coffee-2 { background: linear-gradient(135deg,#2c6e49,#52b788); }
        .bg-coffee-3 { background: linear-gradient(135deg,#1d3557,#457b9d); }
        .bg-coffee-4 { background: linear-gradient(135deg,#7b2d8b,#b05cbb); }

        .table th { font-size: .78rem; font-weight: 700; text-transform: uppercase;
                    letter-spacing: .5px; color: #888; border-top: none; }
        .table td { vertical-align: middle; font-size: .875rem; }
        .btn { border-radius: 10px; font-weight: 600; font-size: .875rem; }
        .btn-coffee { background: var(--coffee-brown); color: #fff; border: none; }
        .btn-coffee:hover { background: var(--coffee-dark); color: #fff; }
        .form-control, .form-select { border-radius: 10px; border-color: #e0d5cc; }
        .form-control:focus, .form-select:focus { border-color: var(--coffee-medium); box-shadow: 0 0 0 .2rem rgba(111,61,30,.15); }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2 mb-1">
            <div>
            <img src="{{ asset('images/libaslogo2.jpeg') }}" alt="Libas Street Coffee"
                style="height:50px;width:50px;mix-blend-mode:screen;border-radius:50%">
                <div class="logo-text">Libas Street Coffee</div>
                <div class="logo-sub">Admin Panel</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-label mt-2">Katalog</div>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Produk
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori
        </a>

        <div class="nav-section-label mt-2">Transaksi</div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Pesanan
            @php $pending = \App\Models\Order::where('status','pending')->count(); @endphp
            @if($pending > 0)
                <span class="badge bg-warning text-dark badge-pill">{{ $pending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.orders.recap') }}" class="nav-link {{ request()->routeIs('admin.orders.recap') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Rekap Bulanan
        </a>

        <div class="nav-section-label mt-2">Manajemen</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Kelola Akun
        </a>

        <div class="nav-section-label mt-2">Akun</div>
        <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link w-100 border-0 text-start" style="background:none;cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </nav>
</aside>

{{-- Main --}}
<div class="main-wrapper">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small d-none d-md-inline">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <div class="rounded-circle bg-coffee-1 d-flex align-items-center justify-content-center text-white"
                         style="width:32px;height:32px;font-size:.8rem;font-weight:700;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="d-none d-md-inline fw-600">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:12px;">
                    <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-left me-2"></i>Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
