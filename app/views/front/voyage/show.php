<?php 
$title = $voyage->titre . ' - Tourisme Bénin';
$meta_description = 'Détails de votre voyage au Bénin.';
?>

<?php ob_start(); ?>

<!-- Hero Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="/voyages" class="text-decoration-none">Mes voyages</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($voyage->titre) ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                
                <!-- En-tête -->
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="display-5 fw-bold mb-2"><?= htmlspecialchars($voyage->titre) ?></h1>
                        <p class="text-muted">
                            Créé le <?= date('d/m/Y', strtotime($voyage->date_creation)) ?>
                        </p>
                    </div>
                    <span class="badge bg-<?= strtotime($voyage->date_fin) < time() ? 'secondary' : 'success' ?> px-4 py-3">
                        <?= strtotime($voyage->date_fin) < time() ? 'Terminé' : 'À venir' ?>
                    </span>
                </div>
                
                <!-- Carte récapitulative -->
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-benin-light rounded-circle p-3 me-3">
                                        <i class="fas fa-calendar-alt text-benin"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Dates du voyage</small>
                                        <span class="fw-bold">
                                            <?= date('d/m/Y', strtotime($voyage->date_debut)) ?> - 
                                            <?= date('d/m/Y', strtotime($voyage->date_fin)) ?>
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            <?php
                                                $debut = new DateTime($voyage->date_debut);
                                                $fin = new DateTime($voyage->date_fin);
                                                $duree = $debut->diff($fin)->days;
                                                echo $duree . ' jour' . ($duree > 1 ? 's' : '');
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-benin-light rounded-circle p-3 me-3">
                                        <i class="fas fa-users text-benin"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Voyageurs</small>
                                        <span class="fw-bold">
                                            <?= $voyage->nb_voyageurs ?? 1 ?> personne(s)
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($voyage->budget_estime): ?>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-benin-light rounded-circle p-3 me-3">
                                            <i class="fas fa-coins text-benin"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Budget estimé</small>
                                            <span class="fw-bold text-benin">
                                                <?= number_format($voyage->budget_estime, 0, ',', ' ') ?> FCFA
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-benin-light rounded-circle p-3 me-3">
                                        <i class="fas fa-clock text-benin"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Délai avant le départ</small>
                                        <?php if (strtotime($voyage->date_debut) > time()): ?>
                                            <?php
                                                $today = new DateTime();
                                                $depart = new DateTime($voyage->date_debut);
                                                $diff = $today->diff($depart);
                                            ?>
                                            <span class="fw-bold">
                                                <?= $diff->days > 0 ? $diff->days . ' jours' : 'Aujourd\'hui' ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="fw-bold">Voyage terminé</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Notes et préférences -->
                <?php if (!empty($voyage->notes)): ?>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">
                                <i class="fas fa-pencil-alt text-benin me-2"></i>
                                Notes et préférences
                            </h4>
                            <p class="text-muted mb-0">
                                <?= nl2br(htmlspecialchars($voyage->notes)) ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Suggestions d'hébergements -->
                <?php if (strtotime($voyage->date_debut) > time()): ?>
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">
                                <i class="fas fa-hotel text-benin me-2"></i>
                                Hébergements recommandés
                            </h4>
                            
                            <?php
                            // Suggestions basées sur les préférences
                            $hebergements = (new App\Models\Hebergement())->search([
                                'ville_id' => $_SESSION['old']['villes'][0] ?? null,
                                'type_id' => $_SESSION['old']['types'][0] ?? null,
                                'statut' => 'approuve'
                            ]);
                            $hebergements = array_slice($hebergements, 0, 3);
                            ?>
                            
                            <?php if (empty($hebergements)): ?>
                                <p class="text-muted text-center py-4">
                                    Aucune recommandation pour le moment.<br>
                                    <a href="/hebergements" class="text-benin">Parcourir tous les hébergements</a>
                                </p>
                            <?php else: ?>
                                <div class="row g-4">
                                    <?php foreach ($hebergements as $heb): ?>
                                        <div class="col-md-4">
                                            <div class="card h-100 border-0">
                                                <img src="<?= $heb->photo_principale ?? '/assets/images/default-hebergement.jpg' ?>" 
                                                     class="card-img-top" 
                                                     alt="<?= htmlspecialchars($heb->nom) ?>"
                                                     style="height: 150px; object-fit: cover;">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title fw-bold mb-1"><?= htmlspecialchars($heb->nom) ?></h6>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                                        <?= htmlspecialchars($heb->ville_nom ?? '') ?>
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold text-benin">
                                                            <?= number_format($heb->prix_nuit_base, 0, ',', ' ') ?> FCFA
                                                        </span>
                                                        <a href="/hebergement/<?= $heb->id ?>" class="btn btn-sm btn-outline-benin">
                                                            Voir
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="text-center mt-4">
                                    <a href="/hebergements" class="btn btn-outline-benin">
                                        Voir plus d'options
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Actions -->
                <div class="d-flex gap-3 mt-4">
                    <a href="/voyages" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                    <?php if (strtotime($voyage->date_debut) > time()): ?>
                        <a href="/voyage/<?= $voyage->id ?>/edit" class="btn btn-outline-benin">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <button class="btn btn-outline-danger ms-auto delete-voyage" 
                                data-id="<?= $voyage->id ?>"
                                data-titre="<?= htmlspecialchars($voyage->titre) ?>">
                            <i class="fas fa-trash-alt me-2"></i>Supprimer
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer le voyage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>
                    Êtes-vous sûr de vouloir supprimer le voyage 
                    <span class="fw-bold"><?= htmlspecialchars($voyage->titre) ?></span> ?
                </p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cette action est irréversible.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="/voyage/<?= $voyage->id ?>/delete">
                    <?php if (isset($_SESSION['csrf_token'])): ?>
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-voyage').forEach(btn => {
        btn.addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});
</script>

<?php 
$content = ob_get_clean();
require dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
require dirname(__DIR__, 2) . '/layout/footer.php';
?>