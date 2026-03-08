<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><span>Ulasan</span></p>
            <h2 class="page-title">Manajemen Ulasan Produk</h2>
        </div>
    </x-slot>

    <div class="dashboard-body">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <x-modal name="success-notification" :show="true" max-width="md">
                    <div style="padding:2rem;text-align:center;">
                        <div style="width:52px;height:52px;background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;color:var(--success)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem;">Berhasil!</h3>
                        <p style="font-size:0.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">{{ session('success') }}</p>
                        <button x-on:click="show = false" class="btn btn-success btn-sm">OK</button>
                    </div>
                </x-modal>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                    <div class="stat-meta">Total Ulasan</div>
                    <div class="stat-value">{{ $reviews->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(52,211,153,.1);border-color:rgba(52,211,153,.15);color:var(--success)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg></div>
                    <div class="stat-meta">Disetujui</div>
                    <div class="stat-value">{{ $reviews->where('is_approved', true)->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.15);color:var(--warning)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="stat-meta">Menunggu</div>
                    <div class="stat-value">{{ $reviews->where('is_approved', false)->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(96,165,250,.1);border-color:rgba(96,165,250,.15);color:var(--info)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg></div>
                    <div class="stat-meta">Sudah Dibalas</div>
                    <div class="stat-value">{{ $reviews->whereNotNull('admin_reply')->count() }}</div>
                </div>
            </div>

            <div class="table-wrap">
                @if($reviews->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        </div>
                        <p class="empty-state-title">Belum ada ulasan</p>
                        <p class="empty-state-text">Ulasan dari pelanggan akan muncul di sini</p>
                    </div>
                @else
                    <table class="table-glass">
                        <thead><tr>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Rating</th>
                            <th>Ulasan</th>
                            <th>Tanggal</th>
                            <th style="text-align:center;">Tampil</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr></thead>
                        <tbody>
                        @foreach($reviews as $review)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div style="width:30px;height:30px;background:linear-gradient(135deg,var(--accent),#60a5fa);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <span style="font-size:.65rem;font-weight:700;color:var(--bg-base);">{{ strtoupper(substr($review->user->name ?? 'U', 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <p style="font-size:.84rem;font-weight:600;color:var(--text-primary);">{{ $review->user->name ?? '—' }}</p>
                                        <p style="font-size:.75rem;color:var(--text-muted);">{{ $review->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="max-width:160px;">
                                <p style="font-size:.84rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $review->product->name ?? 'Produk dihapus' }}</p>
                            </td>
                            <td>
                                <div style="display:flex;gap:2px;margin-bottom:2px;">
                                    @for($i=1;$i<=5;$i++)
                                        <svg fill="{{ $i<=$review->rating ? '#f59e0b' : 'none' }}" stroke="#f59e0b" viewBox="0 0 24 24" style="width:13px;height:13px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span style="font-size:.75rem;color:var(--text-muted);">{{ $review->rating }}/5</span>
                            </td>
                            <td style="max-width:240px;">
                                @if($review->title)<p style="font-size:.84rem;font-weight:600;color:var(--text-primary);margin-bottom:2px;">{{ $review->title }}</p>@endif
                                <p style="font-size:.8rem;color:var(--text-muted);overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $review->body ?: '(Tanpa komentar)' }}</p>
                                @if($review->admin_reply)
                                    <p style="font-size:.74rem;color:var(--accent);margin-top:4px;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:11px;height:11px;display:inline;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                        Sudah dibalas
                                    </p>
                                @endif
                                {{-- Reply form --}}
                                <div id="reply-{{ $review->id }}" style="display:none;margin-top:10px;padding:10px;background:rgba(255,255,255,.04);border:1px solid var(--glass-border);border-radius:8px;">
                                    <form method="POST" action="{{ route('admin.reviews.reply', $review) }}">
                                        @csrf
                                        <textarea name="admin_reply" rows="2"
                                            style="width:100%;padding:8px;border:1px solid var(--glass-border);border-radius:6px;font-size:.82rem;background:rgba(255,255,255,.04);color:var(--text-primary);resize:vertical;box-sizing:border-box;"
                                            placeholder="Tulis balasan untuk pelanggan...">{{ $review->admin_reply }}</textarea>
                                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top:6px;">Simpan Balasan</button>
                                    </form>
                                </div>
                            </td>
                            <td style="font-size:.8rem;color:var(--text-muted);white-space:nowrap;">
                                {{ $review->created_at->format('d M Y') }}
                                <p style="font-size:.72rem;">{{ $review->created_at->format('H:i') }}</p>
                            </td>
                            <td style="text-align:center;">
                                <label style="display:inline-flex;align-items:center;cursor:pointer;">
                                    <input type="checkbox" class="review-toggle sr-only" data-id="{{ $review->id }}" {{ $review->is_approved ? 'checked' : '' }}>
                                    <div class="rev-track" data-id="{{ $review->id }}"
                                         style="width:36px;height:20px;border-radius:10px;background:{{ $review->is_approved ? 'var(--success)' : 'rgba(255,255,255,.12)' }};position:relative;transition:background .2s;cursor:pointer;">
                                        <div style="position:absolute;top:2px;left:{{ $review->is_approved ? '18px' : '2px' }};width:16px;height:16px;background:#fff;border-radius:50%;transition:left .2s;box-shadow:0 1px 3px rgba(0,0,0,.3);"></div>
                                    </div>
                                </label>
                            </td>
                            <td>
                                <div class="table-actions" style="justify-content:center;">
                                    <button type="button" class="table-action-btn view" title="Balas" onclick="toggleReply({{ $review->id }})">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    </button>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ulasan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="table-action-btn delete" title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($reviews, 'links'))
                    <div style="padding:1rem 1.25rem;"><div class="pagination-wrap">{{ $reviews->links() }}</div></div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

<script>
function toggleReply(id) {
    const el = document.getElementById('reply-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
document.querySelectorAll('.review-toggle').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const track = this.nextElementSibling;
        const dot   = track.querySelector('div');
        fetch('/admin/reviews/' + this.dataset.id + '/toggle', {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
        })
        .then(r => r.json())
        .then(data => {
            track.style.background = data.is_approved ? 'var(--success)' : 'rgba(255,255,255,.12)';
            dot.style.left = data.is_approved ? '18px' : '2px';
        });
    });
});
</script>