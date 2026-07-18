<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Server Error</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: linear-gradient(135deg,#1a0a00,#6f3d1e); min-height: 100vh;
               display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
<div class="text-center text-white p-4">
    <div style="font-size:5rem">⚠️</div>
    <h1 class="fw-800 mt-3" style="font-size:4rem">500</h1>
    <h4 class="fw-600 mb-3">Terjadi Kesalahan</h4>
    <p style="opacity:.8">Server sedang bermasalah. Coba lagi beberapa saat.</p>
    <a href="{{ url('/') }}" class="btn px-4 py-2 mt-2 fw-700"
       style="background:#d4a373;color:#1a0a00;border-radius:12px">Kembali ke Beranda</a>
</div>
</body>
</html>
