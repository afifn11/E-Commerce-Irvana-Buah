{{-- Global Add-to-Cart handler for btn-add-to-cart class --}}
<script>
(function() {
    const CART_URL  = '{{ route("cart.store") }}';
    const CSRF      = '{{ csrf_token() }}';
    const LOGIN_URL = '{{ route("login") }}';
    const IS_AUTH   = {{ auth()->check() ? 'true' : 'false' }};

    function handleCartClick(btn) {
        if (!IS_AUTH) {
            window.location.href = LOGIN_URL;
            return;
        }
        const productId   = btn.dataset.productId;
        const productName = btn.dataset.productName || '';
        const origHTML    = btn.innerHTML;

        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Menambahkan...';

        fetch(CART_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i>Ditambahkan!';
                btn.style.background = '#38a169';
                // Update cart badge
                const badge = document.getElementById('cart-badge');
                if (badge && data.cart_count !== undefined) badge.textContent = data.cart_count;
                setTimeout(() => {
                    btn.innerHTML = origHTML;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 2000);
            } else {
                btn.disabled  = false;
                btn.innerHTML = origHTML;
                // show small toast or alert
                showCartMsg(btn, data.message || 'Gagal menambahkan.', 'danger');
            }
        })
        .catch(err => {
            btn.disabled  = false;
            btn.innerHTML = origHTML;
        });
    }

    function showCartMsg(refEl, msg, type) {
        const el = document.createElement('div');
        el.className = `alert alert-${type} py-1 px-2 mt-1 small`;
        el.style.cssText = 'position:absolute;z-index:999;white-space:nowrap;font-size:0.8rem;';
        el.textContent = msg;
        refEl.parentNode.style.position = 'relative';
        refEl.parentNode.appendChild(el);
        setTimeout(() => el.remove(), 3000);
    }

    // Attach via delegation so it works for dynamically rendered cards too
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-add-to-cart');
        if (btn && !btn.disabled && !btn.classList.contains('irvana-cart-disabled')) {
            e.preventDefault();
            handleCartClick(btn);
        }
    });
})();
</script>
