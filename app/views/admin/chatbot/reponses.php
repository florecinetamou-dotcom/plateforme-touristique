<?php
require_once '../../config/database.php';
require_once '../auth_check.php'; 
session_start();

// Mise à jour rapide d'une réponse
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_resp'])) {
    $id = $_POST['resp_id'];
    $texte = trim($_POST['nouveau_texte']);
    
    $stmt = $pdo->prepare("UPDATE chatbot_reponses SET reponse_texte = ? WHERE id = ?");
    $stmt->execute([$texte, $id]);
    $msg = "Réponse mise à jour !";
}

// Récupération de toutes les réponses avec le mot-clé associé pour le contexte
$reponses = $pdo->query("
    SELECT r.*, i.mot_cle 
    FROM chatbot_reponses r 
    JOIN chatbot_intentions i ON r.intention_id = i.id 
    ORDER BY i.mot_cle ASC
")->fetchAll();

$title = 'Toutes les Réponses - Chatbot';
ob_start();
?>

<div class="admin-page py-4 px-3 px-md-5">
    <div class="mb-4">
        <h4 class="fw-bold">📝 Bibliothèque des Réponses</h4>
        <p class="text-muted small">Modifiez directement les textes que le bot renvoie aux utilisateurs.</p>
    </div>

    <?php if(isset($msg)): ?>
        <div class="alert alert-success rounded-pill small py-2"><?= $msg ?></div>
    <?php endif; ?>

    <div class="data-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 20%;">Mot-clé (Intention)</th>
                        <th>Réponse textuelle</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reponses as $r): ?>
                    <tr>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3">
                                #<?= htmlspecialchars($r.mot_cle) ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" id="form-<?= $r->id ?>" class="d-flex gap-2">
                                <input type="hidden" name="resp_id" value="<?= $r->id ?>">
                                <textarea name="nouveau_texte" class="form-control form-control-sm border-0 bg-light" rows="2"><?= htmlspecialchars($r->reponse_texte) ?></textarea>
                            </form>
                        </td>
                        <td class="text-end">
                            <button type="submit" name="update_resp" form="form-<?= $r->id ?>" class="btn-action text-success" title="Sauvegarder">
                                <i class="fas fa-save"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>