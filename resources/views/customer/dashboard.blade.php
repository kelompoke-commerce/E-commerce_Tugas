@extends('layouts.customer')
@section('title', 'Menu')

@section('content')
{{-- Hero Banner --}}
<div style="background:linear-gradient(135deg,#1a0a00 0%,#6f3d1e 100%);padding:3rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white">
                <h1 class="fw-800 mb-2" style="font-size:2.25rem;line-height:1.2">
                    Selamat Datang,<br>
                    <span style="color:#d4a373">{{ Str::words(auth()->user()->name, 1, '') }}! </span>
                </h1>
                <p class="mb-4" style="opacity:.8">Pilih menu favoritmu dan nikmati pengalaman kopi terbaik dari Libas Street Coffee.</p>
                <a href="#menu" class="btn px-4 py-2 fw-700" style="background:#d4a373;color:#1a0a00;border-radius:12px;">
                    Lihat Menu
                </a>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
            </div>
        </div>
    </div>
</div>

{{-- Category Filter --}}
<div class="container py-4" id="menu">
    <div class="d-flex gap-2 flex-wrap mb-4">
        <a href="{{ route('customer.dashboard') }}"
           class="category-pill {{ !request('category') && !request('search') ? 'active' : '' }}">
            🏠 Semua
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('customer.dashboard', ['category' => $cat->slug]) }}"
           class="category-pill {{ request('category') == $cat->slug ? 'active' : '' }}">
            {{ $cat->icon }} {{ $cat->name }}
        </a>
        @endforeach
    </div>

    {{-- Search --}}
    <form method="GET" class="mb-4">
        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
        <div class="input-group" style="max-width:400px">
            <input type="text" name="search" class="form-control" placeholder="Cari menu..." value="{{ request('search') }}">
            <button class="btn" style="background:#6f3d1e;color:#fff;border-radius:0 10px 10px 0">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    {{-- Featured --}}
    @if(!request('category') && !request('search') && $featuredItems->count())
    <div class="mb-5">
        <h5 class="fw-700 mb-3" style="color:#1a0a00">⭐ Menu Unggulan</h5>
        <div class="row g-3">
            @foreach($featuredItems as $product)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="product-card card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center" style="height:140px;background:#fef3e8;font-size:3rem">
                            {{ $product->category->icon ?? '☕' }}
                        </div>
                    @endif
                    <div class="card-body p-2">
                        <div class="fw-700 small mb-1">{{ $product->name }}</div>
                        <div class="price small">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <form action="{{ route('customer.cart.add') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button class="btn-add-cart btn w-100 py-1" style="font-size:.75rem">
                                <i class="bi bi-plus"></i> Tambah
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- All Products --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-700 mb-0" style="color:#1a0a00">
            @if(request('search'))
                Hasil pencarian "{{ request('search') }}"
            @elseif(request('category'))
                {{ $categories->where('slug', request('category'))->first()?->icon }} 
                {{ $categories->where('slug', request('category'))->first()?->name }}
            @else
                Semua Menu
            @endif
        </h5>
        <span class="text-muted small">{{ $products->total() }} menu</span>
    </div>

    <div class="row g-3">
        @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card card h-100">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height:180px;background:#fef3e8;font-size:4rem">
                        {{ $product->category->icon ?? '☕' }}
                    </div>
                @endif
                <div class="card-body d-flex flex-column p-3">
                    <span class="badge-category mb-2">{{ $product->category->icon }} {{ $product->category->name }}</span>
                    <h6 class="fw-700 mb-1" style="font-size:.9rem">{{ $product->name }}</h6>
                    <p class="text-muted mb-2" style="font-size:.78rem;flex-grow:1">{{ Str::limit($product->description, 55) }}</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        @if($product->stock > 0)
                            <span class="badge bg-success" style="font-size:.65rem">Tersedia</span>
                        @else
                            <span class="badge bg-secondary" style="font-size:.65rem">Habis</span>
                        @endif
                    </div>
                    <form action="{{ route('customer.cart.add') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="d-flex gap-2">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="form-control py-1 text-center" style="width:60px;font-size:.85rem">
                            <button class="btn-add-cart btn flex-fill" {{ $product->stock == 0 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus me-1"></i>Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div style="font-size:4rem;opacity:.3">🔍</div>
            <p class="text-muted">Menu tidak ditemukan.</p>
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">Lihat Semua Menu</a>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
