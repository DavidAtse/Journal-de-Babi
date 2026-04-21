<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "journal_babi";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion");
}

// Définir l'encodage UTF-8
$conn->set_charset("utf8");
?>

