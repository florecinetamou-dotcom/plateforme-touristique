<<<<<<< HEAD
<?php
$utilisateurs = $utilisateurs ?? [];
$total        = $total        ?? 0;
$total_pages  = $total_pages  ?? 1;
$page         = $page         ?? 1;
$counts       = $counts       ?? [];
$badges       = $badges       ?? [];

$role        = $_GET['role']        ?? 'tous';
$search      = $_GET['search']      ?? '';
$verifie     = $_GET['verifie']     ?? '';
$newsletter  = $_GET['newsletter']  ?? '';

$roleLabels = [
    'tous'       => ['label' => 'Tous',        'class' => ''],
    'voyageur'   => ['label' => 'Voyageurs',   'class' => 'badge--voyageur'],
    'hebergeur'  => ['label' => 'Hébergeurs',  'class' => 'badge--hebergeur'],
    'admin'      => ['label' => 'Admins',      'class' => 'badge--admin'],
];
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
                <p class="page-sub"><?= $total ?> utilisateur<?= $total > 1 ? 's' : '' ?> au total</p>
            </div>
        </div>
        

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Pills rôle -->
        <div class="status-pills">
            <?php foreach ($roleLabels as $key => $info): ?>
            <a href="?role=<?= $key ?>&search=<?= urlencode($search) ?>&verifie=<?= $verifie ?>&newsletter=<?= $newsletter ?>"
               class="pill <?= $role === $key ? 'pill--active' : '' ?>">
                <?= $info['label'] ?>
                <span class="pill-count"><?= $counts[$key] ?? 0 ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Filtres -->
        <form method="GET" class="filters-bar">
            <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">
            <input type="text" name="search" placeholder="Rechercher nom, prénom, email…"
                   value="<?= htmlspecialchars($search) ?>" class="filter-input">

            <select name="verifie" class="filter-select">
                <option value="">Tous (vérification)</option>
                <option value="1" <?= $verifie == '1' ? 'selected' : '' ?>>Vérifiés</option>
                <option value="0" <?= $verifie == '0' ? 'selected' : '' ?>>Non vérifiés</option>
            </select>

            <select name="newsletter" class="filter-select">
                <option value="">Newsletter</option>
                <option value="1" <?= $newsletter == '1' ? 'selected' : '' ?>>Inscrits</option>
                <option value="0" <?= $newsletter == '0' ? 'selected' : '' ?>>Non inscrits</option>
            </select>

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
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Newsletter</th>
                        <th>Inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $u): ?>
                    <tr>
                        <!-- Nom + Avatar -->
                        <td>
                            <div style="display:flex;align-items:center;gap:12px">
                                <div style="width:42px;height:42px;background:linear-gradient(135deg, #008751, #fcd116);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;color:#fff;font-weight:700">
                                    <?= strtoupper(substr($u->prenom ?? 'U', 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="td-bold"><?= htmlspecialchars($u->prenom . ' ' . $u->nom) ?></div>
                                    <?php if ($u->est_verifie): ?>
                                        <div style="font-size:.65rem;color:#4ade80;margin-top:2px">✓ Email vérifié</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <!-- Email -->
                        <td>
                            <div style="font-size:.83rem;color:#e5e7eb">
                                <?= htmlspecialchars($u->email) ?>
                            </div>
                            <?php if (!empty($u->telephone)): ?>
                            <div style="font-size:.72rem;color:#6b7280">
                                <?= htmlspecialchars($u->telephone) ?>
                            </div>
                            <?php endif; ?>
                        </td>

                        <!-- Rôle -->
                        <td>
                            <?php
                            $roleClass = match($u->role) {
                                'hebergeur' => 'badge--hebergeur',
                                'admin'     => 'badge--admin',
                                default     => 'badge--voyageur',
                            };
                            $roleIcon = match($u->role) {
                                'hebergeur' => '🏨',
                                'admin'     => '⚙️',
                                default     => '✈️',
                            };
                            ?>
                            <span class="badge <?= $roleClass ?>">
                                <?= $roleIcon ?> <?= ucfirst($u->role) ?>
                            </span>
                        </td>

                        <!-- Statut (bloqué/actif) -->
                        <td>
                            <?php if ($u->est_bloque): ?>
                                <span class="badge badge--red">🔒 Bloqué</span>
                            <?php else: ?>
                                <span class="badge badge--green">✅ Actif</span>
                            <?php endif; ?>
                        </td>

                        <!-- Newsletter -->
                        <td>
                            <?php if ($u->newsletter): ?>
                                <span class="badge badge--green">📧 Inscrit</span>
                            <?php else: ?>
                                <span class="badge badge--grey">📧 Non inscrit</span>
                            <?php endif; ?>
                        </td>

                        <!-- Date d'inscription -->
                        <td style="font-size:.78rem;color:#9ca3af">
                            <?= date('d/m/Y', strtotime($u->date_inscription)) ?>
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="action-btns">
                                <a href="/admin/utilisateurs/<?= $u->id ?>" class="btn-icon" title="Voir le détail">👁</a>

                                <!-- Bloquer / Débloquer -->
                                <?php if (!$u->est_bloque): ?>
                                <form method="POST" action="/admin/utilisateurs/<?= $u->id ?>/bloquer" style="display:inline">
                                    <button type="submit" class="btn-icon btn-icon--warning" title="Bloquer" 
                                            onclick="return confirm('Bloquer cet utilisateur ?')">🔒</button>
                                </form>
                                <?php else: ?>
                                <form method="POST" action="/admin/utilisateurs/<?= $u->id ?>/debloquer" style="display:inline">
                                    <button type="submit" class="btn-icon btn-icon--green" title="Débloquer"
                                            onclick="return confirm('Débloquer cet utilisateur ?')">🔓</button>
                                </form>
                                <?php endif; ?>

                                <!-- Changer rôle -->
                                <form method="POST" action="/admin/utilisateurs/<?= $u->id ?>/changer-role" style="display:inline" class="role-form">
                                    <select name="role" onchange="this.form.submit()" class="role-select-mini" title="Changer le rôle">
                                        <option value="voyageur"  <?= $u->role === 'voyageur'  ? 'selected' : '' ?>>✈️</option>
                                        <option value="hebergeur" <?= $u->role === 'hebergeur' ? 'selected' : '' ?>>🏨</option>
                                        <option value="admin"     <?= $u->role === 'admin'     ? 'selected' : '' ?>>⚙️</option>
                                    </select>
                                </form>

                                <!-- Supprimer -->
                                <form method="POST" action="/admin/utilisateurs/<?= $u->id ?>/supprimer" style="display:inline"
                                      onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                                    <button type="submit" class="btn-icon btn-icon--red" title="Supprimer">🗑️</button>
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
                <a href="?page=<?= $i ?>&role=<?= $role ?>&search=<?= urlencode($search) ?>&verifie=<?= $verifie ?>&newsletter=<?= $newsletter ?>"
                   class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="empty-state">
                <span>👥</span>
                <h3>Aucun utilisateur trouvé</h3>
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

/* Badges */
.badge--voyageur  { background: #e3f2fd; color: #0b5e7e; }
.badge--hebergeur { background: #e8f5e9; color: #2e7d32; }
.badge--admin     { background: #f3e5f5; color: #6a1b9a; }
.badge--green     { background: #d4edda; color: #155724; }
.badge--red       { background: #f8d7da; color: #721c24; }
.badge--grey      { background: #e9ecef; color: #495057; }

/* Select mini rôle */
.role-select-mini {
    padding: 4px 6px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: rgba(255,255,255,.05);
    color: #e5e7eb;
    font-size: 1rem;
    cursor: pointer;
    transition: all .2s;
}
.role-select-mini:hover {
    background: rgba(0,135,81,.2);
    border-color: rgba(0,135,81,.5);
}
</style>

</body>
</html>
=======

<div class="admin-header">
    <h1>Gestion des utilisateurs</h1>
    <div class="admin-stats">
        <div class="stat-card">
            <span class="stat-number"><?= $counts['tous'] ?></span>
            <span class="stat-label">Total</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $counts['voyageur'] ?></span>
            <span class="stat-label">Voyageurs</span>
        </div>
        <div class="stat-card warning">
            <span class="stat-number"><?= $counts['hebergeur'] ?></span>
            <span class="stat-label">Hébergeurs</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $counts['admin'] ?></span>
            <span class="stat-label">Admins</span>
        </div>
    </div>
</div>

<div class="admin-filters">
    <form method="GET" class="filters-form">
        <select name="role" onchange="this.form.submit()">
            <option value="tous" <?= ($_GET['role'] ?? 'tous') === 'tous' ? 'selected' : '' ?>>Tous les rôles</option>
            <option value="voyageur" <?= ($_GET['role'] ?? '') === 'voyageur' ? 'selected' : '' ?>>Voyageurs</option>
            <option value="hebergeur" <?= ($_GET['role'] ?? '') === 'hebergeur' ? 'selected' : '' ?>>Hébergeurs</option>
            <option value="admin" <?= ($_GET['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admins</option>
        </select>
        
        <input type="text" name="search" placeholder="Rechercher..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        
        <select name="verifie" onchange="this.form.submit()">
            <option value="">Vérification</option>
            <option value="1" <?= ($_GET['verifie'] ?? '') === '1' ? 'selected' : '' ?>>Vérifiés</option>
            <option value="0" <?= ($_GET['verifie'] ?? '') === '0' ? 'selected' : '' ?>>Non vérifiés</option>
        </select>
        
        <button type="submit" class="btn-sm btn-primary">Filtrer</button>
    </form>
</div>

<div class="admin-table">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom / Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Statut hébergeur</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $u): ?>
            <tr>
                <td>#<?= $u->id ?></td>
                <td>
                    <strong><?= htmlspecialchars($u->prenom . ' ' . $u->nom) ?></strong>
                </td>
                <td><?= htmlspecialchars($u->email) ?></td>
                <td>
                    <span class="role-badge role-<?= $u->role ?>">
                        <?= $u->role === 'hebergeur' ? '🏨 Hébergeur' : ($u->role === 'admin' ? '⚙️ Admin' : '✈️ Voyageur') ?>
                    </span>
                </td>
                <td>
                    <?php if ($u->role === 'hebergeur'): ?>
                        <?php if ($u->statut_hebergeur === 'actif'): ?>
                            <span class="status-badge success">✅ Actif</span>
                        <?php elseif ($u->statut_hebergeur === 'en_attente'): ?>
                            <span class="status-badge warning">⏳ En attente</span>
                        <?php elseif ($u->statut_hebergeur === 'bloque'): ?>
                            <span class="status-badge danger">🔒 Bloqué</span>
                        <?php else: ?>
                            <span class="status-badge muted">📝 Non demandé</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($u->est_bloque): ?>
                        <span class="status-badge danger">Bloqué</span>
                    <?php else: ?>
                        <span class="status-badge success">Actif</span>
                    <?php endif; ?>
                </td>
                <td><?= date('d/m/Y', strtotime($u->date_inscription)) ?></td>
                <td class="actions">
                    <!-- Actions pour hébergeurs en attente -->
                    <?php if ($u->role === 'hebergeur' && $u->statut_hebergeur === 'en_attente'): ?>
                        <form action="/admin/utilisateurs/valider-hebergeur/<?= $u->id ?>" method="POST" style="display:inline">
                            <button type="submit" class="btn-success btn-sm" onclick="return confirm('Valider cet hébergeur ?')">
                                ✅ Valider
                            </button>
                        </form>
                        <form action="/admin/utilisateurs/refuser-hebergeur/<?= $u->id ?>" method="POST" style="display:inline">
                            <button type="submit" class="btn-danger btn-sm" onclick="return confirm('Refuser cet hébergeur ?')">
                                ❌ Refuser
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <!-- Bloquer/Débloquer -->
                    <?php if (!$u->est_bloque): ?>
                        <form action="/admin/utilisateurs/bloquer/<?= $u->id ?>" method="POST" style="display:inline">
                            <button type="submit" class="btn-warning btn-sm" onclick="return confirm('Bloquer cet utilisateur ?')">
                                🔒 Bloquer
                            </button>
                        </form>
                    <?php else: ?>
                        <form action="/admin/utilisateurs/debloquer/<?= $u->id ?>" method="POST" style="display:inline">
                            <button type="submit" class="btn-success btn-sm" onclick="return confirm('Débloquer cet utilisateur ?')">
                                🔓 Débloquer
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <!-- Changer rôle -->
                    <form action="/admin/utilisateurs/changer-role/<?= $u->id ?>" method="POST" style="display:inline">
                        <select name="role" onchange="this.form.submit()" class="role-select">
                            <option value="voyageur" <?= $u->role === 'voyageur' ? 'selected' : '' ?>>Voyageur</option>
                            <option value="hebergeur" <?= $u->role === 'hebergeur' ? 'selected' : '' ?>>Hébergeur</option>
                            <option value="admin" <?= $u->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </form>
                    
                    <a href="/admin/utilisateurs/<?= $u->id ?>" class="btn-info btn-sm">👁️ Voir</a>
                    
                    <form action="/admin/utilisateurs/supprimer/<?= $u->id ?>" method="POST" style="display:inline">
                        <button type="submit" class="btn-danger btn-sm" onclick="return confirm('Supprimer définitivement cet utilisateur ?')">
                            🗑️ Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>&role=<?= $_GET['role'] ?? 'tous' ?>&search=<?= urlencode($_GET['search'] ?? '') ?>" 
           class="page-link <?= $i == $page ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<style>
.admin-header { margin-bottom: 30px; }
.admin-stats { display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap; }
.stat-card { background: white; padding: 20px; border-radius: 12px; text-align: center; min-width: 120px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.stat-card.warning { border-left: 4px solid #ffc107; }
.stat-number { font-size: 2rem; font-weight: 800; display: block; }
.stat-label { font-size: 0.8rem; color: #666; }

.admin-filters { margin-bottom: 20px; }
.filters-form { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
.filters-form input, .filters-form select { padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; }

.admin-table { background: white; border-radius: 16px; overflow-x: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #eee; }
.table th { background: #f8f9fa; font-weight: 600; }

.role-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
.role-voyageur { background: #e3f2fd; color: #0b5e7e; }
.role-hebergeur { background: #e8f5e9; color: #2e7d32; }
.role-admin { background: #f3e5f5; color: #6a1b9a; }

.status-badge { padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; display: inline-block; }
.status-badge.success { background: #d4edda; color: #155724; }
.status-badge.warning { background: #fff3cd; color: #856404; }
.status-badge.danger { background: #f8d7da; color: #721c24; }
.status-badge.muted { background: #e9ecef; color: #6c757d; }

.actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
.btn-sm { padding: 4px 10px; font-size: 0.7rem; border-radius: 20px; cursor: pointer; border: none; text-decoration: none; display: inline-block; }
.btn-success { background: #28a745; color: white; }
.btn-danger { background: #dc3545; color: white; }
.btn-warning { background: #ffc107; color: #333; }
.btn-info { background: #17a2b8; color: white; text-decoration: none; }
.btn-primary { background: #008751; color: white; }

.role-select { padding: 4px 8px; border-radius: 8px; border: 1px solid #ddd; font-size: 0.7rem; cursor: pointer; }

.pagination { display: flex; gap: 8px; justify-content: center; margin-top: 30px; }
.page-link { padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; color: #333; }
.page-link.active { background: #008751; color: white; border-color: #008751; }
</style>
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
