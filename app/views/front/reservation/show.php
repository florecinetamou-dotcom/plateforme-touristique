<?php $title = 'Réservation #' . $reservation->reference; ?>
<?php ob_start(); ?>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Réservation #<?= $reservation->reference ?></h1>
                    <p class="text-muted small mb-0">
                        Réservée le <?= date('d/m/Y à H:i', strtotime($reservation->date_reservation)) ?>
                    </p>
                </div>
                <span class="badge bg-<?= $reservation->statut == 'confirmee' ? 'success' : ($reservation->statut == 'annulee' ? 'danger' : 'secondary') ?> fs-6 p-2">
                    <?= $reservation->statut ?>
                </span>
            </div>
            
            <!-- Carte hébergement -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Hébergement</h5>
                    <div class="d-flex">
                        <div>
                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($reservation->hebergement_nom) ?></h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                <?= htmlspecialchars($reservation->ville_nom) ?>
                            </p>
                            <p class="text-muted small mb-0"><?= htmlspecialchars($reservation->adresse) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Détails du séjour -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Détails du séjour</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Arrivée</small>
                            <span class="fw-bold"><?= date('d/m/Y', strtotime($reservation->date_arrivee)) ?></span>
                            <small class="text-muted d-block mt-1">À partir de 15h00</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Départ</small>
                            <span class="fw-bold"><?= date('d/m/Y', strtotime($reservation->date_depart)) ?></span>
                            <small class="text-muted d-block mt-1">Avant 11h00</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Voyageurs</small>
                            <span class="fw-bold"><?= $reservation->nombre_voyageurs ?> personne(s)</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Durée</small>
                            <?php
                                $arrivee = new DateTime($reservation->date_arrivee);
                                $depart = new DateTime($reservation->date_depart);
                                $nuits = $arrivee->diff($depart)->days;
                            ?>
                            <span class="fw-bold"><?= $nuits ?> nuit<?= $nuits > 1 ? 's' : '' ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Paiement -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Paiement</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Montant total</span>
                        <span class="h4 fw-bold text-benin mb-0">
                            <?= number_format($reservation->montant_total, 0, ',', ' ') ?> FCFA
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Notes -->
            <?php if (!empty($reservation->notes)): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Notes</h5>
                        <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($reservation->notes)) ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Actions -->
            <div class="d-flex gap-2">
                <a href="/reservations" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                
                <?php if ($reservation->statut == 'confirmee'): ?>
                    <?php
                    $now = new DateTime();
                    $arrivee = new DateTime($reservation->date_arrivee);
                    $diff = $now->diff($arrivee);
                    $annulable = $diff->days >= 1 && $diff->invert == 0;
                    ?>
                    
                    <?php if ($annulable): ?>
                        <form method="POST" action="/reservation/<?= $reservation->id ?>/annuler" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                <i class="fas fa-times-circle me-2"></i>Annuler
                            </button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>