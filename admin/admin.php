<?php
    // admin.php - Page admin sécurisée
    session_start();
    include("../config.php");

    // Vérifie que l'admin est connecté
    if(!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit();
    }

    // Gérer l'ajout d'article
    if(isset($_POST['submit'])) {
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $categorie = $_POST['categorie']; // ← ici
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $path = "../uploads/" . $image;

        if(move_uploaded_file($tmp, $path)) {
            $stmt = $conn->prepare("INSERT INTO articles (titre, contenu, image, categorie) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $titre, $contenu, $image, $categorie);
            if($stmt->execute()) {
                $msg = "✅ Article publié !";
            } else {
                $msg = "❌ Erreur SQL : " . $stmt->error;
            }
            $stmt->close();
        } else {
            $msg = "❌ Impossible d'uploader l'image";
        }
    }


    // Supprimer un article si demandé
    if(isset($_POST['delete'])) {
        $delete_id = $_POST['delete_id'];

        // Sécurité : requête préparée
        $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        if($stmt->execute()) {
            $msg = "✅ Article supprimé !";
        } else {
            $msg = "❌ Erreur suppression : " . $stmt->error;
        }
        $stmt->close();
    }


    // Récupérer tous les articles pour affichage
    $articles = $conn->query("SELECT * FROM articles ORDER BY date_publication DESC");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Journal de Babi</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <h1>🛠️ Admin - Journal de Babi</h1>

    <div class="logout">
        <a href="logout.php">🔒 Déconnexion</a>
    </div>

    <div class="form-container">
        <?php if(isset($msg)) { echo "<div class='message'>$msg</div>"; } ?>

        <!-- Formulaire Admin -->
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="titre" placeholder="Titre" required>
            <textarea name="contenu" placeholder="Contenu" required></textarea>
            <input type="file" name="image" required>
            <!-- Nouvelle ligne catégorie -->
            <select name="categorie" required>
                <option value="Actualité">Actualité</option>
                <option value="Buzz">Buzz</option>
                <option value="Sport">Sport</option>
                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                <option value="Education">Education</option>
                <option value="Jeux">Jeux</option>
                <option value="Spiritualité">Spiritualité</option>
                <option value="Faits divers">Faits divers</option>
            </select>
            <button type="submit" name="submit">Publier</button>
        </form>
    </div>

    <div class="articles-container">
        <h2>📄 Articles publiés</h2>
        <?php while($row = $articles->fetch_assoc()) { ?>
            <div class="article-card">
                <h3><?php echo $row['titre']; ?></h3>
                <img src="../uploads/<?php echo $row['image']; ?>" alt="Image article">
                <p><?php echo $row['contenu']; ?></p>
                <small>
                    Publié le <?php echo $row['date_publication']; ?> |
                    👁️ <?php echo $row['vues']; ?> vues
                </small>

                <!-- Bouton supprimer article -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete" style="background:red;">🗑️ Supprimer</button>
                </form>
            </div>
        <?php } ?>
    </div>

</body>
</html>