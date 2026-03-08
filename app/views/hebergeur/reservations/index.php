<?php $title = 'Réservations reçues - BeninExplore'; ?>
<?php ob_start(); ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
        </div>
        
        <!-- Contenu principal -->
        <div class="col-md-9">
            <h4 class="fw-bold mb-4">Réservations reçues</h4>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (empty($reservations)): ?>
                <div class="text-center py-5 bg-light rounded-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h6>Aucune réservation pour le moment</h6>
                    <p class="text-muted small">Les réservations apparaîtront ici</p>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">Référence</th>
                                        <th>Hébergement</th>
                                        <th>Voyageur</th>
                                        <th>Contact</th>
                                        <th>Dates</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th class="pe-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservations as $resa): ?>
                                        <tr>
                                            <td class="ps-3"><small><?= $resa->reference ?></small></td>
                                            <td><small><?= htmlspecialchars($resa->hebergement_nom) ?></small></td>
                                            <td><small><?= htmlspecialchars($resa->prenom . ' ' . $resa->voyageur_nom) ?></small></td>
                                            <td><small><?= htmlspecialchars($resa->email) ?></small></td>
                                            <td>
                                                <small>
                                                    <?= date('d/m/Y', strtotime($resa->date_arrivee)) ?><br>
                                                    <span class="text-muted">au <?= date('d/m/Y', strtotime($resa->date_depart)) ?></span>
                                                </small>
                                            </td>
                                            <td><small><?= number_format($resa->montant_total, 0, ',', ' ') ?> FCFA</small></td>
                                            <td>
                                                <?php
                                                $badgeClass = match($resa->statut) {
                                                    'confirmee' => 'bg-success',
                                                    'en_attente' => 'bg-warning',
                                                    'annulee' => 'bg-danger',
                                                    'terminee' => 'bg-secondary',
                                                    default => 'bg-info'
                                                };
                                                ?>
                                                <span class="badge <?= $badgeClass ?> rounded-pill px-2 py-1 small">
                                                    <?= $resa->statut ?>
                                                </span>
                                            </td>
                                            <td class="pe-3">
                                                <?php if ($resa->statut == 'en_attente'): ?>
                                                    <form method="POST" action="/hebergeur/reservations/confirmer/<?= $resa->id ?>" class="d-inline">
                                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 me-1"
                                                                onclick="return confirm('Confirmer cette réservation ?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="/hebergeur/reservations/annuler/<?= $resa->id ?>" class="d-inline">
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3"
                                                                onclick="return confirm('Annuler cette réservation ?')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>