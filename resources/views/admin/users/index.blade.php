@extends('layouts.admin')
@section('title','Kelola Akun')
@section('page-title','Kelola Akun')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-coffee">
        <i class="bi bi-person-plus me-1"></i>Tambah Akun
    </a>
</div>

<div class="card p-3 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Cari nama / email..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">Semua Role</option>
                <option value="admin"    {{ request('role')=='admin'    ? 'selected':'' }}>Admin</option>
                <option value="customer" {{ request('role')=='customer' ? 'selected':'' }}>Pelanggan</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-coffee flex-fill">Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Pengguna</th><th>Role</th><th>Telepon</th><th>Status</th><th>Terdaftar</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-700"
                                 style="width:36px;height:36px;font-size:.85rem;flex-shrink:0;
                                        background:{{ $user->isAdmin() ? '#6f3d1e' : '#457b9d' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-600 small">{{ $user->name }}</div>
                                <div class="text-muted" style="font-size:.7rem">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->isAdmin())
                            <span class="badge" style="background:#fef3e8;color:#6f3d1e">Admin</span>
                        @else
                            <span class="badge bg-light text-dark border">Pelanggan</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $user->phone ?? '-' }}</td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="bi bi-{{ $user->is_active ? 'pause-circle' : 'play-circle' }}"></i>
                                </button>
                            </form>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Hapus akun ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Tidak ada pengguna</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="d-flex justify-content-center p-3">{{ $users->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
