<?php
    // login.php
    include("../config.php");
    session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Anti brute-force basique : limite les tentatives par fenêtre de temps
    $maxAttempts = 5;
    $lockSeconds = 60;
    if (!isset($_SESSION['login_attempts'])) { $_SESSION['login_attempts'] = 0; }
    if (!isset($_SESSION['login_first_attempt'])) { $_SESSION['login_first_attempt'] = time(); }

    if (time() - $_SESSION['login_first_attempt'] > $lockSeconds) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_first_attempt'] = time();
    }

    if(isset($_POST['login'])) {
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            $error = "❌ Requête invalide, veuillez réessayer";
        } elseif ($_SESSION['login_attempts'] >= $maxAttempts) {
            $error = "❌ Trop de tentatives, réessayez dans quelques instants";
        } else {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Vérifier dans la base
            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $admin = $result->fetch_assoc();

            if($admin && password_verify($password, $admin['password'])) {
                session_regenerate_id(true); // Empêche la fixation de session
                $_SESSION['admin'] = $username; // Stocke la session admin
                $_SESSION['login_attempts'] = 0;
                unset($_SESSION['csrf_token']);
                header("Location: admin.php"); // Redirige vers admin
                exit();
            } else {
                $_SESSION['login_attempts']++;
                $error = "❌ Identifiants incorrects";
            }
            $stmt->close();
        }
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
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="login">Se connecter</button>
    </form>
</div>

</body>
</html>