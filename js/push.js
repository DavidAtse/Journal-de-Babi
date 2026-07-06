// Enregistrement du Service Worker (PWA) + abonnement aux notifications push

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').then((registration) => {
            initNotificationPrompt(registration);
        }).catch((err) => console.error('Erreur enregistrement Service Worker :', err));
    });
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const rawData = window.atob(base64);
    return Uint8Array.from([...rawData].map((char) => char.charCodeAt(0)));
}

function initNotificationPrompt(registration) {
    if (!('PushManager' in window) || Notification.permission === 'denied') {
        return;
    }

    // Si déjà abonné, rien à faire
    registration.pushManager.getSubscription().then((existingSub) => {
        if (existingSub) return;
        if (Notification.permission === 'granted') {
            subscribeUser(registration);
            return;
        }
        showNotificationBanner(() => subscribeUser(registration));
    });
}

function showNotificationBanner(onAccept) {
    if (document.getElementById('push-banner')) return;

    const banner = document.createElement('div');
    banner.id = 'push-banner';
    banner.innerHTML = `
        <span>🔔 Recevez une notification à chaque nouvel article !</span>
        <div class="push-banner-actions">
            <button id="push-banner-accept">Activer</button>
            <button id="push-banner-dismiss">Non merci</button>
        </div>
    `;
    document.body.appendChild(banner);

    document.getElementById('push-banner-accept').addEventListener('click', () => {
        banner.remove();
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') onAccept();
        });
    });

    document.getElementById('push-banner-dismiss').addEventListener('click', () => {
        banner.remove();
    });
}

function subscribeUser(registration) {
    fetch('/api/vapid_public_key.php')
        .then((res) => res.text())
        .then((publicKey) => {
            return registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(publicKey),
            });
        })
        .then((subscription) => {
            return fetch('/api/save_subscription.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(subscription),
            });
        })
        .catch((err) => console.error('Erreur abonnement notifications :', err));
}
