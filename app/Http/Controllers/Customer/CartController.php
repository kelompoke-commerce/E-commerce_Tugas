<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts    = auth()->user()->carts()->with('product.category')->get();
        $subtotal = $carts->sum(fn($c) => $c->quantity * $c->product->price);
        $total    = $subtotal;

        return view('customer.cart', compact('carts', 'subtotal', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_available) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            $newQty = $cart->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $cart->update(['quantity' => $newQty]);
        } else {
            if ($request->quantity > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return back()->with('success', $product->name . ' ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);

        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);
        $cart->delete();
        return back()->with('success', 'Item dihapus dari keranjang!');
    }

    public function clear()
    {
        auth()->user()->carts()->delete();
        return back()->with('success', 'Keranjang dikosongkan!');
    }
}
