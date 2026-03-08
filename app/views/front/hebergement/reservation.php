<?php 
$title = 'Réservation - ' . $hebergement->nom;
ob_start(); 
?>

<section class="py-4 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/hebergements" class="text-decoration-none">Hébergements</a></li>
                <li class="breadcrumb-item"><a href="/hebergement/<?= $hebergement->id ?>" class="text-decoration-none"><?= htmlspecialchars($hebergement->nom) ?></a></li>
                <li class="breadcrumb-item active">Réservation</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4">Confirmer votre réservation</h2>
                        
                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <form method="POST" action="/reservation/create" id="reservationForm">
                            <input type="hidden" name="hebergement_id" value="<?= $hebergement->id ?>">
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Date d'arrivée</label>
                                    <input type="text" class="form-control datepicker" id="date_arrivee" name="date_arrivee" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Date de départ</label>
                                    <input type="text" class="form-control datepicker" id="date_depart" name="date_depart" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nombre de voyageurs</label>
                                    <select class="form-select" name="nb_voyageurs" id="nb_voyageurs">
                                        <?php for($i=1; $i<=$hebergement->capacite; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?> personne<?= $i>1 ? 's' : '' ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Téléphone</label>
                                    <input type="tel" class="form-control" name="telephone" 
                                           value="<?= htmlspecialchars($_SESSION['user_telephone'] ?? '') ?>" required>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Notes ou demandes particulières</label>
                                    <textarea class="form-control" name="notes" rows="3" 
                                              placeholder="Heure d'arrivée estimée, besoins spécifiques..."></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="conditions" id="conditions" required>
                                        <label class="form-check-label small" for="conditions">
                                            J'accepte les <a href="#" class="text-benin">conditions générales de réservation</a> et la politique d'annulation.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="d-flex justify-content-end gap-3">
                                <a href="/hebergement/<?= $hebergement->id ?>" class="btn btn-outline-secondary px-4">Annuler</a>
                                <button type="submit" class="btn btn-benin px-5" id="btnReserver">
                                    <i class="fas fa-check-circle me-2"></i>Confirmer la réservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Résumé de la réservation -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Récapitulatif</h5>
                        
                        <div class="d-flex gap-3 mb-4">
                            <?php if ($hebergement->photo_principale): ?>
                                <img src="<?= htmlspecialchars($hebergement->photo_principale) ?>" 
                                     class="rounded-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-hotel fa-2x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h6 class="fw-bold mb-1"><?= htmlspecialchars($hebergement->nom) ?></h6>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                    <?= htmlspecialchars($hebergement->ville_nom) ?>
                                </small>
                            </div>
                        </div>
                        
                        <div class="bg-light p-3 rounded-3 mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Prix par nuit</span>
                                <span class="fw-bold"><?= number_format($hebergement->prix_nuit_base, 0, ',', ' ') ?> FCFA</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" id="nuitsContainer" style="display: none;">
                                <span class="text-muted small"><span id="nbNuits">0</span> nuits</span>
                                <span class="fw-bold" id="prixNuits">0 FCFA</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span class="text-benin" id="prixTotal"><?= number_format($hebergement->prix_nuit_base, 0, ',', ' ') ?> FCFA</span>
                            </div>
                        </div>
                        
                        <div class="small text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Vous ne serez pas débité maintenant. Le paiement s'effectuera sur place.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Date Range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const prixBase = <?= $hebergement->prix_nuit_base ?>;
    const arriveeInput = document.getElementById('date_arrivee');
    const departInput = document.getElementById('date_depart');
    
    // Initialiser les datepickers
    const arriveePicker = flatpickr(arriveeInput, {
        locale: "fr",
        minDate: "today",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            departPicker.set('minDate', dateStr);
            calculerPrix();
        }
    });
    
    const departPicker = flatpickr(departInput, {
        locale: "fr",
        minDate: "today",
        dateFormat: "Y-m-d",
        onChange: function() {
            calculerPrix();
        }
    });
    
    function calculerPrix() {
        const arrivee = arriveePicker.selectedDates[0];
        const depart = departPicker.selectedDates[0];
        const nuitsContainer = document.getElementById('nuitsContainer');
        const nbNuitsSpan = document.getElementById('nbNuits');
        const prixNuitsSpan = document.getElementById('prixNuits');
        const prixTotalSpan = document.getElementById('prixTotal');
        
        if (arrivee && depart && depart > arrivee) {
            const diffTime = Math.abs(depart - arrivee);
            const nbNuits = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const prixNuits = nbNuits * prixBase;
            
            nuitsContainer.style.display = 'flex';
            nbNuitsSpan.textContent = nbNuits;
            prixNuitsSpan.textContent = prixNuits.toLocaleString('fr-FR') + ' FCFA';
            prixTotalSpan.textContent = prixNuits.toLocaleString('fr-FR') + ' FCFA';
        } else {
            nuitsContainer.style.display = 'none';
            prixTotalSpan.textContent = prixBase.toLocaleString('fr-FR') + ' FCFA';
        }
    }
});
</script>

<style>
.btn-benin {
    background-color: #008751;
    color: white;
    border: none;
}
.btn-benin:hover {
    background-color: #005c37;
    color: white;
}
.text-benin {
    color: #008751 !important;
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>