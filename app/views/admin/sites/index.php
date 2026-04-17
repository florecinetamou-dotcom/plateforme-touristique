<?php
$sites       = $sites       ?? [];
$villes      = $villes      ?? [];
$total       = $total       ?? 0;
$total_pages = $total_pages ?? 1;
$page        = $page        ?? 1;
$badges      = $badges      ?? [];
$filters     = $filters     ?? [];

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
    <title>Sites touristiques — Admin BeninExplore</title>
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
                <h1 class="page-title">Sites touristiques</h1>
                <p class="page-sub"><?= $total ?> site<?= $total > 1 ? 's' : '' ?> au total</p>
            </div>
            <a href="/admin/sites/create" class="btn-primary">
                <span>+</span> Ajouter un site
            </a>
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
            <input type="text" name="search" placeholder="Rechercher un site…"
                   value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="filter-input">

            <select name="ville_id" class="filter-select">
                <option value="">Toutes les villes</option>
                <?php foreach ($villes as $v): ?>
                <option value="<?= $v->id ?>" <?= ($filters['ville_id'] ?? '') == $v->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($v->nom) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <select name="categorie" class="filter-select">
                <option value="">Toutes catégories</option>
                <?php foreach ($categories as $key => $label): ?>
                <option value="<?= $key ?>" <?= ($filters['categorie'] ?? '') === $key ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
                <?php endforeach; ?>
            </select>

            <select name="valide" class="filter-select">
                <option value="">Tous statuts</option>
                <option value="1" <?= ($filters['valide'] ?? '') === '1' ? 'selected' : '' ?>>✅ Publié</option>
                <option value="0" <?= ($filters['valide'] ?? '') === '0' ? 'selected' : '' ?>>⏸ Non publié</option>
            </select>

            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="/admin/sites" class="btn-reset">Réinitialiser</a>
        </form>

        <!-- Table -->
        <div class="table-card">
            <?php if (!empty($sites)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Catégorie</th>
                        <th>Prix entrée</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sites as $site): ?>
                    <tr>
                        <td>
                            <?php if (!empty($site->photo_url)): ?>
                            <img src="<?= htmlspecialchars($site->photo_url) ?>"
                                 style="width:56px;height:42px;object-fit:cover;border-radius:8px;">
                            <?php else: ?>
                            <div style="width:56px;height:42px;background:#1f2937;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;">🏞️</div>
                            <?php endif; ?>
                        </td>
                        <td class="td-bold"><?= htmlspecialchars($site->nom) ?></td>
                        <td><?= htmlspecialchars($site->ville_nom ?? '—') ?></td>
                        <td>
                            <span class="badge badge--cat"><?= $categories[$site->categorie] ?? $site->categorie ?></span>
                        </td>
                        <td><?= $site->prix_entree > 0 ? number_format($site->prix_entree, 0, ',', ' ') . ' FCFA' : 'Gratuit' ?></td>
                        <td>
                            <?php if ($site->est_valide): ?>
                            <span class="badge badge--green">✅ Publié</span>
                            <?php else: ?>
                            <span class="badge badge--grey">⏸ Non publié</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="/admin/sites/<?= $site->id ?>" class="btn-icon" title="Voir">👁</a>
                                <a href="/admin/sites/<?= $site->id ?>/edit" class="btn-icon btn-icon--blue" title="Modifier">✏️</a>
                                <form method="POST" action="/admin/sites/<?= $site->id ?>/toggle" style="display:inline">
                                    <button type="submit" class="btn-icon <?= $site->est_valide ? 'btn-icon--yellow' : 'btn-icon--green' ?>"
                                            title="<?= $site->est_valide ? 'Dépublier' : 'Publier' ?>">
                                        <?= $site->est_valide ? '⏸' : '▶️' ?>
                                    </button>
                                </form>
                                <form method="POST" action="/admin/sites/<?= $site->id ?>/supprimer" style="display:inline"
                                      onsubmit="return confirm('Supprimer ce site touristique ?')">
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
                <a href="?page=<?= $i ?>&search=<?= urlencode($filters['search'] ?? '') ?>&ville_id=<?= $filters['ville_id'] ?? '' ?>&categorie=<?= $filters['categorie'] ?? '' ?>&valide=<?= $filters['valide'] ?? '' ?>"
                   class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="empty-state">
                <span>🏞️</span>
                <h3>Aucun site touristique</h3>
                <p>Commencez par en ajouter un.</p>
                <a href="/admin/sites/create" class="btn-primary">+ Ajouter un site</a>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>
</body>
</html>