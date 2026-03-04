<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'product'])
            ->when($request->rating, fn($q) => $q->where('rating', $request->rating))
            ->when($request->approved !== null, fn($q) => $q->where('is_approved', $request->approved))
            ->latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function reply(Request $request, Review $review)
    {
        $request->validate(['admin_reply' => 'nullable|string|max:500']);
        $review->update(['admin_reply' => $request->admin_reply]);
        return back()->with('success', 'Balasan disimpan.');
    }

    public function toggle(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        return response()->json(['is_approved' => $review->is_approved]);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Ulasan dihapus.');
    }
}
