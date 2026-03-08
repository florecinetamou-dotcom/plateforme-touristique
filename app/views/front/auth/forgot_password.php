<?php $title = 'Mot de passe oublié - Tourisme Bénin'; ?>
<?php $meta_description = 'Réinitialisez votre mot de passe pour retrouver l\'accès à votre compte Tourisme Bénin.'; ?>

<?php ob_start(); ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="card border-0 shadow-lg" data-aos="fade-up">
                    <div class="card-body p-5">
                        
                        <!-- En-tête -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-benin-light p-3 d-inline-block mb-3">
                                <i class="fas fa-lock fa-3x text-benin"></i>
                            </div>
                            <h2 class="fw-bold">Mot de passe oublié ?</h2>
                            <p class="text-muted">
                                Pas d'inquiétude ! Saisissez votre email et nous vous enverrons 
                                un lien pour réinitialiser votre mot de passe.
                            </p>
                        </div>
                        
                        <!-- Formulaire -->
                        <form method="POST" action="/forgot-password" id="forgotPasswordForm">
                            <?php if (isset($_SESSION['csrf_token'])): ?>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <?php endif; ?>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Adresse email</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-benin"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control border-start-0 <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                           id="email" 
                                           name="email" 
                                           value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                                           placeholder="votre@email.com" 
                                           required>
                                </div>
                                <?php if (isset($errors['email'])): ?>
                                    <div class="text-danger mt-2 small">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <?= $errors['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <button type="submit" class="btn btn-benin w-100 py-3 mb-3">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer le lien
                            </button>
                            
                            <div class="text-center">
                                <a href="/login" class="text-benin text-decoration-none">
                                    <i class="fas fa-arrow-left me-1"></i>Retour à la connexion
                                </a>
                            </div>
                        </form>
                        
                        <!-- Message de succès -->
                        <?php if (isset($success) && $success): ?>
                            <div class="alert alert-success mt-4 mb-0">
                                <i class="fas fa-check-circle me-2"></i>
                                Si un compte existe avec cette adresse email, vous recevrez un lien 
                                de réinitialisation dans quelques instants.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Aide supplémentaire -->
                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">
                        <i class="fas fa-clock me-1"></i>
                        Le lien de réinitialisation est valable pendant 1 heure.
                    </p>
                    <p class="text-muted small">
                        <i class="fas fa-shield-alt me-1"></i>
                        Vos données sont protégées et sécurisées.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
$content = ob_get_clean();
unset($_SESSION['old']);
require dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
require dirname(__DIR__, 2) . '/layout/footer.php';
?>