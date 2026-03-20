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
?>