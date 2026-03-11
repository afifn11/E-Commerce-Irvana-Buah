const CACHE_NAME    = 'irvana-buah-v5';
const STATIC_ASSETS = [
  '/assets/img/logo.webp',
  '/assets/img/favicon.png',
  '/assets/vendor/bootstrap/css/bootstrap.min.css',
  '/assets/vendor/bootstrap-icons/bootstrap-icons.css',
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(STATIC_ASSETS).catch(() => {}))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys()
      .then(keys => Promise.all(
        keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k))
      ))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  const { request } = event;

  if (request.method !== 'GET') return;

  const url = new URL(request.url);
  if (url.origin !== self.location.origin) return;

  const skipPaths = [
    '/admin', '/cart', '/checkout', '/payment',
    '/coupon', '/review', '/points', '/login',
    '/register', '/logout', '/api',
  ];
  if (skipPaths.some(p => url.pathname.startsWith(p))) return;

  // CSS & JS — selalu network-first agar update langsung ter-apply
  if (/\.(css|js)(\?|$)/.test(url.pathname)) {
    event.respondWith(
      fetch(request)
        .then(response => {
          if (response.ok) {
            const clone = response.clone();
            caches.open(CACHE_NAME).then(c => c.put(request, clone));
          }
          return response;
        })
        .catch(() => caches.match(request))
    );
    return;
  }

  if (request.mode === 'navigate') {
    // Network-first untuk halaman HTML
    event.respondWith(
      fetch(request)
        .then(response => {
          if (response.ok) {
            const clone = response.clone();
            caches.open(CACHE_NAME).then(c => c.put(request, clone));
          }
          return response;
        })
        .catch(() => caches.match(request).then(r => r || caches.match('/')))
    );
  } else {
    // Cache-first hanya untuk gambar/font
    event.respondWith(
      caches.match(request).then(cached => {
        if (cached) return cached;
        return fetch(request).then(response => {
          if (response.ok && response.status === 200 &&
              /\.(png|webp|jpg|jpeg|woff2?|svg|ico)(\?|$)/.test(request.url)) {
            const clone = response.clone();
            caches.open(CACHE_NAME).then(c => c.put(request, clone));
          }
          return response;
        }).catch(() => caches.match(request));
      })
    );
  }
});