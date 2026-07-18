@extends('layouts.customer')
@section('title', 'Riwayat Belanja')

@section('content')
<div class="container py-4">
    <h4 class="fw-800 mb-4" style="color:#1a0a00">📋 Riwayat Belanja</h4>

    <div class="card p-3 mb-4">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <select name="status" class="form-select" style="max-width:200px" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending"    {{ request('status')=='pending'    ? 'selected':'' }}>Menunggu</option>
                <option value="paid"       {{ request('status')=='paid'       ? 'selected':'' }}>Dibayar</option>
                <option value="processing" {{ request('status')=='processing' ? 'selected':'' }}>Diproses</option>
                <option value="completed"  {{ request('status')=='completed'  ? 'selected':'' }}>Selesai</option>
                <option value="cancelled"  {{ request('status')=='cancelled'  ? 'selected':'' }}>Dibatalkan</option>
            </select>
        </form>
    </div>

    @forelse($orders as $order)
    <div class="card mb-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                    <div class="fw-700" style="color:#6f3d1e">{{ $order->order_number }}</div>
                    <div class="small text-muted">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="text-end">
                    {!! $order->status_badge !!}
                    <div class="fw-800 mt-1" style="color:#6f3d1e">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach($order->items->take(3) as $item)
                <div class="badge rounded-3 py-2 px-3" style="background:#fef3e8;color:#6f3d1e;font-weight:600;font-size:.8rem">
                    {{ $item->product_name }} x{{ $item->quantity }}
                </div>
                @endforeach
                @if($order->items->count() > 3)
                <div class="badge bg-light text-muted border rounded-3 py-2 px-3">
                    +{{ $order->items->count() - 3 }} item lagi
                </div>
                @endif
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-eye me-1"></i>Detail
                </a>
                @if(in_array($order->status, ['paid','processing','completed']))
                <a href="{{ route('customer.orders.receipt', $order) }}" class="btn btn-sm"
                   style="background:#6f3d1e;color:#fff;border-radius:8px">
                    <i class="bi bi-receipt me-1"></i>Struk
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <div style="font-size:4rem;opacity:.2">📋</div>
        <h5 class="text-muted fw-600 mt-3">Belum ada riwayat pesanan</h5>
        <a href="{{ route('customer.dashboard') }}" class="btn mt-2"
           style="background:#6f3d1e;color:#fff;border-radius:12px">Mulai Belanja</a>
    </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection
