@php
    $reviews      = $product->approvedReviews()->with('user')->latest()->get();
    $avgRating    = $product->average_rating;
    $reviewCount  = $product->review_count;
    $ratingDist   = [];
    for ($i = 5; $i >= 1; $i--) {
        $cnt = $reviews->where('rating', $i)->count();
        $ratingDist[$i] = ['count' => $cnt, 'pct' => $reviewCount > 0 ? round($cnt / $reviewCount * 100) : 0];
    }
@endphp

<div class="product-reviews-section mt-5 pt-4" style="border-top:2px solid #f1f5f9;">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0" style="font-family:'Sora',sans-serif;">
      <i class="bi bi-star-fill text-warning me-2"></i>Ulasan Pelanggan
    </h4>
    @auth
      @php
        $canReview = false;
        if (auth()->check()) {
            $deliveredOrderWithProduct = \App\Models\Order::where('user_id', auth()->id())
                ->where('status', 'delivered')
                ->whereHas('orderItems', fn($q) => $q->where('product_id', $product->id))
                ->first();
            $canReview = $deliveredOrderWithProduct &&
                !\App\Models\Review::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->where('order_id', $deliveredOrderWithProduct->id)->exists();
        }
      @endphp
      @if($canReview)
      <a href="{{ route('review.create', ['order_id' => $deliveredOrderWithProduct->id, 'product_id' => $product->id]) }}"
         class="btn-irvana btn-irvana-sm">
        <i class="bi bi-pencil-square me-1"></i>Tulis Ulasan
      </a>
      @endif
    @endauth
  </div>

  @if($reviewCount > 0)
  {{-- Rating summary --}}
  <div class="row g-3 mb-4 align-items-center">
    <div class="col-auto text-center" style="min-width:110px;">
      <div style="font-size:3.2rem;font-weight:900;color:#1e293b;line-height:1;">{{ number_format($avgRating, 1) }}</div>
      <div class="d-flex justify-content-center gap-1 my-1">
        @for($i = 1; $i <= 5; $i++)
          <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }} text-warning" style="font-size:.9rem;"></i>
        @endfor
      </div>
      <div style="font-size:.78rem;color:#94a3b8;">{{ $reviewCount }} ulasan</div>
    </div>
    <div class="col">
      @foreach($ratingDist as $star => $d)
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:.78rem;font-weight:600;color:#64748b;width:10px;">{{ $star }}</span>
        <i class="bi bi-star-fill text-warning" style="font-size:.7rem;"></i>
        <div style="flex:1;height:8px;background:#f1f5f9;border-radius:999px;overflow:hidden;">
          <div style="width:{{ $d['pct'] }}%;height:100%;background:#f59e0b;border-radius:999px;transition:width .4s;"></div>
        </div>
        <span style="font-size:.75rem;color:#94a3b8;width:24px;">{{ $d['count'] }}</span>
      </div>
      @endforeach
    </div>
  </div>

  {{-- Review list --}}
  <div class="review-list">
    @foreach($reviews as $review)
    <div class="review-item" style="padding:18px 0;border-bottom:1px solid #f1f5f9;">
      <div class="d-flex gap-3">
        <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#0a4db8,#3b72e0);
                    display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem;flex-shrink:0;">
          {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
        </div>
        <div style="flex:1;">
          <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
            <div>
              <span style="font-weight:700;font-size:.9rem;">{{ $review->user->name ?? 'Anonim' }}</span>
              <span style="color:#94a3b8;font-size:.78rem;margin-left:8px;">{{ $review->created_at->diffForHumans() }}</span>
            </div>
            <div class="d-flex gap-1">
              @for($i = 1; $i <= 5; $i++)
                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning" style="font-size:.82rem;"></i>
              @endfor
            </div>
          </div>
          @if($review->title)
            <div style="font-weight:600;font-size:.9rem;margin-top:6px;">{{ $review->title }}</div>
          @endif
          @if($review->body)
            <p style="color:#475569;font-size:.87rem;margin:6px 0 0;line-height:1.6;">{{ $review->body }}</p>
          @endif
          @if($review->admin_reply)
          <div style="background:#f0f5ff;border-left:3px solid #0a4db8;border-radius:0 8px 8px 0;padding:10px 14px;margin-top:10px;">
            <div style="font-size:.75rem;font-weight:700;color:#0a4db8;margin-bottom:4px;">
              <i class="bi bi-shop me-1"></i>Irvana Buah
            </div>
            <p style="font-size:.85rem;color:#475569;margin:0;">{{ $review->admin_reply }}</p>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>

  @else
  <div class="text-center py-4" style="color:#94a3b8;">
    <div style="font-size:2.5rem;margin-bottom:8px;">💬</div>
    <p style="font-size:.9rem;">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
  </div>
  @endif
</div>
