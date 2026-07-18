@extends('layouts.admin')
@section('title','Detail Pesanan')
@section('page-title','Detail Pesanan')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        {{-- Order Items --}}
        <div class="card p-4 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-700 mb-0">Item Pesanan</h6>
                <span class="badge fs-6" style="background:#f0e8df;color:#6f3d1e">{{ $order->order_number }}</span>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr><th>Produk</th><th class="text-end">Harga</th><th class="text-center">Qty</th><th class="text-end">Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="fw-600">{{ $item->product_name }}</td>
                            <td class="text-end small">Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                            <td class="text-center"><span class="badge bg-light text-dark border">{{ $item->quantity }}</span></td>
                            <td class="text-end fw-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-top">
                            <td colspan="3" class="text-end text-muted small">Subtotal</td>
                            <td class="text-end fw-600">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-700">Total</td>
                            <td class="text-end fw-800 fs-5" style="color:#6f3d1e">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Payment Proof --}}
        @if($order->payment_proof)
        <div class="card p-4">
            <h6 class="fw-700 mb-3">Bukti Pembayaran</h6>
            <img src="{{ asset('storage/'.$order->payment_proof) }}" alt="Bukti Transfer"
                 class="img-fluid rounded-3" style="max-width:400px">
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        {{-- Status --}}
        <div class="card p-4 mb-3">
            <h6 class="fw-700 mb-3">Status Pesanan</h6>
            <div class="mb-3">{!! $order->status_badge !!}</div>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" class="form-select mb-2">
                    @foreach(['pending','paid','processing','completed','cancelled'] as $st)
                        <option value="{{ $st }}" {{ $order->status == $st ? 'selected' : '' }}>
                            {{ ['pending'=>'Menunggu Pembayaran','paid'=>'Dibayar','processing'=>'Diproses','completed'=>'Selesai','cancelled'=>'Dibatalkan'][$st] }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-coffee w-100">Update Status</button>
            </form>
        </div>

        {{-- Customer Info --}}
        <div class="card p-4 mb-3">
            <h6 class="fw-700 mb-3">Info Pelanggan</h6>
            <div class="small">
                <div class="mb-1"><strong>Nama:</strong> {{ $order->shipping_name }}</div>
                <div class="mb-1"><strong>Telp:</strong> {{ $order->shipping_phone }}</div>
                <div class="mb-1"><strong>Alamat:</strong></div>
                <div class="text-muted">{{ $order->shipping_address }}</div>
                @if($order->notes)
                    <div class="mt-2"><strong>Catatan:</strong> {{ $order->notes }}</div>
                @endif
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="card p-4">
            <h6 class="fw-700 mb-3">Info Pembayaran</h6>
            <div class="small">
                <div class="mb-1"><strong>Metode:</strong> {{ $order->payment_method_label }}</div>
                <div class="mb-1"><strong>Dibayar:</strong> {{ $order->paid_at ? $order->paid_at->format('d M Y H:i') : '-' }}</div>
                <div><strong>Tgl Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>
@endsection
