<?php
$intentions = $intentions ?? [];
$badges     = $badges     ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intentions Chatbot — Admin BeninExplore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php include dirname(__DIR__) . '/partials/admin_styles.php'; ?>
</head>
<body>
<?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>

<div class="main">
    <?php include dirname(__DIR__) . '/partials/topbar.php'; ?>

    <div class="content">

        <div class="page-head">
            <div>
                <p class="label-tag">Chatbot</p>
                <h1 class="page-title">Intentions & Réponses</h1>
                <p class="page-sub"><?= count($intentions) ?> intention<?= count($intentions) > 1 ? 's' : '' ?> configurée<?= count($intentions) > 1 ? 's' : '' ?></p>
            </div>
            <div style="display:flex;gap:10px">
                <a href="/admin/chatbot" class="btn-ghost">← Tableau de bord</a>
                <button onclick="openModal()" class="btn-primary">+ Nouvelle intention</button>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Explication -->
        <div class="info-banner">
            <span>ℹ️</span>
            <p>Le chatbot détecte les <strong>mots-clés</strong> dans les messages des utilisateurs et renvoie la <strong>réponse associée</strong>. Ajoutez autant d'intentions que nécessaire.</p>
        </div>

        <!-- Table intentions -->
        <div class="table-card">
            <?php if (!empty($intentions)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mot-clé</th>
                        <th>Description</th>
                        <th>Réponse du bot</th>
                        <th>Déclenchements</th>
                        <th>Modifié le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($intentions as $i): ?>
                    <tr>
                        <td>
                            <span class="kw-badge"><?= htmlspecialchars($i->mot_cle) ?></span>
                        </td>
                        <td style="font-size:.8rem;color:#9ca3af;max-width:160px">
                            <?= htmlspecialchars($i->description ?? '—') ?>
                        </td>
                        <td style="max-width:280px">
                            <p class="rep-preview">
                                <?= htmlspecialchars(mb_substr($i->reponse_texte ?? '—', 0, 100)) ?>
                                <?= mb_strlen($i->reponse_texte ?? '') > 100 ? '…' : '' ?>
                            </p>
                        </td>
                        <td style="text-align:center">
                            <?php if (($i->nb_declenchements ?? 0) > 0): ?>
                            <span class="badge badge--blue"><?= $i->nb_declenchements ?>x</span>
                            <?php else: ?>
                            <span style="color:#374151;font-size:.8rem">—</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:.75rem;color:#6b7280">
                            <?= $i->date_modification ? date('d/m/Y', strtotime($i->date_modification)) : '—' ?>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button onclick="openEditModal(
                                    <?= $i->id ?>,
                                    <?= htmlspecialchars(json_encode($i->mot_cle), ENT_QUOTES) ?>,
                                    <?= htmlspecialchars(json_encode($i->description ?? ''), ENT_QUOTES) ?>,
                                    <?= htmlspecialchars(json_encode($i->reponse_texte ?? ''), ENT_QUOTES) ?>,
                                    <?= (int)($i->reponse_id ?? 0) ?>
                                )" class="btn-icon btn-icon--blue" title="Modifier">✏️</button>

                                <form method="POST" action="/admin/chatbot/intentions/<?= $i->id ?>/supprimer"
                                      style="display:inline"
                                      onsubmit="return confirm('Supprimer l\'intention \"<?= htmlspecialchars(addslashes($i->mot_cle)) ?>\" ?')">
                                    <button type="submit" class="btn-icon btn-icon--red" title="Supprimer">🗑</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <span>🧠</span>
                <h3>Aucune intention configurée</h3>
                <p>Créez votre première intention pour que le chatbot puisse répondre.</p>
                <button onclick="openModal()" class="btn-primary">+ Nouvelle intention</button>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- ── MODAL CRÉER ── -->
<div id="modal-create" class="modal-overlay" style="display:none" onclick="closeModal(event)">
    <div class="modal-box">
        <div class="modal-head">
            <h3>➕ Nouvelle intention</h3>
            <button onclick="document.getElementById('modal-create').style.display='none'" class="modal-close">✕</button>
        </div>
        <form method="POST" action="/admin/chatbot/intentions/creer">
            <div class="modal-body">
                <div class="form-group">
                    <label>Mot-clé <span class="required">*</span></label>
                    <input type="text" name="mot_cle" placeholder="Ex: bonjour, prix, annuler…" required>
                    <p class="field-hint">Le bot détectera ce mot dans le message de l'utilisateur.</p>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" placeholder="Ex: Accueil des utilisateurs">
                </div>
                <div class="form-group">
                    <label>Réponse du bot <span class="required">*</span></label>
                    <textarea name="reponse_texte" rows="4"
                              placeholder="Entrez la réponse que le chatbot enverra…" required></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" onclick="document.getElementById('modal-create').style.display='none'" class="btn-ghost">Annuler</button>
                <button type="submit" class="btn-primary">✅ Créer</button>
            </div>
        </form>
    </div>
</div>

<!-- ── MODAL MODIFIER ── -->
<div id="modal-edit" class="modal-overlay" style="display:none" onclick="closeModal(event)">
    <div class="modal-box">
        <div class="modal-head">
            <h3>✏️ Modifier l'intention</h3>
            <button onclick="document.getElementById('modal-edit').style.display='none'" class="modal-close">✕</button>
        </div>
        <form method="POST" id="edit-form" action="">
            <input type="hidden" name="reponse_id" id="edit-reponse-id">
            <div class="modal-body">
                <div class="form-group">
                    <label>Mot-clé <span class="required">*</span></label>
                    <input type="text" name="mot_cle" id="edit-mot-cle" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" id="edit-description">
                </div>
                <div class="form-group">
                    <label>Réponse du bot <span class="required">*</span></label>
                    <textarea name="reponse_texte" id="edit-reponse" rows="4" required></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" onclick="document.getElementById('modal-edit').style.display='none'" class="btn-ghost">Annuler</button>
                <button type="submit" class="btn-primary">💾 Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<style>
.info-banner {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: rgba(59,130,246,.08);
    border: 1px solid rgba(59,130,246,.2);
    border-radius: 12px;
    padding: 14px 18px;
    font-size: .84rem;
    color: #93c5fd;
    margin-bottom: 24px;
    line-height: 1.6;
}
.info-banner span { font-size: 1.2rem; flex-shrink: 0; }
.info-banner strong { color: #bfdbfe; }

.kw-badge { background:rgba(139,92,246,.15); color:#a78bfa; font-size:.78rem; font-weight:700; padding:4px 12px; border-radius:20px; font-family:monospace; white-space:nowrap; }
.rep-preview { font-size:.8rem; color:#9ca3af; line-height:1.55; margin:0; }

/* Modal */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.7);
    z-index: 200;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.modal-box {
    background: #1a2233;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 18px;
    width: 100%;
    max-width: 520px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,.5);
}
.modal-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid rgba(255,255,255,.07);
}
.modal-head h3 { font-size:.95rem; font-weight:700; color:#fff; }
.modal-close { background:none; border:none; color:#6b7280; font-size:1.1rem; cursor:pointer; transition:color .2s; padding:4px; }
.modal-close:hover { color:#fff; }
.modal-body { padding: 24px; display:flex; flex-direction:column; gap:18px; }
.modal-foot { padding:16px 24px; border-top:1px solid rgba(255,255,255,.07); display:flex; justify-content:flex-end; gap:10px; }

.form-group { display:flex; flex-direction:column; gap:7px; }
.form-group label { font-size:.75rem; font-weight:600; color:rgba(255,255,255,.5); letter-spacing:.06em; text-transform:uppercase; }
.required { color:#f87171; }
.form-group input, .form-group textarea {
    background: rgba(255,255,255,.06);
    border: 1.5px solid rgba(255,255,255,.1);
    border-radius: 10px;
    padding: 10px 14px;
    font-family: 'Poppins', sans-serif;
    font-size: .86rem;
    color: #fff;
    outline: none;
    transition: border-color .2s;
    width: 100%;
}
.form-group input:focus, .form-group textarea:focus { border-color:#008751; }
.form-group input::placeholder, .form-group textarea::placeholder { color:rgba(255,255,255,.22); }
.form-group textarea { resize:vertical; min-height:90px; }
.field-hint { font-size:.7rem; color:#6b7280; margin-top:2px; }
</style>

<script>
function openModal() {
    document.getElementById('modal-create').style.display = 'flex';
}
function openEditModal(id, motCle, description, reponse, reponseId) {
    document.getElementById('edit-form').action = '/admin/chatbot/intentions/' + id + '/modifier';
    document.getElementById('edit-mot-cle').value    = motCle;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-reponse').value    = reponse;
    document.getElementById('edit-reponse-id').value = reponseId;
    document.getElementById('modal-edit').style.display = 'flex';
}
function closeModal(e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.style.display = 'none';
    }
}
</script>

</body>
</html>