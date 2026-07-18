<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        $products   = $query->latest()->paginate(15);
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . time(),
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
            'image'       => $imagePath,
            'is_available'=> $request->boolean('is_available'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . $product->id,
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
            'image'       => $imagePath,
            'is_available'=> $request->boolean('is_available'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }

    // Toggle unggulan langsung dari tabel tanpa masuk halaman edit
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        $label = $product->is_featured ? 'ditandai sebagai unggulan ⭐' : 'dihapus dari unggulan';
        return back()->with('success', "Produk \"{$product->name}\" {$label}.");
    }
}
