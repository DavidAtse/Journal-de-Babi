const CACHE_NAME = 'journal-babi-v1';
const OFFLINE_ASSETS = [
    '/index.php',
    '/css/header.css',
    '/css/index.css',
    '/css/footer.css',
    '/uploads/Logo-site.png'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(OFFLINE_ASSETS))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key)))
        )
    );
    self.clients.claim();
});

// Stratégie : réseau d'abord, fallback sur le cache si hors-ligne
self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                const clone = response.clone();
                caches.open(CACHE_NAME).then((cache) => cache.put(event.request, clone));
                return response;
            })
            .catch(() => caches.match(event.request))
    );
});

// Réception d'une notification push envoyée par le serveur
self.addEventListener('push', (event) => {
    let data = { title: 'Journal de Babi', body: 'Un nouvel article est disponible !', url: '/index.php' };
    if (event.data) {
        try { data = { ...data, ...event.data.json() }; } catch (e) { /* payload non JSON, on garde les valeurs par défaut */ }
    }

    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: '/uploads/Logo-site.png',
            badge: '/uploads/Logo-site.png',
            data: { url: data.url }
        })
    );
});

// Clic sur la notification : ouvre / focus l'article
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = event.notification.data && event.notification.data.url ? event.notification.data.url : '/index.php';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
            for (const client of clientList) {
                if (client.url.includes(url) && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});
