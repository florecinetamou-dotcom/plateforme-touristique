<?php $title = 'Modifier mon profil - Tourisme Bénin'; ?>
<?php ob_start(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    
                    <!-- En-tête -->
                    <div class="d-flex align-items-center mb-4">
                        <a href="/profile" class="btn btn-outline-secondary me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h4 class="fw-bold mb-0">Modifier mon profil</h4>
                    </div>
                    
                    <!-- Messages flash -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    
                    <!-- Formulaire -->
                    <form method="POST" action="/profile/edit">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Prénom</label>
                                <input type="text" class="form-control" name="prenom" 
                                       value="<?= htmlspecialchars($user->prenom) ?>" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nom</label>
                                <input type="text" class="form-control" name="nom" 
                                       value="<?= htmlspecialchars($user->nom) ?>" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label fw-semibold">Téléphone</label>
                                <input type="tel" class="form-control" name="telephone" 
                                       value="<?= htmlspecialchars($user->telephone ?? '') ?>"
                                       placeholder="+229 01 23 45 67">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Langue préférée</label>
                                <select class="form-select" name="langue">
                                    <option value="fr" <?= ($user->langue_preferee ?? 'fr') == 'fr' ? 'selected' : '' ?>>Français</option>
                                    <option value="en" <?= ($user->langue_preferee ?? '') == 'en' ? 'selected' : '' ?>>English</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="newsletter" id="newsletter"
                                           <?= ($user->newsletter ?? 1) ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-semibold" for="newsletter">
                                        Recevoir la newsletter
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-benin px-5 py-2 rounded-pill">
                                    <i class="fas fa-save me-2"></i>Enregistrer
                                </button>
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