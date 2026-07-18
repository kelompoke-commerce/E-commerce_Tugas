<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function checkout()
    {
        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang Anda masih kosong!');
        }

        $subtotal = $carts->sum(fn($c) => $c->quantity * $c->product->price);
        $total    = $subtotal;
        $user     = auth()->user();

        return view('customer.checkout', compact('carts', 'subtotal', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method'   => 'required|in:qris,dana,gopay,ovo,shopeepay,transfer_bank',
            'notes'            => 'nullable|string|max:500',
            'payment_proof'    => 'required|image|mimes:jpg,jpeg,png|max:3048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.max'      => 'Ukuran file maksimal 3MB.',
        ]);

        $carts = auth()->user()->carts()->with('product')->get();
        if ($carts->isEmpty()) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang kosong!');
        }

        $subtotal = $carts->sum(fn($c) => $c->quantity * $c->product->price);
        $total    = $subtotal;
        DB::beginTransaction();
        try {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => Order::generateOrderNumber(),
                'subtotal'         => $subtotal,
                'total'            => $total,
                'status'           => 'paid',
                'payment_method'   => $request->payment_method,
                'payment_proof'    => $proofPath,
                'paid_at'          => now(),
                'notes'            => $request->notes,
                'shipping_name'    => $request->shipping_name,
                'shipping_phone'   => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $cart->product_id,
                    'product_name'  => $cart->product->name,
                    'product_price' => $cart->product->price,
                    'quantity'      => $cart->quantity,
                    'subtotal'      => $cart->quantity * $cart->product->price,
                ]);

                // Reduce stock
                $cart->product->decrement('stock', $cart->quantity);
            }

            // Clear cart
            auth()->user()->carts()->delete();

            DB::commit();

            return redirect()->route('customer.orders.receipt', $order->id)
                             ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function receipt(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product', 'user');
        return view('customer.receipt', compact('order'));
    }

    public function history(Request $request)
    {
        $query = auth()->user()->orders()->with('items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);
        return view('customer.order-history', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product');
        return view('customer.order-detail', compact('order'));
    }
}
