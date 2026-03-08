<?php $title = 'Mon profil - BeninExplore'; ?>
<?php ob_start(); ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
        </div>
        
        <!-- Contenu principal -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Mon profil</h4>
                <a href="/hebergeur/profil/edit" class="btn btn-benin btn-sm rounded-pill px-4">
                    <i class="fas fa-edit me-1"></i>Modifier
                </a>
            </div>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <div class="row">
                <!-- Informations personnelles -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Informations personnelles</h5>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Nom complet</small>
                                <span class="fw-bold"><?= htmlspecialchars($user->prenom . ' ' . $user->nom) ?></span>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Email</small>
                                <span class="fw-bold"><?= htmlspecialchars($user->email) ?></span>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Téléphone</small>
                                <span class="fw-bold"><?= htmlspecialchars($user->telephone ?? 'Non renseigné') ?></span>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Membre depuis</small>
                                <span class="fw-bold"><?= date('d/m/Y', strtotime($user->date_inscription)) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Informations hébergeur -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Informations hébergeur</h5>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Établissement</small>
                                <span class="fw-bold"><?= htmlspecialchars($profil->nom_etablissement ?? 'Non renseigné') ?></span>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Description</small>
                                <span class="fw-bold"><?= htmlspecialchars($profil->description ?? 'Non renseigné') ?></span>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Adresse</small>
                                <span class="fw-bold"><?= htmlspecialchars($profil->adresse ?? 'Non renseigné') ?></span>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Statut de vérification</small>
                                <?php
                                $badgeClass = match($profil->statut_verification ?? 'en_attente') {
                                    'verifie' => 'bg-success',
                                    'en_attente' => 'bg-warning',
                                    'rejete' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?> rounded-pill">
                                    <?= $profil->statut_verification ?? 'en_attente' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>