@extends('layouts.customer')
@section('title', 'Struk Pembelian')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
    <div class="col-lg-6">
        {{-- Success Banner --}}
        <div class="text-center mb-4">
            <div style="font-size:4rem">✅</div>
            <h4 class="fw-800" style="color:#2c6e49">Pesanan Berhasil Dibuat!</h4>
            <p class="text-muted">Pesananmu sedang kami proses. Terima kasih!</p>
        </div>

        {{-- Receipt Card --}}
        <div class="card" id="receiptCard">
            {{-- Receipt Header --}}
            <div class="p-4 text-center" style="background:linear-gradient(135deg,#1a0a00,#6f3d1e)">
                <div style="font-size:2.5rem">☕</div>
                <div class="fw-800 text-white" style="font-size:1.1rem">Libas Street Coffee</div>
                <div class="text-white small" style="opacity:.7">Struk Pembelian</div>
            </div>

            <div class="p-4">
                {{-- Order Info --}}
                <div class="row g-2 mb-3 pb-3 border-bottom">
                    <div class="col-6">
                        <div class="small text-muted">No. Pesanan</div>
                        <div class="fw-700 small" style="color:#6f3d1e">{{ $order->order_number }}</div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="small text-muted">Tanggal</div>
                        <div class="fw-600 small">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="small text-muted">Pembayaran</div>
                        <div class="fw-600 small">{{ $order->payment_method_label }}</div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="small text-muted">Status</div>
                        <div>{!! $order->status_badge !!}</div>
                    </div>
                </div>

                {{-- Customer --}}
                <div class="mb-3 pb-3 border-bottom">
                    <div class="small text-muted mb-1">Penerima:</div>
                    <div class="fw-700 small">{{ $order->shipping_name }}</div>
                    <div class="small text-muted">{{ $order->shipping_phone }}</div>
                    <div class="small text-muted">{{ $order->shipping_address }}</div>
                    @if($order->notes)
                        <div class="small mt-1"><i class="bi bi-chat-text me-1"></i>{{ $order->notes }}</div>
                    @endif
                </div>

                {{-- Items --}}
                <div class="mb-3 pb-3 border-bottom">
                    <div class="small text-muted mb-2">Item Pesanan:</div>
                    @foreach($order->items as $item)
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="small fw-600">{{ $item->product_name }}</span>
                            <span class="small text-muted"> x{{ $item->quantity }}</span>
                        </div>
                        <div class="small fw-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-800 pt-2 border-top"
                         style="font-size:1.1rem;color:#6f3d1e">
                        <span>TOTAL</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="text-center mt-3 pt-3 border-top">
                    <div class="small text-muted">Terima kasih telah berbelanja di</div>
                    <div class="fw-700 small" style="color:#6f3d1e">Libas Street Coffee ☕</div>
                    <div class="small text-muted">Semoga harimu menyenangkan!</div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="d-flex gap-2 mt-3">
            <button onclick="window.print()" class="btn flex-fill py-2 fw-600"
                    style="background:#6f3d1e;color:#fff;border-radius:12px">
                <i class="bi bi-printer me-1"></i>Cetak Struk
            </button>
            <a href="{{ route('customer.orders.history') }}" class="btn btn-outline-secondary flex-fill py-2 fw-600" style="border-radius:12px">
                <i class="bi bi-clock-history me-1"></i>Riwayat
            </a>
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary py-2 fw-600" style="border-radius:12px">
                <i class="bi bi-house"></i>
            </a>
        </div>
    </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    body * { visibility: hidden; }
    #receiptCard, #receiptCard * { visibility: visible; }
    #receiptCard { position: absolute; top: 0; left: 0; width: 100%; }
    .navbar-coffee, .footer, .btn, nav { display: none !important; }
}
</style>
@endpush
