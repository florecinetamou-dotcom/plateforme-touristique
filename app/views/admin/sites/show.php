<?php
$site   = $site   ?? null;
$badges = $badges ?? [];

$categories = [
    'historique' => '🏛️ Historique',
    'nature'     => '🌿 Nature',
    'culturel'   => '🎭 Culturel',
    'religieux'  => '⛪ Religieux',
    'autre'      => '📍 Autre',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site->nom) ?> — Admin BeninExplore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php include dirname(__DIR__) . '/partials/admin_styles.php'; ?>
</head>
<body>
<?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>

<div class="main">
    <?php include dirname(__DIR__) . '/partials/topbar.php'; ?>

    <div class="content">

        <!-- En-tête -->
        <div class="page-head">
            <div>
                <p class="label-tag">Sites touristiques</p>
                <h1 class="page-title"><?= htmlspecialchars($site->nom) ?></h1>
                <p class="page-sub"><?= htmlspecialchars($site->ville_nom ?? '') ?></p>
            </div>
            <div style="display:flex;gap:10px">
                <a href="/admin/sites/<?= $site->id ?>/edit" class="btn-primary">✏️ Modifier</a>
                <a href="/admin/sites" class="btn-ghost">← Retour</a>
            </div>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success"><?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="show-layout">

            <!-- Photo -->
            <div class="show-photo">
                <?php if (!empty($site->photo_url)): ?>
                <img src="<?= htmlspecialchars($site->photo_url) ?>" alt="<?= htmlspecialchars($site->nom) ?>">
                <?php else: ?>
                <div class="no-photo">🏞️<br><small>Aucune photo</small></div>
                <?php endif; ?>

                <!-- Actions rapides -->
                <div class="quick-actions">
                    <form method="POST" action="/admin/sites/<?= $site->id ?>/toggle">
                        <button type="submit" class="btn-action <?= $site->est_valide ? 'btn-action--yellow' : 'btn-action--green' ?>">
                            <?= $site->est_valide ? '⏸ Dépublier' : '▶️ Publier' ?>
                        </button>
                    </form>
                    <form method="POST" action="/admin/sites/<?= $site->id ?>/supprimer"
                          onsubmit="return confirm('Supprimer définitivement ce site ?')">
                        <button type="submit" class="btn-action btn-action--red">🗑 Supprimer</button>
                    </form>
                </div>
            </div>

            <!-- Infos -->
            <div class="show-info">

                <div class="info-block">
                    <h3>Informations générales</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Statut</span>
                            <span class="info-val">
                                <?php if ($site->est_valide): ?>
                                <span class="badge badge--green">✅ Publié</span>
                                <?php else: ?>
                                <span class="badge badge--grey">⏸ Non publié</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ville</span>
                            <span class="info-val"><?= htmlspecialchars($site->ville_nom ?? '—') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Catégorie</span>
                            <span class="info-val"><?= $categories[$site->categorie] ?? $site->categorie ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Prix d'entrée</span>
                            <span class="info-val">
                                <?= $site->prix_entree > 0
                                    ? number_format($site->prix_entree, 0, ',', ' ') . ' FCFA'
                                    : '🆓 Gratuit' ?>
                            </span>
                        </div>
                        <?php if ($site->heure_ouverture): ?>
                        <div class="info-row">
                            <span class="info-label">Horaires</span>
                            <span class="info-val">
                                <?= substr($site->heure_ouverture, 0, 5) ?> – <?= substr($site->heure_fermeture ?? '??:??', 0, 5) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if ($site->adresse): ?>
                        <div class="info-row">
                            <span class="info-label">Adresse</span>
                            <span class="info-val"><?= htmlspecialchars($site->adresse) ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($site->latitude && $site->longitude): ?>
                        <div class="info-row">
                            <span class="info-label">Coordonnées</span>
                            <span class="info-val"><?= $site->latitude ?>, <?= $site->longitude ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($site->description)): ?>
                <div class="info-block">
                    <h3>Description</h3>
                    <p class="desc-text"><?= nl2br(htmlspecialchars($site->description)) ?></p>
                </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<style>
.show-layout { display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start; }
.show-photo img { width: 100%; height: 220px; object-fit: cover; border-radius: 14px; border: 1px solid var(--border); }
.no-photo { width: 100%; height: 220px; background: var(--card); border-radius: 14px; border: 1px solid var(--border); display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 2.5rem; color: #6b7280; }
.quick-actions { display: flex; flex-direction: column; gap: 10px; margin-top: 16px; }
.btn-action { width: 100%; padding: 11px; border: none; border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: .85rem; font-weight: 600; cursor: pointer; transition: all .2s; }
.btn-action--green  { background: rgba(0,135,81,.15);  color: #4ade80; }
.btn-action--green:hover  { background: #008751; color: #fff; }
.btn-action--yellow { background: rgba(255,214,0,.12); color: #FFD600; }
.btn-action--yellow:hover { background: rgba(255,214,0,.25); }
.btn-action--red    { background: rgba(232,17,45,.12); color: #f87171; }
.btn-action--red:hover    { background: #E8112D; color: #fff; }
.info-block { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: 22px; margin-bottom: 18px; }
.info-block h3 { font-size: .82rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #6b7280; margin-bottom: 16px; }
.info-grid { display: flex; flex-direction: column; gap: 12px; }
.info-row { display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,.04); }
.info-row:last-child { border-bottom: none; padding-bottom: 0; }
.info-label { font-size: .78rem; color: #6b7280; font-weight: 500; }
.info-val { font-size: .85rem; color: #e5e7eb; font-weight: 500; text-align: right; }
.desc-text { font-size: .88rem; color: #9ca3af; line-height: 1.75; }
@media (max-width: 900px) { .show-layout { grid-template-columns: 1fr; } }
</style>

</body>
</html>