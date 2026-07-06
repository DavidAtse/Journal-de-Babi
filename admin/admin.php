<?php
    // admin.php - Page admin sécurisée
    session_start();
    include("../config.php");

    // Vérifie que l'admin est connecté
    if(!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit();
    }

    require_once("../includes/push_helper.php");

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $csrfOk = function() {
        return isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
    };

    $allowedMime = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];
    $categoriesAutorisees = [
        'Actualité', 'Buzz', 'Sport', "Côte d'Ivoire",
        'Education', 'Jeux', 'Spiritualité', 'Faits divers',
    ];
    $maxUploadSize = 5 * 1024 * 1024; // 5 Mo
    $msgType = null; // 'success' | 'error'

    // Gérer l'ajout d'article
    if(isset($_POST['submit'])) {
        if (!$csrfOk()) {
            $msg = "❌ Requête invalide, veuillez réessayer";
            $msgType = 'error';
        } else {
            $titre = trim($_POST['titre']);
            $contenu = trim($_POST['contenu']);
            $categorie = $_POST['categorie'];

            if (
                $titre === '' || $contenu === '' || !in_array($categorie, $categoriesAutorisees, true) ||
                !isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK
            ) {
                $msg = "❌ Champs manquants ou erreur d'upload";
                $msgType = 'error';
            } elseif ($_FILES['image']['size'] > $maxUploadSize) {
                $msg = "❌ Image trop volumineuse (5 Mo max)";
                $msgType = 'error';
            } else {
                $tmp = $_FILES['image']['tmp_name'];
                $mime = mime_content_type($tmp);
                $imageInfo = getimagesize($tmp);

                if ($imageInfo === false || !isset($allowedMime[$mime])) {
                    $msg = "❌ Type de fichier non autorisé (jpg, png, gif, webp uniquement)";
                    $msgType = 'error';
                } else {
                    $ext = $allowedMime[$mime];
                    $image = bin2hex(random_bytes(16)) . "." . $ext; // nom de fichier aléatoire
                    $path = "../uploads/" . $image;

                    if(move_uploaded_file($tmp, $path)) {
                        $stmt = $conn->prepare("INSERT INTO articles (titre, contenu, image, categorie) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("ssss", $titre, $contenu, $image, $categorie);
                        if($stmt->execute()) {
                            $msg = "✅ Article publié !";
                            $msgType = 'success';
                            try {
                                envoyerNotificationNouvelArticle($conn, $titre, $conn->insert_id);
                            } catch (\Throwable $e) {
                                error_log("Erreur envoi notification push : " . $e->getMessage());
                            }
                        } else {
                            $msg = "❌ Erreur lors de la publication";
                            $msgType = 'error';
                        }
                        $stmt->close();
                    } else {
                        $msg = "❌ Impossible d'uploader l'image";
                        $msgType = 'error';
                    }
                }
            }
        }
    }


    // Supprimer un article si demandé
    if(isset($_POST['delete'])) {
        if (!$csrfOk()) {
            $msg = "❌ Requête invalide, veuillez réessayer";
            $msgType = 'error';
        } else {
            $delete_id = (int)$_POST['delete_id'];

            // Récupère le nom de l'image pour la supprimer aussi du disque
            $imgStmt = $conn->prepare("SELECT image FROM articles WHERE id = ?");
            $imgStmt->bind_param("i", $delete_id);
            $imgStmt->execute();
            $imgResult = $imgStmt->get_result()->fetch_assoc();
            $imgStmt->close();

            // Sécurité : requête préparée
            $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
            $stmt->bind_param("i", $delete_id);
            if($stmt->execute()) {
                if ($imgResult && !empty($imgResult['image'])) {
                    $oldImagePath = "../uploads/" . basename($imgResult['image']);
                    if (is_file($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $msg = "✅ Article supprimé !";
                $msgType = 'success';
            } else {
                $msg = "❌ Erreur lors de la suppression";
                $msgType = 'error';
            }
            $stmt->close();
        }
    }


    // Récupérer tous les articles pour affichage
    $articles = $conn->query("SELECT * FROM articles ORDER BY date_publication DESC");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Journal de Babi</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" type="image/x-icon" href="uploads/Logo-site.png">
</head>
<body>

    <h1>🛠️ Admin - Journal de Babi</h1>

    <div class="logout">
        <a href="logout.php">🔒 Déconnexion</a>
    </div>

    <div class="form-container">
        <?php if(isset($msg)) { echo "<div class='message " . htmlspecialchars($msgType, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . "</div>"; } ?>

        <!-- Formulaire Admin -->
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
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
                <h3><?php echo htmlspecialchars($row['titre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <img src="../uploads/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image article">
                <p><?php echo nl2br(htmlspecialchars($row['contenu'], ENT_QUOTES, 'UTF-8')); ?></p>
                <small>
                    Publié le <?php echo htmlspecialchars($row['date_publication'], ENT_QUOTES, 'UTF-8'); ?> |
                    👁️ <?php echo (int)$row['vues']; ?> vues
                </small>

                <!-- Bouton supprimer article -->
                <form method="POST" style="display:inline;" onsubmit="return confirm('Supprimer définitivement cet article ?');">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="delete_id" value="<?php echo (int)$row['id']; ?>">
                    <button type="submit" name="delete" style="background:red;">🗑️ Supprimer</button>
                </form>
            </div>
        <?php } ?>
    </div>

</body>
</html>