<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /** Show review form for an order item */
    public function create(Request $request)
    {
        $orderId   = $request->order_id;
        $productId = $request->product_id;

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->firstOrFail();

        // Check product is in order
        $orderItem = OrderItem::where('order_id', $orderId)
            ->where('product_id', $productId)->firstOrFail();

        // Already reviewed?
        $existing = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('order_id', $orderId)->first();

        return view('customer.review-form', compact('order', 'orderItem', 'existing'));
    }

    /** Store or update review */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'title'      => 'nullable|string|max:100',
            'body'       => 'nullable|string|max:1000',
        ]);

        $order = Order::where('id', $validated['order_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->firstOrFail();

        OrderItem::where('order_id', $validated['order_id'])
            ->where('product_id', $validated['product_id'])->firstOrFail();

        Review::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'product_id' => $validated['product_id'],
                'order_id'   => $validated['order_id'],
            ],
            [
                'rating' => $validated['rating'],
                'title'  => $validated['title'],
                'body'   => $validated['body'],
            ]
        );

        return redirect()->route('customer.orders.show', $validated['order_id'])
            ->with('success', 'Ulasan berhasil disimpan! Terima kasih.');
    }
}
