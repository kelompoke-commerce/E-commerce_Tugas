@extends('layouts.admin')
@section('title','Edit Akun')
@section('page-title','Edit Akun')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card p-4">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-600">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-600">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-600">Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-600">Role</label>
            <select name="role" class="form-select">
                <option value="customer" {{ old('role', $user->role)=='customer' ? 'selected':'' }}>Pelanggan</option>
                <option value="admin"    {{ old('role', $user->role)=='admin'    ? 'selected':'' }}>Admin</option>
            </select>
        </div>
        <hr>
        <p class="small text-muted">Biarkan kosong jika tidak ingin mengubah password.</p>
        <div class="mb-3">
            <label class="form-label fw-600">Password Baru</label>
            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
        </div>
        <div class="mb-4">
            <label class="form-label fw-600">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-coffee px-4">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
</div>
</div>
@endsection
