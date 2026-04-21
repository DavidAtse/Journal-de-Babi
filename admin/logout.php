<?php
// logout.php - Déconnecte l'admin
session_start();
session_destroy();
header("Location: login.php");
exit();
?>