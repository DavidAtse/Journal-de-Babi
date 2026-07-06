<?php
// Ne jamais afficher les erreurs PHP en production (évite de divulguer des infos sensibles)
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// ── Détection environnement ────────────────────────────────────────────────
$isLocal = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1', '::1'])
        || str_starts_with($_SERVER['SERVER_NAME'] ?? '', '192.168.');

// OPTION MANUELLE pour le nouvel hébergeur
$useNovaHost = false; // <-- mettre true quand tu déploies sur Voisilab

if ($isLocal) {
    // ── LOCAL (XAMPP) ──────────────────────────────────────────────────────
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "journal_babi";

} elseif ($useNovaHost) {
    // ── NOUVEL HÉBERGEUR (Voisilab / Nova) ────────────────────────────────
    $host = "voisilab-data-mysql";
    $user = "u_journal_de_babi_452d25";
    $password = "EIKudg4gCZ3neYOQz6r7JFvc";
    $dbname = "db_journal_de_babi_452d25";

} else {
    // ── PRODUCTION (InfinityFree) ──────────────────────────────────────────
    $host = "sql104.infinityfree.com";
    $user = "if0_41776090";
    $password = "GcqTmzhyAWB";
    $dbname = "if0_41776090_portfolio_db";
}

$conn = new mysqli($host, $user, $password, $dbname);

// Gestion erreur connexion
if ($conn->connect_error) {
    error_log("Erreur de connexion MySQL : " . $conn->connect_error);
    die("Erreur de connexion à la base de données");
}

// Définir l'encodage UTF-8
$conn->set_charset("utf8");
?>