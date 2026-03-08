<?php 
$title = $site->nom . ' - BeninExplore';
ob_start(); 
?>

<!-- Fil d'ariane -->
<div class="bg-light py-2">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/sites" class="text-decoration-none">Sites</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($site->nom) ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Détail du site -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <!-- Image principale -->
            <div class="col-lg-8 mb-4">
                <?php 
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
                     class="img-fluid rounded-3 shadow-sm w-100" alt="<?= htmlspecialchars($site->nom) ?>"
                     style="max-height: 400px; object-fit: cover;">
            </div>
            
            <!-- Infos -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-2"><?= htmlspecialchars($site->nom) ?></h2>
                        
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-<?= 
                                $site->categorie == 'historique' ? 'warning' : 
                                ($site->categorie == 'nature' ? 'success' : 
                                ($site->categorie == 'culturel' ? 'info' : 
                                ($site->categorie == 'religieux' ? 'purple' : 'secondary'))) ?> me-2">
                                <?= ucfirst($site->categorie) ?>
                            </span>
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                <?= htmlspecialchars($site->ville_nom) ?>
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-tag text-benin me-2" style="width: 20px;"></i>
                                <span class="small">
                                    <span class="fw-bold">Prix:</span> 
                                    <?= $site->prix_entree > 0 ? number_format($site->prix_entree, 0, ',', ' ') . ' FCFA' : 'Gratuit' ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($site->heure_ouverture)): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-benin me-2" style="width: 20px;"></i>
                                    <span class="small">
                                        <span class="fw-bold">Horaires:</span> 
                                        <?= substr($site->heure_ouverture, 0, 5) ?> - <?= substr($site->heure_fermeture, 0, 5) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($site->adresse)): ?>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-pin text-benin me-2" style="width: 20px;"></i>
                                    <span class="small">
                                        <span class="fw-bold">Adresse:</span> 
                                        <?= htmlspecialchars($site->adresse) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <hr>
                        
                        <h6 class="fw-bold mb-2">Description</h6>
                        <p class="small text-muted"><?= nl2br(htmlspecialchars($site->description)) ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hébergements à proximité -->
        <?php if (!empty($hebergements)): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="fw-bold mb-3">Hébergements à proximité</h5>
                    <div class="row g-3">
                        <?php foreach ($hebergements as $heb): ?>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <img src="<?= $heb->photo ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80' ?>" 
                                         class="card-img-top" alt="<?= htmlspecialchars($heb->nom) ?>"
                                         style="height: 140px; object-fit: cover;">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold small mb-1"><?= htmlspecialchars($heb->nom) ?></h6>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <small class="text-benin fw-bold"><?= number_format($heb->prix_nuit_base, 0, ',', ' ') ?> FCFA</small>
                                            <a href="/hebergement/<?= $heb->id ?>" class="btn btn-sm btn-outline-benin">Voir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
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