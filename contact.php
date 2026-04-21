<?php
// contact.php - Page Contact Journal de Babi

$message = '';
if(isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $sujet = $_POST['sujet'];
    $contenu = $_POST['message'];

    // Ici tu peux envoyer l’email via mail() ou stocker en DB
    $message = "✅ Merci $nom, votre message a été envoyé !";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact - Journal de Babi</title>
    <link rel="stylesheet" href="css/contact.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">
    <h1>Contactez-nous</h1>

    <?php if($message) { echo "<p class='success'>$message</p>"; } ?>

    <form method="POST">
        <input type="text" name="nom" placeholder="Votre nom" required>
        <input type="email" name="email" placeholder="Votre email" required>
        <input type="text" name="sujet" placeholder="Sujet" required>
        <textarea name="message" placeholder="Votre message..." required></textarea>
        <button type="submit" name="submit">Envoyer</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>

<script>
    function toggleMenu() {
        document.querySelector('.nav-links').classList.toggle('active');
    }
</script>

</body>
</html>