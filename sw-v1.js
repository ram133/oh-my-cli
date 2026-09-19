const CACHE_NAME = 'cli-v1';
const ASSETS = [
  './index-v4.html',
  './manifest-v1.json',
  './config-v1.js',
  './data-v1.json'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(ASSETS))
  );
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => response || fetch(event.request))
  );
});
