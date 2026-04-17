<?php 
$title = 'Confirmation de réservation - BeninExplore';
ob_start(); 
?>

<section class="py-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <!-- Icône de succès -->
                <div class="mb-4">
                    <div class="success-checkmark">
                        <i class="fas fa-check-circle fa-5x text-success"></i>
                    </div>
                </div>

                <h1 class="fw-bold mb-3">Félicitations !</h1>
                <p class="text-muted fs-5 mb-5">
                    Votre réservation a été enregistrée avec succès.
                </p>

                <!-- Carte récapitulative -->
                <div class="card border-0 bg-light rounded-4 p-4 mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">Numéro de référence :</span>
                        <span class="fw-bold text-dark"><?= htmlspecialchars($reservation->reference) ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Statut :</span>
                        <?php
                        $badgeClass = match($reservation->statut) {
                            'confirmee' => 'bg-success',
                            'en_attente' => 'bg-warning text-dark',
                            'annulee' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $badgeClass ?> px-3 rounded-pill">
                            <?= $reservation->statut == 'en_attente' ? 'En attente de confirmation' : ucfirst($reservation->statut) ?>
                        </span>
                    </div>
                </div>

                <!-- Détails du séjour -->
                <div class="card border-0 shadow-sm mb-5 text-start">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Détails du séjour</h5>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">Hébergement</small>
                            <span class="fw-bold"><?= htmlspecialchars($reservation->hebergement_nom) ?></span>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Arrivée</small>
                                <span class="fw-bold"><?= date('d/m/Y', strtotime($reservation->date_arrivee)) ?></span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Départ</small>
                                <span class="fw-bold"><?= date('d/m/Y', strtotime($reservation->date_depart)) ?></span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted d-block">Ville</small>
                            <span class="fw-bold"><?= htmlspecialchars($reservation->ville_nom) ?></span>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Montant total</small>
                            <span class="fw-bold text-benin"><?= number_format($reservation->montant_total, 0, ',', ' ') ?> FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="/" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                        <i class="fas fa-home me-2"></i>Retour à l'accueil
                    </a>
                    <a href="/reservations" class="btn btn-benin px-4 py-2 rounded-pill">
                        <i class="fas fa-list me-2"></i>Voir mes réservations
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-benin px-4 py-2 rounded-pill">
                        <i class="fas fa-print me-2"></i>Imprimer
                    </button>
                </div>

                <!-- Aide -->
                <div class="mt-5 p-4 border rounded-4">
                    <h5 class="fw-bold mb-3">Besoin d'aide ?</h5>
                    <p class="small text-muted mb-0">
                        Contactez notre support au <span class="text-benin fw-bold">+229 01 23 45 67</span> <br>
                        ou par email à <span class="text-benin fw-bold">support@beninexplore.bj</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.text-benin { color: #008751; }
.btn-benin { background-color: #008751; color: white; border: none; }
.btn-benin:hover { background-color: #005c37; color: white; }
.btn-outline-benin { border: 2px solid #008751; color: #008751; background: transparent; }
.btn-outline-benin:hover { background-color: #008751; color: white; }
.success-checkmark {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    color: #008751;
}
@media print {
    .btn-outline-benin, .btn-benin, .btn-outline-secondary, footer, .navbar { display: none; }
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>