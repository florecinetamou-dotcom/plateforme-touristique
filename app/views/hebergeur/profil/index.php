<<<<<<< HEAD
<?php
$title = 'Mon profil hébergeur - BeninExplore';
$stats = $stats ?? null;
ob_start();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&display=swap');

:root {
    --bg-primary: #f8fafc;
    --bg-card: #ffffff;
    --text-primary: #0f172a;
    --text-secondary: #475569;
    --text-muted: #94a3b8;
    --border: #e2e8f0;
    --border-light: #f1f5f9;
    --success: #10b981;
    --success-dark: #059669;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --benin-green: #008751;
    --benin-yellow: #fcd116;
    --benin-red: #e8112d;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    --radius-sm: 0.5rem;
    --radius: 1rem;
    --radius-lg: 1.5rem;
}

body {
    background: linear-gradient(135deg, #1e3c2c 0%, #2d5a3f 100%);
    font-family: 'Inter', sans-serif;
}

.profile-container {
    min-height: 100vh;
    padding: 2rem;
    position: relative;
}

/* Fond décoratif */
.bg-decoration {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    z-index: 0;
}

.bg-decoration::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: moveBackground 20s linear infinite;
}

@keyframes moveBackground {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

.content-wrapper {
    position: relative;
    z-index: 1;
    max-width: 1400px;
    margin: 0 auto;
}

/* Header */
.profile-header {
    text-align: center;
    margin-bottom: 3rem;
}

.profile-header h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.profile-header p {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
}

/* Cards */
.card-modern {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    border: none;
    box-shadow: var(--shadow-xl);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 35px -12px rgba(0,0,0,0.25);
}

.card-header-modern {
    background: linear-gradient(135deg, #1e3c2c 0%, #2d5a3f 100%);
    padding: 1.5rem;
    border-bottom: none;
    position: relative;
    overflow: hidden;
}

.card-header-modern::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 30px 30px;
}

.card-header-modern h3 {
    color: white;
    margin: 0;
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

.card-header-modern i {
    margin-right: 0.75rem;
    position: relative;
    z-index: 1;
}

.card-body-modern {
    padding: 2rem;
}

/* Avatar */
.avatar-section {
    text-align: center;
    margin-bottom: 2rem;
}

.avatar-wrapper {
    position: relative;
    display: inline-block;
}

.avatar-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: var(--shadow-lg);
}

.avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1e3c2c, #2d5a3f);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Space Grotesk', sans-serif;
    font-size: 3rem;
    font-weight: 700;
    color: white;
    border: 4px solid white;
    box-shadow: var(--shadow-lg);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: linear-gradient(135deg, #1e3c2c 0%, #2d5a3f 100%);
    border-radius: var(--radius);
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    color: white;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-number {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

.stat-icon {
    font-size: 2rem;
    margin-bottom: 0.75rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-light);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: var(--text-secondary);
    font-weight: 500;
    font-size: 0.875rem;
}

.info-value {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.9375rem;
}

/* Badges */
.badge-custom {
    padding: 0.375rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.badge-success {
    background: linear-gradient(135deg, var(--success), var(--success-dark));
    color: white;
}

.badge-warning {
    background: linear-gradient(135deg, var(--warning), #d97706);
    color: white;
}

/* Action Buttons */
.actions-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.btn-action {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: var(--radius);
    text-decoration: none;
    color: var(--text-primary);
    background: var(--bg-card);
    border: 1px solid var(--border);
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-action:hover {
    transform: translateX(10px);
    background: linear-gradient(135deg, #1e3c2c 0%, #2d5a3f 100%);
    color: white;
    border-color: transparent;
}

.btn-action i {
    width: 24px;
    font-size: 1.125rem;
}

.btn-action-danger {
    border-color: rgba(239, 68, 68, 0.3);
    color: var(--danger);
}

.btn-action-danger:hover {
    background: linear-gradient(135deg, var(--danger), #dc2626);
    color: white;
}

/* Modal */
.modal-modern .modal-content {
    border-radius: var(--radius-lg);
    border: none;
    box-shadow: var(--shadow-xl);
}

.modal-modern .modal-header {
    background: linear-gradient(135deg, #1e3c2c 0%, #2d5a3f 100%);
    color: white;
    border-bottom: none;
    border-radius: var(--radius-lg) var(--radius-lg) 0 0;
}

.modal-modern .modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.modal-modern .modal-body {
    padding: 2rem;
}

/* Form */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 500;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.form-control-modern {
    border: 2px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control-modern:focus {
    border-color: #1e3c2c;
    box-shadow: 0 0 0 3px rgba(30, 60, 44, 0.1);
}

.btn-modern {
    background: linear-gradient(135deg, #1e3c2c 0%, #2d5a3f 100%);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-sm);
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Alerts */
.alert-modern {
    border-radius: var(--radius);
    border: none;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .profile-container {
        padding: 1rem;
    }
    
    .profile-header h1 {
        font-size: 1.75rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .card-body-modern {
        padding: 1.5rem;
    }
    
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>

<div class="profile-container">
    <div class="bg-decoration"></div>
    
    <div class="content-wrapper">
        <div class="profile-header">
            <h1>Mon Profil Hébergeur</h1>
            <p>Gérez vos informations professionnelles et personnelles</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-8">
                <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); endif; ?>
                
                <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); endif; ?>
                
                <div class="card-modern mb-4">
                    <div class="card-header-modern">
                        <h3><i class="fas fa-hotel"></i> Informations professionnelles</h3>
                    </div>
                    <div class="card-body-modern">
                        <div class="avatar-section">
                            <div class="avatar-wrapper">
                                <?php if (!empty($user->avatar_url)): ?>
                                    <img src="<?= htmlspecialchars($user->avatar_url) ?>" class="avatar-image" alt="Avatar">
                                <?php else: ?>
                                    <div class="avatar-placeholder">
                                        <?= strtoupper(substr($user->prenom ?? 'H', 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mt-2">
                                <span class="badge-custom badge-success">
                                    <i class="fas fa-check-circle"></i> Compte hébergeur actif
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-user me-2"></i>Prénom</span>
                                <span class="info-value"><?= htmlspecialchars($user->prenom ?? '—') ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-user me-2"></i>Nom</span>
                                <span class="info-value"><?= htmlspecialchars($user->nom ?? '—') ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-envelope me-2"></i>Email</span>
                                <span class="info-value"><?= htmlspecialchars($user->email) ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-phone me-2"></i>Téléphone</span>
                                <span class="info-value"><?= htmlspecialchars($user->telephone ?? 'Non renseigné') ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-language me-2"></i>Langue préférée</span>
                                <span class="info-value"><?= $user->langue_preferee === 'en' ? '🇬🇧 English' : '🇫🇷 Français' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if ($stats): ?>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">🏠</div>
                        <div class="stat-number"><?= $stats->nb_hebergements ?? 0 ?></div>
                        <div class="stat-label">Hébergement<?= ($stats->nb_hebergements ?? 0) > 1 ? 's' : '' ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📅</div>
                        <div class="stat-number"><?= $stats->nb_reservations ?? 0 ?></div>
                        <div class="stat-label">Réservation<?= ($stats->nb_reservations ?? 0) > 1 ? 's' : '' ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">💰</div>
                        <div class="stat-number"><?= number_format($stats->chiffre_affaires ?? 0, 0, ',', ' ') ?> FCFA</div>
                        <div class="stat-label">Chiffre d'affaires</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-number"><?= $stats->note_moyenne ?? 0 ?>/5</div>
                        <div class="stat-label">Note moyenne</div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-4">
                <div class="card-modern mb-4">
                    <div class="card-header-modern">
                        <h3><i class="fas fa-cog"></i> Mon compte hébergeur</h3>
                    </div>
                    <div class="card-body-modern">
                        <div class="actions-list">
                            <a href="/hebergeur/profil/edit" class="btn-action">
                                <i class="fas fa-edit"></i>
                                Modifier mon profil
                            </a>
                            <a href="#" class="btn-action" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                <i class="fas fa-lock"></i>
                                Changer mon mot de passe
                            </a>
                            <a href="/hebergeur/dashboard" class="btn-action">
                                <i class="fas fa-chart-line"></i>
                                Dashboard hébergeur
                            </a>
                            <a href="/hebergeur/hebergements" class="btn-action">
                                <i class="fas fa-building"></i>
                                Mes hébergements
                            </a>
                            <a href="/hebergeur/reservations" class="btn-action">
                                <i class="fas fa-calendar-check"></i>
                                Réservations reçues
                            </a>
                            <a href="/logout" class="btn-action btn-action-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                Se déconnecter
                            </a>
                        </div>
                    </div>
                </div>
                
                <?php if ($user->derniere_connexion): ?>
                <div class="card-modern">
                    <div class="card-header-modern">
                        <h3><i class="fas fa-clock"></i> Activité récente</h3>
                    </div>
                    <div class="card-body-modern">
                        <div class="info-item">
                            <span class="info-label">Dernière connexion</span>
                            <span class="info-value"><?= date('d/m/Y à H:i', strtotime($user->derniere_connexion)) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Membre depuis</span>
                            <span class="info-value"><?= date('d/m/Y', strtotime($user->date_inscription)) ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mot de Passe -->
<div class="modal fade modal-modern" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">
                    <i class="fas fa-key me-2"></i>Changer mon mot de passe
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/hebergeur/profil/update" method="POST" id="passwordForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control form-control-modern" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control form-control-modern" name="new_password" id="newPassword" required>
                        <small class="text-muted">Minimum 6 caractères</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control form-control-modern" name="confirm_password" id="confirmPassword" required>
                        <div id="passwordError" class="text-danger small mt-1" style="display: none;">Les mots de passe ne correspondent pas</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-modern">Changer le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('confirmPassword').addEventListener('input', function() {
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = this.value;
    const errorDiv = document.getElementById('passwordError');
    
    if (newPass !== confirmPass && confirmPass.length > 0) {
        errorDiv.style.display = 'block';
        this.classList.add('is-invalid');
    } else {
        errorDiv.style.display = 'none';
        this.classList.remove('is-invalid');
    }
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmPassword').value;
    
    if (newPass !== confirmPass) {
        e.preventDefault();
        document.getElementById('passwordError').style.display = 'block';
    }
});
</script>

<?php
$content = ob_get_clean();
include ROOT_PATH . '/app/views/layout/header.php';
echo $content;
include ROOT_PATH . '/app/views/layout/footer.php';
=======
<?php $title = 'Mon profil - BeninExplore'; ?>
<?php ob_start(); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

.heb-profil * { font-family: 'DM Sans', sans-serif; }
.heb-profil h1,.heb-profil h2,.heb-profil h3,.heb-profil h4,.heb-profil h5,.heb-profil .fw-bold { font-family: 'Syne', sans-serif; }

.heb-profil { background: #f0f7f3; min-height: 100vh; }

/* Hero */
.profil-hero {
    background: linear-gradient(135deg, #0f1923 0%, #1a2d20 60%, #0f1923 100%);
    border-radius: 18px; padding: 28px;
    position: relative; overflow: hidden; margin-bottom: 20px;
}
.profil-hero::before {
    content: ''; position: absolute; top: -50px; right: -50px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(0,135,81,.3) 0%, transparent 70%);
    border-radius: 50%;
}
.profil-hero::after {
    content: ''; position: absolute; bottom: -30px; left: 30%;
    width: 150px; height: 150px;
    background: radial-gradient(circle, rgba(252,209,22,.1) 0%, transparent 70%);
    border-radius: 50%;
}
.hero-avatar {
    width: 72px; height: 72px; border-radius: 50%;
    object-fit: cover; border: 3px solid rgba(255,255,255,.2); flex-shrink: 0;
}
.hero-avatar-ph {
    width: 72px; height: 72px; border-radius: 50%;
    background: linear-gradient(135deg, #008751, #00c97a);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800;
    color: #fff; flex-shrink: 0; border: 3px solid rgba(255,255,255,.2);
}
.hero-name { font-family: 'Syne', sans-serif; font-size: 1.3rem; font-weight: 800; color: #fff; }
.hero-email { color: rgba(255,255,255,.5); font-size: .82rem; }
.hero-badge {
    background: rgba(252,209,22,.15); color: #FCD116;
    border: 1px solid rgba(252,209,22,.3);
    border-radius: 50px; padding: 3px 12px;
    font-size: .7rem; font-family: 'Syne', sans-serif; font-weight: 700;
}
.statut-badge {
    border-radius: 50px; padding: 3px 12px;
    font-size: .7rem; font-family: 'Syne', sans-serif; font-weight: 700;
    display: inline-flex; align-items: center; gap: 5px;
}
.statut-verifie   { background: rgba(0,135,81,.2);  color: #4ade80; border: 1px solid rgba(0,135,81,.3); }
.statut-en_attente{ background: rgba(252,209,22,.15);color: #FCD116; border: 1px solid rgba(252,209,22,.3); }
.statut-rejete    { background: rgba(232,17,45,.15); color: #f87171; border: 1px solid rgba(232,17,45,.3); }

/* Stats */
.stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-bottom: 20px; }
.stat-card {
    background: #fff; border: 1px solid #E8EBF0;
    border-radius: 12px; padding: 18px; text-align: center;
    transition: all .2s;
}
.stat-card:hover { border-color: #008751; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,135,81,.1); }
.stat-num { font-family: 'Syne', sans-serif; font-size: 1.8rem; font-weight: 800; color: #008751; line-height: 1; margin-bottom: 4px; }
.stat-label { font-size: .73rem; color: #6b7585; }
.stat-icon { font-size: 1.2rem; margin-bottom: 6px; display: block; }

/* Info cards */
.info-card {
    background: #fff; border: 1px solid #E8EBF0;
    border-radius: 16px; padding: 22px 26px;
    box-shadow: 0 2px 12px rgba(0,0,0,.04); margin-bottom: 16px;
}
.info-card-title {
    font-family: 'Syne', sans-serif; font-size: .72rem;
    text-transform: uppercase; letter-spacing: .1em;
    color: #6b7585; margin-bottom: 16px;
    padding-bottom: 10px; border-bottom: 1px solid #F7F8FA;
    display: flex; align-items: center; gap: 8px;
}
.info-card-title i { color: #008751; }
.info-row {
    display: flex; justify-content: space-between; align-items: flex-start;
    padding: 9px 0; border-bottom: 1px solid #F7F8FA;
}
.info-row:last-child { border-bottom: none; }
.info-label { font-size: .78rem; color: #6b7585; flex-shrink: 0; min-width: 120px; }
.info-value { font-size: .85rem; font-weight: 600; color: #0f1923; text-align: right; }

/* Actions */
.action-link {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 16px; border-radius: 10px;
    text-decoration: none; font-size: .83rem;
    font-family: 'Syne', sans-serif; font-weight: 600;
    transition: all .2s; border: 1.5px solid #E8EBF0;
    color: #0f1923; background: #fff; margin-bottom: 8px;
}
.action-link:hover { border-color: #008751; color: #008751; background: rgba(0,135,81,.03); transform: translateX(4px); }
.action-link i { width: 18px; text-align: center; font-size: .85rem; }
.action-link.danger:hover { border-color: #E8112D; color: #E8112D; background: rgba(232,17,45,.03); }

.btn-benin { background: #008751; color: #fff; border: none; border-radius: 50px; padding: 8px 22px; font-family: 'Syne', sans-serif; font-weight: 700; font-size: .82rem; text-decoration: none; transition: all .2s; display: inline-flex; align-items: center; gap: 6px; }
.btn-benin:hover { background: #005c37; color: #fff; transform: translateY(-2px); }
</style>

<div class="container-fluid py-4 heb-profil">
<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
    </div>

    <!-- Contenu -->
    <div class="col-md-9">

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3 small">
            <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 small">
            <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); endif; ?>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Mon profil hébergeur</h4>
            <a href="/hebergeur/profil/edit" class="btn-benin">
                <i class="fas fa-edit"></i> Modifier
            </a>
        </div>

        <!-- Hero -->
        <div class="profil-hero">
            <div class="d-flex align-items-center gap-3" style="position:relative;z-index:1">
                <?php if (!empty($user->avatar_url)): ?>
                    <img src="<?= htmlspecialchars($user->avatar_url) ?>" class="hero-avatar" alt="Avatar">
                <?php else: ?>
                    <div class="hero-avatar-ph"><?= strtoupper(substr($user->prenom ?? 'H', 0, 1)) ?></div>
                <?php endif; ?>
                <div>
                    <div class="hero-name"><?= htmlspecialchars($user->prenom . ' ' . $user->nom) ?></div>
                    <div class="hero-email mb-2"><?= htmlspecialchars($user->email) ?></div>
                    <span class="hero-badge">🏨 Hébergeur</span>
                    &nbsp;
                    <?php
                    $statut = $profil->statut_verification ?? 'en_attente';
                    $statutLabels = ['verifie' => '✅ Vérifié', 'en_attente' => '⏳ En attente', 'rejete' => '❌ Rejeté'];
                    ?>
                    <span class="statut-badge statut-<?= $statut ?>">
                        <?= $statutLabels[$statut] ?? $statut ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <?php if ($stats): ?>
        <div class="stats-row">
            <a href="/hebergeur/hebergements" class="stat-card text-decoration-none">
                <span class="stat-icon">🏠</span>
                <div class="stat-num"><?= $stats->nb_hebergements ?></div>
                <div class="stat-label">Hébergement<?= $stats->nb_hebergements > 1 ? 's' : '' ?></div>
            </a>
            <div class="stat-card">
                <span class="stat-icon">✅</span>
                <div class="stat-num"><?= $stats->nb_actifs ?></div>
                <div class="stat-label">Actif<?= $stats->nb_actifs > 1 ? 's' : '' ?></div>
            </div>
            <a href="/hebergeur/reservations" class="stat-card text-decoration-none">
                <span class="stat-icon">📅</span>
                <div class="stat-num"><?= $stats->nb_reservations ?></div>
                <div class="stat-label">Réservation<?= $stats->nb_reservations > 1 ? 's' : '' ?></div>
            </a>
        </div>
        <?php endif; ?>

        <div class="row g-3">
            <div class="col-lg-8">

                <!-- Infos personnelles -->
                <div class="info-card">
                    <div class="info-card-title"><i class="fas fa-user"></i> Informations personnelles</div>
                    <div class="info-row">
                        <span class="info-label">Nom complet</span>
                        <span class="info-value"><?= htmlspecialchars($user->prenom . ' ' . $user->nom) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value"><?= htmlspecialchars($user->email) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value"><?= htmlspecialchars($user->telephone ?? 'Non renseigné') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Langue</span>
                        <span class="info-value"><?= $user->langue_preferee === 'en' ? '🇬🇧 English' : '🇫🇷 Français' ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Membre depuis</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($user->date_inscription)) ?></span>
                    </div>
                </div>

                <!-- Infos établissement -->
                <div class="info-card">
                    <div class="info-card-title"><i class="fas fa-building"></i> Mon établissement</div>
                    <div class="info-row">
                        <span class="info-label">Nom</span>
                        <span class="info-value"><?= htmlspecialchars($profil->nom_etablissement ?? 'Non renseigné') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Adresse</span>
                        <span class="info-value"><?= htmlspecialchars($profil->adresse ?? 'Non renseigné') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">N° SIRET</span>
                        <span class="info-value"><?= htmlspecialchars($profil->numero_siret ?? 'Non renseigné') ?></span>
                    </div>
                    <?php if (!empty($profil->description)): ?>
                    <div class="info-row" style="flex-direction:column;align-items:flex-start;gap:6px">
                        <span class="info-label">Description</span>
                        <span class="info-value" style="text-align:left;font-weight:400;color:#6b7585;font-size:.82rem;line-height:1.6">
                            <?= nl2br(htmlspecialchars($profil->description)) ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Actions -->
            <div class="col-lg-4">
                <div class="info-card">
                    <div class="info-card-title"><i class="fas fa-cog"></i> Actions</div>
                    <a href="/hebergeur/profil/edit" class="action-link">
                        <i class="fas fa-edit"></i> Modifier le profil
                    </a>
                    <a href="/hebergeur/hebergements" class="action-link">
                        <i class="fas fa-home"></i> Mes hébergements
                    </a>
                    <a href="/hebergeur/reservations" class="action-link">
                        <i class="fas fa-calendar-check"></i> Mes réservations
                    </a>
                    <a href="/hebergeur/dashboard" class="action-link">
                        <i class="fas fa-chart-bar"></i> Tableau de bord
                    </a>
                    <a href="/logout" class="action-link danger">
                        <i class="fas fa-sign-out-alt"></i> Se déconnecter
                    </a>
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
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
?>