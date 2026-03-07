const CACHE_NAME    = 'irvana-buah-v1';
const STATIC_ASSETS = [
  '/',
  '/assets/css/main.css',
  '/assets/img/logo.webp',
  '/assets/img/favicon.png',
  '/assets/vendor/bootstrap/css/bootstrap.min.css',
  '/assets/vendor/bootstrap-icons/bootstrap-icons.css',
];

// Install: cache static assets
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(STATIC_ASSETS).catch(() => {}))
      .then(() => self.skipWaiting())
  );
});

// Activate: clean old caches
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
    ).then(() => self.clients.claim())
  );
});

// Fetch: network first, fallback to cache for navigation
self.addEventListener('fetch', event => {
  const { request } = event;
  // Skip non-GET and admin/checkout routes
  if (request.method !== 'GET') return;
  const url = new URL(request.url);
  if (url.pathname.startsWith('/admin') || url.pathname.startsWith('/cart') || url.pathname.startsWith('/checkout')) return;

  if (request.mode === 'navigate') {
    // Network first for pages
    event.respondWith(
      fetch(request)
        .then(response => {
          const clone = response.clone();
          caches.open(CACHE_NAME).then(c => c.put(request, clone));
          return response;
        })
        .catch(() => caches.match(request).then(r => r || caches.match('/')))
    );
  } else {
    // Cache first for static assets
    event.respondWith(
      caches.match(request).then(cached => {
        if (cached) return cached;
        return fetch(request).then(response => {
          if (response.ok && request.url.match(/\.(css|js|png|webp|jpg|woff2?)$/)) {
            caches.open(CACHE_NAME).then(c => c.put(request, response.clone()));
          }
          return response;
        });
      })
    );
  }
});
