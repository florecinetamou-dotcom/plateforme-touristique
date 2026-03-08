<?php
$avis         = $avis         ?? [];
$total        = $total        ?? 0;
$total_pages  = $total_pages  ?? 1;
$page         = $page         ?? 1;
$counts       = $counts       ?? [];
$note_moyenne = $note_moyenne ?? 0;
$badges       = $badges       ?? [];
$filters      = $filters      ?? [];

$filtreLabels = [
    'tous'         => ['label' => 'Tous',           'icon' => '⭐'],
    'signales'     => ['label' => 'Signalés',       'icon' => '🚨'],
    'non_verifies' => ['label' => 'Non vérifiés',   'icon' => '⏳'],
    'verifies'     => ['label' => 'Vérifiés',       'icon' => '✅'],
];

function stars(int $note): string {
    $s = '';
    for ($i = 1; $i <= 5; $i++) {
        $s .= $i <= $note ? '⭐' : '☆';
    }
    return $s;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis — Admin BeninExplore</title>
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
                <p class="label-tag">Gestion</p>
                <h1 class="page-title">Avis & Commentaires</h1>
                <p class="page-sub"><?= $total ?> avis au total · Note moyenne : <strong style="color:#FFD600"><?= $note_moyenne ?>/5</strong></p>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="avis-stats">
            <div class="avis-stat">
                <div class="avis-stat__icon">⭐</div>
                <div class="avis-stat__val" style="color:#FFD600"><?= $note_moyenne ?></div>
                <div class="avis-stat__label">Note moyenne</div>
            </div>
            <div class="avis-stat">
                <div class="avis-stat__icon">✅</div>
                <div class="avis-stat__val" style="color:#4ade80"><?= $counts['verifies'] ?? 0 ?></div>
                <div class="avis-stat__label">Vérifiés</div>
            </div>
            <div class="avis-stat">
                <div class="avis-stat__icon">⏳</div>
                <div class="avis-stat__val"><?= $counts['non_verifies'] ?? 0 ?></div>
                <div class="avis-stat__label">En attente</div>
            </div>
            <div class="avis-stat">
                <div class="avis-stat__icon">🚨</div>
                <div class="avis-stat__val" style="color:#f87171"><?= $counts['signales'] ?? 0 ?></div>
                <div class="avis-stat__label">Signalés</div>
            </div>
        </div>

        <!-- Pills -->
        <div class="status-pills">
            <?php foreach ($filtreLabels as $key => $info): ?>
            <a href="?filtre=<?= $key ?>&search=<?= urlencode($filters['search'] ?? '') ?>"
               class="pill <?= ($filters['filtre'] ?? 'tous') === $key ? 'pill--active' : '' ?>
               <?= $key === 'signales' && ($counts['signales'] ?? 0) > 0 ? 'pill--alert' : '' ?>">
                <?= $info['icon'] ?> <?= $info['label'] ?>
                <span class="pill-count"><?= $counts[$key] ?? 0 ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Filtres -->
        <form method="GET" class="filters-bar">
            <input type="hidden" name="filtre" value="<?= htmlspecialchars($filters['filtre'] ?? 'tous') ?>">
            <input type="text" name="search" placeholder="Voyageur, hébergement…"
                   value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="filter-input">
            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="/admin/avis" class="btn-reset">Réinitialiser</a>
        </form>

        <!-- Cards avis -->
        <?php if (!empty($avis)): ?>
        <div class="avis-grid">
            <?php foreach ($avis as $a): ?>
            <div class="avis-card <?= $a->signalement ? 'avis-card--signale' : '' ?>">

                <!-- Header -->
                <div class="avis-card__head">
                    <div class="avis-card__user">
                        <div class="avis-avatar">
                            <?= strtoupper(substr($a->voyageur_prenom ?? 'U', 0, 1)) ?>
                        </div>
                        <div>
                            <div class="avis-card__name">
                                <?= htmlspecialchars(($a->voyageur_prenom ?? '') . ' ' . ($a->voyageur_nom ?? '')) ?>
                            </div>
                            <div class="avis-card__date">
                                <?= date('d/m/Y', strtotime($a->date_creation)) ?>
                            </div>
                        </div>
                    </div>
                    <div style="text-align:right">
                        <div class="avis-stars"><?= stars((int)$a->note_globale) ?></div>
                        <div style="font-size:.65rem;color:#6b7280;margin-top:2px">
                            <?= $a->note_globale ?>/5
                        </div>
                    </div>
                </div>

                <!-- Hébergement -->
                <div class="avis-card__hotel">
                    🏨 <?= htmlspecialchars($a->hebergement_nom ?? '—') ?>
                </div>

                <!-- Commentaire -->
                <?php if (!empty($a->commentaire_public)): ?>
                <p class="avis-card__comment">
                    "<?= htmlspecialchars(mb_substr($a->commentaire_public, 0, 140)) ?>
                    <?= mb_strlen($a->commentaire_public) > 140 ? '…' : '' ?>"
                </p>
                <?php endif; ?>

                <!-- Badges statut -->
                <div class="avis-card__badges">
                    <?php if ($a->signalement): ?>
                    <span class="badge badge--red">🚨 Signalé</span>
                    <?php endif; ?>
                    <?php if ($a->est_verifie): ?>
                    <span class="badge badge--green">✅ Vérifié</span>
                    <?php else: ?>
                    <span class="badge badge--grey">⏳ En attente</span>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="avis-card__actions">
                    <a href="/admin/avis/<?= $a->id ?>" class="btn-sm-action">👁 Voir</a>

                    <?php if (!$a->est_verifie): ?>
                    <form method="POST" action="/admin/avis/<?= $a->id ?>/verifier" style="display:inline">
                        <button type="submit" class="btn-sm-action btn-sm-action--green">✓ Valider</button>
                    </form>
                    <?php endif; ?>

                    <form method="POST" action="/admin/avis/<?= $a->id ?>/supprimer" style="display:inline"
                          onsubmit="return confirm('Supprimer cet avis ?')">
                        <button type="submit" class="btn-sm-action btn-sm-action--red">🗑 Supprimer</button>
                    </form>
                </div>

            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination" style="margin-top:20px">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>&filtre=<?= $filters['filtre'] ?? 'tous' ?>&search=<?= urlencode($filters['search'] ?? '') ?>"
               class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="empty-state">
            <span>⭐</span>
            <h3>Aucun avis trouvé</h3>
            <p>Modifiez vos filtres ou attendez les premiers avis.</p>
        </div>
        <?php endif; ?>

    </div>
</div>

<style>
/* Stats */
.avis-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.avis-stat {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 18px;
    text-align: center;
}
.avis-stat__icon { font-size: 1.5rem; margin-bottom: 8px; }
.avis-stat__val  { font-size: 1.8rem; font-weight: 800; color: #fff; line-height: 1; }
.avis-stat__label{ font-size: .72rem; color: #6b7280; margin-top: 4px; }

/* Pills */
.status-pills { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px; }
.pill { display:inline-flex; align-items:center; gap:7px; padding:7px 16px; border-radius:30px; font-size:.78rem; font-weight:600; text-decoration:none; color:var(--muted2); background:rgba(255,255,255,.05); border:1px solid var(--border); transition:all .2s; }
.pill:hover { background:rgba(255,255,255,.1); color:#fff; }
.pill--active { background:rgba(0,135,81,.15); border-color:rgba(0,135,81,.4); color:#4ade80; }
.pill--alert  { border-color:rgba(232,17,45,.3); color:#f87171; }
.pill-count { background:rgba(255,255,255,.1); padding:1px 8px; border-radius:20px; font-size:.68rem; }
.pill--active .pill-count { background:rgba(0,135,81,.25); }

/* Grille avis */
.avis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 16px;
}
.avis-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: transform .2s, box-shadow .2s;
}
.avis-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.25); }
.avis-card--signale { border-color: rgba(232,17,45,.35); background: rgba(232,17,45,.04); }

.avis-card__head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.avis-card__user { display: flex; align-items: center; gap: 10px; }
.avis-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #008751;
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; font-weight: 700; color: #fff;
    flex-shrink: 0;
}
.avis-card__name  { font-size: .85rem; font-weight: 600; color: #fff; }
.avis-card__date  { font-size: .7rem; color: #6b7280; margin-top: 2px; }
.avis-stars       { font-size: .85rem; }

.avis-card__hotel {
    font-size: .78rem;
    color: #9ca3af;
    padding: 6px 10px;
    background: rgba(255,255,255,.04);
    border-radius: 8px;
}
.avis-card__comment {
    font-size: .83rem;
    color: #9ca3af;
    line-height: 1.6;
    font-style: italic;
    flex: 1;
}
.avis-card__badges { display: flex; gap: 6px; flex-wrap: wrap; }
.avis-card__actions {
    display: flex;
    gap: 8px;
    padding-top: 10px;
    border-top: 1px solid rgba(255,255,255,.05);
    flex-wrap: wrap;
}

.btn-sm-action {
    padding: 5px 12px;
    border-radius: 7px;
    font-family: 'Poppins', sans-serif;
    font-size: .72rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    border: none;
    background: rgba(255,255,255,.07);
    color: var(--muted2);
    transition: all .2s;
}
.btn-sm-action:hover         { background: rgba(255,255,255,.14); color: #fff; }
.btn-sm-action--green        { background: rgba(0,135,81,.12); color: #4ade80; }
.btn-sm-action--green:hover  { background: #008751; color: #fff; }
.btn-sm-action--red          { background: rgba(232,17,45,.1); color: #f87171; }
.btn-sm-action--red:hover    { background: #E8112D; color: #fff; }

@media (max-width: 900px) { .avis-stats { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 640px) { .avis-stats { grid-template-columns: 1fr 1fr; } .avis-grid { grid-template-columns: 1fr; } }
</style>

</body>
</html>