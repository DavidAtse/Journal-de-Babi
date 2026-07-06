<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal de Babi</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#C0392B">
    <script src="js/push.js" defer></script>
    <?php if (file_exists(__DIR__ . '/../adsense_config.php')): ?>
        <?php require_once __DIR__ . '/../adsense_config.php'; ?>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-<?php echo htmlspecialchars(ADSENSE_CLIENT_ID, ENT_QUOTES, 'UTF-8'); ?>" crossorigin="anonymous"></script>
    <?php endif; ?>
</head>
<body>

    <!-- BANDE SUPÉRIEURE -->
    <div class="topbar">
        <span class="topbar-date">
            <?php
                setlocale(LC_TIME, 'fr_FR.UTF-8');
                echo strftime('%A %d %B %Y');
            ?>
        </span>
        <span>
            <a href="apropos.php">À propos</a>
            &nbsp;|&nbsp;
            <a href="contact.php">Contact</a>
        </span>
    </div>

    <!-- NAVBAR PRINCIPALE -->
    <nav class="navbar">

        <a href="index.php" class="logo">
            <img src="uploads/Logo-site.png" class="logo-img" alt="Journal de Babi">
            <div class="logo-text">
                <span class="brand-name">Journal de Babi</span>
                <span class="brand-sub">L'info d'Abidjan &amp; d'ailleurs</span>
            </div>
        </a>

        <div class="search-box">
            <input type="text" id="search" placeholder="Rechercher…" autocomplete="off">
            <div id="suggestions"></div>
        </div>

        <ul class="nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="index.php?categorie=Actualité">Actualité</a></li>
            <li><a href="index.php?categorie=Côte+d'Ivoire">Côte d'Ivoire</a></li>
            <li><a href="index.php?categorie=Sport">Sport</a></li>
            <li><a href="index.php?categorie=Buzz">Buzz</a></li>
            <li><a href="index.php?categorie=Education">Éducation</a></li>
            <li><a href="index.php?categorie=Jeux">Jeux</a></li>
            <li><a href="index.php?categorie=Spiritualité">Spiritualité</a></li>
            <li><a href="index.php?categorie=Faits+divers">Faits divers</a></li>
        </ul>

        <button class="menu-toggle" onclick="toggleMenu()" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </nav>

    <script>
        function toggleMenu() {
            document.querySelector('.nav-links').classList.toggle('active');
        }

        // Fermer le menu si on clique ailleurs
        document.addEventListener('click', function(e) {
            const nav = document.querySelector('.nav-links');
            const toggle = document.querySelector('.menu-toggle');
            if (!nav.contains(e.target) && !toggle.contains(e.target)) {
                nav.classList.remove('active');
            }
        });

        // Surligner le lien actif selon la catégorie dans l'URL
        const params = new URLSearchParams(window.location.search);
        const cat = params.get('categorie');
        document.querySelectorAll('.nav-links li a').forEach(link => {
            const url = new URL(link.href);
            const linkCat = url.searchParams.get('categorie');
            if ((!cat && !linkCat && link.pathname.endsWith('index.php')) ||
                (cat && linkCat === cat)) {
                link.classList.add('active');
            }
        });

        // Suggestions de recherche
        const searchInput = document.getElementById("search");
        const suggestionsBox = document.getElementById("suggestions");

        searchInput.addEventListener("keyup", function () {
            const query = this.value.trim();
            if (query.length < 2) {
                suggestionsBox.style.display = "none";
                return;
            }
            fetch("search.php?q=" + encodeURIComponent(query))
                .then(res => res.text())
                .then(data => {
                    suggestionsBox.innerHTML = data;
                    suggestionsBox.style.display = data.trim() ? "block" : "none";
                });
        });

        document.addEventListener("click", function (e) {
            if (!searchInput.contains(e.target)) {
                suggestionsBox.style.display = "none";
            }
        });
    </script>

</body>
</html>