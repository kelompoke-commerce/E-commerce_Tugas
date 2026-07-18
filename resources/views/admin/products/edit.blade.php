@extends('layouts.admin')
@section('title','Edit Produk')
@section('page-title','Edit Produk')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card p-4">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-600">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-600">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-600">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-600">Stok</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-600">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-600">Foto Produk</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                             class="rounded-3" style="max-width:150px;max-height:150px;object-fit:cover">
                        <div class="small text-muted mt-1">Foto saat ini. Upload baru untuk mengganti.</div>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                <div class="mt-2" id="imagePreview" style="display:none">
                    <img id="previewImg" src="" alt="Preview" class="rounded-3" style="max-width:150px;object-fit:cover">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_available" id="is_available"
                           value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                    <label class="form-check-label fw-600" for="is_available">Produk Tersedia</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                           value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label fw-600" for="is_featured">Produk Unggulan ⭐</label>
                </div>
            </div>
            <div class="col-12 d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-coffee px-4">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
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
