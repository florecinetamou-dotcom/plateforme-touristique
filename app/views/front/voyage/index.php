<?php 
$title = 'Mes voyages - Tourisme Bénin';
$meta_description = 'Planifiez et organisez vos voyages au Bénin.';
?>

<?php ob_start(); ?>

<!-- Hero Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center" data-aos="fade-up">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Mes voyages</h1>
                <p class="lead text-muted mb-4">
                    Planifiez vos prochains séjours et gardez une trace de vos aventures.
                </p>
                <a href="/voyage/create" class="btn btn-benin btn-lg px-5">
                    <i class="fas fa-plus-circle me-2"></i>Planifier un nouveau voyage
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Voyages à venir -->
        <h2 class="fw-bold mb-4">
            <i class="fas fa-suitcase-rolling text-benin me-2"></i>
            Voyages à venir
        </h2>
        
        <?php if (empty($voyages_a_venir)): ?>
            <div class="text-center py-5 bg-light rounded-4 mb-5">
                <div class="mb-3">
                    <i class="fas fa-map-marked-alt fa-4x text-muted"></i>
                </div>
                <h4 class="fw-bold mb-2">Aucun voyage planifié</h4>
                <p class="text-muted mb-0">
                    Commencez à planifier votre prochaine aventure au Bénin !
                </p>
            </div>
        <?php else: ?>
            <div class="row g-4 mb-5">
                <?php foreach ($voyages_a_venir as $voyage): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="fw-bold mb-0">
                                        <?= htmlspecialchars($voyage->titre) ?>
                                    </h5>
                                    <span class="badge bg-success">À venir</span>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-alt text-benin me-2"></i>
                                        <span>
                                            <?= date('d/m/Y', strtotime($voyage->date_debut)) ?> - 
                                            <?= date('d/m/Y', strtotime($voyage->date_fin)) ?>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock text-benin me-2"></i>
                                        <span>
                                            <?php
                                                $debut = new DateTime($voyage->date_debut);
                                                $fin = new DateTime($voyage->date_fin);
                                                $duree = $debut->diff($fin)->days;
                                                echo $duree . ' jour' . ($duree > 1 ? 's' : '');
                                            ?>
                                        </span>
                                    </div>
                                    <?php if ($voyage->budget_estime): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-coins text-benin me-2"></i>
                                            <span>
                                                Budget: <?= number_format($voyage->budget_estime, 0, ',', ' ') ?> FCFA
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="/voyage/<?= $voyage->id ?>" class="btn btn-outline-benin flex-grow-1">
                                        Voir détails
                                    </a>
                                    <button class="btn btn-outline-danger delete-voyage" 
                                            data-id="<?= $voyage->id ?>"
                                            data-titre="<?= htmlspecialchars($voyage->titre) ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Voyages passés -->
        <h2 class="fw-bold mb-4">
            <i class="fas fa-history text-benin me-2"></i>
            Voyages passés
        </h2>
        
        <?php if (empty($voyages_passes)): ?>
            <div class="text-center py-5 bg-light rounded-4">
                <div class="mb-3">
                    <i class="fas fa-suitcase fa-4x text-muted"></i>
                </div>
                <h4 class="fw-bold mb-2">Aucun voyage passé</h4>
                <p class="text-muted mb-0">
                    Vos prochains voyages apparaîtront ici une fois terminés.
                </p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Titre</th>
                            <th>Dates</th>
                            <th>Durée</th>
                            <th>Budget</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($voyages_passes as $voyage): ?>
                            <tr>
                                <td>
                                    <span class="fw-bold"><?= htmlspecialchars($voyage->titre) ?></span>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($voyage->date_debut)) ?> - 
                                    <?= date('d/m/Y', strtotime($voyage->date_fin)) ?>
                                </td>
                                <td>
                                    <?php
                                        $debut = new DateTime($voyage->date_debut);
                                        $fin = new DateTime($voyage->date_fin);
                                        echo $debut->diff($fin)->days . ' jours';
                                    ?>
                                </td>
                                <td>
                                    <?= $voyage->budget_estime ? number_format($voyage->budget_estime, 0, ',', ' ') . ' FCFA' : '-' ?>
                                </td>
                                <td>
                                    <a href="/voyage/<?= $voyage->id ?>" class="btn btn-sm btn-outline-secondary">
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
                    <span class="fw-bold" id="deleteVoyageTitre"></span> ?
                </p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cette action est irréversible.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteVoyageForm" method="POST">
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
    // Suppression d'un voyage
    document.querySelectorAll('.delete-voyage').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const titre = this.dataset.titre;
            
            document.getElementById('deleteVoyageTitre').textContent = titre;
            document.getElementById('deleteVoyageForm').action = '/voyage/' + id + '/delete';
            
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