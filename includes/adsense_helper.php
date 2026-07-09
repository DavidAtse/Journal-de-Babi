<?php
function obtenirAdsenseClientId(): ?string
{
    $clientId = getenv('ADSENSE_CLIENT_ID') ?: null;

    if (!$clientId && file_exists(__DIR__ . '/../adsense_config.php')) {
        require_once __DIR__ . '/../adsense_config.php';
        $clientId = ADSENSE_CLIENT_ID;
    }

    return $clientId ?: null;
}
