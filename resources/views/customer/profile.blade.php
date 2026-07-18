@extends('layouts.customer')
@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <h4 class="fw-800 mb-4" style="color:#1a0a00">👤 Profil Saya</h4>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card p-4 text-center">
                <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center text-white fw-800 mb-3"
                     style="width:80px;height:80px;font-size:2rem;background:linear-gradient(135deg,#6f3d1e,#a0522d)">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-700">{{ $user->name }}</h5>
                <p class="text-muted small mb-1">{{ $user->email }}</p>
                <p class="text-muted small">{{ $user->phone ?? 'Belum ada nomor telepon' }}</p>
                <span class="badge" style="background:#fef3e8;color:#6f3d1e">Pelanggan</span>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="fw-800 fs-4" style="color:#6f3d1e">{{ $user->orders()->count() }}</div>
                        <div class="small text-muted">Total Pesanan</div>
                    </div>
                    <div class="col-6">
                        <div class="fw-800 fs-4" style="color:#6f3d1e">
                            {{ $user->orders()->where('status','completed')->count() }}
                        </div>
                        <div class="small text-muted">Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card p-4">
                @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3">
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf @method('PUT')

                    <h6 class="fw-700 mb-3">Informasi Akun</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600 small">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600 small">Alamat</label>
                            <textarea name="address" class="form-control" rows="3"
                                      placeholder="Alamat lengkap...">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>

                    <hr>
                    <h6 class="fw-700 mb-3">Ubah Password <span class="text-muted fw-400 small">(opsional)</span></h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-600 small">Password Lama</label>
                            <input type="password" name="current_password" class="form-control"
                                   placeholder="Password saat ini">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600 small">Password Baru</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Minimal 6 karakter">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600 small">Konfirmasi</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <button type="submit" class="btn px-4 py-2 fw-700"
                            style="background:#6f3d1e;color:#fff;border-radius:12px">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
