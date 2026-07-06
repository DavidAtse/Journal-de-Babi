<?php
require __DIR__ . '/../config.php';

header('Content-Type: application/json');

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (
    !is_array($data) ||
    empty($data['endpoint']) ||
    empty($data['keys']['p256dh']) ||
    empty($data['keys']['auth'])
) {
    http_response_code(400);
    echo json_encode(['error' => 'Abonnement invalide']);
    exit();
}

$endpoint = $data['endpoint'];
$p256dh = $data['keys']['p256dh'];
$auth = $data['keys']['auth'];

$stmt = $conn->prepare("
    INSERT INTO push_subscriptions (endpoint, p256dh, auth_token)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE p256dh = VALUES(p256dh), auth_token = VALUES(auth_token)
");
$stmt->bind_param("sss", $endpoint, $p256dh, $auth);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
$stmt->close();
