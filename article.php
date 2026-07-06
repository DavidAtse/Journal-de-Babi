<?php
    include("config.php");

    if(!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) { echo "Aucun article sélectionné"; exit(); }
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();
    if(!$article) { echo "Article introuvable"; exit(); }

    $update = $conn->prepare("UPDATE articles SET vues = vues + 1 WHERE id = ?");
    $update->bind_param("i", $id);
    $update->execute();
    $update->close();

    $titre = htmlspecialchars($article['titre'], ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($article['image'], ENT_QUOTES, 'UTF-8');
    $date = htmlspecialchars($article['date_publication'], ENT_QUOTES, 'UTF-8');
    $contenu = nl2br(htmlspecialchars($article['contenu'], ENT_QUOTES, 'UTF-8'));
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titre; ?></title>
    <link rel="stylesheet" href="css/article.css">
</head>
<body>

<?php require "includes/header.php"; ?>

<div class="container">
    <a href="index.php">← Retour</a>
    <h1><?php echo $titre; ?></h1>
    <p class="date">Publié le <?php echo $date; ?></p>
    <div class="hero"><img src="uploads/<?php echo $image; ?>"></div>
    <p><?php echo $contenu; ?></p>

    <?php $adSlotId = "2222222222"; require "includes/ad_slot.php"; ?>
</div>

<script>
function toggleMenu() { document.querySelector('.nav-links').classList.toggle('active'); }
</script>

</body>
</html>