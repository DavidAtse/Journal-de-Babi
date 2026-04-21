<?php
include("config.php");

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

if($categorie) {
    $stmt = $conn->prepare("SELECT * FROM articles WHERE categorie = ? ORDER BY date_publication DESC LIMIT 5");
    $stmt->bind_param("s", $categorie);
    $stmt->execute();
    $articles = $stmt->get_result();
} else {
    $articles = $conn->query("SELECT * FROM articles ORDER BY date_publication DESC LIMIT 5");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Journal de Babi</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<?php require "includes/header.php"; ?>

<div class="container">
    <div class="articles-container">
        <?php while($row = $articles->fetch_assoc()) { ?>
            <div class="article-card">
                <h3><?php echo $row['titre']; ?></h3>
                <img src="uploads/<?php echo $row['image']; ?>" alt="Image article">
                <p><?php echo substr($row['contenu'], 0, 150); ?>...</p>
                <a href="article.php?id=<?php echo $row['id']; ?>">Lire la suite →</a>
                <small>Publié le <?php echo $row['date_publication']; ?></small>
            </div>
        <?php } ?>
    </div>
</div>

<?php require "includes/footer.php"; ?>

</body>
</html>