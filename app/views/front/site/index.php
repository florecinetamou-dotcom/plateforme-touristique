<?php 
$title = 'Sites touristiques - BeninExplore';
$meta_description = 'Découvrez tous les sites touristiques du Bénin.';
ob_start(); 
?>

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

<!-- Liste des sites -->
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
                <?php foreach ($sites as $site): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm hover-card h-100">
                            <img src="<?= $site->photo_url ?? 'https://images.unsplash.com/photo-1590608897129-79da3d22b0c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80' ?>" 
                                 class="card-img-top" alt="<?= htmlspecialchars($site->nom) ?>"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($site->nom) ?></h5>
                                <p class="card-text text-muted small">
                                    <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                    <?= htmlspecialchars($site->ville_nom ?? 'Bénin') ?>
                                </p>
                                <p class="card-text small">
                                    <?= htmlspecialchars(substr($site->description ?? '', 0, 100)) ?>...
                                </p>
                                <a href="/site/<?= $site->id ?>" class="btn btn-outline-benin btn-sm">Voir détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>