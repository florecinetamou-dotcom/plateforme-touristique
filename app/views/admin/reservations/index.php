<?php
$reservations = $reservations ?? [];
$total        = $total        ?? 0;
$total_pages  = $total_pages  ?? 1;
$page         = $page         ?? 1;
$counts       = $counts       ?? [];
$stats        = $stats        ?? [];
$badges       = $badges       ?? [];
$filters      = $filters      ?? [];

$statutLabels = [
    'tous'       => ['label' => 'Toutes',      'icon' => '📋'],
    'en_attente' => ['label' => 'En attente',  'icon' => '⏳'],
    'confirmee'  => ['label' => 'Confirmées',  'icon' => '✅'],
    'annulee'    => ['label' => 'Annulées',    'icon' => '❌'],
    'terminee'   => ['label' => 'Terminées',   'icon' => '🏁'],
    'no_show'    => ['label' => 'No show',     'icon' => '👻'],
];

$badgeMap = [
    'en_attente' => 'badge--attente',
    'confirmee'  => 'badge--green',
    'annulee'    => 'badge--red',
    'terminee'   => 'badge--blue',
    'no_show'    => 'badge--grey',
];

$modeMap = [
    'carte'        => '💳 Carte',
    'mobile_money' => '📱 Mobile Money',
    'especes'      => '💵 Espèces',
    'virement'     => '🏦 Virement',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservations — Admin BeninExplore</title>
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
                <h1 class="page-title">Réservations</h1>
                <p class="page-sub"><?= $total ?> réservation<?= $total > 1 ? 's' : '' ?> au total</p>
            </div>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Stats financières -->
        <div class="rev-cards">
            <div class="rev-card">
                <div class="rev-card__icon">💰</div>
                <div class="rev-card__info">
                    <div class="rev-card__label">Revenus confirmés (total)</div>
                    <div class="rev-card__val"><?= number_format($stats['revenus_confirmes'] ?? 0, 0, ',', ' ') ?> FCFA</div>
                </div>
            </div>
            <div class="rev-card">
                <div class="rev-card__icon">📅</div>
                <div class="rev-card__info">
                    <div class="rev-card__label">Revenus ce mois</div>
                    <div class="rev-card__val" style="color:#FFD600"><?= number_format($stats['revenus_mois'] ?? 0, 0, ',', ' ') ?> FCFA</div>
                </div>
            </div>
            <div class="rev-card">
                <div class="rev-card__icon">⏳</div>
                <div class="rev-card__info">
                    <div class="rev-card__label">En attente</div>
                    <div class="rev-card__val" style="color:#FFD600"><?= $counts['en_attente'] ?? 0 ?></div>
                </div>
            </div>
            <div class="rev-card">
                <div class="rev-card__icon">✅</div>
                <div class="rev-card__info">
                    <div class="rev-card__label">Confirmées</div>
                    <div class="rev-card__val" style="color:#4ade80"><?= $counts['confirmee'] ?? 0 ?></div>
                </div>
            </div>
        </div>

        <!-- Pills statut -->
        <div class="status-pills">
            <?php foreach ($statutLabels as $key => $info): ?>
            <a href="?statut=<?= $key ?>&search=<?= urlencode($filters['search'] ?? '') ?>"
               class="pill <?= ($filters['statut'] ?? 'tous') === $key ? 'pill--active' : '' ?>">
                <?= $info['icon'] ?> <?= $info['label'] ?>
                <span class="pill-count"><?= $counts[$key] ?? 0 ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Filtres -->
        <form method="GET" class="filters-bar">
            <input type="hidden" name="statut" value="<?= htmlspecialchars($filters['statut'] ?? 'tous') ?>">
            <input type="text" name="search" placeholder="Réf, voyageur, hébergement…"
                   value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="filter-input">
            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="/admin/reservations" class="btn-reset">Réinitialiser</a>
        </form>

        <!-- Table -->
        <div class="table-card">
            <?php if (!empty($reservations)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Voyageur</th>
                        <th>Hébergement</th>
                        <th>Arrivée</th>
                        <th>Départ</th>
                        <th>Voyageurs</th>
                        <th>Montant</th>
                        <th>Paiement</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $r): ?>
                    <tr>
                        <td>
                            <span class="ref-badge">#<?= htmlspecialchars($r->reference) ?></span>
                        </td>
                        <td>
                            <div class="td-bold"><?= htmlspecialchars(($r->voyageur_prenom ?? '') . ' ' . ($r->voyageur_nom ?? '')) ?></div>
                            <div style="font-size:.72rem;color:#6b7280"><?= htmlspecialchars($r->voyageur_email ?? '') ?></div>
                        </td>
                        <td>
                            <div style="font-size:.83rem;color:#e5e7eb"><?= htmlspecialchars($r->hebergement_nom ?? '—') ?></div>
                            <div style="font-size:.72rem;color:#6b7280"><?= htmlspecialchars($r->ville_nom ?? '') ?></div>
                        </td>
                        <td><?= date('d/m/Y', strtotime($r->date_arrivee)) ?></td>
                        <td><?= date('d/m/Y', strtotime($r->date_depart)) ?></td>
                        <td style="text-align:center"><?= $r->nombre_voyageurs ?? '—' ?></td>
                        <td style="font-weight:700;color:#4ade80">
                            <?= number_format($r->montant_total ?? 0, 0, ',', ' ') ?>
                            <span style="font-size:.7rem;font-weight:400;color:#6b7280">FCFA</span>
                        </td>
                        <td style="font-size:.75rem">
                            <?= $modeMap[$r->mode_paiement ?? ''] ?? '—' ?>
                        </td>
                        <td>
                            <?php $bc = $badgeMap[$r->statut ?? ''] ?? 'badge--grey'; ?>
                            <span class="badge <?= $bc ?>">
                                <?= ucfirst(str_replace('_', ' ', $r->statut ?? '')) ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="/admin/reservations/<?= $r->id ?>" class="btn-icon" title="Voir">👁</a>
                                <?php if ($r->statut === 'en_attente'): ?>
                                <form method="POST" action="/admin/reservations/<?= $r->id ?>/confirmer" style="display:inline">
                                    <button type="submit" class="btn-icon btn-icon--green" title="Confirmer">✓</button>
                                </form>
                                <form method="POST" action="/admin/reservations/<?= $r->id ?>/annuler" style="display:inline"
                                      onsubmit="return confirm('Annuler cette réservation ?')">
                                    <button type="submit" class="btn-icon btn-icon--red" title="Annuler">✗</button>
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
                <a href="?page=<?= $i ?>&statut=<?= $filters['statut'] ?? 'tous' ?>&search=<?= urlencode($filters['search'] ?? '') ?>"
                   class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="empty-state">
                <span>📅</span>
                <h3>Aucune réservation trouvée</h3>
                <p>Modifiez vos filtres ou attendez de nouvelles réservations.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
.rev-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}
.rev-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.rev-card__icon { font-size: 1.8rem; flex-shrink: 0; }
.rev-card__label { font-size: .72rem; color: #6b7280; font-weight: 500; margin-bottom: 4px; }
.rev-card__val { font-size: 1.2rem; font-weight: 800; color: #fff; }

.status-pills { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px; }
.pill { display:inline-flex; align-items:center; gap:7px; padding:7px 16px; border-radius:30px; font-size:.78rem; font-weight:600; text-decoration:none; color:var(--muted2); background:rgba(255,255,255,.05); border:1px solid var(--border); transition:all .2s; }
.pill:hover { background:rgba(255,255,255,.1); color:#fff; }
.pill--active { background:rgba(0,135,81,.15); border-color:rgba(0,135,81,.4); color:#4ade80; }
.pill-count { background:rgba(255,255,255,.1); padding:1px 8px; border-radius:20px; font-size:.68rem; }
.pill--active .pill-count { background:rgba(0,135,81,.25); }

.ref-badge { font-family:monospace; font-size:.78rem; font-weight:700; color:#a78bfa; background:rgba(139,92,246,.1); padding:3px 8px; border-radius:6px; }

@media (max-width:1200px) { .rev-cards { grid-template-columns:repeat(2,1fr); } }
@media (max-width:640px)  { .rev-cards { grid-template-columns:1fr; } }
</style>

</body>
</html>