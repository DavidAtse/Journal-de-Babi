<?php
    include("config.php");

    if(!isset($_GET['id'])) { echo "Aucun article sélectionné"; exit(); }
    $id = $_GET['id'];
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
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $article['titre']; ?></title>
    <link rel="stylesheet" href="css/article.css">
</head>
<body>

<?php require "includes/header.php"; ?>

<div class="container">
    <a href="index.php">← Retour</a>
    <h1><?php echo $article['titre']; ?></h1>
    <p class="date">Publié le <?php echo $article['date_publication']; ?></p>
    <div class="hero"><img src="uploads/<?php echo $article['image']; ?>"></div>
    <p><?php echo nl2br($article['contenu']); ?></p>
</div>

<script>
function toggleMenu() { document.querySelector('.nav-links').classList.toggle('active'); }
</script>

</body>
</html>