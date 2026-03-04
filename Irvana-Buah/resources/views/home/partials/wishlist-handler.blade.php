<script>
(function() {
    const TOGGLE_URL = '{{ route("wishlist.toggle") }}';
    const LOGIN_URL  = '{{ route("login") }}';
    const IS_AUTH    = {{ auth()->check() ? 'true' : 'false' }};
    const CSRF       = document.querySelector('meta[name=csrf-token]')?.content || '';

    // Load wishlist state on page load and mark hearts
    if (IS_AUTH) {
        fetch('{{ route("wishlist.status") }}')
            .then(r => r.json())
            .then(ids => {
                document.querySelectorAll('[data-wishlist-id]').forEach(btn => {
                    if (ids.includes(parseInt(btn.dataset.wishlistId))) {
                        markActive(btn);
                    }
                });
            });
    }

    // Delegate click on all wishlist buttons
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.irvana-action-btn[data-wishlist-id], .btn-wishlist-toggle[data-wishlist-id]');
        if (!btn) return;
        e.preventDefault();

        if (!IS_AUTH) {
            showWishlistToast('Silakan login untuk menyimpan wishlist', 'info');
            setTimeout(() => window.location.href = LOGIN_URL, 1200);
            return;
        }

        const productId = btn.dataset.wishlistId;
        const icon = btn.querySelector('i');

        // Optimistic UI
        btn.classList.add('wl-loading');

        fetch(TOGGLE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
            },
            body: JSON.stringify({ product_id: productId }),
        })
        .then(r => r.json())
        .then(data => {
            btn.classList.remove('wl-loading');
            if (data.wishlisted) {
                markActive(btn);
                showWishlistToast('Ditambahkan ke wishlist ❤️');
            } else {
                markInactive(btn);
                showWishlistToast('Dihapus dari wishlist');
            }
            // Update wishlist badge in header
            const wlBadge = document.getElementById('wishlist-badge');
            if (wlBadge) {
                wlBadge.textContent = data.count;
                wlBadge.style.display = data.count > 0 ? '' : 'none';
            }
        })
        .catch(() => {
            btn.classList.remove('wl-loading');
            showWishlistToast('Terjadi kesalahan', 'error');
        });
    });

    function markActive(btn) {
        btn.classList.add('wishlisted');
        const i = btn.querySelector('i');
        if (i) { i.className = i.className.replace('bi-heart', 'bi-heart-fill'); }
        btn.style.color = '#ef4444';
    }

    function markInactive(btn) {
        btn.classList.remove('wishlisted');
        const i = btn.querySelector('i');
        if (i) { i.className = i.className.replace('bi-heart-fill', 'bi-heart'); }
        btn.style.color = '';
    }

    function showWishlistToast(msg, type = 'success') {
        const existing = document.getElementById('wl-toast');
        if (existing) existing.remove();
        const el = document.createElement('div');
        el.id = 'wl-toast';
        const color = type === 'success' ? '#ef4444' : type === 'info' ? '#0a4db8' : '#888';
        el.style.cssText = `
            position:fixed;top:20px;left:50%;transform:translateX(-50%) translateY(-8px);
            z-index:10001;padding:11px 22px;border-radius:999px;font-weight:600;font-size:.88rem;
            background:${color};color:#fff;box-shadow:0 4px 20px rgba(0,0,0,.18);
            display:flex;align-items:center;gap:8px;
            animation:wlFadeIn .3s ease forwards;white-space:nowrap;
        `;
        el.innerHTML = msg;
        document.body.appendChild(el);
        setTimeout(() => el.style.opacity = '0', 2200);
        setTimeout(() => el.remove(), 2600);
    }
})();
</script>
<style>
@keyframes wlFadeIn { from { opacity:0; transform:translateX(-50%) translateY(-16px); } to { opacity:1; transform:translateX(-50%) translateY(0); } }
.irvana-action-btn.wishlisted { color: #ef4444 !important; }
.irvana-action-btn.wl-loading { opacity: .5; pointer-events: none; }
</style>
