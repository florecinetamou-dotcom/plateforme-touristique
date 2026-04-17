<?php
$current_uri = $_SERVER['REQUEST_URI'];
$menu = [
    ['label' => 'Mon profil',       'icon' => 'fa-user',          'url' => '/profile',              'match' => '/profile'],
    ['label' => 'Mes réservations', 'icon' => 'fa-calendar-check','url' => '/reservations',         'match' => '/reservations'],
    ['label' => 'Mes favoris',      'icon' => 'fa-heart',         'url' => '/favoris',              'match' => '/favoris'],
    ['label' => 'Mes avis',         'icon' => 'fa-star',          'url' => '/avis',                 'match' => '/avis'],
    ['label' => 'Paramètres',       'icon' => 'fa-cog',           'url' => '/profile/edit',         'match' => '/profile/edit'],
];
// Stats injectées depuis le contrôleur
$voy_stats = $voy_stats ?? ['reservations' => 0, 'favoris' => 0, 'avis' => 0];

// 🔴 CORRECTION : Récupération correcte du prénom et nom
$user_prenom = $_SESSION['user_prenom'] ?? '';
$user_nom = $_SESSION['user_nom'] ?? '';

// Si le nom complet est dans user_name, on le découpe
if (empty($user_prenom) && empty($user_nom) && isset($_SESSION['user_name'])) {
    $name_parts = explode(' ', $_SESSION['user_name'], 2);
    $user_prenom = $name_parts[0] ?? '';
    $user_nom = $name_parts[1] ?? '';
}

// Dernier recours : valeurs par défaut
if (empty($user_prenom)) $user_prenom = 'V';
if (empty($user_nom)) $user_nom = 'R';

$user_email = $_SESSION['user_email'] ?? 'voyageur@beninexplore.com';
$user_role = $_SESSION['user_role'] ?? 'voyageur';
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap');

.voy-sidebar {
    background: linear-gradient(180deg, #0f1923 0%, #162035 60%, #0f1923 100%);
    border-radius: 20px;
    overflow: hidden;
    position: sticky;
    top: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    border: 1px solid rgba(255,255,255,0.06);
}

/* ─── Profil header ─── */
.voy-profile-header {
    padding: 24px 20px 18px;
    border-bottom: 1px solid rgba(255,255,255,0.07);
    text-align: center;
    position: relative;
    overflow: hidden;
}
.voy-profile-header::before {
    content: '';
    position: absolute; top: -30px; left: 50%; transform: translateX(-50%);
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(0,135,81,0.2) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.voy-avatar {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #008751, #fcd116);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 1.3rem; color: #fff;
    margin: 0 auto 12px;
    box-shadow: 0 4px 16px rgba(0,135,81,0.35);
    position: relative; z-index: 1;
}
.voy-name {
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 0.95rem; color: #fff;
    margin-bottom: 3px;
    position: relative; z-index: 1;
}
.voy-email {
    font-size: 0.72rem; color: rgba(255,255,255,0.4);
    font-family: 'DM Sans', sans-serif;
    position: relative; z-index: 1;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 180px; margin: 0 auto;
}
.voy-role-badge {
    display: inline-flex; align-items: center; gap: 4px;
    background: rgba(0,135,81,0.15); border: 1px solid rgba(0,135,81,0.3);
    color: #00e676; border-radius: 50px;
    padding: 3px 10px; font-size: 0.66rem;
    font-family: 'Syne', sans-serif; font-weight: 700;
    letter-spacing: 0.05em; text-transform: uppercase;
    margin-top: 8px; position: relative; z-index: 1;
}

/* ─── Mini stats ─── */
.voy-stats {
    display: grid; grid-template-columns: repeat(3, 1fr);
    border-bottom: 1px solid rgba(255,255,255,0.07);
}
.voy-stat {
    padding: 14px 8px;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,0.07);
}
.voy-stat:last-child { border-right: none; }
.voy-stat-value {
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 1.1rem; color: #fff; line-height: 1;
    margin-bottom: 3px;
}
.voy-stat-label {
    font-size: 0.62rem; color: rgba(255,255,255,0.35);
    font-family: 'DM Sans', sans-serif; font-weight: 400;
}

/* ─── Nav ─── */
.voy-nav { padding: 12px 10px; }
.voy-link {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 12px;
    text-decoration: none; color: rgba(255,255,255,0.5);
    font-family: 'DM Sans', sans-serif; font-size: 0.83rem; font-weight: 500;
    transition: all 0.2s; margin-bottom: 2px;
}
.voy-link:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.9); }
.voy-link.active {
    background: linear-gradient(135deg, rgba(0,135,81,0.25), rgba(0,168,98,0.15));
    color: #fff; border: 1px solid rgba(0,135,81,0.3);
}
.voy-link-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: rgba(255,255,255,0.05);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.72rem; flex-shrink: 0; transition: all 0.2s;
}
.voy-link.active .voy-link-icon { background: rgba(0,135,81,0.3); color: #00e676; }
.voy-link:hover .voy-link-icon  { background: rgba(255,255,255,0.1); }

/* ─── Footer ─── */
.voy-sidebar-footer {
    padding: 12px 10px;
    border-top: 1px solid rgba(255,255,255,0.07);
}
.voy-logout {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 12px; border-radius: 10px;
    text-decoration: none; color: rgba(255,255,255,0.4);
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem;
    transition: all 0.2s;
}
.voy-logout:hover { background: rgba(232,17,45,0.12); color: #ff6b7a; }
</style>

<div class="voy-sidebar">

    <!-- Profil -->
    <div class="voy-profile-header">
        <div class="voy-avatar">
            <?= strtoupper(substr($user_prenom, 0, 1) . substr($user_nom, 0, 1)) ?>
        </div>
        <div class="voy-name"><?= htmlspecialchars($user_prenom . ' ' . $user_nom) ?></div>
        <div class="voy-email"><?= htmlspecialchars($user_email) ?></div>
        <div class="voy-role-badge">
            <i class="fas fa-user" style="font-size:.58rem"></i> 
            <?= ucfirst($user_role) ?>
        </div>
    </div>

    <!-- Stats -->
    <div class="voy-stats">
        <div class="voy-stat">
            <div class="voy-stat-value"><?= $voy_stats['reservations'] ?></div>
            <div class="voy-stat-label">Séjours</div>
        </div>
        <div class="voy-stat">
            <div class="voy-stat-value"><?= $voy_stats['favoris'] ?></div>
            <div class="voy-stat-label">Favoris</div>
        </div>
        <div class="voy-stat">
            <div class="voy-stat-value"><?= $voy_stats['avis'] ?></div>
            <div class="voy-stat-label">Avis</div>
        </div>
    </div>

    <!-- Nav -->
    <div class="voy-nav">
        <?php foreach ($menu as $item):
            $active = strpos($current_uri, $item['match']) !== false && $item['match'] !== '/profile'
                   || $current_uri === $item['match'];
        ?>
        <a href="<?= $item['url'] ?>" class="voy-link <?= $active ? 'active' : '' ?>">
            <span class="voy-link-icon"><i class="fas <?= $item['icon'] ?>"></i></span>
            <?= $item['label'] ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Logout -->
    <div class="voy-sidebar-footer">
        <a href="/logout" class="voy-logout">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>

</div>