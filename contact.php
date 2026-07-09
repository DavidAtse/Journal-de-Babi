<?php
// contact.php - Page Contact Journal de Babi
session_start();
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';
$errors = [];

if(isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errors[] = "Requête invalide, veuillez réessayer.";
    }

    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $contenu = trim($_POST['message'] ?? '');

    if ($nom === '' || $sujet === '' || $contenu === '') {
        $errors[] = "Veuillez remplir tous les champs.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    if (empty($errors)) {
        // Variables Voisilab en priorité, sinon fichier local (XAMPP)
        $smtpUsername = getenv('SMTP_USERNAME') ?: null;
        $smtpPassword = getenv('SMTP_PASSWORD') ?: null;
        $contactReceiver = getenv('CONTACT_RECEIVER') ?: null;

        if ((!$smtpUsername || !$smtpPassword || !$contactReceiver) && file_exists(__DIR__ . '/mail_config.php')) {
            require __DIR__ . '/mail_config.php';
            $smtpUsername = $smtpUsername ?: SMTP_USERNAME;
            $smtpPassword = $smtpPassword ?: SMTP_PASSWORD;
            $contactReceiver = $contactReceiver ?: CONTACT_RECEIVER;
        }

        if (!$smtpUsername || !$smtpPassword || !$contactReceiver) {
            $errors[] = "L'envoi d'email n'est pas encore configuré sur le serveur.";
        } else {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $smtpUsername;
                $mail->Password   = $smtpPassword;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';

                $mail->setFrom($smtpUsername, 'Journal de Babi - Formulaire de contact');
                $mail->addAddress($contactReceiver);
                $mail->addReplyTo($email, $nom);

                $mail->isHTML(true);
                $mail->Subject = "[Contact Journal de Babi] " . $sujet;
                $mail->Body = "
                    <h3>Nouveau message depuis le formulaire de contact</h3>
                    <p><strong>Nom :</strong> " . htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') . "</p>
                    <p><strong>Email :</strong> " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</p>
                    <p><strong>Sujet :</strong> " . htmlspecialchars($sujet, ENT_QUOTES, 'UTF-8') . "</p>
                    <p><strong>Message :</strong><br>" . nl2br(htmlspecialchars($contenu, ENT_QUOTES, 'UTF-8')) . "</p>
                ";
                $mail->AltBody = "Nom: $nom\nEmail: $email\nSujet: $sujet\n\n$contenu";

                $mail->send();
                $message = "✅ Merci " . htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') . ", votre message a bien été envoyé !";
            } catch (Exception $e) {
                error_log("Erreur envoi mail contact : " . $mail->ErrorInfo);
                $errors[] = "Une erreur est survenue lors de l'envoi. Veuillez réessayer plus tard.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Journal de Babi</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="icon" type="image/x-icon" href="uploads/Logo-site.png">
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="contact-hero">
    <h1>Contactez-nous</h1>
    <p>Une info, une suggestion, un partenariat ? Écrivez-nous, on vous répond rapidement.</p>
</div>

<div class="contact-wrap container">

    <!-- Formulaire -->
    <div class="contact-form-card">
        <h2>Envoyer un message</h2>

        <?php if($message) { echo "<p class='success'>$message</p>"; } ?>
        <?php foreach($errors as $err) { echo "<p class='error'>" . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . "</p>"; } ?>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-row">
                <input type="text" name="nom" placeholder="Votre nom" required>
                <input type="email" name="email" placeholder="Votre email" required>
            </div>
            <input type="text" name="sujet" placeholder="Sujet" required>
            <textarea name="message" placeholder="Votre message..." rows="6" required></textarea>
            <button type="submit" name="submit">Envoyer le message</button>
        </form>
    </div>

    <!-- À propos de moi -->
    <div class="about-me-card">
        <div class="about-me-avatar">👨‍💻</div>
        <h2>Atse David</h2>
        <p class="about-me-role">Développeur Web</p>
        <p class="about-me-text">
            Créateur et développeur du <strong>Journal de Babi</strong>. Passionné de développement
            web (PHP, MySQL, JavaScript), j'aime concevoir des plateformes utiles, modernes et
            accessibles à tous.
        </p>

        <div class="about-me-contact">
            <a href="mailto:daatsey24@gmail.com" class="about-me-link">
                <span class="icon">✉</span> daatsey24@gmail.com
            </a>
            <a href="https://www.linkedin.com/in/david-atse-26a1b9356/" class="about-me-link" target="_blank" rel="noopener">
                <span class="icon">in</span> LinkedIn
            </a>
            <a href="https://www.instagram.com/iam_dvvid/" class="about-me-link" target="_blank" rel="noopener">
                <span class="icon">📷</span> Instagram
            </a>
            <a href="https://wa.me/2250768438101" class="about-me-link" target="_blank" rel="noopener">
                <span class="icon">💬</span> WhatsApp
            </a>
        </div>
    </div>

</div>

<?php include "includes/footer.php"; ?>

<script>
    function toggleMenu() {
        document.querySelector('.nav-links').classList.toggle('active');
    }
</script>

</body>
</html>
