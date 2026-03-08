<?php
$villes      = $villes      ?? [];
$total       = $total       ?? 0;
$total_pages = $total_pages ?? 1;
$page        = $page        ?? 1;
$badges      = $badges      ?? [];
$filters     = $filters     ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villes — Admin BeninExplore</title>
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
                <h1 class="page-title">Villes</h1>
                <p class="page-sub"><?= $total ?> ville<?= $total > 1 ? 's' : '' ?> au total</p>
            </div>
            <a href="/admin/villes/create" class="btn-primary">+ Ajouter une ville</a>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success"><?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error"><?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Filtres -->
        <form method="GET" class="filters-bar">
            <input type="text" name="search" placeholder="Rechercher une ville…"
                   value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="filter-input">
            <select name="active" class="filter-select">
                <option value="">Tous statuts</option>
                <option value="1" <?= ($filters['active'] ?? '') === '1' ? 'selected' : '' ?>>✅ Active</option>
                <option value="0" <?= ($filters['active'] ?? '') === '0' ? 'selected' : '' ?>>⏸ Inactive</option>
            </select>
            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="/admin/villes" class="btn-reset">Réinitialiser</a>
        </form>

        <!-- Table -->
        <div class="table-card">
            <?php if (!empty($villes)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Hébergements</th>
                        <th>Sites</th>
                        <th>Coordonnées</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($villes as $ville): ?>
                    <tr>
                        <td>
                            <?php if (!empty($ville->photo_url)): ?>
                            <img src="<?= htmlspecialchars($ville->photo_url) ?>"
                                 style="width:56px;height:42px;object-fit:cover;border-radius:8px;">
                            <?php else: ?>
                            <div style="width:56px;height:42px;background:#1f2937;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">📍</div>
                            <?php endif; ?>
                        </td>
                        <td class="td-bold"><?= htmlspecialchars($ville->nom) ?></td>
                        <td>
                            <span class="badge badge--blue"><?= $ville->nb_hebergements ?? 0 ?> héberg.</span>
                        </td>
                        <td>
                            <span class="badge badge--cat"><?= $ville->nb_sites ?? 0 ?> sites</span>
                        </td>
                        <td style="font-size:.75rem;color:#6b7280">
                            <?php if ($ville->latitude && $ville->longitude): ?>
                                <?= $ville->latitude ?><br><?= $ville->longitude ?>
                            <?php else: ?>
                                <span style="color:#374151">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($ville->est_active): ?>
                            <span class="badge badge--green">✅ Active</span>
                            <?php else: ?>
                            <span class="badge badge--grey">⏸ Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="/admin/villes/<?= $ville->id ?>" class="btn-icon" title="Voir">👁</a>
                                <a href="/admin/villes/edit/<?= $ville->id ?>" class="btn-icon btn-icon--blue" title="Modifier">✏️</a>
                                <form method="POST" action="/admin/villes/toggle/<?= $ville->id ?>" style="display:inline">
                                    <button type="submit" class="btn-icon <?= $ville->est_active ? 'btn-icon--yellow' : 'btn-icon--green' ?>"
                                            title="<?= $ville->est_active ? 'Désactiver' : 'Activer' ?>">
                                        <?= $ville->est_active ? '⏸' : '▶️' ?>
                                    </button>
                                </form>
                                <form method="POST" action="/admin/villes/delete/<?= $ville->id ?>" style="display:inline"
                                      onsubmit="return confirm('Supprimer la ville <?= htmlspecialchars(addslashes($ville->nom)) ?> ?')">
                                    <button type="submit" class="btn-icon btn-icon--red" title="Supprimer">🗑</button>
                                </form>
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
                <a href="?page=<?= $i ?>&search=<?= urlencode($filters['search'] ?? '') ?>&active=<?= $filters['active'] ?? '' ?>"
                   class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="empty-state">
                <span>📍</span>
                <h3>Aucune ville</h3>
                <p>Commencez par en ajouter une.</p>
                <a href="/admin/villes/create" class="btn-primary">+ Ajouter une ville</a>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>
</body>
</html>