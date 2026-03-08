<?php 
$title = 'Mes favoris - Tourisme Bénin';
$meta_description = 'Retrouvez tous vos hébergements favoris et planifiez vos prochains voyages.';
?>

<?php ob_start(); ?>

<!-- Hero Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center" data-aos="fade-up">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Mes favoris</h1>
                <p class="lead text-muted mb-0">
                    Retrouvez tous vos hébergements coup de cœur et planifiez vos prochains séjours.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Liste des favoris -->
<section class="py-5">
    <div class="container">
        <?php if (empty($favoris)): ?>
            <div class="text-center py-5" data-aos="fade-up">
                <div class="mb-4">
                    <i class="fas fa-heart fa-5x text-muted"></i>
                </div>
                <h3 class="fw-bold mb-3">Aucun favori pour le moment</h3>
                <p class="text-muted mb-4">
                    Explorez nos hébergements et ajoutez vos coups de cœur aux favoris.
                </p>
                <a href="/hebergements" class="btn btn-benin btn-lg px-5">
                    <i class="fas fa-search me-2"></i>Découvrir des hébergements
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($favoris as $favori): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="position-relative">
                                <img src="<?= $favori->hebergement->photo_principale ?? '/assets/images/default-hebergement.jpg' ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($favori->hebergement->nom) ?>"
                                     style="height: 200px; object-fit: cover;">
                                <span class="position-absolute top-0 end-0 m-3 badge bg-dark">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <?= number_format($favori->hebergement->note_moyenne ?? 0, 1) ?>
                                </span>
                                <button class="btn position-absolute top-0 start-0 m-3 remove-favorite" 
                                        data-id="<?= $favori->hebergement->id ?>"
                                        style="background: rgba(255,255,255,0.9);">
                                    <i class="fas fa-heart text-danger"></i>
                                </button>
                                <span class="position-absolute bottom-0 start-0 m-3 badge bg-benin">
                                    <i class="fas fa-tag me-1"></i>
                                    <?= number_format($favori->hebergement->prix_nuit_base ?? 0, 0, ',', ' ') ?> FCFA/nuit
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold mb-0">
                                        <?= htmlspecialchars($favori->hebergement->nom) ?>
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt text-benin"></i>
                                        <?= htmlspecialchars($favori->hebergement->ville_nom ?? '') ?>
                                    </small>
                                </div>
                                <p class="card-text text-muted small">
                                    <?= htmlspecialchars(substr($favori->hebergement->description ?? '', 0, 80)) ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <span class="text-muted small">Ajouté le</span>
                                        <br>
                                        <small><?= date('d/m/Y', strtotime($favori->date_ajout)) ?></small>
                                    </div>
                                    <a href="/hebergement/<?= $favori->hebergement->id ?>" class="btn btn-benin">
                                        Voir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Note privée -->
            <?php if (!empty($favori->note_privee)): ?>
                <div class="mt-4 p-3 bg-light rounded-3">
                    <small class="text-muted d-block mb-1">
                        <i class="fas fa-lock me-1"></i>Note privée :
                    </small>
                    <p class="mb-0"><?= nl2br(htmlspecialchars($favori->note_privee)) ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Suggestions -->
<?php if (!empty($favoris)): ?>
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold mb-4">Suggestions pour vous</h2>
            <div class="row g-4">
                <?php
                // Suggestions basées sur les favoris
                $suggestions = (new App\Models\Hebergement())->query(
                    "SELECT h.*, v.nom as ville_nom,
                            (SELECT url FROM photo_hebergement WHERE hebergement_id = h.id AND est_principale = 1 LIMIT 1) as photo_principale
                     FROM hebergement h
                     JOIN ville v ON h.ville_id = v.id
                     WHERE h.statut = 'approuve'
                     AND h.id NOT IN (SELECT hebergement_id FROM favori WHERE voyageur_id = ?)
                     ORDER BY h.note_moyenne DESC
                     LIMIT 3",
                    [$_SESSION['user_id']]
                );
                ?>
                <?php foreach ($suggestions as $suggestion): ?>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="<?= $suggestion->photo_principale ?? '/assets/images/default-hebergement.jpg' ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($suggestion->nom) ?>"
                                 style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title fw-bold"><?= htmlspecialchars($suggestion->nom) ?></h6>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                    <?= htmlspecialchars($suggestion->ville_nom) ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-benin">
                                        <?= number_format($suggestion->prix_nuit_base, 0, ',', ' ') ?> FCFA
                                    </span>
                                    <a href="/hebergement/<?= $suggestion->id ?>" class="btn btn-sm btn-outline-benin">
                                        Découvrir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Supprimer des favoris
    document.querySelectorAll('.remove-favorite').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const hebergementId = this.dataset.id;
            const card = this.closest('.col-md-6');
            
            if (confirm('Retirer cet hébergement de vos favoris ?')) {
                fetch('/favoris/remove/' + hebergementId, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        card.remove();
                        // Recharger si plus de favoris
                        if (document.querySelectorAll('.remove-favorite').length === 0) {
                            location.reload();
                        }
                    }
                });
            }
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