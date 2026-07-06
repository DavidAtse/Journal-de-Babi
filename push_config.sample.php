<?php
// Copiez ce fichier en "push_config.php" (à côté de celui-ci).
// push_config.php est ignoré par git : ne partagez jamais la clé privée.

// Nécessaire sur certains environnements Windows/XAMPP pour qu'openssl fonctionne correctement
// (sans effet sur un hébergement Linux, où openssl.cnf est déjà configuré par l'hébergeur)
if (stripos(PHP_OS, 'WIN') === 0 && is_file('C:\\xampp\\php\\extras\\ssl\\openssl.cnf')) {
    putenv('OPENSSL_CONF=C:\\xampp\\php\\extras\\ssl\\openssl.cnf');
}

// Clés VAPID générées une seule fois pour ce site (voir README pour les régénérer)
define('VAPID_PUBLIC_KEY', 'BBrYauOiNDWO--QjxtdjY1SQ4Bk-HNrEf_71rIS-MVm4-DtceVNG9TBfCWldLi6-VpOj5ZKOH2EBJeEm_7_upcw');
define('VAPID_PRIVATE_KEY', 'M3CFqK0N6i2zJPTJmhayojbsaTZERS9_ODNqti8MuAY');

// Doit être une adresse mail ou une URL identifiant le site (exigé par la norme Web Push)
define('VAPID_SUBJECT', 'mailto:daatsey24@gmail.com');
