<?php $title = 'Modifier mon profil - BeninExplore'; ?>
<?php ob_start(); ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
        </div>
        
        <!-- Contenu principal -->
        <div class="col-md-9">
            <div class="d-flex align-items-center mb-4">
                <a href="/hebergeur/profil" class="btn btn-outline-secondary btn-sm me-3 rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i>Retour
                </a>
                <h4 class="fw-bold mb-0">Modifier mon profil</h4>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="/hebergeur/profil/update">
                        <div class="row g-3">
                            <!-- Informations personnelles -->
                            <div class="col-12">
                                <h5 class="fw-bold mb-3">Informations personnelles</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Prénom</label>
                                <input type="text" class="form-control form-control-sm" 
                                       value="<?= htmlspecialchars($user->prenom) ?>" disabled>
                                <small class="text-muted">Non modifiable</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Nom</label>
                                <input type="text" class="form-control form-control-sm" 
                                       value="<?= htmlspecialchars($user->nom) ?>" disabled>
                                <small class="text-muted">Non modifiable</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Email</label>
                                <input type="email" class="form-control form-control-sm" 
                                       value="<?= htmlspecialchars($user->email) ?>" disabled>
                                <small class="text-muted">Non modifiable</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Téléphone</label>
                                <input type="tel" name="telephone" class="form-control form-control-sm" 
                                       value="<?= htmlspecialchars($user->telephone ?? '') ?>">
                            </div>
                            
                            <!-- Informations hébergeur -->
                            <div class="col-12 mt-4">
                                <h5 class="fw-bold mb-3">Informations hébergeur</h5>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Nom de l'établissement</label>
                                <input type="text" name="nom_etablissement" class="form-control form-control-sm" 
                                       value="<?= htmlspecialchars($profil->nom_etablissement ?? '') ?>">
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Description</label>
                                <textarea name="description" class="form-control form-control-sm" rows="3"><?= htmlspecialchars($profil->description ?? '') ?></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Adresse</label>
                                <textarea name="adresse" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($profil->adresse ?? '') ?></textarea>
                            </div>
                            
                            <!-- Préférences -->
                            <div class="col-12 mt-4">
                                <h5 class="fw-bold mb-3">Préférences</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Langue préférée</label>
                                <select name="langue" class="form-select form-select-sm">
                                    <option value="fr" <?= ($user->langue_preferee ?? 'fr') == 'fr' ? 'selected' : '' ?>>Français</option>
                                    <option value="en" <?= ($user->langue_preferee ?? '') == 'en' ? 'selected' : '' ?>>English</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter"
                                           <?= ($user->newsletter ?? 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label small" for="newsletter">
                                        Recevoir la newsletter
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Bouton -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-benin px-5 rounded-pill">
                                    <i class="fas fa-save me-2"></i>Enregistrer
                                </button>
                                <a href="/hebergeur/profil" class="btn btn-outline-secondary px-4 rounded-pill ms-2">
                                    Annuler
                                </a>
                            </div>
                        </div>
                    </form>
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