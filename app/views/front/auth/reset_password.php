<?php $title = 'Réinitialisation mot de passe - Tourisme Bénin'; ?>
<?php $meta_description = 'Choisissez un nouveau mot de passe pour votre compte Tourisme Bénin.'; ?>

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
                                <i class="fas fa-key fa-3x text-benin"></i>
                            </div>
                            <h2 class="fw-bold">Nouveau mot de passe</h2>
                            <p class="text-muted">
                                Choisissez un mot de passe sécurisé pour votre compte.
                            </p>
                        </div>
                        
                        <!-- Token caché -->
                        <?php $token = $token ?? $_GET['token'] ?? ''; ?>
                        
                        <!-- Formulaire -->
                        <form method="POST" action="/reset-password" id="resetPasswordForm">
                            <?php if (isset($_SESSION['csrf_token'])): ?>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <?php endif; ?>
                            
                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                            
                            <!-- Nouveau mot de passe -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-benin"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control border-start-0 <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                           id="password" 
                                           name="password" 
                                           placeholder="••••••••" 
                                           required>
                                    <button class="btn btn-light border" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php if (isset($errors['password'])): ?>
                                    <div class="text-danger mt-1 small"><?= $errors['password'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Confirmation -->
                            <div class="mb-4">
                                <label for="password_confirm" class="form-label fw-semibold">Confirmer le mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-benin"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control border-start-0 <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                                           id="password_confirm" 
                                           name="password_confirm" 
                                           placeholder="••••••••" 
                                           required>
                                    <button class="btn btn-light border" type="button" id="togglePasswordConfirm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <?php if (isset($errors['password_confirm'])): ?>
                                    <div class="text-danger mt-1 small"><?= $errors['password_confirm'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Indicateurs de force -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small">Force du mot de passe</span>
                                    <span class="small" id="passwordStrength">Faible</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div id="passwordStrengthBar" class="progress-bar bg-danger" style="width: 33%"></div>
                                </div>
                                <ul class="list-unstyled mt-2 small text-muted">
                                    <li id="criteria-length" class="mb-1">
                                        <i class="fas fa-times-circle text-danger me-1"></i> Au moins 8 caractères
                                    </li>
                                    <li id="criteria-uppercase" class="mb-1">
                                        <i class="fas fa-times-circle text-danger me-1"></i> Au moins 1 majuscule
                                    </li>
                                    <li id="criteria-number" class="mb-1">
                                        <i class="fas fa-times-circle text-danger me-1"></i> Au moins 1 chiffre
                                    </li>
                                </ul>
                            </div>
                            
                            <button type="submit" class="btn btn-benin w-100 py-3">
                                <i class="fas fa-save me-2"></i>Enregistrer le mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.querySelector('i').classList.toggle('fa-eye');
    this.querySelector('i').classList.toggle('fa-eye-slash');
});

document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
    const password = document.getElementById('password_confirm');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.querySelector('i').classList.toggle('fa-eye');
    this.querySelector('i').classList.toggle('fa-eye-slash');
});

// Vérification de la force du mot de passe
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    
    // Critères
    const hasLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    
    // Mise à jour des icônes
    document.getElementById('criteria-length').innerHTML = `<i class="fas fa-${hasLength ? 'check-circle text-success' : 'times-circle text-danger'} me-1"></i> Au moins 8 caractères`;
    document.getElementById('criteria-uppercase').innerHTML = `<i class="fas fa-${hasUppercase ? 'check-circle text-success' : 'times-circle text-danger'} me-1"></i> Au moins 1 majuscule`;
    document.getElementById('criteria-number').innerHTML = `<i class="fas fa-${hasNumber ? 'check-circle text-success' : 'times-circle text-danger'} me-1"></i> Au moins 1 chiffre`;
    
    // Calcul de la force
    let score = 0;
    if (hasLength) score++;
    if (hasUppercase) score++;
    if (hasNumber) score++;
    
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrength');
    
    if (score === 0) {
        strengthBar.className = 'progress-bar bg-danger';
        strengthBar.style.width = '33%';
        strengthText.textContent = 'Faible';
        strengthText.className = 'small text-danger';
    } else if (score === 1) {
        strengthBar.className = 'progress-bar bg-warning';
        strengthBar.style.width = '50%';
        strengthText.textContent = 'Moyen';
        strengthText.className = 'small text-warning';
    } else if (score === 2) {
        strengthBar.className = 'progress-bar bg-info';
        strengthBar.style.width = '75%';
        strengthText.textContent = 'Bon';
        strengthText.className = 'small text-info';
    } else {
        strengthBar.className = 'progress-bar bg-success';
        strengthBar.style.width = '100%';
        strengthText.textContent = 'Fort';
        strengthText.className = 'small text-success';
    }
});
</script>

<?php 
$content = ob_get_clean();
require dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
require dirname(__DIR__, 2) . '/layout/footer.php';
?>