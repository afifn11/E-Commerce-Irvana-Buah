<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.form', ['coupon' => new Coupon]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Coupon::create($data);
        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil dibuat.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.form', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($this->validated($request, $coupon));
        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil diperbarui.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Kupon dihapus.');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return response()->json(['is_active' => $coupon->is_active]);
    }

    private function validated(Request $request, ?Coupon $coupon = null): array
    {
        return $request->validate([
            'code'          => 'required|string|max:50|unique:coupons,code' . ($coupon?->id ? ",{$coupon->id}" : ''),
            'type'          => 'required|in:percent,fixed',
            'value'         => 'required|numeric|min:1',
            'min_order'     => 'nullable|numeric|min:0',
            'max_discount'  => 'nullable|numeric|min:0',
            'usage_limit'   => 'nullable|integer|min:1',
            'per_user_limit'=> 'nullable|integer|min:1',
            'is_active'     => 'boolean',
            'starts_at'     => 'nullable|date',
            'expires_at'    => 'nullable|date|after_or_equal:starts_at',
            'description'   => 'nullable|string|max:200',
        ]);
    }
}
