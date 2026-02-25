<footer style="border-top:1px solid var(--glass-border);padding:1.25rem 1rem;margin-top:auto;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:24px;height:24px;background:var(--accent-dim);border:1px solid rgba(62,207,207,0.2);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                    <x-application-logo class="block h-3 w-auto fill-current" style="color:var(--accent)" />
                </div>
                <span style="font-size:0.78rem;font-weight:600;color:var(--text-muted);">Irvana Buah</span>
                <span style="font-size:0.72rem;color:var(--text-muted);padding:0.15rem 0.5rem;background:var(--glass-bg);border:1px solid var(--glass-border);border-radius:var(--radius-full);">v2.0</span>
            </div>
            <p style="font-size:0.75rem;color:var(--text-muted);">
                © {{ date('Y') }} Irvana Buah. All rights reserved.
            </p>
            <div style="display:flex;align-items:center;gap:0.375rem;">
                <a href="{{ route('dashboard') }}" style="font-size:0.75rem;color:var(--text-muted);" class="{{ request()->routeIs('dashboard') ? '' : '' }}">Dashboard</a>
                <span style="color:var(--glass-border);">·</span>
                <a href="{{ route('products.index') }}" style="font-size:0.75rem;color:var(--text-muted);">Produk</a>
                <span style="color:var(--glass-border);">·</span>
                <a href="{{ route('orders.index') }}" style="font-size:0.75rem;color:var(--text-muted);">Pesanan</a>
            </div>
        </div>
    </div>
</footer>
