@extends('layouts.admin')
@section('title','Tambah Produk')
@section('page-title','Tambah Produk Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card p-4">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-600">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Contoh: Kopi Susu Gula Aren" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-600">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Pilih --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-600">Harga (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" min="0" placeholder="20000" required>
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-600">Stok <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', 50) }}" min="0" required>
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label fw-600">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="Deskripsi singkat produk...">{{ old('description') }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-600">Foto Produk</label>
                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*"
                       onchange="previewImage(this)">
                <div class="mt-2" id="imagePreview" style="display:none">
                    <img id="previewImg" src="" alt="Preview" class="rounded-3" style="max-width:200px;max-height:200px;object-fit:cover">
                </div>
                <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2MB.</small>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_available" id="is_available"
                           value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-600" for="is_available">Produk Tersedia</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                           value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label fw-600" for="is_featured">Produk Unggulan ⭐</label>
                </div>
            </div>
            <div class="col-12 d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-coffee px-4">
                    <i class="bi bi-plus-lg me-1"></i>Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>
</div>
</div>
@endsection
@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
