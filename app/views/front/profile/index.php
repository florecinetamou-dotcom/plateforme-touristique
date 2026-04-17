<?php
$title = 'Mon profil - BeninExplore';
$stats = $stats ?? null;
ob_start();
?>

<style>
<<<<<<< HEAD
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap');
=======
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap');
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

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
<<<<<<< HEAD
    --radius:       20px;
    --radius-sm:    12px;
    --shadow:       0 8px 30px rgba(0,0,0,0.05);
    --shadow-hover: 0 12px 40px rgba(0,0,0,0.08);
    --transition:   all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.profile-page { background: linear-gradient(145deg, #F7F8FA 0%, #F0F2F5 100%); min-height: 100vh; padding: 40px 0 80px; }

/* Badges */
.badge-success, .badge-warning, .badge-danger, .badge-info {
    padding: 6px 14px; border-radius: 50px; font-size: 0.72rem;
    font-weight: 600; display: inline-block; font-family: 'Syne', sans-serif;
}
.badge-success { background: linear-gradient(135deg, #d4edda, #c3e6cb); color: #155724; }
.badge-warning { background: linear-gradient(135deg, #fff3cd, #ffeaa7); color: #856404; }
.badge-danger { background: linear-gradient(135deg, #f8d7da, #f5c6cb); color: #721c24; }
.badge-info { background: linear-gradient(135deg, #d1ecf1, #bee5eb); color: #0c5460; }

/* Hero section modernisée */
.profile-hero {
    background: linear-gradient(125deg, #0a121c 0%, #14301a 40%, #0a121c 100%);
    border-radius: var(--radius);
    padding: 42px 38px;
    position: relative;
    overflow: hidden;
    margin-bottom: 32px;
    box-shadow: 0 20px 40px -15px rgba(0,0,0,0.2);
}
.profile-hero::before {
    content: '';
    position: absolute; top: -80px; right: -80px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(0,135,81,0.25) 0%, transparent 70%);
=======
    --radius:       18px;
    --radius-sm:    10px;
    --shadow:       0 4px 20px rgba(0,0,0,0.07);
}

.profile-page { background: var(--surface); min-height: 100vh; padding: 32px 0 60px; }

/* Badges de statut */
.badge-success { background: #d4edda; color: #155724; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
.badge-warning { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
.badge-danger { background: #f8d7da; color: #721c24; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
.badge-info { background: #d1ecf1; color: #0c5460; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; display: inline-block; }

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
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    border-radius: 50%;
}
.profile-hero::after {
    content: '';
<<<<<<< HEAD
    position: absolute; bottom: -60px; left: 10%;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(252,209,22,0.1) 0%, transparent 70%);
    border-radius: 50%;
}
.hero-content {
    position: relative; z-index: 2;
}
.hero-avatar {
    width: 100px; height: 100px; border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255,255,255,0.15);
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.2);
    transition: var(--transition);
}
.hero-avatar:hover { transform: scale(1.02); border-color: rgba(0,135,81,0.5); }
.hero-avatar-placeholder {
    width: 100px; height: 100px; border-radius: 50%;
    background: linear-gradient(135deg, var(--benin-green), #00c97a);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif;
    font-size: 2.2rem; font-weight: 800;
    color: #fff;
    border: 4px solid rgba(255,255,255,0.15);
    transition: var(--transition);
}
.hero-name {
    font-family: 'Syne', sans-serif;
    font-size: 1.7rem; font-weight: 800;
    color: #fff; margin-bottom: 8px;
    letter-spacing: -0.02em;
}
.hero-email {
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem; margin-bottom: 14px;
}
.hero-badge {
    background: rgba(0,135,81,0.2);
    color: #4ade80;
    border: 1px solid rgba(0,135,81,0.4);
    border-radius: 50px; padding: 5px 16px;
    font-size: 0.72rem; font-family: 'Syne', sans-serif;
    font-weight: 700; letter-spacing: 0.03em;
    display: inline-flex; align-items: center; gap: 6px;
    transition: var(--transition);
}
.hero-badge.hebergeur { background: rgba(252,209,22,0.15); color: #ffd966; border-color: rgba(252,209,22,0.4); }
.hero-badge.admin { background: rgba(232,17,45,0.15); color: #f87171; border-color: rgba(232,17,45,0.4); }
.membre-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.7);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 50px; padding: 5px 14px;
    font-size: 0.7rem; font-family: 'Syne', sans-serif; font-weight: 600;
}

/* Cartes stats modernes */
.stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px; }
.stat-card {
    background: var(--card-bg);
    border: none;
    border-radius: var(--radius-sm);
    padding: 24px 20px;
    text-align: center;
    transition: var(--transition);
    box-shadow: var(--shadow);
    cursor: pointer;
    text-decoration: none;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
    background: linear-gradient(135deg, #fff, #fefce8);
}
.stat-num {
    font-family: 'Syne', sans-serif;
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--benin-green), #00c97a);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    line-height: 1;
    margin-bottom: 6px;
}
.stat-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 600;
    letter-spacing: 0.03em;
}
.stat-icon {
    font-size: 1.6rem;
    margin-bottom: 12px;
    display: block;
}

/* Info cards modernes */
.info-card {
    background: var(--card-bg);
    border: none;
    border-radius: var(--radius);
    padding: 28px 30px;
    box-shadow: var(--shadow);
    margin-bottom: 24px;
    transition: var(--transition);
}
.info-card:hover { box-shadow: var(--shadow-hover); }
.info-card-title {
    font-family: 'Syne', sans-serif;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--text-muted);
    margin-bottom: 22px;
    padding-bottom: 14px;
    border-bottom: 2px solid #F0F2F5;
    display: flex;
    align-items: center;
    gap: 8px;
}
.info-card-title i {
    color: var(--benin-green);
    font-size: 1rem;
}
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #F0F2F5;
}
.info-row:last-child { border-bottom: none; }
.info-label {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
}
.info-value {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--text-primary);
    text-align: right;
}

/* Boutons actions modernes */
.action-btns { display: flex; flex-direction: column; gap: 12px; }
.btn-action-profile {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 20px;
    border-radius: var(--radius-sm);
    text-decoration: none;
    font-size: 0.85rem;
    font-family: 'Syne', sans-serif;
    font-weight: 600;
    transition: var(--transition);
    border: 1.5px solid var(--border);
    color: var(--text-primary);
    background: var(--card-bg);
}
.btn-action-profile i {
    width: 22px;
    text-align: center;
    font-size: 1rem;
    transition: var(--transition);
}
.btn-action-profile:hover {
    border-color: var(--benin-green);
    color: var(--benin-green);
    background: linear-gradient(135deg, rgba(0,135,81,0.04), rgba(0,201,122,0.02));
    transform: translateX(6px);
}
.btn-action-profile:hover i {
    transform: translateX(2px);
}
.btn-action-profile.danger:hover {
    border-color: var(--benin-red);
    color: var(--benin-red);
    background: linear-gradient(135deg, rgba(232,17,45,0.04), rgba(232,17,45,0.02));
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.info-card, .stat-card, .profile-hero {
    animation: fadeInUp 0.5s ease-out forwards;
}
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.1s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.info-card:first-of-type { animation-delay: 0.2s; }

/* Responsive */
@media (max-width: 768px) {
    .profile-page { padding: 20px 0 40px; }
    .profile-hero { padding: 28px 20px; }
    .hero-avatar, .hero-avatar-placeholder { width: 70px; height: 70px; font-size: 1.6rem; }
    .hero-name { font-size: 1.3rem; }
    .stats-row { gap: 12px; }
    .stat-card { padding: 16px 12px; }
    .stat-num { font-size: 1.8rem; }
    .info-card { padding: 20px; }
    .btn-action-profile { padding: 12px 16px; font-size: 0.8rem; }
=======
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
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
}

@media (max-width: 640px) {
    .stats-row { grid-template-columns: repeat(3, 1fr); gap: 8px; }
<<<<<<< HEAD
=======
    .stat-num { font-size: 1.5rem; }
    .profile-hero { padding: 24px 20px; }
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
}
</style>

<div class="profile-page">
<div class="container">
<<<<<<< HEAD
<div class="row g-4">

    <!-- Colonne principale -->
=======
<div class="row">

    <!-- ── Colonne principale ── -->
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    <div class="col-lg-8">

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
<<<<<<< HEAD
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
=======
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3 small" role="alert">
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
<<<<<<< HEAD
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
=======
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 small" role="alert">
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
            <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); endif; ?>

<<<<<<< HEAD
        <!-- Hero modernisé -->
        <div class="profile-hero">
            <div class="hero-content d-flex align-items-center gap-4 flex-wrap">
=======
        <!-- Hero -->
        <div class="profile-hero">
            <div class="d-flex align-items-center gap-3" style="position:relative;z-index:1">
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                <?php if (!empty($user->avatar_url)): ?>
                    <img src="<?= htmlspecialchars($user->avatar_url) ?>" class="hero-avatar" alt="Avatar">
                <?php else: ?>
                    <div class="hero-avatar-placeholder">
<<<<<<< HEAD
                        <?= strtoupper(substr($user->prenom ?? $user->nom ?? 'U', 0, 1)) ?>
                    </div>
                <?php endif; ?>
                <div class="flex-grow-1">
                    <div class="hero-name"><?= htmlspecialchars($user->prenom . ' ' . $user->nom) ?></div>
                    <div class="hero-email mb-2"><?= htmlspecialchars($user->email) ?></div>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="hero-badge <?= $user->role ?>">
                            <?php if ($user->role === 'hebergeur'): ?>🏨 Hébergeur
                            <?php elseif ($user->role === 'admin'): ?>⚙️ Admin
                            <?php else: ?>✈️ Voyageur<?php endif; ?>
                        </span>
                        <span class="membre-tag">
                            🗓 Membre depuis <?= date('M Y', strtotime($user->date_inscription)) ?>
                        </span>
                    </div>
=======
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
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                </div>
            </div>
        </div>

<<<<<<< HEAD
        <!-- Stats modernisées -->
=======
        <!-- Stats -->
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        <?php if ($stats): ?>
        <div class="stats-row">
            <a href="/reservations" class="stat-card text-decoration-none">
                <span class="stat-icon">🏨</span>
                <div class="stat-num"><?= $stats->nb_reservations ?? 0 ?></div>
                <div class="stat-label">Réservation<?= ($stats->nb_reservations ?? 0) > 1 ? 's' : '' ?></div>
            </a>
            <a href="/favoris" class="stat-card text-decoration-none">
                <span class="stat-icon">❤️</span>
                <div class="stat-num"><?= $stats->nb_favoris ?? 0 ?></div>
                <div class="stat-label">Favori<?= ($stats->nb_favoris ?? 0) > 1 ? 's' : '' ?></div>
            </a>
            <div class="stat-card">
                <span class="stat-icon">⭐</span>
                <div class="stat-num"><?= $stats->nb_avis ?? 0 ?></div>
                <div class="stat-label">Avis donné<?= ($stats->nb_avis ?? 0) > 1 ? 's' : '' ?></div>
            </div>
        </div>
        <?php endif; ?>

<<<<<<< HEAD
        <!-- Informations personnelles modernisées -->
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-user-circle"></i> Informations personnelles
=======
        <!-- Infos personnelles -->
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-user"></i> Informations personnelles
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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
                <span class="info-label">Email vérifié</span>
                <span class="info-value"><?= $user->est_verifie ? '✅ Oui' : '⏳ En attente' ?></span>
            </div>
            
<<<<<<< HEAD
            <!-- Statut hébergeur modernisé -->
            <?php if ($user->role === 'hebergeur'): ?>
            <div class="info-row" style="display: block;">
                <span class="info-label">Statut hébergeur</span>
                <div style="margin-top: 10px;">
=======
            <!-- AJOUT : Statut hébergeur -->
            <?php if ($user->role === 'hebergeur'): ?>
            <div class="info-row">
                <span class="info-label">Statut hébergeur</span>
                <span class="info-value">
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                    <?php if ($user->statut_hebergeur === 'actif'): ?>
                        <span class="badge-success">✅ Compte validé</span>
                    <?php elseif ($user->statut_hebergeur === 'en_attente'): ?>
                        <span class="badge-warning">⏳ En attente de validation</span>
                        <div class="text-muted small mt-1">
                            Votre demande a été envoyée. Un administrateur va la traiter dans les 48h.
                        </div>
                    <?php elseif ($user->statut_hebergeur === 'bloque'): ?>
                        <span class="badge-danger">🔒 Compte bloqué</span>
                        <div class="text-muted small mt-1">
                            Veuillez contacter l'administrateur pour plus d'informations.
                        </div>
                    <?php else: ?>
                        <span class="badge-info">📝 Demande non soumise</span>
                        <div class="text-muted small mt-1">
                            <a href="/hebergeur/demande" class="text-decoration-none">Devenir hébergeur →</a>
                        </div>
                    <?php endif; ?>
<<<<<<< HEAD
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Colonne droite modernisée -->
    <div class="col-lg-4">
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-sliders-h"></i> Mon compte
=======
                </span>
            </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- ── Colonne droite : actions ── -->
    <div class="col-lg-4">
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-cog"></i> Mon compte
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
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
                <?php if ($user->role === 'hebergeur' && $user->statut_hebergeur === 'actif'): ?>
                <a href="/hebergeur/dashboard" class="btn-action-profile">
                    <i class="fas fa-home"></i> Espace hébergeur
                </a>
                <?php elseif ($user->role === 'voyageur'): ?>
                <a href="/hebergeur/demande" class="btn-action-profile">
                    <i class="fas fa-hotel"></i> Devenir hébergeur
                </a>
                <?php endif; ?>
                <a href="/logout" class="btn-action-profile danger">
                    <i class="fas fa-sign-out-alt"></i> Se déconnecter
                </a>
            </div>
        </div>

<<<<<<< HEAD
        <!-- Dernière connexion modernisée -->
        <?php if ($user->derniere_connexion): ?>
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-history"></i> Activité récente
            </div>
            <div class="info-row">
                <span class="info-label">Dernière connexion</span>
                <span class="info-value" style="font-size:0.78rem">
=======
        <!-- Dernière connexion -->
        <?php if ($user->derniere_connexion): ?>
        <div class="info-card">
            <div class="info-card-title">
                <i class="fas fa-clock"></i> Activité
            </div>
            <div class="info-row">
                <span class="info-label">Dernière connexion</span>
                <span class="info-value" style="font-size:.78rem">
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                    <?= date('d/m/Y à H:i', strtotime($user->derniere_connexion)) ?>
                </span>
            </div>
        </div>
        <?php endif; ?>
    </div>
<<<<<<< HEAD
=======

>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
</div>
</div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>