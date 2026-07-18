@extends('layouts.admin')
@section('title','Rekap Bulanan')
@section('page-title','Rekap Bulanan')

@section('content')
<div class="card p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-600 small">Pilih Bulan</label>
            <input type="month" name="month" class="form-control" value="{{ $month }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-coffee">Tampilkan</button>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card p-3 text-center">
            <div class="fw-800 fs-4">{{ $summary['total_orders'] }}</div>
            <div class="small text-muted">Total Pesanan</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card p-3 text-center">
            <div class="fw-800 fs-4 text-warning">{{ $summary['pending'] }}</div>
            <div class="small text-muted">Menunggu</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card p-3 text-center">
            <div class="fw-800 fs-4 text-info">{{ $summary['paid'] }}</div>
            <div class="small text-muted">Dibayar</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card p-3 text-center">
            <div class="fw-800 fs-4 text-primary">{{ $summary['processing'] }}</div>
            <div class="small text-muted">Diproses</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card p-3 text-center">
            <div class="fw-800 fs-4 text-success">{{ $summary['completed'] }}</div>
            <div class="small text-muted">Selesai</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card p-3 text-center">
            <div class="fw-800 fs-4 text-danger">{{ $summary['cancelled'] }}</div>
            <div class="small text-muted">Dibatalkan</div>
        </div>
    </div>
</div>

<div class="card p-3 mb-4 d-flex flex-row align-items-center gap-3"
     style="background:linear-gradient(135deg,#6f3d1e,#a0522d);border-radius:16px;">
    <i class="bi bi-cash-coin text-white" style="font-size:2.5rem;opacity:.8"></i>
    <div>
        <div class="small text-white" style="opacity:.8">Total Pendapatan Bulan Ini</div>
        <div class="fw-800 text-white" style="font-size:1.75rem">
            Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white border-0 pt-3 pb-0">
        <h6 class="fw-700" style="color:#1a0a00">Daftar Pesanan — {{ \Carbon\Carbon::parse($month)->isoFormat('MMMM Y') }}</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>No. Pesanan</th><th>Pelanggan</th><th>Total</th><th>Metode</th><th>Status</th><th>Tanggal</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-600 small" style="color:#6f3d1e">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none" style="color:#6f3d1e">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td>{{ $order->user->name }}</td>
                    <td class="fw-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="small">{{ $order->payment_method_label }}</td>
                    <td>{!! $order->status_badge !!}</td>
                    <td class="small text-muted">{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Tidak ada pesanan pada bulan ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
