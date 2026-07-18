<!DOCTYPE html>
<html lang="id">
<link rel="icon" type="image/png" href="{{ asset('favicon.jpeg') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Libas Street Coffee</title>
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
        .auth-card {
            background: #fff; border-radius: 24px;
            box-shadow: 0 24px 80px rgba(0,0,0,.3);
            overflow: hidden; width: 100%; max-width: 440px;
        }
        .auth-header {
            background: linear-gradient(135deg, #1a0a00, #6f3d1e);
            padding: 2.5rem 2rem 2rem; text-align: center;
        }
        .auth-header .brand { color: #d4a373; font-size: 1.2rem; font-weight: 800; }
        .auth-header .subtitle { color: rgba(255,255,255,.6); font-size: .85rem; margin-top: .25rem; }
        .auth-body { padding: 2rem; }
        .form-label { font-weight: 600; font-size: .875rem; color: #444; }
        .form-control {
            border-radius: 12px; border: 2px solid #e8e0d8; padding: .75rem 1rem;
            font-size: .9rem; transition: border-color .2s;
        }
        .form-control:focus { border-color: #a0522d; box-shadow: 0 0 0 .2rem rgba(160,82,45,.15); }
        .btn-login {
            background: linear-gradient(135deg, #6f3d1e, #a0522d);
            color: #fff; border: none; border-radius: 12px; padding: .85rem;
            font-weight: 700; font-size: 1rem; width: 100%; transition: opacity .2s;
        }
        .btn-login:hover { opacity: .9; color: #fff; }
        .divider { position: relative; text-align: center; margin: 1.25rem 0; }
        .divider::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #e8e0d8; }
        .divider span { background: #fff; padding: 0 .75rem; color: #aaa; font-size: .8rem; position: relative; }
        .input-group-icon { position: relative; }
        .input-group-icon .bi { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: #aaa; }
        .input-group-icon .form-control { padding-left: 2.5rem; }
        .toggle-pw { position: absolute; right: .9rem; top: 50%; transform: translateY(-50%);
                     color: #aaa; cursor: pointer; background: none; border: none; padding: 0; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-header">
        <img src="{{ asset('images/libaslogo2.jpeg') }}" alt="Libas Street Coffee"
        style="height:100px;width:100px;mix-blend-mode:screen;border-radius:50%">
        <div>
        </div>
        <div class="subtitle">Silahkan Login</div>
    </div>
    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 py-2 mb-3" style="font-size:.875rem">
                <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 py-2 mb-3" style="font-size:.875rem">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group-icon">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="nama@email.com" value="{{ old('email') }}" autofocus required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group-icon">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Masukkan password" required>
                    <button type="button" class="toggle-pw" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="divider"><span>atau</span></div>

        <div class="text-center">
            <span class="text-muted small">Belum punya akun? </span>
            <a href="{{ route('register') }}" class="fw-600 small" style="color:#6f3d1e">Daftar Sekarang</a>
        </div>
    </div>
</div>
<script>
function togglePassword() {
    const pw = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        pw.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>
