<?php
require_once __DIR__ . '/config/database.php';
$pdo = getPDO();
$msg = null;

$idEcole = 1; // page publique

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare(
        "INSERT INTO contact (nom_contact, email_contact, tel_contact, message, id_ecole)
         VALUES (?,?,?,?,?)"
    );
    $ok = $stmt->execute([
        trim($_POST['nom'] ?? ''),
        trim($_POST['email'] ?? ''),
        trim($_POST['tel'] ?? ''),
        trim($_POST['message'] ?? ''),
        $idEcole,
    ]);
    $msg = $ok ? ['ok', 'Message envoyé. Merci !'] : ['err', 'Erreur lors de l\'envoi.'];
}
function h($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact</title>
<style>
  body{font-family:'Segoe UI',sans-serif;background:#eef2f5;margin:0;padding:30px}
  .box{max-width:540px;margin:auto;background:#fff;padding:32px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
  h1{margin:0 0 18px;color:#2c3e50}
  label{display:block;font-weight:600;margin:12px 0 6px}
  input,textarea{width:100%;padding:12px;border:1px solid #dfe4ea;border-radius:8px;box-sizing:border-box}
  button{width:100%;margin-top:18px;padding:14px;background:#3498db;color:#fff;border:none;border-radius:8px;font-weight:700;cursor:pointer}
  .ok{background:#eafaf1;color:#1e8449;padding:14px;border-radius:8px;margin-bottom:14px}
  .err{background:#fdedec;color:#922b21;padding:14px;border-radius:8px;margin-bottom:14px}
</style>
</head>
<body>
  <div class="box">
    <h1>Contactez-nous</h1>
    <?php if ($msg): ?><div class="<?= $msg[0]==='ok'?'ok':'err' ?>"><?= h($msg[1]) ?></div><?php endif; ?>
    <form method="POST">
      <label>Nom</label><input name="nom" required>
      <label>Email</label><input type="email" name="email" required>
      <label>Téléphone</label><input name="tel">
      <label>Message</label><textarea name="message" rows="5" required></textarea>
      <button type="submit">Envoyer</button>
    </form>
    <p style="text-align:center;margin-top:14px"><a href="index.php">← Accueil</a></p>
  </div>
</body>
</html>
