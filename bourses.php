<?php
require_once __DIR__ . '/includes/auth.php';
require_role('etudiant');   // la table bourse référence id_user -> il faut être connecté

$pdo     = getPDO();
$idEcole = ecole_courante();
$idUser  = $_SESSION['user_id'];
$msg     = null;

// Déjà une candidature ?
$ex = $pdo->prepare("SELECT statut FROM bourse WHERE id_user = ? AND id_ecole = ? ORDER BY id_bourse DESC LIMIT 1");
$ex->execute([$idUser, $idEcole]);
$existante = $ex->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$existante) {
    $stmt = $pdo->prepare(
        "INSERT INTO bourse (id_user, moyenne, lettre, statut, id_ecole)
         VALUES (?,?,?, 'en_attente', ?)"
    );
    $ok = $stmt->execute([
        $idUser,
        (float) ($_POST['moyenne'] ?? 0),
        trim($_POST['motivation'] ?? ''),
        $idEcole,
    ]);
    $msg = $ok ? ['ok', 'Candidature envoyée. Vous serez recontacté(e).'] : ['err', 'Erreur lors de l\'envoi.'];
    if ($ok) { $existante = ['statut' => 'en_attente']; }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Candidature bourse</title>
<link rel="stylesheet" href="assets/app.css">
<style>body{display:block;background:#eef2f5;padding:30px}.box{max-width:560px;margin:auto}</style>
</head>
<body>
  <div class="box">
    <h1><i class="fas fa-award"></i> Candidature à une bourse</h1>
    <?php if ($msg): ?><div class="alert alert-<?= $msg[0]==='ok'?'ok':'danger' ?>"><?= e($msg[1]) ?></div><?php endif; ?>

    <?php if ($existante): ?>
      <div class="alert alert-info">
        Vous avez déjà une candidature — statut :
        <strong><?= e(str_replace('_',' ', $existante['statut'])) ?></strong>.
      </div>
      <a class="btn btn-grey" href="etudiant/etudiant_dashboard.php">← Mon espace</a>
    <?php else: ?>
      <form method="POST" class="card" style="padding:24px">
        <label class="label">Votre moyenne générale (/20)</label>
        <input class="input" type="number" step="0.01" min="0" max="20" name="moyenne" required>
        <label class="label">Lettre de motivation</label>
        <textarea class="input" name="motivation" rows="6" required placeholder="Expliquez votre situation et vos motivations…"></textarea>
        <button class="btn btn-green"><i class="fas fa-paper-plane"></i> Soumettre ma candidature</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
