<?php
require_once __DIR__ . '/config/database.php';
$pdo = getPDO();
$msg = null;

$idEcole = 1; // page publique : école par défaut (adapter si multi-domaine)
$filieres = $pdo->prepare("SELECT id_filiere, nom_filiere FROM filieres WHERE id_ecole = ? ORDER BY nom_filiere");
$filieres->execute([$idEcole]);
$filieres = $filieres->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare(
        "INSERT INTO `pre-inscription` (nom_pre, prenom_pre, date_de_naissance, telephone, email_pre, id_filiere)
         VALUES (?,?,?,?,?,?)"
    );
    $ok = $stmt->execute([
        trim($_POST['nom'] ?? ''),
        trim($_POST['prenom'] ?? ''),
        $_POST['date_naissance'] ?: null,
        trim($_POST['tel'] ?? ''),
        trim($_POST['email'] ?? ''),
        (int) ($_POST['id_filiere'] ?? 0),
    ]);
    $msg = $ok ? ['ok', 'Pré-inscription enregistrée. Un conseiller vous contactera.'] : ['err', 'Erreur lors de l\'enregistrement.'];
}

function h($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pré-inscription</title>
<style>
  body{font-family:'Segoe UI',sans-serif;background:#eef2f5;margin:0;padding:30px}
  .box{max-width:560px;margin:auto;background:#fff;padding:32px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
  h1{margin:0 0 18px;color:#2c3e50}
  label{display:block;font-weight:600;margin:12px 0 6px;color:#34495e}
  input,select{width:100%;padding:12px;border:1px solid #dfe4ea;border-radius:8px;box-sizing:border-box}
  button{width:100%;margin-top:20px;padding:14px;background:#3498db;color:#fff;border:none;border-radius:8px;font-weight:700;cursor:pointer}
  .ok{background:#eafaf1;color:#1e8449;padding:14px;border-radius:8px;margin-bottom:14px}
  .err{background:#fdedec;color:#922b21;padding:14px;border-radius:8px;margin-bottom:14px}
  .row{display:flex;gap:14px}.row>div{flex:1}
</style>
</head>
<body>
  <div class="box">
    <h1>Demande de pré-inscription</h1>
    <?php if ($msg): ?><div class="<?= $msg[0]==='ok'?'ok':'err' ?>"><?= h($msg[1]) ?></div><?php endif; ?>
    <form method="POST">
      <div class="row">
        <div><label>Nom</label><input name="nom" required></div>
        <div><label>Prénom</label><input name="prenom" required></div>
      </div>
      <label>Date de naissance</label><input type="date" name="date_naissance">
      <div class="row">
        <div><label>Téléphone</label><input name="tel" required></div>
        <div><label>Email</label><input type="email" name="email" required></div>
      </div>
      <label>Filière souhaitée</label>
      <select name="id_filiere" required>
        <option value="">— Sélectionner —</option>
        <?php foreach ($filieres as $f): ?><option value="<?= $f['id_filiere'] ?>"><?= h($f['nom_filiere']) ?></option><?php endforeach; ?>
      </select>
      <button type="submit">Envoyer ma demande</button>
    </form>
    <p style="text-align:center;margin-top:16px"><a href="index.php">← Retour à l'accueil</a></p>
  </div>
</body>
</html>
