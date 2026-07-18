@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card bg-coffee-1">
            <i class="bi bi-bag-check stat-icon"></i>
            <div class="stat-value">{{ number_format($totalOrders) }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card bg-coffee-2">
            <i class="bi bi-cash-coin stat-icon"></i>
            <div class="stat-value">Rp {{ number_format($totalRevenue/1000, 0) }}K</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card bg-coffee-3">
            <i class="bi bi-box-seam stat-icon"></i>
            <div class="stat-value">{{ number_format($totalProducts) }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card bg-coffee-4">
            <i class="bi bi-people stat-icon"></i>
            <div class="stat-value">{{ number_format($totalCustomers) }}</div>
            <div class="stat-label">Total Pelanggan</div>
        </div>
    </div>
</div>

{{-- Pending alert --}}
@if($pendingOrders > 0)
<div class="alert border-0 rounded-3 d-flex align-items-center gap-3 mb-4"
     style="background:#fff8e1;border-left:4px solid #ffc107 !important;">
    <i class="bi bi-exclamation-triangle-fill fs-4" style="color:#ffc107"></i>
    <div>
        <strong>{{ $pendingOrders }} pesanan</strong> menunggu konfirmasi pembayaran.
        <a href="{{ route('admin.orders.index', ['status'=>'pending']) }}" class="fw-600 ms-1" style="color:#a0522d">Lihat sekarang →</a>
    </div>
</div>
@endif

<div class="row g-3">
    {{-- Revenue Chart --}}
    <div class="col-lg-8">
        <div class="card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-700 mb-0" style="color:#1a0a00">Pendapatan 12 Bulan Terakhir</h6>
            </div>
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    {{-- Recap this month --}}
    <div class="col-lg-4">
        <div class="card p-3 h-100">
            <h6 class="fw-700 mb-3" style="color:#1a0a00">Rekap Bulan Ini</h6>
            <div class="mb-2">
                <div class="d-flex justify-content-between small mb-1">
                    <span>Menunggu</span><strong class="text-warning">{{ $monthlyRecap->where('status','pending')->sum('count') }}</strong>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                    <span>Dibayar</span><strong class="text-info">{{ $monthlyRecap->where('status','paid')->sum('count') }}</strong>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                    <span>Diproses</span><strong class="text-primary">{{ $monthlyRecap->where('status','processing')->sum('count') }}</strong>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                    <span>Selesai</span><strong class="text-success">{{ $monthlyRecap->where('status','completed')->sum('count') }}</strong>
                </div>
                <div class="d-flex justify-content-between small mb-1">
                    <span>Dibatalkan</span><strong class="text-danger">{{ $monthlyRecap->where('status','cancelled')->sum('count') }}</strong>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between small">
                    <span class="fw-600">Total Pendapatan</span>
                    <strong style="color:#6f3d1e">
                        Rp {{ number_format($monthlyRecap->whereIn('status',['paid','processing','completed'])->sum('total'), 0, ',', '.') }}
                    </strong>
                </div>
            </div>
            <a href="{{ route('admin.orders.recap') }}" class="btn btn-sm btn-coffee mt-auto w-100">
                Lihat Rekap Lengkap
            </a>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="col-lg-8">
        <div class="card p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-700 mb-0" style="color:#1a0a00">Pesanan Terbaru</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-coffee">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr>
                        <th>No. Pesanan</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Tgl</th>
                    </tr></thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="fw-600 text-decoration-none"
                                   style="color:#6f3d1e">{{ $order->order_number }}</a></td>
                            <td>{{ $order->user->name }}</td>
                            <td class="fw-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>{!! $order->status_badge !!}</td>
                            <td class="text-muted small">{{ $order->created_at->format('d M') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada pesanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="col-lg-4">
        <div class="card p-3">
            <h6 class="fw-700 mb-3" style="color:#1a0a00">Produk Terlaris</h6>
            @forelse($topProducts as $i => $product)
            <div class="d-flex align-items-center gap-2 mb-2 pb-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700"
                     style="width:28px;height:28px;font-size:.75rem;flex-shrink:0;
                            background:{{ ['#6f3d1e','#a0522d','#c4772c','#d4a373','#e8c99a'][$i] ?? '#ccc' }}">
                    {{ $i+1 }}
                </div>
                <div class="flex-grow-1 min-w-0">
                    <div class="small fw-600 text-truncate">{{ $product->name }}</div>
                    <div class="small text-muted">{{ $product->total_qty }} terjual</div>
                </div>
                <div class="small fw-700" style="color:#6f3d1e">
                    Rp {{ number_format($product->total_revenue/1000, 0) }}K
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-3 small">Belum ada data penjualan</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const rawData = @json($monthlyRevenue);

// Build last 12 months labels & data
const labels = [];
const data   = [];
for (let i = 11; i >= 0; i--) {
    const d = new Date();
    d.setMonth(d.getMonth() - i);
    const m = d.getMonth() + 1;
    const y = d.getFullYear();
    labels.push(months[d.getMonth()] + ' ' + y);
    const found = rawData.find(r => r.month == m && r.year == y);
    data.push(found ? parseFloat(found.total) : 0);
}

new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data,
            backgroundColor: 'rgba(111,61,30,.7)',
            borderColor: '#6f3d1e',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K' }, grid: { color: '#f0e8df' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
