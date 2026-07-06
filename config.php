<?php
// Ne jamais afficher les erreurs PHP en production (évite de divulguer des infos sensibles)
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

$host = "localhost";
$user = "root";
$password = "";
$dbname = "journal_babi";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    error_log("Erreur de connexion MySQL : " . $conn->connect_error);
    die("Erreur de connexion à la base de données");
}

// Définir l'encodage UTF-8
$conn->set_charset("utf8");
?>

