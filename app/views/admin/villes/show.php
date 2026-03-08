<?php
$ville        = $ville        ?? null;
$hebergements = $hebergements ?? [];
$sites        = $sites        ?? [];
$badges       = $badges       ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($ville->nom) ?> — Admin BeninExplore</title>
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
                <p class="label-tag">Villes</p>
                <h1 class="page-title"><?= htmlspecialchars($ville->nom) ?></h1>
            </div>
            <div style="display:flex;gap:10px">
                <a href="/admin/villes/edit/<?= $ville->id ?>" class="btn-primary">✏️ Modifier</a>
                <a href="/admin/villes" class="btn-ghost">← Retour</a>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success"><?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="show-layout">

            <!-- Photo + actions -->
            <div class="show-photo">
                <?php if (!empty($ville->photo_url)): ?>
                <img src="<?= htmlspecialchars($ville->photo_url) ?>" alt="<?= htmlspecialchars($ville->nom) ?>">
                <?php else: ?>
                <div class="no-photo">📍<br><small>Aucune photo</small></div>
                <?php endif; ?>

                <div class="quick-actions">
                    <form method="POST" action="/admin/villes/toggle/<?= $ville->id ?>">
                        <button type="submit" class="btn-action <?= $ville->est_active ? 'btn-action--yellow' : 'btn-action--green' ?>">
                            <?= $ville->est_active ? '⏸ Désactiver' : '▶️ Activer' ?>
                        </button>
                    </form>
                    <form method="POST" action="/admin/villes/delete/<?= $ville->id ?>"
                          onsubmit="return confirm('Supprimer définitivement cette ville ?')">
                        <button type="submit" class="btn-action btn-action--red">🗑 Supprimer</button>
                    </form>
                </div>
            </div>

            <!-- Infos -->
            <div class="show-info">

                <div class="info-block">
                    <h3>Informations</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Statut</span>
                            <span class="info-val">
                                <?= $ville->est_active
                                    ? '<span class="badge badge--green">✅ Active</span>'
                                    : '<span class="badge badge--grey">⏸ Inactive</span>' ?>
                            </span>
                        </div>
                        <?php if ($ville->latitude && $ville->longitude): ?>
                        <div class="info-row">
                            <span class="info-label">Coordonnées</span>
                            <span class="info-val"><?= $ville->latitude ?>, <?= $ville->longitude ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($ville->description)): ?>
                        <div class="info-row" style="flex-direction:column;align-items:flex-start;gap:8px">
                            <span class="info-label">Description</span>
                            <span class="info-val" style="text-align:left;color:#9ca3af;line-height:1.65">
                                <?= nl2br(htmlspecialchars($ville->description)) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Hébergements liés -->
                <?php if (!empty($hebergements)): ?>
                <div class="info-block">
                    <h3>Hébergements (<?= count($hebergements) ?>)</h3>
                    <table class="data-table" style="margin-top:8px">
                        <thead>
                            <tr><th>Nom</th><th>Prix / nuit</th><th>Statut</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hebergements as $h): ?>
                            <tr>
                                <td class="td-bold">
                                    <a href="/admin/hebergements/<?= $h->id ?>" style="color:#60a5fa;text-decoration:none">
                                        <?= htmlspecialchars($h->nom) ?>
                                    </a>
                                </td>
                                <td><?= number_format($h->prix_nuit_base, 0, ',', ' ') ?> FCFA</td>
                                <td>
                                    <?php
                                    $map = ['approuve'=>'badge--green','en_attente'=>'badge--attente','rejete'=>'badge--red','suspendu'=>'badge--grey'];
                                    $bc  = $map[$h->statut] ?? 'badge--grey';
                                    ?>
                                    <span class="badge <?= $bc ?>"><?= ucfirst(str_replace('_',' ',$h->statut)) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

                <!-- Sites liés -->
                <?php if (!empty($sites)): ?>
                <div class="info-block">
                    <h3>Sites touristiques (<?= count($sites) ?>)</h3>
                    <table class="data-table" style="margin-top:8px">
                        <thead>
                            <tr><th>Nom</th><th>Catégorie</th><th>Statut</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sites as $s): ?>
                            <tr>
                                <td class="td-bold">
                                    <a href="/admin/sites/<?= $s->id ?>" style="color:#60a5fa;text-decoration:none">
                                        <?= htmlspecialchars($s->nom) ?>
                                    </a>
                                </td>
                                <td><?= ucfirst($s->categorie) ?></td>
                                <td>
                                    <?= $s->est_valide
                                        ? '<span class="badge badge--green">✅ Publié</span>'
                                        : '<span class="badge badge--grey">⏸ Non publié</span>' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<style>
.show-layout{display:grid;grid-template-columns:300px 1fr;gap:24px;align-items:start}
.show-photo img{width:100%;height:200px;object-fit:cover;border-radius:14px;border:1px solid var(--border)}
.no-photo{width:100%;height:200px;background:var(--card);border-radius:14px;border:1px solid var(--border);display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:2.5rem;color:#6b7280}
.quick-actions{display:flex;flex-direction:column;gap:10px;margin-top:16px}
.btn-action{width:100%;padding:11px;border:none;border-radius:10px;font-family:'Poppins',sans-serif;font-size:.85rem;font-weight:600;cursor:pointer;transition:all .2s}
.btn-action--green{background:rgba(0,135,81,.15);color:#4ade80}.btn-action--green:hover{background:#008751;color:#fff}
.btn-action--yellow{background:rgba(255,214,0,.12);color:#FFD600}.btn-action--yellow:hover{background:rgba(255,214,0,.25)}
.btn-action--red{background:rgba(232,17,45,.12);color:#f87171}.btn-action--red:hover{background:#E8112D;color:#fff}
.info-block{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:22px;margin-bottom:18px}
.info-block h3{font-size:.78rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6b7280;margin-bottom:16px}
.info-grid{display:flex;flex-direction:column;gap:12px}
.info-row{display:flex;justify-content:space-between;align-items:center;padding-bottom:10px;border-bottom:1px solid rgba(255,255,255,.04)}
.info-row:last-child{border-bottom:none;padding-bottom:0}
.info-label{font-size:.78rem;color:#6b7280;font-weight:500}
.info-val{font-size:.85rem;color:#e5e7eb;font-weight:500;text-align:right}
@media(max-width:900px){.show-layout{grid-template-columns:1fr}}
</style>

</body>
</html>