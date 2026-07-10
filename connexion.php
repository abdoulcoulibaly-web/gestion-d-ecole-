<?php
require_once __DIR__ . '/includes/auth.php';

// Déjà connecté ? -> dashboard (si le rôle en session est valide, sinon on nettoie pour éviter une boucle de redirection)
if (!empty($_SESSION['user_id'])) {
    $dest = dashboard_pour_role($_SESSION['role'] ?? null);
    if ($dest !== 'connexion.php') {
        header('Location: ' . $dest);
        exit;
    }
    $_SESSION = [];
    session_destroy();
}

$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (tenter_connexion($email, $password)) {
        header('Location: ' . dashboard_pour_role($_SESSION['role'] ?? null));
        exit;
    }
    $erreur = 'Email ou mot de passe incorrect.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion — Gestion Scolaire</title>
<style>
  body{margin:0;display:flex;justify-content:center;align-items:center;height:100vh;
       background:#2c3e50;font-family:'Segoe UI',sans-serif}
  .login-box{background:#fff;padding:40px;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,.3);
             width:100%;max-width:400px;text-align:center}
  .login-box h2{color:#2c3e50;margin:0 0 6px}
  .logo{font-weight:bold;color:#3498db;font-size:26px;display:block;margin-bottom:14px}
  input{width:100%;padding:12px;margin-bottom:14px;border:1px solid #dfe4ea;border-radius:8px;box-sizing:border-box}
  button{width:100%;padding:13px;background:#3498db;color:#fff;border:none;border-radius:8px;
         font-weight:700;cursor:pointer}
  button:hover{opacity:.92}
  .err{color:#e74c3c;margin-bottom:12px;font-size:.9rem}
</style>
</head>
<body>
  <div class="login-box">
    <span class="logo">Gestion Scolaire</span>
    <h2>Espace de connexion</h2>
    <?php if ($erreur): ?><p class="err"><?= e($erreur) ?></p><?php endif; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Adresse email" required>
      <input type="password" name="password" placeholder="Mot de passe" required>
      <button type="submit">Se connecter</button>
    </form>
    <p style="font-size:12px;color:#7f8c8d;margin-top:18px">&copy; 2026 — Plateforme multi-écoles</p>
  </div>
</body>
</html>
