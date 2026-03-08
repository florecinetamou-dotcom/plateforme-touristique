<?php $title = 'Dashboard Hébergeur - BeninExplore'; ?>
<?php ob_start(); ?>

<div class="heb-layout">

    <!-- Sidebar -->
    <aside class="heb-sidebar-wrap">
        <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
    </aside>

    <!-- Contenu principal -->
    <main class="heb-main">

        <!-- Header page -->
        <div class="heb-page-header">
            <div>
                <h1 class="heb-page-title">Tableau de bord</h1>
                <p class="heb-page-sub">Bonjour <?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'Hébergeur')[0]) ?>, voici un aperçu de votre activité.</p>
            </div>
            <a href="/hebergeur/hebergements/create" class="btn btn-heb-primary">
                <i class="fas fa-plus me-2"></i>Nouvel hébergement
            </a>
        </div>

        <!-- Statistiques -->
        <div class="row g-4 mb-5">
            <div class="col-md-3 col-6">
                <div class="stat-card stat-blue">
                    <div class="stat-icon"><i class="fas fa-hotel"></i></div>
                    <div class="stat-body">
                        <div class="stat-num"><?= $stats['total_hebergements'] ?? 0 ?></div>
                        <div class="stat-label">Hébergements</div>
                        <div class="stat-sub"><?= $stats['hebergements_actifs'] ?? 0 ?> actifs</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card stat-green">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-body">
                        <div class="stat-num"><?= $stats['total_reservations'] ?? 0 ?></div>
                        <div class="stat-label">Réservations</div>
                        <div class="stat-sub">
                            <?php if (!empty($stats['reservations_en_attente']) && $stats['reservations_en_attente'] > 0): ?>
                                <span class="stat-alert"><?= $stats['reservations_en_attente'] ?> en attente</span>
                            <?php else: ?>
                                Aucune en attente
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card stat-yellow">
                    <div class="stat-icon"><i class="fas fa-coins"></i></div>
                    <div class="stat-body">
                        <div class="stat-num"><?= number_format($stats['chiffre_affaires'] ?? 0, 0, ',', ' ') ?></div>
                        <div class="stat-label">Chiffre d'affaires</div>
                        <div class="stat-sub">FCFA ce mois</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card stat-purple">
                    <div class="stat-icon"><i class="fas fa-star"></i></div>
                    <div class="stat-body">
                        <div class="stat-num"><?= $stats['note_moyenne'] ?? '—' ?></div>
                        <div class="stat-label">Note moyenne</div>
                        <div class="stat-sub">sur 5</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dernières réservations -->
        <div class="heb-card">
            <div class="heb-card-header">
                <div>
                    <h2 class="heb-card-title">Dernières réservations</h2>
                    <p class="heb-card-sub">Les 10 dernières réservations reçues</p>
                </div>
                <a href="/hebergeur/reservations" class="btn btn-heb-outline btn-sm">
                    Tout voir <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <?php if (empty($recentReservations)): ?>
                <div class="heb-empty">
                    <div class="heb-empty-icon"><i class="fas fa-calendar-times"></i></div>
                    <div class="heb-empty-title">Aucune réservation pour le moment</div>
                    <div class="heb-empty-sub">Vos réservations apparaîtront ici dès qu'un voyageur réservera chez vous.</div>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="heb-table">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Hébergement</th>
                                <th>Voyageur</th>
                                <th>Dates</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentReservations as $resa): ?>
                            <tr>
                                <td>
                                    <span class="resa-ref">#<?= htmlspecialchars($resa->reference) ?></span>
                                </td>
                                <td>
                                    <span class="resa-hotel"><?= htmlspecialchars($resa->hebergement_nom) ?></span>
                                </td>
                                <td>
                                    <div class="resa-voyageur">
                                        <div class="resa-avatar"><?= strtoupper(substr($resa->prenom, 0, 1)) ?></div>
                                        <span><?= htmlspecialchars($resa->prenom . ' ' . $resa->voyageur_nom) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="resa-dates">
                                        <i class="fas fa-calendar me-1 text-muted"></i>
                                        <?= date('d/m/Y', strtotime($resa->date_arrivee)) ?>
                                        <span class="text-muted mx-1">→</span>
                                        <?= date('d/m/Y', strtotime($resa->date_depart)) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="resa-montant"><?= number_format($resa->montant_total, 0, ',', ' ') ?> <small>FCFA</small></span>
                                </td>
                                <td>
                                    <?php
                                    $statusConfig = [
                                        'confirmee'  => ['label' => 'Confirmée',  'class' => 'status-green'],
                                        'en_attente' => ['label' => 'En attente', 'class' => 'status-yellow'],
                                        'annulee'    => ['label' => 'Annulée',    'class' => 'status-red'],
                                    ];
                                    $sc = $statusConfig[$resa->statut] ?? ['label' => ucfirst($resa->statut), 'class' => 'status-gray'];
                                    ?>
                                    <span class="resa-status <?= $sc['class'] ?>"><?= $sc['label'] ?></span>
                                </td>
                                <td>
                                    <a href="/hebergeur/reservations" class="btn-action">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </main>
</div>

<style>
/* ===== LAYOUT ===== */
.heb-layout {
    display: flex;
    gap: 28px;
    padding: 32px 24px;
    max-width: 1400px;
    margin: 0 auto;
    align-items: flex-start;
}
.heb-sidebar-wrap {
    width: 260px;
    flex-shrink: 0;
}
.heb-main {
    flex: 1;
    min-width: 0;
}

/* ===== PAGE HEADER ===== */
.heb-page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 14px;
}
.heb-page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 4px;
}
.heb-page-sub {
    font-size: 0.875rem;
    color: #888;
    margin: 0;
}

/* Boutons */
.btn-heb-primary {
    background: linear-gradient(135deg, #008751, #00a862);
    color: white; border: none;
    border-radius: 50px;
    padding: 10px 22px;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 4px 14px rgba(0,135,81,0.25);
    white-space: nowrap;
}
.btn-heb-primary:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,135,81,0.35); }
.btn-heb-outline {
    border: 1.5px solid #008751;
    color: #008751;
    background: transparent;
    border-radius: 50px;
    padding: 7px 16px;
    font-size: 0.82rem;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-heb-outline:hover { background: #008751; color: white; }

/* ===== STAT CARDS ===== */
.stat-card {
    border-radius: 18px;
    padding: 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.3s, box-shadow 0.3s;
    border: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    height: 100%;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,0,0,0.1); }
.stat-blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.stat-green  { background: linear-gradient(135deg, #008751, #00a862); }
.stat-yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }
.stat-purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.stat-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.2);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 22px; flex-shrink: 0;
}
.stat-num { font-size: 1.8rem; font-weight: 800; color: white; line-height: 1; }
.stat-label { font-size: 0.8rem; color: rgba(255,255,255,0.85); font-weight: 500; margin-top: 2px; }
.stat-sub { font-size: 0.72rem; color: rgba(255,255,255,0.65); margin-top: 2px; }
.stat-alert {
    background: rgba(255,255,255,0.25);
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 50px;
}

/* ===== HEB CARD ===== */
.heb-card {
    background: white;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    border: 1px solid #f0f0f0;
    overflow: hidden;
}
.heb-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f5f5f5;
}
.heb-card-title { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0; }
.heb-card-sub { font-size: 0.78rem; color: #aaa; margin: 2px 0 0; }

/* Empty state */
.heb-empty {
    text-align: center;
    padding: 60px 24px;
}
.heb-empty-icon {
    width: 64px; height: 64px;
    background: #f5f5f5;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    color: #ccc; font-size: 28px;
    margin: 0 auto 16px;
}
.heb-empty-title { font-size: 0.95rem; font-weight: 700; color: #333; margin-bottom: 6px; }
.heb-empty-sub { font-size: 0.82rem; color: #aaa; }

/* ===== TABLE ===== */
.heb-table {
    width: 100%;
    border-collapse: collapse;
}
.heb-table thead tr {
    background: #fafafa;
    border-bottom: 1px solid #f0f0f0;
}
.heb-table th {
    padding: 12px 16px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #aaa;
    white-space: nowrap;
}
.heb-table td {
    padding: 14px 16px;
    font-size: 0.85rem;
    color: #333;
    border-bottom: 1px solid #f8f8f8;
    vertical-align: middle;
}
.heb-table tbody tr { transition: background 0.15s; }
.heb-table tbody tr:hover { background: #fafffe; }
.heb-table tbody tr:last-child td { border-bottom: none; }

.resa-ref { font-size: 0.78rem; font-weight: 700; color: #008751; font-family: monospace; }
.resa-hotel { font-weight: 600; color: #1a1a2e; font-size: 0.85rem; }
.resa-voyageur { display: flex; align-items: center; gap: 8px; }
.resa-avatar {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #008751, #FFD600);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 0.7rem; font-weight: 700; flex-shrink: 0;
}
.resa-dates { font-size: 0.8rem; color: #555; white-space: nowrap; }
.resa-montant { font-weight: 700; color: #1a1a2e; }
.resa-montant small { font-weight: 400; color: #aaa; font-size: 0.72rem; }

/* Statuts */
.resa-status {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}
.status-green  { background: #d1fae5; color: #065f46; }
.status-yellow { background: #fef3c7; color: #92400e; }
.status-red    { background: #fee2e2; color: #991b1b; }
.status-gray   { background: #f3f4f6; color: #6b7280; }

/* Action */
.btn-action {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(0,135,81,0.08);
    color: #008751;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-action:hover { background: #008751; color: white; }

/* ===== RESPONSIVE ===== */
@media (max-width: 991px) {
    .heb-layout { flex-direction: column; padding: 20px 16px; }
    .heb-sidebar-wrap { width: 100%; }
}
@media (max-width: 576px) {
    .heb-page-header { flex-direction: column; align-items: flex-start; }
    .stat-num { font-size: 1.4rem; }
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>