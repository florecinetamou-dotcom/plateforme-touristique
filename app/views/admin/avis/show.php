<?php
$avis   = $avis   ?? null;
$badges = $badges ?? [];

if (!$avis) {
    header('Location: /admin/avis');
    exit;
}

function stars(int $note): string {
    $s = '';
    for ($i = 1; $i <= 5; $i++) {
        $s .= '<span style="color:' . ($i <= $note ? '#FFD600' : '#374151') . ';font-size:1.1rem">★</span>';
    }
    return $s;
}

function noteBar(int $note): string {
    $pct = ($note / 5) * 100;
    $color = $note >= 4 ? '#4ade80' : ($note >= 3 ? '#FFD600' : '#f87171');
    return "<div class='note-bar-wrap'>
        <div class='note-bar' style='width:{$pct}%;background:{$color}'></div>
    </div>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis #<?= $avis->id ?> — Admin BeninExplore</title>
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
                <p class="label-tag">Avis & Commentaires</p>
                <h1 class="page-title">Avis #<?= $avis->id ?></h1>
                <p class="page-sub">
                    Par <?= htmlspecialchars(($avis->voyageur_prenom ?? '') . ' ' . ($avis->voyageur_nom ?? '')) ?>
                    · <?= date('d/m/Y', strtotime($avis->date_creation)) ?>
                </p>
            </div>
            <a href="/admin/avis" class="btn-ghost">← Retour</a>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="show-layout">

            <!-- ── GAUCHE ── -->
            <div class="show-left">

                <!-- Note globale -->
                <div class="note-globale-card">
                    <div class="note-globale-card__val"><?= $avis->note_globale ?></div>
                    <div class="note-globale-card__stars"><?= stars((int)$avis->note_globale) ?></div>
                    <div class="note-globale-card__label">Note globale / 5</div>
                </div>

                <!-- Notes détaillées -->
                <div class="info-block">
                    <h3>Notes détaillées</h3>
                    <div class="notes-detail">
                        <?php
                        $noteItems = [
                            'Propreté'        => $avis->note_proprete,
                            'Communication'   => $avis->note_communication,
                            'Emplacement'     => $avis->note_emplacement,
                            'Qualité / Prix'  => $avis->note_qualite_prix,
                        ];
                        foreach ($noteItems as $label => $note):
                            if ($note === null) continue;
                        ?>
                        <div class="note-detail-row">
                            <span class="note-detail-label"><?= $label ?></span>
                            <div style="display:flex;align-items:center;gap:10px;flex:1">
                                <?= noteBar((int)$note) ?>
                                <span class="note-detail-val"><?= $note ?>/5</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Commentaire public -->
                <?php if (!empty($avis->commentaire_public)): ?>
                <div class="info-block">
                    <h3>💬 Commentaire public</h3>
                    <p class="comment-text">"<?= nl2br(htmlspecialchars($avis->commentaire_public)) ?>"</p>
                </div>
                <?php endif; ?>

                <!-- Commentaire privé -->
                <?php if (!empty($avis->commentaire_prive)): ?>
                <div class="info-block" style="border-color:rgba(255,214,0,.15)">
                    <h3 style="color:#FFD600">🔒 Commentaire privé</h3>
                    <p class="comment-text"><?= nl2br(htmlspecialchars($avis->commentaire_prive)) ?></p>
                </div>
                <?php endif; ?>

                <!-- Réponse hébergeur -->
                <?php if (!empty($avis->reponse_hebergeur)): ?>
                <div class="info-block" style="border-color:rgba(59,130,246,.2)">
                    <h3 style="color:#60a5fa">🏨 Réponse de l'hébergeur</h3>
                    <?php if ($avis->date_reponse): ?>
                    <p style="font-size:.72rem;color:#6b7280;margin-bottom:10px">
                        Le <?= date('d/m/Y', strtotime($avis->date_reponse)) ?>
                    </p>
                    <?php endif; ?>
                    <p class="comment-text"><?= nl2br(htmlspecialchars($avis->reponse_hebergeur)) ?></p>
                </div>
                <?php endif; ?>

            </div>

            <!-- ── DROITE ── -->
            <div class="show-right">

                <!-- Actions admin -->
                <div class="decision-card">
                    <h3>Actions Admin</h3>

                    <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:16px">
                        <?php if ($avis->est_verifie): ?>
                        <span class="badge badge--green" style="padding:7px 14px;font-size:.8rem">✅ Avis vérifié</span>
                        <?php else: ?>
                        <span class="badge badge--grey" style="padding:7px 14px;font-size:.8rem">⏳ En attente de vérification</span>
                        <?php endif; ?>
                        <?php if ($avis->signalement): ?>
                        <span class="badge badge--red" style="padding:7px 14px;font-size:.8rem">🚨 Signalé</span>
                        <?php endif; ?>
                    </div>

                    <div class="decision-btns">
                        <?php if (!$avis->est_verifie): ?>
                        <form method="POST" action="/admin/avis/<?= $avis->id ?>/verifier">
                            <button type="submit" class="decision-btn decision-btn--green">✓ Vérifier et publier</button>
                        </form>
                        <?php endif; ?>

                        <?php if ($avis->signalement): ?>
                        <form method="POST" action="/admin/avis/<?= $avis->id ?>/rejeterSignalement">
                            <button type="submit" class="decision-btn" style="background:rgba(59,130,246,.12);color:#60a5fa">
                                ✓ Rejeter le signalement
                            </button>
                        </form>
                        <?php endif; ?>

                        <form method="POST" action="/admin/avis/<?= $avis->id ?>/supprimer"
                              onsubmit="return confirm('Supprimer définitivement cet avis ?')">
                            <button type="submit" class="decision-btn decision-btn--red">🗑 Supprimer l'avis</button>
                        </form>
                    </div>
                </div>

                <!-- Infos voyageur -->
                <div class="info-block">
                    <h3>👤 Voyageur</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Nom</span>
                            <span class="info-val">
                                <?= htmlspecialchars(($avis->voyageur_prenom ?? '') . ' ' . ($avis->voyageur_nom ?? '')) ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-val" style="font-size:.75rem">
                                <?= htmlspecialchars($avis->voyageur_email ?? '—') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Infos hébergement -->
                <div class="info-block">
                    <h3>🏨 Hébergement</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Nom</span>
                            <span class="info-val"><?= htmlspecialchars($avis->hebergement_nom ?? '—') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ville</span>
                            <span class="info-val"><?= htmlspecialchars($avis->ville_nom ?? '—') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Voir l'hébergement</span>
                            <span class="info-val">
                                <a href="/admin/hebergements/<?= $avis->hebergement_id ?>"
                                   style="color:#60a5fa;text-decoration:none;font-size:.78rem">→ Détail</a>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.show-layout { display:grid; grid-template-columns:1fr 320px; gap:24px; align-items:start; }

/* Note globale */
.note-globale-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 28px;
    text-align: center;
    margin-bottom: 16px;
}
.note-globale-card__val   { font-size: 4rem; font-weight: 800; color: #FFD600; line-height: 1; }
.note-globale-card__stars { margin: 10px 0 6px; }
.note-globale-card__label { font-size: .75rem; color: #6b7280; }

/* Notes détaillées */
.notes-detail { display: flex; flex-direction: column; gap: 12px; }
.note-detail-row { display: flex; align-items: center; gap: 12px; }
.note-detail-label { font-size: .78rem; color: #9ca3af; width: 130px; flex-shrink: 0; }
.note-detail-val   { font-size: .78rem; font-weight: 700; color: #fff; white-space: nowrap; }
.note-bar-wrap { flex: 1; height: 6px; background: rgba(255,255,255,.07); border-radius: 4px; overflow: hidden; }
.note-bar      { height: 100%; border-radius: 4px; transition: width .4s; }

/* Commentaires */
.comment-text { font-size: .88rem; color: #9ca3af; line-height: 1.75; font-style: italic; }

/* Info blocks */
.info-block { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:20px; margin-bottom:16px; }
.info-block h3 { font-size:.72rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:14px; }
.info-grid  { display:flex; flex-direction:column; gap:10px; }
.info-row   { display:flex; justify-content:space-between; align-items:center; padding-bottom:8px; border-bottom:1px solid rgba(255,255,255,.04); }
.info-row:last-child { border-bottom:none; padding-bottom:0; }
.info-label { font-size:.78rem; color:#6b7280; font-weight:500; }
.info-val   { font-size:.83rem; color:#e5e7eb; font-weight:500; text-align:right; }

/* Decision */
.decision-card  { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:22px; margin-bottom:16px; }
.decision-card h3 { font-size:.72rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:14px; }
.decision-btns  { display:flex; flex-direction:column; gap:10px; }
.decision-btn   { width:100%; padding:12px; border:none; border-radius:10px; font-family:'Poppins',sans-serif; font-size:.85rem; font-weight:700; cursor:pointer; transition:all .2s; }
.decision-btn--green { background:rgba(0,135,81,.15); color:#4ade80; }
.decision-btn--green:hover { background:#008751; color:#fff; }
.decision-btn--red { background:rgba(232,17,45,.12); color:#f87171; }
.decision-btn--red:hover { background:#E8112D; color:#fff; }

@media (max-width:1024px) { .show-layout { grid-template-columns:1fr; } }
</style>

</body>
</html>