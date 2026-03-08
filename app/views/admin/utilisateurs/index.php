<?php
$utilisateurs = $utilisateurs ?? [];
$total        = $total        ?? 0;
$total_pages  = $total_pages  ?? 1;
$page         = $page         ?? 1;
$counts       = $counts       ?? [];
$badges       = $badges       ?? [];

$role   = $_GET['role']   ?? 'tous';
$search = $_GET['search'] ?? '';

$roleLabels = [
    'tous'      => ['label' => 'Tous',        'icon' => '👥'],
    'voyageur'  => ['label' => 'Voyageurs',   'icon' => '🧳'],
    'hebergeur' => ['label' => 'Hébergeurs',  'icon' => '🏨'],
    'admin'     => ['label' => 'Admins',      'icon' => '🔑'],
];

$roleMap = [
    'voyageur'  => 'badge--blue',
    'hebergeur' => 'badge--attente',
    'admin'     => 'badge--green',
];

$colors = ['#008751','#3b82f6','#f59e0b','#8b5cf6','#ec4899','#14b8a6','#f97316','#06b6d4'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs — Admin BeninExplore</title>
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
                <h1 class="page-title">Utilisateurs</h1>
                <p class="page-sub"><?= $total ?> utilisateur<?= $total > 1 ? 's' : '' ?> inscrits</p>
            </div>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Stats rapides -->
        <div class="user-stats">
            <?php foreach ($roleLabels as $key => $info): ?>
            <?php if ($key === 'tous') continue; ?>
            <div class="user-stat-card">
                <div class="user-stat-card__icon"><?= $info['icon'] ?></div>
                <div>
                    <div class="user-stat-card__val"><?= $counts[$key] ?? 0 ?></div>
                    <div class="user-stat-card__label"><?= $info['label'] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pills rôle -->
        <div class="status-pills">
            <?php foreach ($roleLabels as $key => $info): ?>
            <a href="?role=<?= $key ?>&search=<?= urlencode($search) ?>"
               class="pill <?= $role === $key ? 'pill--active' : '' ?>">
                <?= $info['icon'] ?> <?= $info['label'] ?>
                <span class="pill-count"><?= $counts[$key] ?? 0 ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Filtres -->
        <form method="GET" class="filters-bar">
            <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">
            <input type="text" name="search" placeholder="Nom, prénom, email…"
                   value="<?= htmlspecialchars($search) ?>" class="filter-input">
            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="/admin/utilisateurs" class="btn-reset">Réinitialiser</a>
        </form>

        <!-- Table -->
        <div class="table-card">
            <?php if (!empty($utilisateurs)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                        <th>Inscription</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $i => $u): ?>
                    <?php $color = $colors[$i % count($colors)]; ?>
                    <tr>
                        <!-- Avatar + Nom -->
                        <td>
                            <div style="display:flex;align-items:center;gap:12px">
                                <div class="u-avatar" style="background:<?= $color ?>">
                                    <?= strtoupper(substr($u->prenom ?? $u->nom ?? 'U', 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="td-bold"><?= htmlspecialchars(($u->prenom ?? '') . ' ' . ($u->nom ?? '')) ?></div>
                                    <div style="font-size:.72rem;color:#6b7280">#<?= $u->id ?></div>
                                </div>
                            </div>
                        </td>

                        <td style="font-size:.82rem"><?= htmlspecialchars($u->email ?? '—') ?></td>
                        <td style="font-size:.82rem"><?= htmlspecialchars($u->telephone ?? '—') ?></td>

                        <!-- Rôle -->
                        <td>
                            <span class="badge <?= $roleMap[$u->role ?? ''] ?? 'badge--grey' ?>">
                                <?= ucfirst($u->role ?? '—') ?>
                            </span>
                        </td>

                        <!-- Date inscription -->
                        <td style="font-size:.78rem;color:#9ca3af">
                            <?= date('d/m/Y', strtotime($u->date_inscription)) ?>
                        </td>

                        <!-- Vérifié -->
                        <td>
                            <?php if ($u->est_verifie): ?>
                            <span class="badge badge--green">✅ Actif</span>
                            <?php else: ?>
                            <span class="badge badge--grey">⏸ Bloqué</span>
                            <?php endif; ?>
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="action-btns">
                                <a href="/admin/utilisateurs/<?= $u->id ?>" class="btn-icon" title="Voir le profil">👁</a>

                                <?php if ($u->est_verifie): ?>
                                <form method="POST" action="/admin/utilisateurs/<?= $u->id ?>/bloquer" style="display:inline"
                                      onsubmit="return confirm('Bloquer <?= htmlspecialchars(addslashes(($u->prenom ?? '') . ' ' . ($u->nom ?? ''))) ?> ?')">
                                    <button type="submit" class="btn-icon btn-icon--red" title="Bloquer">🚫</button>
                                </form>
                                <?php else: ?>
                                <form method="POST" action="/admin/utilisateurs/<?= $u->id ?>/debloquer" style="display:inline">
                                    <button type="submit" class="btn-icon btn-icon--green" title="Débloquer">✓</button>
                                </form>
                                <?php endif; ?>

                                <?php if ((int)$u->id !== (int)($_SESSION['user_id'] ?? 0)): ?>
                                <form method="POST" action="/admin/utilisateurs/<?= $u->id ?>/supprimer" style="display:inline"
                                      onsubmit="return confirm('Supprimer définitivement ce compte ?')">
                                    <button type="submit" class="btn-icon btn-icon--red" title="Supprimer">🗑</button>
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
                <a href="?page=<?= $i ?>&role=<?= $role ?>&search=<?= urlencode($search) ?>"
                   class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="empty-state">
                <span>👥</span>
                <h3>Aucun utilisateur trouvé</h3>
                <p>Modifiez vos filtres de recherche.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
.user-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.user-stat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.user-stat-card__icon { font-size: 1.6rem; }
.user-stat-card__val  { font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1; }
.user-stat-card__label{ font-size: .72rem; color: #6b7280; margin-top: 3px; }

.status-pills { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px; }
.pill { display:inline-flex; align-items:center; gap:7px; padding:7px 16px; border-radius:30px; font-size:.78rem; font-weight:600; text-decoration:none; color:var(--muted2); background:rgba(255,255,255,.05); border:1px solid var(--border); transition:all .2s; }
.pill:hover { background:rgba(255,255,255,.1); color:#fff; }
.pill--active { background:rgba(0,135,81,.15); border-color:rgba(0,135,81,.4); color:#4ade80; }
.pill-count { background:rgba(255,255,255,.1); padding:1px 8px; border-radius:20px; font-size:.68rem; }
.pill--active .pill-count { background:rgba(0,135,81,.25); }

.u-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .82rem; font-weight: 700; color: #fff;
    flex-shrink: 0;
}

@media (max-width: 768px) { .user-stats { grid-template-columns: 1fr; } }
</style>

</body>
</html>