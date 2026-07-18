@extends('layouts.admin')
@section('title','Kelola Pesanan')
@section('page-title','Kelola Pesanan')

@section('content')
<div class="card p-3 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari no. pesanan / nama..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending"    {{ request('status')=='pending'    ? 'selected':'' }}>Menunggu Pembayaran</option>
                <option value="paid"       {{ request('status')=='paid'       ? 'selected':'' }}>Dibayar</option>
                <option value="processing" {{ request('status')=='processing' ? 'selected':'' }}>Diproses</option>
                <option value="completed"  {{ request('status')=='completed'  ? 'selected':'' }}>Selesai</option>
                <option value="cancelled"  {{ request('status')=='cancelled'  ? 'selected':'' }}>Dibatalkan</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="month" name="month" class="form-control" value="{{ request('month') }}">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-coffee flex-fill">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-600 small" style="color:#6f3d1e">{{ $order->order_number }}</td>
                    <td>
                        <div class="fw-600 small">{{ $order->user->name }}</div>
                        <div class="text-muted" style="font-size:.7rem">{{ $order->user->email }}</div>
                    </td>
                    <td class="fw-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td><span class="badge bg-light text-dark border small">{{ $order->payment_method_label }}</span></td>
                    <td>{!! $order->status_badge !!}</td>
                    <td class="small text-muted">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-coffee">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-5">
                    <i class="bi bi-bag fs-2 d-block mb-2"></i>Tidak ada pesanan
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="d-flex justify-content-center p-3">{{ $orders->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
