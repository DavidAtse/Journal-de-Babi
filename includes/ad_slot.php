<?php
/**
 * Emplacement publicitaire réutilisable.
 * N'affiche rien tant que adsense_config.php n'existe pas (avant approbation Google).
 *
 * Utilisation : $adSlotId = "1234567890"; require "includes/ad_slot.php";
 */
require_once __DIR__ . '/adsense_helper.php';
$adsenseClientId = obtenirAdsenseClientId();
if ($adsenseClientId && !empty($adSlotId)) {
    $slot = htmlspecialchars($adSlotId, ENT_QUOTES, 'UTF-8');
    $client = htmlspecialchars($adsenseClientId, ENT_QUOTES, 'UTF-8');
    ?>
    <div class="ad-slot">
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-<?php echo $client; ?>"
             data-ad-slot="<?php echo $slot; ?>"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
    <?php
    unset($adSlotId);
}
