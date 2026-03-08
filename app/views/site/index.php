<?php $title = 'Sites touristiques - BeninExplore'; ?>
<?php $meta_description = 'Découvrez tous les sites touristiques du Bénin : Route des Esclaves, Palais d\'Abomey, Parc Pendjari...'; ?>
<?php ob_start(); ?>

<!-- Bannière -->
<div class="bg-light py-3">
    <div class="container">
        <h1 class="h4 fw-bold mb-0">Sites touristiques du Bénin</h1>
        <p class="text-muted small mb-0"><?= count($sites) ?> sites à découvrir</p>
    </div>
</div>

<!-- Filtres -->
<section class="py-3 border-bottom">
    <div class="container">
        <form method="GET" action="/sites" class="row g-2">
            <div class="col-md-4">
                <select name="categorie" class="form-select form-select-sm">
                    <option value="">Toutes catégories</option>
                    <?php foreach ($categories as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($filters['categorie'] ?? '') == $key ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <select name="ville" class="form-select form-select-sm">
                    <option value="">Toutes les villes</option>
                    <?php foreach ($villes as $ville): ?>
                        <option value="<?= $ville->id ?>" <?= ($filters['ville'] ?? '') == $ville->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ville->nom) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" 
                       placeholder="Rechercher un site..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            
            <div class="col-md-1">
                <button type="submit" class="btn btn-benin btn-sm w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Liste des sites - ALIGNEMENT CORRIGÉ -->
<section class="py-4">
    <div class="container">
        <?php if (empty($sites)): ?>
            <div class="text-center py-5">
                <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                <h5>Aucun site trouvé</h5>
                <p class="text-muted small">Essayez de modifier vos filtres</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($sites as $index => $site): ?>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="card border-0 shadow-sm hover-card w-100">
                            <div class="position-relative">
                                <?php 
                                // Images par défaut selon la catégorie
                                $defaultImages = [
                                    'historique' => 'https://images.unsplash.com/photo-1590608897129-79da3d22b0c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
                                    'nature' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=1472&q=80',
                                    'culturel' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=1472&q=80',
                                    'religieux' => 'https://images.unsplash.com/photo-1590608897129-79da3d22b0c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
                                    'autre' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=1472&q=80'
                                ];
                                $imageUrl = $site->photo_url ?? $defaultImages[$site->categorie] ?? $defaultImages['autre'];
                                ?>
                                <img src="<?= $imageUrl ?>" 
                                     class="card-img-top" alt="<?= htmlspecialchars($site->nom) ?>"
                                     style="height: 200px; object-fit: cover;">
                                <span class="position-absolute top-0 end-0 m-2 badge bg-<?= 
                                    $site->categorie == 'historique' ? 'warning' : 
                                    ($site->categorie == 'nature' ? 'success' : 
                                    ($site->categorie == 'culturel' ? 'info' : 
                                    ($site->categorie == 'religieux' ? 'purple' : 'secondary'))) ?>">
                                    <?= ucfirst($site->categorie) ?>
                                </span>
                                <?php if ($site->prix_entree == 0): ?>
                                    <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                        Gratuit
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="fw-bold mb-1"><?= htmlspecialchars($site->nom) ?></h6>
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                    <?= htmlspecialchars($site->ville_nom) ?>
                                </p>
                                <p class="small text-muted mb-3">
                                    <?= substr(htmlspecialchars($site->description ?? ''), 0, 80) ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="small fw-bold text-benin">
                                        <?= $site->prix_entree > 0 ? number_format($site->prix_entree, 0, ',', ' ') . ' FCFA' : 'Gratuit' ?>
                                    </span>
                                    <a href="/site/<?= $site->id ?>" class="btn btn-outline-benin btn-sm rounded-pill">
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
</section>

<style>
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,135,81,0.1) !important;
}
</style>

<?php 
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>