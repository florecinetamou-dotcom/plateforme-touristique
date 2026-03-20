<?php
$title = 'Mon profil - BeninExplore';
$stats = $stats ?? null;
ob_start();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap');

.profile-page * { font-family: 'DM Sans', sans-serif; }
.profile-page h1,.profile-page h2,.profile-page h3,.profile-page h4,.profile-page h5,.profile-page .fw-bold { font-family: 'Syne', sans-serif; }

:root {
    --benin-green:  #008751;
    --benin-yellow: #FCD116;
    --benin-red:    #E8112D;
    --surface:      #F7F8FA;
    --card-bg:      #ffffff;
    --text-primary: #0f1923;
    --text-muted:   #6b7585;
    --border:       #E8EBF0;
    --radius:       18px;
    --radius-sm:    10px;
    --shadow:       0 4px 20px rgba(0,0,0,0.07);
}

.profile-page { background: var(--surface); min-height: 100vh; padding: 32px 0 60px; }

/* ── Hero profil ── */
.profile-hero {
    background: linear-gradient(135deg, #0f1923 0%, #1a2d20 60%, #0f1923 100%);
    border-radius: var(--radius);
    padding: 36px 32px;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
}
.profile-hero::before {
    content: '';
    position: absolute; top: -60px; right: -60px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(0,135,81,.3) 0%, transparent 70%);
    border-radius: 50%;
}
.profile-hero::after {
    content: '';
    position: absolute; bottom: -40px; left: 20%;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(252,209,22,.12) 0%, transparent 70%);
    border-radius: 50%;
}
.hero-avatar {
    width: 80px; height: 80px; border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,.2);
    flex-shrink: 0;
}
.hero-avatar-placeholder {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, var(--benin-green), #00c97a);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif;
    font-size: 1.8rem; font-weight: 800;
    color: #fff; flex-shrink: 0;
    border: 3px solid rgba(255,255,255,.2);
}
.hero-name { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 4px; }
.hero-email { color: rgba(255,255,255,.5); font-size: .85rem; }
.hero-badge {
    background: rgba(0,135,81,.2); color: #4ade80;
    border: 1px solid rgba(0,135,81,.3);
    border-radius: 50px; padding: 4px 14px;
    font-size: .72rem; font-family: 'Syne', sans-serif;
    font-weight: 700; letter-spacing: .04em;
    display: inline-flex; align-items: center; gap: 5px;
}
.hero-badge.hebergeur { background: rgba(252,209,22,.15); color: var(--benin-yellow); border-color: rgba(252,209,22,.3); }
.hero-badge.admin { background: rgba(232,17,45,.15); color: #f87171; border-color: rgba(232,17,45,.3); }

/* ── Stats ── */
.stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 28px; }
.stat-card {
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: var(--radius-sm); padding: 20px;
    text-align: center; transition: all .2s;
}
.stat-card:hover { border-color: var(--benin-green); transform: translateY(-3px); box-shadow: var(--shadow); }
.stat-num { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800; color: var(--benin-green); line-height: 1; margin-bottom: 4px; }
.stat-label { font-size: .75rem; color: var(--text-muted); font-weight: 500; }
.stat-icon { font-size: 1.4rem; margin-bottom: 8px; display: block; }

/* ── Info cards ── */
.info-card {
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 24px 28px;
    box-shadow: var(--shadow); margin-bottom: 20px;
}
.info-card-title {
    font-family: 'Syne', sans-serif; font-size: .75rem;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--text-muted); margin-bottom: 18px;
    padding-bottom: 12px; border-bottom: 1px solid var(--surface);
    display: flex; align-items: center; gap: 8px;
}
.info-card-title i { color: var(--benin-green); }
.info-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--surface); }
.info-row:last-child { border-bottom: none; }
.info-label { font-size: .8rem; color: var(--text-muted); }
.info-value { font-size: .88rem; font-weight: 600; color: var(--text-primary); text-align: right; }

/* ── Boutons actions ── */
.action-btns { display: flex; flex-direction: column; gap: 10px; }
.btn-action-profile {
    display: flex; align-items: center; gap: 10px;
    padding: 13px 18px; border-radius: var(--radius-sm);
    text-decoration: none; font-size: .85rem;
    font-family: 'Syne', sans-serif; font-weight: 600;
    transition: all .2s; border: 1.5px solid var(--border);
    color: var(--text-primary); background: var(--card-bg);
}
.btn-action-profile:hover { border-color: var(--benin-green); color: var(--benin-green); background: rgba(0,135,81,.04); transform: translateX(4px); }
.btn-action-profile i { width: 20px; text-align: center; }
.btn-action-profile.danger:hover { border-color: var(--benin-red); color: var(--benin-red); background: rgba(232,17,45,.04); }

/* ── Membre depuis ── */
.membre-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(252,209,22,.1); color: #a07800;
    border: 1px solid rgba(252,209,22,.3);
    border-radius: 50px; padding: 4px 14px;
    font-size: .72rem; font-family: 'Syne', sans-serif; font-weight: 700;
    position: relative; z-index: 1;
}

@media (max-width: 640px) {
    .stats-row { grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .stat-num { font-size: 1.5rem; }
    .profile-hero { padding: 24px 20px; }
}
</style>

<div class="profile-page">
<div class="container">
<div class="row">

    <!-- ── Colonne principale ── -->
    <div class="col-lg-8">

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3 small" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 small" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); endif; ?>

        <!-- Hero -->
        <div class="profile-hero">
            <div class="d-flex align-items-center gap-3" style="position:relative;z-index:1">
                <?php if (!empty($user->avatar_url)): ?>
                    <img src="<?= htmlspecialchars($user->avatar_url) ?>" class="hero-avatar" alt="Avatar">
                <?php else: ?>
                    <div class="hero-avatar-placeholder">
                        <?= strtoupper(substr($user->prenom ?? 'U', 0, 1)) ?>
                    </div>
                <?php endif; ?>
                <div>
                    <div class="hero-name"><?= htmlspecialchars($user->prenom . ' ' . $user->nom) ?></div>
                    <div class="hero-email mb-2"><?= htmlspecialchars($user->email) ?></div>
                    <span class="hero-badge <?= $user->role ?>">
                        <?php if ($user->role === 'hebergeur'): ?>🏨 Hébergeur
                        <?php elseif ($user->role === 'admin'): ?>⚙️ Admin
                        <?php else: ?>✈️ Voyageur<?php endif; ?>
                    </span>
                    &nbsp;
                    <span class="membre-tag">
                        🗓 Membre depuis <?= date('M Y', strtotime($user->date_inscription)) ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <?php if ($stats): ?>
        <div class="stats-row">
            <a href="/reservations" class="stat-card text-decoration-none">
                <span class="stat-icon">🏨</span>
                <div class="stat-num"><?= $stats->nb_reservations ?></div>
                <div class="stat-label">Réservation<?= $stats->nb_reservations > 1 ? 's' : '' ?></div>
            </a>
            <a href="/favoris" class="stat-card text-decoration-none">
                <span class="stat-icon">❤️</span>
                <div class="stat-num"><?= $stats->nb_favoris ?></div>
                <div class="stat-label">Favori<?= $stats->nb_favoris > 1 ? 's' : '' ?></div>
            </a>
            <div class="stat-card">
                <span class="stat-icon">⭐</span>
                <div class="stat-num"><?= $stats->nb_avis ?></div>
                <div class="stat-label">Avis donné<?= $stats->nb_avis > 1 ? 's' : '' ?></div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Infos personnelles -->
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-user"></i> Informations personnelles
            </div>
            <div class="info-row">
                <span class="info-label">Prénom</span>
                <span class="info-value"><?= htmlspecialchars($user->prenom ?? '—') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Nom</span>
                <span class="info-value"><?= htmlspecialchars($user->nom ?? '—') ?></span>
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
                <span class="info-label">Langue préférée</span>
                <span class="info-value"><?= $user->langue_preferee === 'en' ? '🇬🇧 English' : '🇫🇷 Français' ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Newsletter</span>
                <span class="info-value"><?= $user->newsletter ? '✅ Activée' : '❌ Désactivée' ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Compte vérifié</span>
                <span class="info-value"><?= $user->est_verifie ? '✅ Oui' : '⏳ En attente' ?></span>
            </div>
        </div>

    </div>

    <!-- ── Colonne droite : actions ── -->
    <div class="col-lg-4">
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-cog"></i> Mon compte
            </div>
            <div class="action-btns">
                <a href="/profile/edit" class="btn-action-profile">
                    <i class="fas fa-edit"></i> Modifier mon profil
                </a>
                <a href="/profile/password" class="btn-action-profile">
                    <i class="fas fa-lock"></i> Changer mon mot de passe
                </a>
                <a href="/reservations" class="btn-action-profile">
                    <i class="fas fa-calendar-check"></i> Mes réservations
                </a>
                <a href="/favoris" class="btn-action-profile">
                    <i class="fas fa-heart"></i> Mes favoris
                </a>
                <?php if ($user->role === 'hebergeur'): ?>
                <a href="/hebergeur/dashboard" class="btn-action-profile">
                    <i class="fas fa-home"></i> Espace hébergeur
                </a>
                <?php endif; ?>
                <a href="/logout" class="btn-action-profile danger">
                    <i class="fas fa-sign-out-alt"></i> Se déconnecter
                </a>
            </div>
        </div>

        <!-- Dernière connexion -->
        <?php if ($user->derniere_connexion): ?>
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-clock"></i> Activité
            </div>
            <div class="info-row">
                <span class="info-label">Dernière connexion</span>
                <span class="info-value" style="font-size:.78rem">
                    <?= date('d/m/Y à H:i', strtotime($user->derniere_connexion)) ?>
                </span>
            </div>
        </div>
        <?php endif; ?>
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