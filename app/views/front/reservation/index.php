<?php $title = 'Mes réservations - Tourisme Bénin'; ?>
<?php ob_start(); ?>

<div class="container py-4">
    <h1 class="h3 fw-bold mb-4">Mes réservations</h1>
    
    <!-- Onglets -->
    <ul class="nav nav-tabs mb-4" id="reservationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">
                Toutes (<?= count($reservations) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button">
                À venir (<?= count($upcoming) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button">
                Passées (<?= count($past) ?>)
            </button>
        </li>
    </ul>
    
    <!-- Contenu des onglets -->
    <div class="tab-content" id="reservationTabContent">
        <!-- Toutes les réservations -->
        <div class="tab-pane fade show active" id="all" role="tabpanel">
            <?php if (empty($reservations)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5>Aucune réservation</h5>
                    <p class="text-muted small">Découvrez nos hébergements et réservez votre séjour !</p>
                    <a href="/hebergements" class="btn btn-benin btn-sm rounded-pill">
                        <i class="fas fa-search me-1"></i>Voir les hébergements
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($reservations as $resa): ?>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($resa->hebergement_nom) ?></h6>
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                                <?= htmlspecialchars($resa->ville_nom) ?>
                                            </small>
                                        </div>
                                        <span class="badge bg-<?= $resa->statut == 'confirmee' ? 'success' : ($resa->statut == 'annulee' ? 'danger' : 'secondary') ?>">
                                            <?= $resa->statut ?>
                                        </span>
                                    </div>
                                    
                                    <div class="small mb-2">
                                        <i class="fas fa-calendar-alt me-1 text-benin"></i>
                                        <?= date('d/m/Y', strtotime($resa->date_arrivee)) ?> - 
                                        <?= date('d/m/Y', strtotime($resa->date_depart)) ?>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-benin"><?= number_format($resa->montant_total, 0, ',', ' ') ?> FCFA</span>
                                        <a href="/reservation/<?= $resa->id ?>" class="btn btn-outline-benin btn-sm rounded-pill">
                                            Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Réservations à venir -->
        <div class="tab-pane fade" id="upcoming" role="tabpanel">
            <?php if (empty($upcoming)): ?>
                <p class="text-muted text-center py-4">Aucune réservation à venir</p>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($upcoming as $resa): ?>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($resa->hebergement_nom) ?></h6>
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-map-marker-alt text-benin me-1"></i><?= htmlspecialchars($resa->ville_nom) ?>
                                    </small>
                                    <div class="small mb-2">
                                        <i class="fas fa-calendar-alt me-1 text-benin"></i>
                                        <?= date('d/m/Y', strtotime($resa->date_arrivee)) ?> - 
                                        <?= date('d/m/Y', strtotime($resa->date_depart)) ?>
                                    </div>
                                    <a href="/reservation/<?= $resa->id ?>" class="btn btn-outline-benin btn-sm w-100 rounded-pill">
                                        Voir détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Réservations passées -->
        <div class="tab-pane fade" id="past" role="tabpanel">
            <?php if (empty($past)): ?>
                <p class="text-muted text-center py-4">Aucune réservation passée</p>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($past as $resa): ?>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($resa->hebergement_nom) ?></h6>
                                    <small class="text-muted d-block mb-2"><?= htmlspecialchars($resa->ville_nom) ?></small>
                                    <div class="small mb-2"><?= date('d/m/Y', strtotime($resa->date_arrivee)) ?></div>
                                    <a href="/reservation/<?= $resa->id ?>" class="btn btn-outline-secondary btn-sm w-100 rounded-pill">
                                        Voir
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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