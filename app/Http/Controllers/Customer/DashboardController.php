<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Product::where('is_available', true)->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products      = $query->latest()->paginate(12);
        $featuredItems = Product::where('is_available', true)->where('is_featured', true)->take(6)->get();
        $cartCount     = auth()->user()->carts()->count();
        $recentOrders  = auth()->user()->orders()->latest()->take(3)->get();

        return view('customer.dashboard', compact(
            'categories', 'products', 'featuredItems', 'cartCount', 'recentOrders'
        ));
    }

    public function show(Product $product)
    {
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->take(4)
            ->get();

        return view('customer.product-detail', compact('product', 'related'));
    }
}
