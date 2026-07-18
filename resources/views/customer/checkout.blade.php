@extends('layouts.customer')
@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <h4 class="fw-800 mb-4" style="color:#1a0a00">Halaman Checkout</h4>

    <form action="{{ route('customer.checkout.place') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                {{-- Shipping Info --}}
                <div class="card p-4 mb-3">
                    <h6 class="fw-700 mb-3">Informasi Pengiriman</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Nama Penerima</label>
                            <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror"
                                   value="{{ old('shipping_name', $user->name) }}" required>
                            @error('shipping_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Nomor Telepon</label>
                            <input type="text" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror"
                                   value="{{ old('shipping_phone', $user->phone) }}" required>
                            @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600 small">Alamat Lengkap</label>
                            <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                                      rows="3" required>{{ old('shipping_address', $user->address) }}</textarea>
                            @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600 small">Catatan (opsional)</label>
                            <input type="text" name="notes" class="form-control"
                                   placeholder="Instruksi khusus untuk pesanan..." value="{{ old('notes') }}">
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="card p-4 mb-3">
                    <h6 class="fw-700 mb-3">Metode Pembayaran</h6>
                    @error('payment_method')<div class="alert alert-danger py-2 small">{{ $message }}</div>@enderror
                    <div class="row g-2">
                        @php
                        $methods = [
                            'qris'          => ['label'=>'QRIS',          'icon'=>'images/payments/qris.jpg', 'desc'=>'Bayar via QRIS apapun'],
                            'gopay'         => ['label'=>'GoPay',         'icon'=>'images/payments/gopay.jpg', 'desc'=>'Bayar via GoPay'],
                            'dana'          => ['label'=>'DANA',          'icon'=>'images/payments/dana.jpg', 'desc'=>'Bayar via DANA'],
                            'ovo'           => ['label'=>'OVO',           'icon'=>'images/payments/ovo.jpg', 'desc'=>'Bayar via OVO'],
                            'shopeepay'     => ['label'=>'ShopeePay',     'icon'=>'images/payments/shopeepay.jpg', 'desc'=>'Bayar via ShopeePay'],
                            'transfer_bank' => ['label'=>'Transfer Bank', 'icon'=>'images/payments/bank.jpg', 'desc'=>'Transfer via ATM/Mobile Banking'],
                        ];
                        @endphp
                        @foreach($methods as $val => $m)
                        <div class="col-6 col-md-4">
                            <label class="payment-option w-100" style="cursor:pointer">
                                <input type="radio" name="payment_method" value="{{ $val }}"
                                       {{ old('payment_method') == $val ? 'checked' : '' }} class="d-none payment-radio">
                                <div class="border rounded-3 p-3 text-center payment-card" style="transition:all .2s">
                                <img src="{{ asset($m['icon']) }}" alt="{{ $m['label'] }}" style="height:32px;object-fit:contain">
                                <div class="fw-700 small mt-1">{{ $m['label'] }}</div>
                                <div class="text-muted" style="font-size:.65rem">{{ $m['desc'] }}</div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    {{-- Payment Info Box --}}
                    <div class="mt-3 p-3 rounded-3" style="background:#fef9f5;border:1px solid #f0e8df" id="paymentInfo">
                        <div class="fw-700 small mb-2">Info Rekening / QR Code:</div>
                        <div class="small text-muted" id="paymentDetail">Pilih metode pembayaran di atas.</div>
                    </div>

                    {{-- Upload Proof --}}
                    <div class="mt-3">
                        <label class="form-label fw-600 small">📎 Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" name="payment_proof" id="proofInput"
                               class="form-control @error('payment_proof') is-invalid @enderror"
                               accept="image/*" onchange="previewProof(this)" required>
                        @error('payment_proof')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Format: JPG/PNG. Maks 3MB.</small>
                        <div id="proofPreview" class="mt-2" style="display:none">
                            <img id="proofImg" src="" alt="Preview" class="rounded-3 border" style="max-width:200px">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                {{-- Order Summary --}}
                <div class="card p-4 sticky-top" style="top:80px">
                    <h6 class="fw-700 mb-3">Ringkasan Pesanan</h6>
                    @foreach($carts as $cart)
                    <div class="d-flex justify-content-between align-items-center mb-2 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="d-flex align-items-center gap-2">
                            @if($cart->product->image)
                                <img src="{{ asset('storage/'.$cart->product->image) }}" class="rounded-2"
                                     style="width:36px;height:36px;object-fit:cover">
                            @else
                                <div class="rounded-2 d-flex align-items-center justify-content-center"
                                     style="width:36px;height:36px;background:#fef3e8;font-size:1rem">
                                    {{ $cart->product->category->icon ?? '☕' }}
                                </div>
                            @endif
                            <div>
                                <div class="small fw-600" style="max-width:150px">{{ Str::limit($cart->product->name, 20) }}</div>
                                <div class="text-muted" style="font-size:.7rem">x{{ $cart->quantity }}</div>
                            </div>
                        </div>
                        <div class="small fw-600">Rp {{ number_format($cart->quantity * $cart->product->price, 0, ',', '.') }}</div>
                    </div>
                    @endforeach

                    <div class="mt-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between fw-800">
                            <span>Total</span>
                            <span style="color:#6f3d1e;font-size:1.1rem">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 mt-4 py-3 fw-700"
                            style="background:#6f3d1e;color:#fff;border-radius:12px;font-size:1rem">
                        Buat Pesanan
                    </button>
                    <a href="{{ route('customer.cart') }}" class="btn btn-outline-secondary w-100 mt-2">
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.payment-card { border-color: #e0d5cc !important; }
.payment-radio:checked + .payment-card {
    border-color: #6f3d1e !important;
    background: #fef3e8;
    box-shadow: 0 0 0 2px #6f3d1e;
}
</style>
@endpush

@push('scripts')
<script>
const paymentDetails = {
    qris:          'Scan QRIS Libas Street Coffee\n<strong>0812-3456-7890</strong>',
    gopay:         'GoPay: <strong>0812-3456-7890</strong> a/n Libas Street Coffee',
    dana:          'DANA: <strong>0812-3456-7890</strong> a/n Libas Street Coffee',
    ovo:           'OVO: <strong>0812-3456-7890</strong> a/n Libas Street Coffee',
    shopeepay:     'ShopeePay: <strong>0812-3456-7890</strong> a/n Libas Street Coffee',
    transfer_bank: 'BCA: <strong>1234567890</strong> a/n Libas Street Coffee<br>Mandiri: <strong>1234567890</strong> a/n Libas Street Coffee',
};

document.querySelectorAll('.payment-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('paymentDetail').innerHTML = paymentDetails[this.value] || '';
    });
});

function previewProof(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('proofImg').src = e.target.result;
            document.getElementById('proofPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
