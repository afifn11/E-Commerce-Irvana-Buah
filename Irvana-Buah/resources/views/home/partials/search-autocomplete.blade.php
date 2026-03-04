<style>
.search-suggestions {
    position: absolute;
    top: calc(100% + 6px);
    left: 0; right: 0;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,.14);
    border: 1px solid #e2e8f0;
    z-index: 9999;
    overflow: hidden;
    max-height: 380px;
    overflow-y: auto;
}
.search-suggestions:empty { display: none !important; }

.ss-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 14px; cursor: pointer;
    transition: background .15s;
    text-decoration: none; color: inherit;
    border-bottom: 1px solid #f1f5f9;
}
.ss-item:last-child { border-bottom: none; }
.ss-item:hover, .ss-item.ss-active { background: #f0f5ff; }

.ss-img {
    width: 44px; height: 44px; border-radius: 8px;
    object-fit: cover; flex-shrink: 0;
    border: 1px solid #eee;
}
.ss-info { flex: 1; min-width: 0; }
.ss-name {
    font-size: .88rem; font-weight: 600; color: #1e293b;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.ss-name mark {
    background: #fef3c7; color: #92400e;
    border-radius: 2px; padding: 0 2px;
}
.ss-cat  { font-size: .73rem; color: #94a3b8; margin-top: 1px; }
.ss-price { font-size: .85rem; font-weight: 700; color: #0a4db8; white-space: nowrap; }

.ss-header {
    padding: 8px 14px 4px;
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: #94a3b8;
    background: #f8fafc;
}
.ss-footer {
    padding: 10px 14px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    text-align: center;
    font-size: .82rem; font-weight: 600; color: #0a4db8;
    cursor: pointer; transition: background .15s;
}
.ss-footer:hover { background: #eaf0fc; }
.ss-empty {
    padding: 20px; text-align: center;
    font-size: .88rem; color: #94a3b8;
}
.ss-loading {
    padding: 16px; text-align: center; color: #0a4db8;
}
.ss-loading::after {
    content: ''; display: inline-block;
    width: 18px; height: 18px; border-radius: 50%;
    border: 2px solid #d1d5db; border-top-color: #0a4db8;
    animation: ss-spin .6s linear infinite; vertical-align: middle; margin-left: 8px;
}
@keyframes ss-spin { to { transform: rotate(360deg); } }

/* Recent searches */
.ss-recent-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 14px; cursor: pointer;
    transition: background .15s;
    font-size: .86rem; color: #475569;
    border-bottom: 1px solid #f1f5f9;
}
.ss-recent-item:hover { background: #f8fafc; }
.ss-recent-item i { color: #94a3b8; font-size: .85rem; }
.ss-recent-del {
    margin-left: auto; color: #cbd5e1; font-size: .8rem;
    padding: 2px 6px; border-radius: 4px;
}
.ss-recent-del:hover { color: #ef4444; background: #fee2e2; }
</style>

<script>
(function() {
    const SEARCH_URL  = '{{ route("search.products") }}';
    const PRODUCTS_URL = '{{ route("products") }}';
    const MAX_RECENTS  = 5;
    const RECENT_KEY   = 'irvana_recent_searches';

    let debounceTimer;
    let currentQuery = '';
    let activeIndex  = -1;

    function getRecents() {
        try { return JSON.parse(localStorage.getItem(RECENT_KEY) || '[]'); } catch { return []; }
    }
    function saveRecent(q) {
        if (!q || q.length < 2) return;
        let arr = getRecents().filter(s => s.toLowerCase() !== q.toLowerCase());
        arr.unshift(q);
        arr = arr.slice(0, MAX_RECENTS);
        try { localStorage.setItem(RECENT_KEY, JSON.stringify(arr)); } catch {}
    }
    function removeRecent(q) {
        const arr = getRecents().filter(s => s !== q);
        try { localStorage.setItem(RECENT_KEY, JSON.stringify(arr)); } catch {}
    }

    function escapeHtml(s) {
        return s.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    }
    function highlight(text, query) {
        if (!query) return escapeHtml(text);
        const re = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g,'\\$&') + ')', 'gi');
        return escapeHtml(text).replace(re, '<mark>$1</mark>');
    }

    // Setup all search inputs (desktop + mobile)
    document.querySelectorAll('#headerSearchInput, #mobileSearchInput').forEach(input => {
        const wrapper = input.closest('.search-form, form');
        if (!wrapper) return;

        // Ensure suggestions container exists relative to input wrapper
        let box = wrapper.querySelector('.search-suggestions');
        if (!box) {
            box = document.createElement('div');
            box.className = 'search-suggestions';
            box.style.display = 'none';
            wrapper.style.position = 'relative';
            input.parentNode.appendChild(box);
        }

        // Show recents on focus (if empty query)
        input.addEventListener('focus', () => {
            if (!input.value.trim()) showRecents(box);
        });

        input.addEventListener('input', () => {
            const q = input.value.trim();
            currentQuery = q;
            activeIndex  = -1;
            clearTimeout(debounceTimer);
            if (!q) { showRecents(box); return; }
            if (q.length < 2) { box.style.display = 'none'; return; }
            showLoading(box);
            debounceTimer = setTimeout(() => fetchSuggestions(q, box, input), 280);
        });

        // Keyboard navigation
        input.addEventListener('keydown', (e) => {
            const items = [...box.querySelectorAll('.ss-item')];
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = Math.min(activeIndex + 1, items.length - 1);
                items.forEach((el, i) => el.classList.toggle('ss-active', i === activeIndex));
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = Math.max(activeIndex - 1, -1);
                items.forEach((el, i) => el.classList.toggle('ss-active', i === activeIndex));
            } else if (e.key === 'Enter') {
                if (activeIndex >= 0 && items[activeIndex]) {
                    e.preventDefault();
                    items[activeIndex].click();
                } else if (input.value.trim()) {
                    saveRecent(input.value.trim());
                }
                box.style.display = 'none';
            } else if (e.key === 'Escape') {
                box.style.display = 'none';
            }
        });

        // Hide on outside click
        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) box.style.display = 'none';
        });
    });

    function showLoading(box) {
        box.style.display = 'block';
        box.innerHTML = '<div class="ss-loading">Mencari produk</div>';
    }

    function showRecents(box) {
        const recents = getRecents();
        if (!recents.length) { box.style.display = 'none'; return; }
        box.style.display = 'block';
        box.innerHTML = `
            <div class="ss-header"><i class="bi bi-clock-history me-1"></i>Pencarian Terakhir</div>
            ${recents.map(q => `
                <div class="ss-recent-item" data-query="${escapeHtml(q)}">
                    <i class="bi bi-search"></i>
                    <span>${escapeHtml(q)}</span>
                    <span class="ss-recent-del" data-del="${escapeHtml(q)}">✕</span>
                </div>`).join('')}`;

        box.querySelectorAll('.ss-recent-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (e.target.closest('.ss-recent-del')) {
                    const q = e.target.closest('.ss-recent-del').dataset.del;
                    removeRecent(q); showRecents(box); return;
                }
                const q = item.dataset.query;
                window.location.href = `${PRODUCTS_URL}?search=${encodeURIComponent(q)}`;
            });
        });
    }

    function fetchSuggestions(query, box, input) {
        if (query !== currentQuery) return;
        fetch(`${SEARCH_URL}?query=${encodeURIComponent(query)}`)
            .then(r => r.json())
            .then(products => {
                if (query !== currentQuery) return;
                renderSuggestions(products, query, box, input);
            })
            .catch(() => { box.style.display = 'none'; });
    }

    function renderSuggestions(products, query, box, input) {
        if (!products.length) {
            box.style.display = 'block';
            box.innerHTML = `<div class="ss-empty"><i class="bi bi-search me-2"></i>Produk "<strong>${escapeHtml(query)}</strong>" tidak ditemukan</div>`;
            return;
        }
        const items = products.slice(0, 6).map(p => `
            <a href="/product/${p.slug}" class="ss-item" data-slug="${p.slug}">
                <img src="${p.image_url}" alt="${escapeHtml(p.name)}" class="ss-img"
                     onerror="this.src='{{ asset('assets/img/product/product-1.webp') }}'">
                <div class="ss-info">
                    <div class="ss-name">${highlight(p.name, query)}</div>
                    <div class="ss-cat">${escapeHtml(p.category)}</div>
                </div>
                <div class="ss-price">${p.formatted_price}</div>
            </a>`).join('');

        const footer = products.length > 6
            ? `<div class="ss-footer" data-query="${escapeHtml(query)}">Lihat semua ${products.length} hasil &rarr;</div>`
            : '';

        box.style.display = 'block';
        box.innerHTML = `<div class="ss-header"><i class="bi bi-box-seam me-1"></i>Produk</div>${items}${footer}`;

        // Click on item
        box.querySelectorAll('.ss-item').forEach(el => {
            el.addEventListener('click', () => { saveRecent(query); box.style.display = 'none'; });
        });
        // Click on "see all"
        const footerEl = box.querySelector('.ss-footer');
        if (footerEl) {
            footerEl.addEventListener('click', () => {
                saveRecent(query);
                window.location.href = `${PRODUCTS_URL}?search=${encodeURIComponent(footerEl.dataset.query)}`;
            });
        }
    }
})();
</script>
