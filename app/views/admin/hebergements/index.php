<?php
$hebergements = $hebergements ?? [];
$total        = $total        ?? 0;
$total_pages  = $total_pages  ?? 1;
$page         = $page         ?? 1;
$counts       = $counts       ?? [];
$villes       = $villes       ?? [];
$types        = $types        ?? [];
$badges       = $badges       ?? [];

$statut   = $_GET['statut']   ?? 'tous';
$search   = $_GET['search']   ?? '';
$ville_id = $_GET['ville_id'] ?? '';
$type_id  = $_GET['type_id']  ?? '';

$statutLabels = [
    'tous'       => ['label' => 'Tous',        'class' => ''],
    'en_attente' => ['label' => 'En attente',  'class' => 'badge--attente'],
    'approuve'   => ['label' => 'Approuvés',   'class' => 'badge--green'],
    'rejete'     => ['label' => 'Rejetés',     'class' => 'badge--red'],
    'suspendu'   => ['label' => 'Suspendus',   'class' => 'badge--grey'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hébergements — Admin BeninExplore</title>
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
                <p class="label-tag">Gestion</p>
                <h1 class="page-title">Hébergements</h1>
                <p class="page-sub"><?= $total ?> hébergement<?= $total > 1 ? 's' : '' ?> au total</p>
            </div>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Pills statut -->
        <div class="status-pills">
            <?php foreach ($statutLabels as $key => $info): ?>
            <a href="?statut=<?= $key ?>&search=<?= urlencode($search) ?>&ville_id=<?= $ville_id ?>&type_id=<?= $type_id ?>"
               class="pill <?= $statut === $key ? 'pill--active' : '' ?>">
                <?= $info['label'] ?>
                <span class="pill-count"><?= $counts[$key] ?? 0 ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Filtres -->
        <form method="GET" class="filters-bar">
            <input type="hidden" name="statut" value="<?= htmlspecialchars($statut) ?>">
            <input type="text" name="search" placeholder="Rechercher nom, hébergeur…"
                   value="<?= htmlspecialchars($search) ?>" class="filter-input">

            <select name="ville_id" class="filter-select">
                <option value="">Toutes les villes</option>
                <?php foreach ($villes as $v): ?>
                <option value="<?= $v->id ?>" <?= $ville_id == $v->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($v->nom) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <select name="type_id" class="filter-select">
                <option value="">Tous les types</option>
                <?php foreach ($types as $t): ?>
                <option value="<?= $t->id ?>" <?= $type_id == $t->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t->nom) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="/admin/hebergements" class="btn-reset">Réinitialiser</a>
        </form>

        <!-- Table -->
        <div class="table-card">
            <?php if (!empty($hebergements)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Hébergement</th>
                        <th>Hébergeur</th>
                        <th>Ville</th>
                        <th>Type</th>
                        <th>Prix / nuit</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hebergements as $h): ?>
                    <tr>
                        <!-- Photo + Nom -->
                        <td>
                            <div style="display:flex;align-items:center;gap:12px">
                                <?php if (!empty($h->photo)): ?>
                                <img src="<?= htmlspecialchars($h->photo) ?>"
                                     style="width:52px;height:40px;object-fit:cover;border-radius:8px;flex-shrink:0">
                                <?php else: ?>
                                <div style="width:52px;height:40px;background:#1f2937;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0">🏨</div>
                                <?php endif; ?>
                                <div>
                                    <div class="td-bold"><?= htmlspecialchars($h->nom) ?></div>
                                    <div style="font-size:.72rem;color:#6b7280;margin-top:2px">
                                        Ajouté le <?= date('d/m/Y', strtotime($h->date_creation)) ?>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Hébergeur -->
                        <td>
                            <div style="font-size:.83rem;color:#e5e7eb">
                                <?= htmlspecialchars(($h->hebergeur_prenom ?? '') . ' ' . ($h->hebergeur_nom ?? '')) ?>
                            </div>
                            <div style="font-size:.72rem;color:#6b7280">
                                <?= htmlspecialchars($h->hebergeur_email ?? '') ?>
                            </div>
                        </td>

                        <td><?= htmlspecialchars($h->ville_nom ?? '—') ?></td>
                        <td><?= htmlspecialchars($h->type_nom  ?? '—') ?></td>

                        <!-- Prix -->
                        <td style="font-weight:700;color:#4ade80">
                            <?= number_format($h->prix_nuit_base ?? 0, 0, ',', ' ') ?> <span style="font-size:.7rem;font-weight:400;color:#6b7280">FCFA</span>
                        </td>

                        <!-- Statut -->
                        <td>
                            <?php
                            $map = [
                                'en_attente' => 'badge--attente',
                                'approuve'   => 'badge--green',
                                'rejete'     => 'badge--red',
                                'suspendu'   => 'badge--grey',
                            ];
                            $bc = $map[$h->statut ?? ''] ?? 'badge--grey';
                            ?>
                            <span class="badge <?= $bc ?>">
                                <?= ucfirst(str_replace('_', ' ', $h->statut ?? '')) ?>
                            </span>
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="action-btns">
                                <a href="/admin/hebergements/<?= $h->id ?>"
                                   class="btn-icon" title="Voir le détail">👁</a>

                                <?php if ($h->statut === 'en_attente'): ?>
                                <form method="POST" action="/admin/hebergements/<?= $h->id ?>/valider" style="display:inline">
                                    <button type="submit" class="btn-icon btn-icon--green" title="Valider">✓</button>
                                </form>
                                <form method="POST" action="/admin/hebergements/<?= $h->id ?>/rejeter" style="display:inline">
                                    <button type="submit" class="btn-icon btn-icon--red" title="Rejeter">✗</button>
                                </form>
                                <?php elseif ($h->statut === 'approuve'): ?>
                                <form method="POST" action="/admin/hebergements/<?= $h->id ?>/rejeter" style="display:inline"
                                      onsubmit="return confirm('Suspendre cet hébergement ?')">
                                    <button type="submit" class="btn-icon btn-icon--yellow" title="Suspendre">⏸</button>
                                </form>
                                <?php elseif (in_array($h->statut, ['rejete', 'suspendu'])): ?>
                                <form method="POST" action="/admin/hebergements/<?= $h->id ?>/valider" style="display:inline">
                                    <button type="submit" class="btn-icon btn-icon--green" title="Réactiver">▶️</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>&statut=<?= $statut ?>&search=<?= urlencode($search) ?>&ville_id=<?= $ville_id ?>&type_id=<?= $type_id ?>"
                   class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="empty-state">
                <span>🏨</span>
                <h3>Aucun hébergement trouvé</h3>
                <p>Essayez de modifier vos filtres.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
/* Pills statut */
.status-pills {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 16px;
    border-radius: 30px;
    font-size: .78rem;
    font-weight: 600;
    text-decoration: none;
    color: var(--muted2);
    background: rgba(255,255,255,.05);
    border: 1px solid var(--border);
    transition: all .2s;
}
.pill:hover     { background: rgba(255,255,255,.1); color: #fff; }
.pill--active   { background: rgba(0,135,81,.15); border-color: rgba(0,135,81,.4); color: #4ade80; }
.pill-count {
    background: rgba(255,255,255,.1);
    padding: 1px 8px;
    border-radius: 20px;
    font-size: .68rem;
}
.pill--active .pill-count { background: rgba(0,135,81,.25); }
</style>

</body>
</html>