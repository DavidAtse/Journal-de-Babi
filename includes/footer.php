<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

    <footer class="footer">

        <!-- Ligne décorative rouge/or en haut -->
        <div class="footer-topline"></div>

        <div class="footer-container">

            <!-- COL 1 : Branding -->
            <div class="footer-section">
                <h3>📰 Journal de Babi</h3>
                <p class="brand-tagline">
                    Votre source d'actualité, buzz et divertissement en Côte d'Ivoire.
                    Rapide, fiable et toujours connecté à l'essentiel.
                </p>
                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=100074910699634" class="social-link" title="Facebook">F</a>
                    <a href="https://www.instagram.com/iam_dvvid/" class="social-link" title="Instagram">I</a>
                    <a href="https://wa.me/2250768438101" class="social-link" title="WhatsApp">W</a>
                    <a href="https://www.linkedin.com/in/david-atse-26a1b9356/" class="social-link" title="LinkedIn">L</a>
                </div>
            </div>

            <!-- COL 2 : Navigation -->
            <div class="footer-section">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="index.php?categorie=Actualité">Actualité</a></li>
                    <li><a href="index.php?categorie=Côte+d'Ivoire">Côte d'Ivoire</a></li>
                    <li><a href="index.php?categorie=Sport">Sport</a></li>
                    <li><a href="index.php?categorie=Buzz">Buzz</a></li>
                    <li><a href="index.php?categorie=Education">Éducation</a></li>
                    <li><a href="apropos.php">À propos</a></li>
                    <li><a href="politique-confidentialite.php">Politique de confidentialité</a></li>
                </ul>
            </div>

            <!-- COL 3 : Contact -->
            <div class="footer-section">
                <h4>Contact</h4>

                <div class="contact-item">
                    <span class="icon">✉</span>
                    <div>
                        <a href="mailto:daatsey24@gmail.com?subject=Contact%20Journal%20de%20Babi">
                            daatsey24@gmail.com
                        </a>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="icon">📍</span>
                    <div>Abidjan, Côte d'Ivoire</div>
                </div>

                <div class="contact-item">
                    <span class="icon">🕐</span>
                    <div>Actualités 24h/24, 7j/7</div>
                </div>
            </div>

        </div>

        <!-- Barre du bas -->
        <div class="footer-bottom">
            <p>© <?php echo date("Y"); ?> <span>Journal de Babi</span> — Tous droits réservés</p>
            <p class="made-with">Fait avec ❤️ depuis Abidjan 🇨🇮</p>
        </div>

    </footer>

</body>
</html>

