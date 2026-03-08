<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><span>Kupon</span></p>
                <h2 class="page-title">Manajemen Kupon & Promo</h2>
            </div>
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Buat Kupon Baru
            </a>
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
                    <div class="stat-icon-wrap"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg></div>
                    <div class="stat-meta">Total Kupon</div>
                    <div class="stat-value">{{ $coupons->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(52,211,153,.1);border-color:rgba(52,211,153,.15);color:var(--success)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg></div>
                    <div class="stat-meta">Aktif</div>
                    <div class="stat-value">{{ $coupons->where('is_active', true)->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(96,165,250,.1);border-color:rgba(96,165,250,.15);color:var(--info)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                    <div class="stat-meta">Total Dipakai</div>
                    <div class="stat-value">{{ $coupons->sum('usage_count') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(248,113,113,.1);border-color:rgba(248,113,113,.15);color:var(--danger)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="stat-meta">Kadaluarsa</div>
                    <div class="stat-value">{{ $coupons->filter(fn($c) => $c->expires_at && $c->expires_at->isPast())->count() }}</div>
                </div>
            </div>

            <div class="table-wrap">
                @if($coupons->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg></div>
                        <p class="empty-state-title">Belum ada kupon</p>
                        <p class="empty-state-text">Buat kupon promo pertama Anda</p>
                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm" style="margin-top:1rem;">Buat Kupon</a>
                    </div>
                @else
                    <table class="table-glass">
                        <thead><tr>
                            <th>Kode</th>
                            <th>Tipe & Nilai</th>
                            <th>Min. Order</th>
                            <th>Penggunaan</th>
                            <th>Berlaku Sampai</th>
                            <th style="text-align:center;">Aktif</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr></thead>
                        <tbody>
                        @foreach($coupons as $c)
                        <tr>
                            <td>
                                <span style="font-family:var(--font-mono);font-size:.85rem;font-weight:700;color:var(--accent);background:rgba(99,102,241,.08);padding:3px 10px;border-radius:6px;letter-spacing:.04em;">{{ $c->code }}</span>
                                @if($c->description)<p style="font-size:.74rem;color:var(--text-muted);margin-top:4px;">{{ $c->description }}</p>@endif
                            </td>
                            <td>
                                <span class="badge {{ $c->type === 'percent' ? 'badge-blue' : 'badge-green' }}"><span class="badge-dot"></span>{{ $c->type === 'percent' ? 'Persen' : 'Nominal' }}</span>
                                <p style="font-size:.84rem;font-weight:700;color:var(--text-primary);margin-top:4px;">
                                    {{ $c->formatted_value }}
                                    @if($c->type === 'percent' && $c->max_discount)<span style="font-weight:400;font-size:.75rem;color:var(--text-muted);">(maks Rp {{ number_format($c->max_discount,0,',','.') }})</span>@endif
                                </p>
                            </td>
                            <td style="font-size:.84rem;">{{ $c->min_order > 0 ? 'Rp '.number_format($c->min_order,0,',','.') : '—' }}</td>
                            <td style="font-size:.84rem;">
                                <span style="font-weight:600;color:var(--text-primary);">{{ $c->usage_count }}</span>
                                <span style="color:var(--text-muted);">{{ $c->usage_limit ? ' / '.$c->usage_limit : ' / ∞' }}</span>
                            </td>
                            <td style="font-size:.8rem;">
                                @if($c->expires_at)
                                    @if($c->expires_at->isPast())
                                        <span class="badge badge-red">Kadaluarsa</span>
                                    @else
                                        <span style="color:var(--text-primary);">{{ $c->expires_at->format('d M Y') }}</span>
                                        <p style="font-size:.72rem;color:var(--text-muted);">{{ $c->expires_at->diffForHumans() }}</p>
                                    @endif
                                @else
                                    <span style="color:var(--text-muted);">Tidak ada batas</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <label style="display:inline-flex;align-items:center;cursor:pointer;">
                                    <input type="checkbox" class="coupon-toggle sr-only" data-id="{{ $c->id }}" {{ $c->is_active ? 'checked' : '' }}>
                                    <div class="toggle-track {{ $c->is_active ? 'toggle-on' : '' }}" style="width:36px;height:20px;border-radius:10px;background:{{ $c->is_active ? 'var(--success)' : 'rgba(255,255,255,.12)' }};position:relative;transition:background .2s;">
                                        <div style="position:absolute;top:2px;left:{{ $c->is_active ? '18px' : '2px' }};width:16px;height:16px;background:#fff;border-radius:50%;transition:left .2s;box-shadow:0 1px 3px rgba(0,0,0,.3);"></div>
                                    </div>
                                </label>
                            </td>
                            <td>
                                <div class="table-actions" style="justify-content:center;">
                                    <a href="{{ route('admin.coupons.edit', $c) }}" class="table-action-btn edit" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" class="table-action-btn delete" title="Hapus"
                                        onclick="confirmDelete('{{ route('admin.coupons.destroy', $c) }}', '{{ addslashes($c->code) }}')">
                                        <svg class="w-3.5 h-3.5" style="pointer-events:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($coupons, 'links'))
                    <div style="padding:1rem 1.25rem;"><div class="pagination-wrap">{{ $coupons->links() }}</div></div>
                    @endif
                @endif
            </div>

        </div>

        {{-- Delete Modal --}}
        <div id="deleteModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.7);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:1rem;">
            <div style="background:rgba(12,17,24,.97);border:1px solid var(--glass-border-strong);border-radius:var(--radius-2xl);padding:2rem;max-width:26rem;width:100%;text-align:center;box-shadow:var(--shadow-lg);">
                <div style="width:52px;height:52px;background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;color:var(--danger)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.667-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:.5rem;">Hapus Kupon?</h3>
                <p style="font-size:.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">
                    Kupon <strong id="deleteModalName" style="color:var(--text-primary);font-family:var(--font-mono);"></strong> akan dihapus permanen.
                </p>
                <div style="display:flex;gap:.75rem;justify-content:center;">
                    <button onclick="document.getElementById('deleteModal').style.display='none'" class="btn btn-ghost">Batal</button>
                    <button onclick="document.getElementById('deleteForm').submit()" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
        <form id="deleteForm" method="POST" style="display:none;">
            @csrf @method('DELETE')
        </form>

    </div>
</x-app-layout>

<script>
function confirmDelete(url, name) {
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteModalName').textContent = name;
    document.getElementById('deleteModal').style.display = 'flex';
}
document.querySelectorAll('.coupon-toggle').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const track = this.nextElementSibling;
        const dot   = track.querySelector('div');
        fetch('/admin/coupons/' + this.dataset.id + '/toggle', {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
        })
        .then(r => r.json())
        .then(data => {
            track.style.background = data.is_active ? 'var(--success)' : 'rgba(255,255,255,.12)';
            dot.style.left = data.is_active ? '18px' : '2px';
        });
    });
});
</script>