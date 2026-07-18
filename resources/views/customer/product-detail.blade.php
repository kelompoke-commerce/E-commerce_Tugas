@extends('layouts.customer')
@section('title', $product->name)

@section('content')
<div class="container py-4">
    <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Menu
    </a>

    <div class="row g-4">
        <div class="col-md-5">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                     class="img-fluid rounded-4 w-100" style="max-height:400px;object-fit:cover">
            @else
                <div class="rounded-4 d-flex align-items-center justify-content-center"
                     style="height:350px;background:linear-gradient(135deg,#fef3e8,#faedcd);font-size:8rem">
                    {{ $product->category->icon ?? '☕' }}
                </div>
            @endif
        </div>
        <div class="col-md-7">
            <span class="badge mb-2" style="background:#fef3e8;color:#6f3d1e">
                {{ $product->category->icon }} {{ $product->category->name }}
            </span>
            <h2 class="fw-800 mb-2" style="color:#1a0a00">{{ $product->name }}</h2>
            <div class="fw-800 mb-3" style="font-size:1.75rem;color:#6f3d1e">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>
            <p class="text-muted mb-4" style="line-height:1.7">{{ $product->description }}</p>

            @if($product->stock > 0)
                <div class="badge bg-success mb-3">✓ Tersedia ({{ $product->stock }} stok)</div>
            @else
                <div class="badge bg-danger mb-3">✗ Stok Habis</div>
            @endif

            <form action="{{ route('customer.cart.add') }}" method="POST" class="d-flex align-items-center gap-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-600 small">Jumlah:</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                           class="form-control text-center" style="width:80px" {{ $product->stock == 0 ? 'disabled' : '' }}>
                </div>
                <button type="submit" class="btn px-4 py-2 fw-700"
                        style="background:#6f3d1e;color:#fff;border-radius:12px"
                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                    <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                </button>
            </form>
        </div>
    </div>

    @if($related->count())
    <div class="mt-5">
        <h5 class="fw-700 mb-3" style="color:#1a0a00">Menu Terkait</h5>
        <div class="row g-3">
            @foreach($related as $item)
            <div class="col-6 col-md-3">
                <div class="product-card card h-100">
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center"
                             style="height:140px;background:#fef3e8;font-size:3rem">
                            {{ $item->category->icon ?? '☕' }}
                        </div>
                    @endif
                    <div class="card-body p-3">
                        <h6 class="fw-700 small mb-1">{{ $item->name }}</h6>
                        <div class="price small mb-2">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        <a href="{{ route('customer.product.show', $item) }}" class="btn btn-sm w-100"
                           style="background:#6f3d1e;color:#fff;border-radius:8px;font-size:.8rem">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
