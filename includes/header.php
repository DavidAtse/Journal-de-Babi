<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">📰 Journal de Babi</div>
        <div class="search-box">
            <input type="text" id="search" placeholder="Rechercher un article...">
            <div id="suggestions"></div>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="index.php?categorie=Actualité">Actualité</a></li>
            <li><a href="index.php?categorie=Buzz">Buzz</a></li>
            <li><a href="index.php?categorie=Sport">Sport</a></li>
            <li><a href="index.php?categorie=Côte+d'Ivoire">Côte d'Ivoire</a></li>
            <li><a href="index.php?categorie=Education">Education</a></li>
            <li><a href="index.php?categorie=Jeux">Jeux</a></li>
            <li><a href="index.php?categorie=Spiritualité">Spiritualité</a></li>
            <li><a href="index.php?categorie=Faits+divers">Faits divers</a></li>
        </ul>
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>
    </nav>

    <script>
        function toggleMenu() {
            document.querySelector('.nav-links').classList.toggle('active');
        }


        // Fonction de recherche avec suggestions
        const searchInput = document.getElementById("search");
        const suggestionsBox = document.getElementById("suggestions");

        searchInput.addEventListener("keyup", function() {
            let query = this.value;

            if(query.length < 2) {
                suggestionsBox.style.display = "none";
                return;
            }

            fetch("search.php?q=" + query)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("suggestions").innerHTML = data;
                    document.getElementById("suggestions").style.display = "block";
                });
        });
    </script>
</body>
</html>
