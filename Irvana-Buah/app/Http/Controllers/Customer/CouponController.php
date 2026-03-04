<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /** AJAX: validate and calculate coupon discount */
    public function apply(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $code   = strtoupper(trim($request->code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json(['success' => false, 'message' => 'Kode kupon tidak valid atau sudah kadaluarsa.']);
        }

        // Check per-user limit
        if ($coupon->per_user_limit && $coupon->usageCountByUser(Auth::id()) >= $coupon->per_user_limit) {
            return response()->json(['success' => false, 'message' => 'Anda sudah menggunakan kupon ini.']);
        }

        // Calculate subtotal from cart
        $subtotal = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get()
            ->sum(fn($item) => $item->quantity * ($item->product->effective_price ?? 0));

        if ($subtotal < $coupon->min_order) {
            $min = number_format($coupon->min_order, 0, ',', '.');
            return response()->json(['success' => false, 'message' => "Minimum pembelian Rp {$min} untuk kupon ini."]);
        }

        $discount = $coupon->calculateDiscount($subtotal);
        $final    = max(0, $subtotal - $discount);

        return response()->json([
            'success'          => true,
            'message'          => "Kupon berhasil! Hemat Rp " . number_format($discount, 0, ',', '.'),
            'coupon_id'        => $coupon->id,
            'coupon_code'      => $coupon->code,
            'discount_amount'  => $discount,
            'discount_display' => 'Rp ' . number_format($discount, 0, ',', '.'),
            'subtotal'         => $subtotal,
            'total_display'    => 'Rp ' . number_format($final, 0, ',', '.'),
            'description'      => $coupon->description,
        ]);
    }
}
