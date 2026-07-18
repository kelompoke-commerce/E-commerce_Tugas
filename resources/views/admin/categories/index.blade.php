@extends('layouts.admin')
@section('title','Kelola Kategori')
@section('page-title','Kelola Kategori')

@section('content')
<div class="row g-4">
    {{-- Add Form --}}
    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="fw-700 mb-3" style="color:#1a0a00">➕ Tambah Kategori</h6>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-600 small">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Kopi Spesial" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600 small">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi singkat..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-600 small">Urutan</label>
                    <input type="number" name="sort_order" class="form-control" value="0" min="0">
                </div>
                <button type="submit" class="btn btn-coffee w-100">Tambah Kategori</button>
            </form>
        </div>
    </div>

    {{-- List --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Kategori</th><th>Deskripsi</th><th>Produk</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span style="font-size:1.5rem">{{ $cat->icon ?? '📦' }}</span>
                                    <div>
                                        <div class="fw-600">{{ $cat->name }}</div>
                                        <div class="small text-muted">Urutan: {{ $cat->sort_order }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small text-muted">{{ Str::limit($cat->description, 50) }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $cat->products_count }} produk</span></td>
                            <td>
                                @if($cat->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal" data-bs-target="#editCat{{ $cat->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kategori</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modals --}}
@foreach($categories as $cat)
<div class="modal fade" id="editCat{{ $cat->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-700">Edit Kategori</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.categories.update', $cat) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-600 small">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600 small">Ikon</label>
                        <input type="text" name="icon" class="form-control" value="{{ $cat->icon }}" maxlength="5">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600 small">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2">{{ $cat->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600 small">Urutan</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ $cat->sort_order }}" min="0">
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                               {{ $cat->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-600 small">Aktif</label>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-coffee flex-fill">Simpan</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
