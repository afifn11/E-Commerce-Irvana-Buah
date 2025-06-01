<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id; // Asumsikan sudah login via Sanctum
        return Cart::with('product')->where('user_id', $userId)->get();
    }

    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek apakah product sudah ada di cart user
        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $data['product_id'])
                    ->first();

        if ($cart) {
            $cart->quantity += $data['quantity'];
            $cart->save();
            return response()->json($cart, 200);
        }

        $cart = Cart::create([
            'user_id' => $userId,
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
        ]);
        return response()->json($cart, 201);
    }

    public function update(Request $request, Cart $cart)
    {
        $userId = $request->user()->id;
        if($cart->user_id !== $userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cart->update($data);
        return response()->json($cart);
    }

    public function destroy(Request $request, Cart $cart)
    {
        $userId = $request->user()->id;
        if($cart->user_id !== $userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $cart->delete();
        return response()->json(null, 204);
    }
}
