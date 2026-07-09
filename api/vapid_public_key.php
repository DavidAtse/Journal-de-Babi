<?php
require_once __DIR__ . '/../includes/push_helper.php';

$vapid = chargerVapidConfig();
header('Content-Type: text/plain');

if ($vapid === null) {
    http_response_code(404);
    exit;
}

echo $vapid['publicKey'];
