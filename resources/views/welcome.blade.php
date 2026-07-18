<!DOCTYPE html>
<html lang="id">
<link rel="icon" type="image/png" href="{{ asset('favicon.jpeg') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libas Street Coffee — Nikmati Setiap Tegukan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        :root {
            --coffee-dark: #1a0a00; --coffee-brown: #6f3d1e;
            --coffee-light: #d4a373; --coffee-cream: #fefae0;
        }
        body { overflow-x: hidden; }
        /* Navbar */
        .navbar-landing { background: rgba(26,10,0,0.95); backdrop-filter: blur(10px);
                          padding: 1rem 0; position: sticky; top: 0; z-index: 999; }
        .navbar-landing .navbar-brand { color: var(--coffee-light) !important; font-weight: 800; font-size: 1.15rem; }
        .navbar-landing .nav-link { color: rgba(255,255,255,.75) !important; font-weight: 500; }
        .navbar-landing .nav-link:hover { color: var(--coffee-light) !important; }
        .btn-hero { background: var(--coffee-light); color: var(--coffee-dark);
                    border: none; border-radius: 50px; padding: .85rem 2rem; font-weight: 700; font-size: 1rem;
                    transition: transform .2s, box-shadow .2s; }
        .btn-hero:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212,163,115,.4); color: var(--coffee-dark); }
        .btn-outline-hero { border: 2px solid rgba(255,255,255,.5); color: #fff; border-radius: 50px;
                             padding: .85rem 2rem; font-weight: 700; transition: all .2s; }
        .btn-outline-hero:hover { background: rgba(255,255,255,.15); color: #fff; border-color: #fff; }
        /* Hero */
        .hero { background: linear-gradient(135deg, #0d0500 0%, #1a0a00 40%, #3d1a00 70%, #6f3d1e 100%);
                min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: -50%; right: -20%; width: 600px; height: 600px;
                        background: radial-gradient(circle, rgba(212,163,115,.15) 0%, transparent 70%);
                        border-radius: 50%; }
        .hero-title { font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 800; line-height: 1.1;
                      color: #fff; }
        .hero-title span { color: var(--coffee-light); }
        .hero-sub { font-size: 1.1rem; color: rgba(255,255,255,.7); max-width: 500px; line-height: 1.6; }
        /* Stats */
        .stats-bar { background: var(--coffee-dark); padding: 2.5rem 0; }
        .stat-item { text-align: center; }
        .stat-item .num { font-size: 2rem; font-weight: 800; color: var(--coffee-light); }
        .stat-item .lbl { font-size: .85rem; color: rgba(255,255,255,.6); }
        /* Features */
        .features { background: var(--coffee-cream); padding: 5rem 0; }
        .feature-card { background: #fff; border-radius: 20px; padding: 2rem 1.5rem;
                        text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,.06);
                        transition: transform .2s; }
        .feature-card:hover { transform: translateY(-4px); }
        .feature-icon { font-size: 2.5rem; margin-bottom: 1rem; }
        /* Menu Preview */
        .menu-preview { padding: 5rem 0; background: #fff; }
        .menu-card { border: none; border-radius: 16px; overflow: hidden;
                     box-shadow: 0 4px 20px rgba(0,0,0,.08); transition: transform .2s; }
        .menu-card:hover { transform: translateY(-4px); }
        .menu-card .card-img-top { height: 160px; object-fit: cover; }
        .menu-placeholder { height: 160px; display: flex; align-items: center;
                             justify-content: center; font-size: 3.5rem;
                             background: linear-gradient(135deg, #fef3e8, #faedcd); }
        .price-tag { color: var(--coffee-brown); font-weight: 800; font-size: 1.1rem; }
        /* CTA */
        .cta-section { background: linear-gradient(135deg, #1a0a00, #6f3d1e); padding: 5rem 0; }
        /* Footer */
        .footer-landing { background: #0d0500; padding: 3rem 0 1.5rem; }
        .footer-brand { color: var(--coffee-light); font-size: 1.2rem; font-weight: 800; }
        .footer-link { color: rgba(255,255,255,.6); text-decoration: none; font-size: .875rem;
                       transition: color .2s; }
        .footer-link:hover { color: var(--coffee-light); }
        .section-title { font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 800;
                         color: var(--coffee-dark); line-height: 1.2; }
        .section-subtitle { color: #888; font-size: 1rem; max-width: 500px; margin: 0 auto; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-landing">
    <div class="container d-flex align-items-center justify-content-between">
    <a href="#" class="navbar-brand text-decoration-none d-flex align-items-center gap-2">
        <img src="{{ asset('images/libaslogo2.jpeg') }}" alt="Libas Street Coffee"
        style="height:36px;width:36px;mix-blend-mode:screen;border-radius:50%">
        <div>
            <div style="line-height:1.1">Libas Street Coffee</div>
            <div style="font-size:.6rem;opacity:.5;letter-spacing:2px;font-weight:400">EST. 2025</div>
        </div>
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="#menu" class="nav-link d-none d-md-block">Menu</a>
            <a href="#tentang" class="nav-link d-none d-md-block">Tentang</a>
            <a href="{{ route('login') }}" class="btn btn-sm fw-600"
               style="border:1.5px solid rgba(255,255,255,.4);color:#fff;border-radius:20px;padding:.4rem 1rem">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="btn btn-sm fw-700"
               style="background:var(--coffee-light);color:#1a0a00;border-radius:20px;padding:.4rem 1rem">
                Daftar
            </a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="mb-3">
                    <span class="badge px-3 py-2 fw-600"
                          style="background:rgba(212,163,115,.2);color:var(--coffee-light);border:1px solid rgba(212,163,115,.3);border-radius:20px">
                        Premium Coffee Experience
                    </span>
                </div>
                <h1 class="hero-title mb-3">
                    Setiap Tegukan<br>
                    Punya <span>Ceritanya</span><br>
                    Sendiri
                </h1>
                <p class="hero-sub mb-4">
                    Dari biji kopi pilihan terbaik hingga racikan barista berpengalaman —
                    Libas Street Coffee menghadirkan pengalaman kopi yang tak terlupakan.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn-hero">
                        Pesan Sekarang
                    </a>
                    <a href="#menu" class="btn-outline-hero btn">
                        Lihat Menu
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <img src="{{ asset('images/libaslogo.jpeg') }}" alt="Libas Street Coffee"
                     style="max-width:100%;max-height:500px;mix-blend-mode:screen;filter:drop-shadow(0 20px 40px rgba(0,0,0,.4))">
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features" id="tentang">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kenapa Pilih Kami?</h2>
            <p class="section-subtitle mt-2">Kami berkomitmen memberikan pengalaman kopi terbaik di setiap pesanan</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <h5 class="fw-700 mb-2">Biji Kopi Premium</h5>
                    <p class="text-muted small">Dipilih langsung dari perkebunan terbaik Nusantara, diproses dengan standar specialty coffee.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <h5 class="fw-700 mb-2">Barista Berpengalaman</h5>
                    <p class="text-muted small">Setiap minuman dibuat oleh barista terlatih yang berdedikasi pada kualitas dan konsistensi rasa.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <h5 class="fw-700 mb-2">Pesan Mudah & Cepat</h5>
                    <p class="text-muted small">Order online kapan saja, bayar dengan berbagai metode digital, struk langsung tersedia.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MENU PREVIEW — dinamis dari database, diatur admin -->
<section class="menu-preview" id="menu">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Menu Unggulan Kami</h2>
            <p class="section-subtitle mt-2">Temukan minuman dan cemilan favoritmu</p>
        </div>

        @if($featuredProducts->count())
        <div class="row g-3 justify-content-center">
            @foreach($featuredProducts as $product)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="menu-card card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             style="height:160px;object-fit:cover;width:100%">
                    @else
                        <div class="menu-placeholder">
                            {{ $product->category->icon ?? '☕' }}
                        </div>
                    @endif
                    <div class="card-body p-3">
                        <span class="badge mb-1" style="background:#fef3e8;color:#6f3d1e;font-size:.65rem">
                            {{ $product->category->name ?? '' }}
                        </span>
                        <h6 class="fw-700 mb-1" style="font-size:.85rem">{{ $product->name }}</h6>
                        <p class="text-muted mb-2" style="font-size:.73rem;line-height:1.4">
                            {{ Str::limit($product->description, 55) }}
                        </p>
                        <div class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-muted mt-2">Menu unggulan belum diatur oleh admin.</p>
        </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('register') }}" class="btn fw-700 px-4 py-2"
               style="background:var(--coffee-brown);color:#fff;border-radius:50px">
                Lihat Semua Menu
            </a>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section style="background:#faf7f4;padding:5rem 0">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Cara Pesan</h2>
            <p class="section-subtitle mt-2">Cukup 4 langkah mudah</p>
        </div>
        <div class="row g-4 justify-content-center">
            @php $steps = [
                ['num'=>'01','title'=>'Daftar Akun','desc'=>'Buat akun gratis dalam 30 detik'],
                ['num'=>'02','title'=>'Pilih Menu','desc'=>'Browse katalog dan tambah ke keranjang'],
                ['num'=>'03','title'=>'Bayar','desc'=>'Pilih metode pembayaran digital'],
                ['num'=>'04','title'=>'Terima Pesanan','desc'=>'Pesanan diproses & struk tersedia'],
            ]; @endphp
            @foreach($steps as $step)
            <div class="col-6 col-md-3">
                <div class="text-center p-3">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-800"
                         style="width:60px;height:60px;background:linear-gradient(135deg,#6f3d1e,#a0522d);font-size:.9rem">
                        {{ $step['num'] }}
                    </div>
                    <h6 class="fw-700 mb-1">{{ $step['title'] }}</h6>
                    <p class="text-muted small mb-0">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="fw-800 text-white mb-3" style="font-size:2.25rem">
            Siap Menikmati Kopi Terbaik?
        </h2>
        <p class="mb-4" style="color:rgba(255,255,255,.7);font-size:1.05rem">
            Daftar gratis sekarang dan dapatkan pengalaman belanja kopi yang menyenangkan
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('register') }}" class="btn-hero btn fw-700 px-5">
                Daftar Gratis Sekarang
            </a>
            <a href="{{ route('login') }}" class="btn-outline-hero btn fw-600 px-4">
                Sudah Punya Akun? Masuk
            </a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer-landing">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-md-4">
                <div class="footer-brand d-flex align-items-center gap-2 mb-3">
                    <span style="font-size:1.5rem"></span> Libas Street Coffee
                </div>
                <p class="small" style="color:rgba(255,255,255,.5);line-height:1.7">
                    Menghadirkan pengalaman kopi premium yang autentik dan menyenangkan untuk setiap pelanggan kami.
                </p>
            </div>
            <div class="col-6 col-md-2">
                <div class="fw-700 text-white small mb-3">Menu</div>
                <div class="d-flex flex-column gap-2">
                    <a href="#" class="footer-link">Kopi</a>
                    <a href="#" class="footer-link">Non Kopi</a>
                    <a href="#" class="footer-link">Cemilan</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="fw-700 text-white small mb-3">Kontak</div>
                <div class="d-flex flex-column gap-2 small" style="color:rgba(255,255,255,.6)">
                    <div>Jl. Medan - Banda Aceh, Lhokseumawe, Batuphat Timur</div>
                    <div>0812-3456-7890</div>
                    <div>libascafe@gmail.com</div>
                    <div>Senin–Minggu, 07:00–23:00</div>
                </div>
            </div>
        </div>
        <div class="border-top pt-3 mt-2 d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="border-color:rgba(255,255,255,.1)!important">
            <span class="small" style="color:rgba(255,255,255,.4)">
                © {{ date('Y') }} Libas Street Coffee. All rights reserved.
            </span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) { e.preventDefault(); target.scrollIntoView({behavior:'smooth'}); }
        });
    });
</script>
</body>
</html>
