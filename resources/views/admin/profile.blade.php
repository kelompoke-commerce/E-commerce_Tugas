@extends('layouts.admin')
@section('title','Profil Admin')
@section('page-title','Profil Admin')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">

    <div class="card p-4 mb-4 text-center">
        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center text-white fw-800 mb-3"
             style="width:80px;height:80px;font-size:2rem;background:linear-gradient(135deg,#6f3d1e,#a0522d)">
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>
        <h5 class="fw-700 mb-1">{{ $user->name }}</h5>
        <span class="badge" style="background:#fef3e8;color:#6f3d1e">Administrator</span>
    </div>

    <div class="card p-4">
        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 mb-3">
                <ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf @method('PUT')
            <h6 class="fw-700 mb-3">Informasi Akun</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-600 small">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-600 small">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-600 small">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}">
                </div>
            </div>
            <hr>
            <h6 class="fw-700 mb-3">Ubah Password <span class="text-muted fw-400 small">(opsional)</span></h6>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-600 small">Password Lama</label>
                    <input type="password" name="current_password" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-600 small">Password Baru</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-600 small">Konfirmasi</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-coffee px-4">Simpan Perubahan</button>
        </form>
    </div>
</div>
</div>
@endsection
