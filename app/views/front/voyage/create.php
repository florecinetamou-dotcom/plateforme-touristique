<?php 
$title = 'Planifier un voyage - Tourisme Bénin';
$meta_description = 'Créez votre itinéraire de voyage personnalisé au Bénin.';
?>

<?php ob_start(); ?>

<!-- Hero Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center" data-aos="fade-up">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Planifier un voyage</h1>
                <p class="lead text-muted">
                    Créez votre itinéraire personnalisé et organisez votre séjour au Bénin.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" data-aos="fade-up">
                    <div class="card-body p-5">
                        
                        <!-- Progression -->
                        <div class="mb-5">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Création du voyage</span>
                                <span class="text-muted">Étape 1/3</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-benin" style="width: 33%"></div>
                            </div>
                        </div>
                        
                        <!-- Formulaire -->
                        <form method="POST" action="/voyage/create" id="voyageForm">
                            <?php if (isset($_SESSION['csrf_token'])): ?>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <?php endif; ?>
                            
                            <h4 class="fw-bold mb-4">Informations générales</h4>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-12">
                                    <label for="titre" class="form-label fw-semibold">
                                        Titre du voyage <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg <?= isset($errors['titre']) ? 'is-invalid' : '' ?>" 
                                           id="titre" 
                                           name="titre" 
                                           value="<?= htmlspecialchars($_SESSION['old']['titre'] ?? '') ?>"
                                           placeholder="Ex: Découverte du Sud-Bénin, Safari dans la Pendjari..."
                                           required>
                                    <?php if (isset($errors['titre'])): ?>
                                        <div class="invalid-feedback"><?= $errors['titre'] ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="date_debut" class="form-label fw-semibold">
                                        Date de début <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg datepicker <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>" 
                                           id="date_debut" 
                                           name="date_debut" 
                                           value="<?= htmlspecialchars($_SESSION['old']['date_debut'] ?? '') ?>"
                                           required>
                                    <?php if (isset($errors['date_debut'])): ?>
                                        <div class="invalid-feedback"><?= $errors['date_debut'] ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="date_fin" class="form-label fw-semibold">
                                        Date de fin <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg datepicker <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>" 
                                           id="date_fin" 
                                           name="date_fin" 
                                           value="<?= htmlspecialchars($_SESSION['old']['date_fin'] ?? '') ?>"
                                           required>
                                    <?php if (isset($errors['date_fin'])): ?>
                                        <div class="invalid-feedback"><?= $errors['date_fin'] ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="budget_estime" class="form-label fw-semibold">
                                        Budget estimé (FCFA)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">FCFA</span>
                                        <input type="number" 
                                               class="form-control form-control-lg" 
                                               id="budget_estime" 
                                               name="budget_estime" 
                                               value="<?= htmlspecialchars($_SESSION['old']['budget_estime'] ?? '') ?>"
                                               placeholder="Ex: 500000"
                                               min="0"
                                               step="10000">
                                    </div>
                                    <small class="text-muted">Optionnel</small>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="voyageurs" class="form-label fw-semibold">
                                        Nombre de voyageurs
                                    </label>
                                    <select class="form-select form-control-lg" id="voyageurs" name="voyageurs">
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>" <?= ($_SESSION['old']['voyageurs'] ?? 1) == $i ? 'selected' : '' ?>>
                                                <?= $i ?> personne<?= $i > 1 ? 's' : '' ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <label for="notes" class="form-label fw-semibold">
                                        Notes et préférences
                                    </label>
                                    <textarea class="form-control" 
                                              id="notes" 
                                              name="notes" 
                                              rows="4"
                                              placeholder="Décrivez vos envies : types d'hébergement, sites à visiter, activités souhaitées..."><?= htmlspecialchars($_SESSION['old']['notes'] ?? '') ?></textarea>
                                    <small class="text-muted">Ces notes vous aideront à organiser votre voyage</small>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <!-- Destinations -->
                            <h4 class="fw-bold mb-4">Destinations souhaitées</h4>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Villes à visiter</label>
                                <div class="row g-3">
                                    <?php
                                    $villes = (new App\Models\Ville())->getActive();
                                    $selected_villes = $_SESSION['old']['villes'] ?? [];
                                    ?>
                                    <?php foreach ($villes as $ville): ?>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="villes[]" 
                                                       value="<?= $ville->id ?>"
                                                       id="ville_<?= $ville->id ?>"
                                                       <?= in_array($ville->id, (array)$selected_villes) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="ville_<?= $ville->id ?>">
                                                    <?= htmlspecialchars($ville->nom) ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Types d'hébergement -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Types d'hébergement préférés</label>
                                <div class="row g-3">
                                    <?php
                                    $types = (new App\Models\TypeHebergement())->all();
                                    $selected_types = $_SESSION['old']['types'] ?? [];
                                    ?>
                                    <?php foreach ($types as $type): ?>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="types[]" 
                                                       value="<?= $type->id ?>"
                                                       id="type_<?= $type->id ?>"
                                                       <?= in_array($type->id, (array)$selected_types) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="type_<?= $type->id ?>">
                                                    <?= htmlspecialchars($type->nom) ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Activités -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Activités souhaitées</label>
                                <div class="row g-3">
                                    <?php
                                    $activites = [
                                        'historique' => 'Visites historiques',
                                        'nature' => 'Safari / Nature',
                                        'plage' => 'Plage / Détente',
                                        'culturel' => 'Découverte culturelle',
                                        'gastronomie' => 'Gastronomie',
                                        'sport' => 'Sports / Aventures'
                                    ];
                                    $selected_activites = $_SESSION['old']['activites'] ?? [];
                                    ?>
                                    <?php foreach ($activites as $key => $label): ?>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="activites[]" 
                                                       value="<?= $key ?>"
                                                       id="activite_<?= $key ?>"
                                                       <?= in_array($key, (array)$selected_activites) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="activite_<?= $key ?>">
                                                    <?= $label ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-3 mt-5">
                                <a href="/voyages" class="btn btn-outline-secondary btn-lg px-5">
                                    Annuler
                                </a>
                                <button type="submit" class="btn btn-benin btn-lg px-5 flex-grow-1">
                                    <i class="fas fa-save me-2"></i>Créer le voyage
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Conseils -->
                <div class="mt-5" data-aos="fade-up">
                    <div class="bg-light p-4 rounded-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-lightbulb text-benin me-2"></i>
                            Conseils pour planifier votre voyage
                        </h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-benin me-2"></i>
                                Prévoyez au moins 3-4 jours pour découvrir une région
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-benin me-2"></i>
                                La saison sèche (novembre-mars) est idéale pour visiter le nord
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-benin me-2"></i>
                                Réservez vos hébergements à l'avance en haute saison
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-benin me-2"></i>
                                Pensez aux transferts entre les villes dans votre budget
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date pickers
    flatpickr("#date_debut", {
        locale: "fr",
        minDate: "today",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            flatpickr("#date_fin", {
                minDate: dateStr
            });
        }
    });
    
    flatpickr("#date_fin", {
        locale: "fr",
        minDate: "today",
        dateFormat: "Y-m-d"
    });
    
    // Calcul automatique de la durée
    document.getElementById('date_debut').addEventListener('change', function() {
        const dateFin = document.getElementById('date_fin');
        if (dateFin.value) {
            const debut = new Date(this.value);
            const fin = new Date(dateFin.value);
            const diffTime = Math.abs(fin - debut);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays >= 0) {
                // Afficher la durée
            }
        }
    });
});
</script>

<?php 
$content = ob_get_clean();
$extra_css = ['https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'];
$extra_js = ['https://cdn.jsdelivr.net/npm/flatpickr', 'https://npmcdn.com/flatpickr/dist/l10n/fr.js'];
unset($_SESSION['old']);
require dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
require dirname(__DIR__, 2) . '/layout/footer.php';
?>