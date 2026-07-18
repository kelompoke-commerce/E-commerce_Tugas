@extends('layouts.admin')
@section('title','Tambah Akun')
@section('page-title','Tambah Akun Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card p-4">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-600">Nama Lengkap</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-600">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-600">Telepon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-600">Role</label>
            <select name="role" class="form-select" required>
                <option value="customer" {{ old('role')=='customer' ? 'selected':'' }}>Pelanggan</option>
                <option value="admin"    {{ old('role')=='admin'    ? 'selected':'' }}>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-600">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Minimal 6 karakter" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="form-label fw-600">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-coffee px-4">Buat Akun</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
</div>
</div>
@endsection
