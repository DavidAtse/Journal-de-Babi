<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

function envoyerNotificationNouvelArticle(mysqli $conn, string $titre, int $articleId): void
{
    $pushConfigFile = __DIR__ . '/../push_config.php';
    if (!file_exists($pushConfigFile)) {
        return; // Les notifications push ne sont pas encore configurées
    }
    require_once $pushConfigFile;

    $result = $conn->query("SELECT id, endpoint, p256dh, auth_token FROM push_subscriptions");
    if (!$result || $result->num_rows === 0) {
        return;
    }

    $webPush = new WebPush([
        'VAPID' => [
            'subject'    => VAPID_SUBJECT,
            'publicKey'  => VAPID_PUBLIC_KEY,
            'privateKey' => VAPID_PRIVATE_KEY,
        ],
    ]);

    $payload = json_encode([
        'title' => 'Journal de Babi',
        'body'  => $titre,
        'url'   => '/article.php?id=' . $articleId,
    ]);

    while ($row = $result->fetch_assoc()) {
        $webPush->queueNotification(
            Subscription::create([
                'endpoint' => $row['endpoint'],
                'keys' => [
                    'p256dh' => $row['p256dh'],
                    'auth'   => $row['auth_token'],
                ],
            ]),
            $payload
        );
    }

    foreach ($webPush->flush() as $report) {
        // Abonnement expiré ou invalide (410/404) : on le supprime de la base
        if (!$report->isSuccess() && in_array($report->getResponse()?->getStatusCode(), [404, 410], true)) {
            $endpoint = $report->getRequest()->getUri()->__toString();
            $stmt = $conn->prepare("DELETE FROM push_subscriptions WHERE endpoint = ?");
            $stmt->bind_param("s", $endpoint);
            $stmt->execute();
            $stmt->close();
        }
    }
}
