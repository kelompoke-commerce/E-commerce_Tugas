@extends('layouts.customer')
@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-4">
    <a href="{{ route('customer.orders.history') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <h4 class="fw-800 mb-4" style="color:#1a0a00">Detail Pesanan</h4>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4 mb-3">
                <div class="d-flex justify-content-between mb-3">
                    <h6 class="fw-700 mb-0">🛒 Item Pesanan</h6>
                    {!! $order->status_badge !!}
                </div>
                @foreach($order->items as $item)
                <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;background:#fef3e8;font-size:1.5rem;flex-shrink:0">
                        ☕
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-700 small">{{ $item->product_name }}</div>
                        <div class="text-muted" style="font-size:.75rem">Rp {{ number_format($item->product_price, 0, ',', '.') }} × {{ $item->quantity }}</div>
                    </div>
                    <div class="fw-700 small" style="color:#6f3d1e">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
                @endforeach
                <div class="mt-3 pt-3 border-top">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-800" style="color:#6f3d1e">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4 mb-3">
                <h6 class="fw-700 mb-3">Info Pesanan</h6>
                <div class="small">
                    <div class="mb-1"><strong>No. Pesanan:</strong></div>
                    <div class="text-muted mb-2" style="color:#6f3d1e!important;font-weight:600">{{ $order->order_number }}</div>
                    <div class="mb-1"><strong>Tanggal:</strong></div>
                    <div class="text-muted mb-2">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    <div class="mb-1"><strong>Pembayaran:</strong></div>
                    <div class="text-muted mb-2">{{ $order->payment_method_label }}</div>
                    <div class="mb-1"><strong>Alamat Kirim:</strong></div>
                    <div class="text-muted">{{ $order->shipping_address }}</div>
                </div>
            </div>
            @if(in_array($order->status, ['paid','processing','completed']))
            <a href="{{ route('customer.orders.receipt', $order) }}" class="btn w-100 py-2 fw-600"
               style="background:#6f3d1e;color:#fff;border-radius:12px">
                <i class="bi bi-receipt me-1"></i>Lihat Struk
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
