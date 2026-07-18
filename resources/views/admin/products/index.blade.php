@extends('layouts.admin')
@section('title','Kelola Produk')
@section('page-title','Kelola Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    {{-- Info berapa produk unggulan aktif --}}
    <div class="d-flex align-items-center gap-2">
        <span class="badge py-2 px-3" style="background:#fef3e8;color:#6f3d1e;font-size:.85rem">
            <i class="bi bi-star-fill text-warning me-1"></i>
            {{ $products->where('is_featured', true)->count() }} unggulan di halaman ini
        </span>
        @if(request('featured'))
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">Tampilkan Semua</a>
        @else
            <a href="{{ route('admin.products.index', ['featured'=>1]) }}" class="btn btn-sm btn-outline-warning">Filter Unggulan</a>
        @endif
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-coffee">
        <i class="bi bi-plus-lg me-1"></i>Tambah Produk
    </a>
</div>

<div class="card p-3 mb-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->icon }} {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-coffee flex-fill">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th title="Klik bintang untuk toggle unggulan di landing page">
                        Unggulan <i class="bi bi-info-circle text-muted" style="font-size:.7rem"></i>
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $i => $product)
                <tr>
                    <td class="text-muted small">{{ $products->firstItem() + $i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                     class="rounded-2" style="width:44px;height:44px;object-fit:cover;flex-shrink:0">
                            @else
                                <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width:44px;height:44px;background:#f0e8df;font-size:1.4rem">
                                    {{ $product->category->icon ?? '☕' }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-600 small">{{ $product->name }}</div>
                                <div class="text-muted" style="font-size:.7rem">{{ Str::limit($product->description, 40) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge rounded-pill" style="background:#fef3e8;color:#6f3d1e">
                            {{ $product->category->icon ?? '' }} {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="fw-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $product->stock < 5 ? 'bg-danger' : ($product->stock < 20 ? 'bg-warning text-dark' : 'bg-success') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        @if($product->is_available)
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>

                    {{-- Toggle Unggulan — klik langsung dari tabel --}}
                    <td>
                        <form action="{{ route('admin.products.toggleFeatured', $product) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="btn btn-sm border-0 p-0"
                                    title="{{ $product->is_featured ? 'Hapus dari unggulan' : 'Jadikan unggulan' }}"
                                    style="background:none;font-size:1.4rem;line-height:1;cursor:pointer">
                                @if($product->is_featured)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            </button>
                        </form>
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('Hapus produk \'{{ addslashes($product->name) }}\'?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-box-seam fs-2 d-block mb-2"></i>Belum ada produk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div class="d-flex justify-content-center p-3">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</div>

{{-- Keterangan bintang --}}
<div class="mt-2 text-muted small">
    <i class="bi bi-star-fill text-warning me-1"></i> = Tampil di Menu Unggulan landing page &nbsp;|&nbsp;
    <i class="bi bi-star text-muted me-1"></i> = Tidak tampil di landing page
</div>
@endsection
