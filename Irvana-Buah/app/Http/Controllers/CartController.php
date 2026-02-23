<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat keranjang');
        }

        $cartItems = Cart::with('product.category')
            ->where('user_id', Auth::id())
            ->get();

        $totalPrice = $cartItems->sum(fn($item) => $item->quantity * $item->product->effective_price);

        return view('home.cart', compact('cartItems', 'totalPrice'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return response()->json(['success' => false, 'message' => 'Produk tidak tersedia']);
        }

        // Cek stok
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        $totalQuantity = $request->quantity + ($existingCart ? $existingCart->quantity : 0);

        if ($product->stock < $totalQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock . ' kg',
            ]);
        }

        // FIX: Tidak pakai DB::raw agar tidak double
        if ($existingCart) {
            $existingCart->update(['quantity' => $existingCart->quantity + $request->quantity]);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success'    => true,
            'message'    => $product->name . ' berhasil ditambahkan ke keranjang',
            'cart_count' => $cartCount,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate(['quantity' => 'required|integer|min:1']);

        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($cartItem->product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $cartItem->product->stock . ' kg',
            ]);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        $totalPrice = Cart::with('product')->where('user_id', Auth::id())->get()
            ->sum(fn($item) => $item->quantity * $item->product->effective_price);

        return response()->json([
            'success'             => true,
            'message'             => 'Keranjang berhasil diperbarui',
            'total_price'         => $totalPrice,
            'formatted_total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            'cart_count'          => Cart::where('user_id', Auth::id())->sum('quantity'),
        ]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cartItem->delete();

        $cartCount  = Cart::where('user_id', Auth::id())->sum('quantity');
        $totalPrice = Cart::with('product')->where('user_id', Auth::id())->get()
            ->sum(fn($item) => $item->quantity * $item->product->effective_price);

        return response()->json([
            'success'               => true,
            'message'               => 'Produk berhasil dihapus dari keranjang',
            'cart_count'            => $cartCount,
            'total_price'           => $totalPrice,
            'formatted_total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
        ]);
    }

    public function clear()
    {
        if (!Auth::check()) return redirect()->route('login');
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function getCount()
    {
        if (!Auth::check()) return response()->json(['count' => 0]);
        return response()->json(['count' => Cart::where('user_id', Auth::id())->sum('quantity')]);
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $cartItems = Cart::with('product.category')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong');
        }

        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', 'Stok ' . $item->product->name . ' tidak mencukupi');
            }
        }

        $totalPrice = $cartItems->sum(fn($item) => $item->quantity * $item->product->effective_price);

        return view('home.checkout', compact('cartItems', 'totalPrice'));
    }
}
