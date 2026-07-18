@extends('layouts.customer')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-4">
    <h4 class="fw-800 mb-4" style="color:#1a0a00">Keranjang Belanja</h4>

    @if($carts->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:5rem;opacity:.2">🛒</div>
        <h5 class="fw-600 text-muted mt-3">Keranjang masih kosong</h5>
        <p class="text-muted small">Yuk, tambahkan menu favoritmu!</p>
        <a href="{{ route('customer.dashboard') }}" class="btn px-4 py-2 fw-700"
           style="background:#6f3d1e;color:#fff;border-radius:12px">Lihat Menu</a>
    </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-700 mb-0">Item ({{ $carts->count() }})</h6>
                    <form action="{{ route('customer.cart.clear') }}" method="POST"
                          onsubmit="return confirm('Kosongkan keranjang?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>Kosongkan
                        </button>
                    </form>
                </div>

                @foreach($carts as $cart)
                <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    @if($cart->product->image)
                        <img src="{{ asset('storage/'.$cart->product->image) }}" alt="{{ $cart->product->name }}"
                             class="rounded-3" style="width:70px;height:70px;object-fit:cover;flex-shrink:0">
                    @else
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width:70px;height:70px;background:#fef3e8;font-size:2rem;flex-shrink:0">
                            {{ $cart->product->category->icon ?? '☕' }}
                        </div>
                    @endif
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-700">{{ $cart->product->name }}</div>
                        <div class="small text-muted">{{ $cart->product->category->name }}</div>
                        <div class="fw-700 mt-1" style="color:#6f3d1e">
                            Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <form action="{{ route('customer.cart.update', $cart) }}" method="POST" class="d-flex align-items-center gap-1">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1"
                                   max="{{ $cart->product->stock }}"
                                   class="form-control text-center py-1"
                                   style="width:55px;font-size:.85rem"
                                   onchange="this.form.submit()">
                        </form>
                        <div class="fw-700 text-nowrap" style="min-width:80px;text-align:right">
                            Rp {{ number_format($cart->quantity * $cart->product->price, 0, ',', '.') }}
                        </div>
                        <form action="{{ route('customer.cart.remove', $cart) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 sticky-top" style="top:80px">
                <h6 class="fw-700 mb-3">Ringkasan Belanja</h6>
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-700">Total</span>
                    <span class="fw-800 fs-5" style="color:#6f3d1e">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('customer.checkout') }}" class="btn w-100 py-3 fw-700"
                   style="background:#6f3d1e;color:#fff;border-radius:12px;font-size:1rem">
                    Checkout Sekarang
                </a>
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">
                    + Tambah Menu
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
