<!DOCTYPE html>
<html lang="id">
<link rel="icon" type="image/png" href="{{ asset('favicon.jpeg') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Libas Street Coffee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a0a00 0%, #3d1a00 50%, #6f3d1e 100%);
            display: flex; align-items: center; justify-content: center; padding: 1rem;
        }
        .auth-card { background: #fff; border-radius: 24px; box-shadow: 0 24px 80px rgba(0,0,0,.3);
                     overflow: hidden; width: 100%; max-width: 480px; }
        .auth-header { background: linear-gradient(135deg, #1a0a00, #6f3d1e);
                       padding: 2rem; text-align: center; }
        .auth-header .brand { color: #d4a373; font-size: 1.2rem; font-weight: 800; }
        .auth-header .subtitle { color: rgba(255,255,255,.6); font-size: .85rem; margin-top: .25rem; }
        .auth-body { padding: 2rem; }
        .form-label { font-weight: 600; font-size: .875rem; color: #444; }
        .form-control { border-radius: 12px; border: 2px solid #e8e0d8; padding: .75rem 1rem; font-size: .9rem; }
        .form-control:focus { border-color: #a0522d; box-shadow: 0 0 0 .2rem rgba(160,82,45,.15); }
        .form-control.is-invalid { border-color: #dc3545; }
        .btn-register { background: linear-gradient(135deg, #6f3d1e, #a0522d);
                        color: #fff; border: none; border-radius: 12px; padding: .85rem;
                        font-weight: 700; font-size: 1rem; width: 100%; }
        .btn-register:hover { opacity: .9; color: #fff; }
        .input-group-icon { position: relative; }
        .input-group-icon .bi { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: #aaa; }
        .input-group-icon .form-control { padding-left: 2.5rem; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-header">
        <img src="{{ asset('images/libaslogo2.jpeg') }}" alt="Libas Street Coffee"
        style="height:100px;width:100px;mix-blend-mode:screen;border-radius:50%">
        <div>
        </div>
        <div class="subtitle">Daftar Akun Anda</div>
    </div>
    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 py-2 mb-3" style="font-size:.875rem">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-group-icon">
                    <i class="bi bi-person"></i>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nama lengkap Anda" value="{{ old('name') }}" required autofocus>
                </div>
                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group-icon">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>
                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon / WhatsApp</label>
                <div class="input-group-icon">
                    <i class="bi bi-telephone"></i>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                </div>
                @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group-icon">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 6 karakter" required>
                </div>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <div class="input-group-icon">
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Ulangi password" required>
                </div>
            </div>
            <button type="submit" class="btn-register">Daftar Sekarang</button>
        </form>

        <div class="text-center mt-3">
            <span class="text-muted small">Sudah punya akun? </span>
            <a href="{{ route('login') }}" class="fw-600 small" style="color:#6f3d1e">Masuk di sini</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
