<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders    = Order::count();
        $totalRevenue   = Order::whereIn('status', ['paid','processing','completed'])->sum('total');
        $totalProducts  = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // Monthly revenue for chart (last 12 months)
        $monthlyRevenue = Order::whereIn('status', ['paid','processing','completed'])
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as total')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(8)
            ->get();

        // Top products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_items.quantity) as total_qty, SUM(order_items.subtotal) as total_revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Monthly recap (current month)
        $currentMonth = now()->month;
        $currentYear  = now()->year;
        $monthlyRecap = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->selectRaw('status, COUNT(*) as count, SUM(total) as total')
            ->groupBy('status')
            ->get();

        $pendingOrders = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts', 'totalCustomers',
            'monthlyRevenue', 'recentOrders', 'topProducts', 'monthlyRecap',
            'pendingOrders'
        ));
    }
}
