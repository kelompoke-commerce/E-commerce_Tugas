<!DOCTYPE html>
<html lang="id">
<link rel="icon" type="image/png" href="{{ asset('favicon.jpeg') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Menu') — Libas Street Coffee</title>
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
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #faf7f4; }

        /* Navbar */
        .navbar-coffee {
            background: var(--coffee-dark) !important;
            padding: .75rem 0;
        }
        .navbar-coffee .navbar-brand { color: var(--coffee-light) !important; font-weight: 800; font-size: 1.1rem; }
        .navbar-coffee .nav-link { color: rgba(255,255,255,.8) !important; font-weight: 500; font-size: .875rem; }
        .navbar-coffee .nav-link:hover,
        .navbar-coffee .nav-link.active { color: var(--coffee-light) !important; }
        .cart-badge { background: #e63946; color: #fff; font-size: .65rem; border-radius: 50%;
                      padding: 2px 6px; font-weight: 700; position: relative; top: -8px; left: -6px; }

        /* Product cards */
        .product-card { border: none; border-radius: 16px; overflow: hidden;
                        box-shadow: 0 2px 12px rgba(0,0,0,.06); transition: transform .2s, box-shadow .2s; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
        .product-card .card-img-top { height: 180px; object-fit: cover; }
        .product-card .badge-category { background: var(--coffee-warm); color: var(--coffee-brown);
                                         font-size: .7rem; font-weight: 700; border-radius: 6px; padding: .2rem .6rem; }
        .product-card .price { color: var(--coffee-brown); font-size: 1.1rem; font-weight: 800; }
        .btn-add-cart { background: var(--coffee-brown); color: #fff; border: none; border-radius: 10px;
                        font-weight: 600; font-size: .875rem; transition: background .2s; }
        .btn-add-cart:hover { background: var(--coffee-dark); color: #fff; }

        /* Category pills */
        .category-pill { display: inline-flex; align-items: center; gap: .4rem;
                         padding: .5rem 1rem; border-radius: 50px; font-size: .85rem; font-weight: 600;
                         background: #fff; border: 2px solid #e0d5cc; color: #666; text-decoration: none;
                         transition: all .2s; }
        .category-pill:hover, .category-pill.active {
            background: var(--coffee-brown); border-color: var(--coffee-brown); color: #fff;
        }

        /* Footer */
        .footer { background: var(--coffee-dark); color: rgba(255,255,255,.7); padding: 2rem 0; margin-top: 4rem; }
        .footer .footer-brand { color: var(--coffee-light); font-size: 1.1rem; font-weight: 800; }

        .card { border: none; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
        .btn { border-radius: 10px; font-weight: 600; }
        .form-control, .form-select { border-radius: 10px; border-color: #e0d5cc; }
        .form-control:focus, .form-select:focus {
            border-color: var(--coffee-medium); box-shadow: 0 0 0 .2rem rgba(111,61,30,.15);
        }
        .alert { border-radius: 12px; border: none; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-coffee navbar-expand-lg sticky-top">
    <div class="container">
        <a href="#" class="navbar-brand text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('images/libaslogo2.jpeg') }}" alt="Libas Street Coffee"
            style="height:36px;width:36px;mix-blend-mode:screen;border-radius:50%">
            <div>
                <div style="line-height:1.1">Libas Street Coffee</div>
                <div style="font-size:.6rem;opacity:.5;letter-spacing:2px;font-weight:400">EST. 2025</div>
            </div>
        </a>

        <div class="d-flex align-items-center gap-3 order-lg-2">
            <a href="{{ route('customer.cart') }}" class="nav-link position-relative">
                <i class="bi bi-bag" style="font-size:1.3rem;color:rgba(255,255,255,.8)"></i>
                @php $cartCount = auth()->user()->carts()->count(); @endphp
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>

            <div class="dropdown">
                <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-2 py-1"
                        data-bs-toggle="dropdown" style="border-radius:20px;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                         style="width:28px;height:28px;background:var(--coffee-brown);font-size:.75rem;font-weight:700;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="d-none d-lg-inline fw-600 small">{{ Str::words(auth()->user()->name, 1, '') }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:12px;min-width:180px;">
                    <li><span class="dropdown-item-text small fw-600">{{ auth()->user()->name }}</span></li>
                    <li><span class="dropdown-item-text small text-muted" style="margin-top:-8px">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item" href="{{ route('customer.profile') }}"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                    <li><a class="dropdown-item" href="{{ route('customer.orders.history') }}"><i class="bi bi-bag me-2"></i>Pesanan Saya</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-left me-2"></i>Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>

            <button class="navbar-toggler border-0 text-white p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto ms-3 gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
                       href="{{ route('customer.dashboard') }}">
                        <i class="bi bi-house me-1"></i>Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}"
                       href="{{ route('customer.orders.history') }}">
                        <i class="bi bi-clock-history me-1"></i>Riwayat
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}"
                       href="{{ route('customer.profile') }}">
                        <i class="bi bi-person me-1"></i>Profil
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="footer-brand mb-1">Libas Street Coffee</div>
                <small>Nikmati setiap tegukan, rasakan perbedaannya.</small>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <small>© {{ date('Y') }} Libas Street Coffee. All rights reserved.</small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
