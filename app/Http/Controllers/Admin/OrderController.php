<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', date('m', strtotime($request->month)))
                  ->whereYear('created_at', date('Y', strtotime($request->month)));
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        if ($request->status === 'paid' && !$order->paid_at) {
            $order->update(['paid_at' => now()]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function recap(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        [$year, $mon] = explode('-', $month);

        $orders = Order::with(['user', 'items'])
            ->whereMonth('created_at', $mon)
            ->whereYear('created_at', $year)
            ->latest()
            ->get();

        $summary = [
            'total_orders'   => $orders->count(),
            'total_revenue'  => $orders->whereIn('status', ['paid','processing','completed'])->sum('total'),
            'pending'        => $orders->where('status', 'pending')->count(),
            'paid'           => $orders->where('status', 'paid')->count(),
            'processing'     => $orders->where('status', 'processing')->count(),
            'completed'      => $orders->where('status', 'completed')->count(),
            'cancelled'      => $orders->where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.recap', compact('orders', 'summary', 'month'));
    }
}
