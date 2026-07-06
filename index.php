<?php
include("config.php");

$categorie = isset($_GET['categorie']) ? trim($_GET['categorie']) : '';

if ($categorie) {
    $stmt = $conn->prepare("SELECT * FROM articles WHERE categorie = ? ORDER BY date_publication DESC LIMIT 9");
    $stmt->bind_param("s", $categorie);
    $stmt->execute();
    $articles = $stmt->get_result();
} else {
    $articles = $conn->query("SELECT * FROM articles ORDER BY date_publication DESC LIMIT 9");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $categorie ? htmlspecialchars($categorie) . ' — ' : ''; ?>Journal de Babi</title>
    <meta name="description" content="Journal de Babi – L'actualité de Côte d'Ivoire et d'ailleurs : buzz, sport, éducation et plus.">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/x-icon" href="uploads/Logo-site.png">
</head>
<body>

<?php require "includes/header.php"; ?>

<!-- HERO BANNER -->
<?php if (!$categorie): ?>
<div class="hero-banner">
    <div class="hero-text">
        <h1>L'actualité d'Abidjan<br>et d'ailleurs</h1>
        <p>Restez informé avec Journal de Babi — rapide, fiable, toujours connecté.</p>
    </div>
    <div class="hero-badge">🇨🇮 Côte d'Ivoire &amp; Monde</div>
</div>
<?php endif; ?>

<!-- CONTENU PRINCIPAL -->
<div class="container">

    <!-- Titre de section -->
    <div class="section-title">
        <span class="dot"></span>
        <h2><?php echo $categorie ? '📂 ' . htmlspecialchars($categorie) : '🔥 À la une'; ?></h2>
        <div class="line"></div>
    </div>

    <!-- Grille des articles -->
    <div class="articles-container">
        <?php
        $index = 0;
        if ($articles->num_rows > 0):
            while ($row = $articles->fetch_assoc()):
                $featured = ($index === 0 && !$categorie) ? 'featured' : '';
                $titre    = htmlspecialchars($row['titre']);
                $contenu  = htmlspecialchars(substr(strip_tags($row['contenu']), 0, 160));
                $image    = htmlspecialchars($row['image']);
                $date     = date('d/m/Y à H:i', strtotime($row['date_publication']));
                $cat      = htmlspecialchars($row['categorie'] ?? '');
                $id       = (int)$row['id'];
        ?>
        <div class="article-card <?php echo $featured; ?>">

            <div class="card-img-wrap">
                <img src="uploads/<?php echo $image; ?>" alt="<?php echo $titre; ?>" loading="lazy">
            </div>

            <div class="card-body">
                <?php if ($cat): ?>
                    <span class="categorie-badge"><?php echo $cat; ?></span>
                <?php endif; ?>

                <h3><?php echo $titre; ?></h3>
                <p><?php echo $contenu; ?>…</p>

                <div class="card-footer">
                    <small>📅 <?php echo $date; ?></small>
                    <a class="lire-suite" href="article.php?id=<?php echo $id; ?>">Lire la suite →</a>
                </div>
            </div>

        </div>
        <?php
                // Emplacement pub toutes les 4 cartes (inactif tant qu'AdSense n'est pas configuré)
                if ($index === 3) {
                    $adSlotId = "1111111111";
                    require "includes/ad_slot.php";
                }
                $index++;
            endwhile;
        else:
        ?>
        <div class="empty-state">
            <h3>Aucun article trouvé</h3>
            <p>Il n'y a pas encore d'articles dans cette catégorie.</p>
        </div>
        <?php endif; ?>
    </div>

</div>

<?php require "includes/footer.php"; ?>

</body>
</html>