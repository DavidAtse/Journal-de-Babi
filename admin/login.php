<?php
    // login.php
    include("../config.php");
    session_start();

    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Vérifier dans la base
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = SHA2(?, 256)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1) {
            $_SESSION['admin'] = $username; // Stocke la session admin
            header("Location: admin.php"); // Redirige vers admin
            exit();
        } else {
            $error = "❌ Identifiants incorrects";
        }
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin - Journal de Babi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <h2>🔐 Login Admin</h2>

    <?php if(isset($error)) { echo "<div class='error'>$error</div>"; } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="login">Se connecter</button>
    </form>
</div>

</body>
</html>