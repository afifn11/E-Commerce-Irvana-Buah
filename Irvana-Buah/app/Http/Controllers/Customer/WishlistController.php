<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /** Toggle wishlist (add / remove) — returns JSON */
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $userId    = Auth::id();
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
            $message    = 'Produk dihapus dari wishlist';
        } else {
            Wishlist::create(['user_id' => $userId, 'product_id' => $productId]);
            $wishlisted = true;
            $message    = 'Produk ditambahkan ke wishlist';
        }

        $count = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'success'    => true,
            'wishlisted' => $wishlisted,
            'message'    => $message,
            'count'      => $count,
        ]);
    }

    /** Wishlist page */
    public function index()
    {
        $items = Wishlist::with('product.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.wishlist', compact('items'));
    }

    /** Remove single item */
    public function destroy(int $id)
    {
        Wishlist::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Produk dihapus dari wishlist.');
    }

    /** Get wishlist status for multiple products — for page rendering */
    public function status(Request $request)
    {
        if (!Auth::check()) return response()->json([]);

        $ids = Wishlist::where('user_id', Auth::id())
            ->pluck('product_id')
            ->toArray();

        return response()->json($ids);
    }
}
