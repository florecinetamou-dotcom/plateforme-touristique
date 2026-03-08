<?php 
$title = 'Nos Hébergements - BeninExplore';
$meta_description = 'Trouvez l\'hôtel ou la maison d\'hôte idéale pour votre séjour au Bénin.';
ob_start(); 
?>

<section class="page-header py-5" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1920&q=80') center/cover;">
    <div class="container text-center py-4">
        <h1 class="text-white fw-bold">Où séjourner ?</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="/" class="text-white-50">Accueil</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Hébergements</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Barre de filtres -->
<section class="py-4 bg-white border-bottom sticky-top shadow-sm" style="top: 0; z-index: 1020;">
    <div class="container">
        <form method="GET" action="/hebergements" class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" 
                           placeholder="Nom ou description..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="ville" class="form-select">
                    <option value="">Toutes les villes</option>
                    <?php foreach ($villes as $ville): ?>
                        <option value="<?= $ville->id ?>" <?= ($filters['ville'] ?? '') == $ville->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ville->nom) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">Tous les types</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $type->id ?>" <?= ($filters['type'] ?? '') == $type->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($type->nom) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-benin w-100">Filtrer</button>
            </div>
        </form>
    </div>
</section>

<!-- Liste des hébergements -->
<section class="py-5 bg-light">
    <div class="container">
        <?php if (empty($hebergements)): ?>
            <div class="text-center py-5">
                <i class="fas fa-hotel fa-4x text-muted mb-3"></i>
                <h4>Aucun hébergement trouvé</h4>
                <p class="text-muted">Essayez de modifier vos critères de recherche.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($hebergements as $heb): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="hotel-card h-100 shadow-sm border-0">
                            <div class="position-relative">
                                <?php 
                                $photoUrl = $heb->photo ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80';
                                ?>
                                <img src="<?= $photoUrl ?>" class="card-img-top" alt="<?= htmlspecialchars($heb->nom) ?>" 
                                     style="height: 220px; object-fit: cover;">
                                <?php if ($heb->note_moyenne > 0): ?>
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill">
                                        <i class="fas fa-star text-warning me-1"></i><?= number_format($heb->note_moyenne, 1) ?>
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($heb->nom) ?></h5>
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i><?= htmlspecialchars($heb->ville_nom) ?>
                                </p>
                                <p class="card-text small text-muted">
                                    <?= htmlspecialchars(substr($heb->description ?? '', 0, 80)) ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div>
                                        <span class="fs-5 fw-bold text-benin"><?= number_format($heb->prix_nuit_base, 0, ',', ' ') ?></span>
                                        <small class="text-muted">/nuit</small>
                                    </div>
                                    <a href="/hebergement/<?= $heb->id ?>" class="btn btn-outline-benin btn-sm px-3">Détails</a>
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
.hotel-card {
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}
.hotel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important;
}
.btn-benin {
    background-color: #008751;
    color: white;
}
.btn-benin:hover {
    background-color: #005c37;
    color: white;
}
.btn-outline-benin {
    border-color: #008751;
    color: #008751;
}
.btn-outline-benin:hover {
    background-color: #008751;
    color: white;
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>