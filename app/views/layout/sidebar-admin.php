<?php
// Déterminer la page active
$current_uri = $_SERVER['REQUEST_URI'];
$admin_menu = [
    [
        'label' => 'Dashboard',
        'icon'  => 'fa-chart-pie',
        'url'   => '/admin/dashboard',
        'match' => '/admin/dashboard',
    ],
    [
        'label' => 'Hébergements',
        'icon'  => 'fa-hotel',
        'url'   => '/admin/hebergements',
        'match' => '/admin/hebergements',
        'badge_key' => 'nb_hebergements_attente',
    ],
    [
        'label' => 'Utilisateurs',
        'icon'  => 'fa-users',
        'url'   => '/admin/utilisateurs',
        'match' => '/admin/utilisateurs',
    ],
    [
        'label' => 'Réservations',
        'icon'  => 'fa-calendar-check',
        'url'   => '/admin/reservations',
        'match' => '/admin/reservations',
    ],
    [
        'label' => 'Avis',
        'icon'  => 'fa-star',
        'url'   => '/admin/avis',
        'match' => '/admin/avis',
    ],
    [
        'label' => 'Villes',
        'icon'  => 'fa-map-marker-alt',
        'url'   => '/admin/villes',
        'match' => '/admin/villes',
    ],
];

// Compteurs pour badges (injectés depuis le contrôleur si dispo)
$badges = $badges ?? [];
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap');

.admin-sidebar {
    background: linear-gradient(180deg, #0f1923 0%, #162035 60%, #0f1923 100%);
    border-radius: 20px;
    padding: 0;
    overflow: hidden;
    position: sticky;
    top: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    border: 1px solid rgba(255,255,255,0.06);
}

/* ─── Branding ─── */
.sidebar-brand {
    padding: 22px 20px 18px;
    border-bottom: 1px solid rgba(255,255,255,0.07);
    position: relative;
    overflow: hidden;
}
.sidebar-brand::before {
    content: '';
    position: absolute;
    top: -20px; right: -20px;
    width: 100px; height: 100px;
    background: radial-gradient(circle, rgba(0,135,81,0.2) 0%, transparent 70%);
    border-radius: 50%;
}
.sidebar-brand-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    margin-bottom: 12px;
}
.brand-icon {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #008751, #00a862);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: #fff;
    box-shadow: 0 4px 12px rgba(0,135,81,0.4);
    flex-shrink: 0;
}
.brand-text {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: 1rem;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1;
}
.brand-sub {
    font-size: 0.68rem;
    color: rgba(255,255,255,0.45);
    font-family: 'DM Sans', sans-serif;
    font-weight: 400;
    margin-top: 2px;
}

/* Admin badge */
.admin-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(252,209,22,0.12);
    border: 1px solid rgba(252,209,22,0.25);
    color: #fcd116;
    border-radius: 50px;
    padding: 4px 10px;
    font-size: 0.68rem;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* ─── Nav ─── */
.sidebar-nav {
    padding: 12px 10px;
}

.nav-section-label {
    font-size: 0.62rem;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    color: rgba(255,255,255,0.25);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 8px 12px 4px;
    margin-top: 4px;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 12px;
    text-decoration: none;
    color: rgba(255,255,255,0.55);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.83rem;
    font-weight: 500;
    transition: all 0.2s;
    margin-bottom: 2px;
    position: relative;
}
.sidebar-link:hover {
    background: rgba(255,255,255,0.06);
    color: rgba(255,255,255,0.9);
}
.sidebar-link.active {
    background: linear-gradient(135deg, rgba(0,135,81,0.25), rgba(0,168,98,0.15));
    color: #fff;
    border: 1px solid rgba(0,135,81,0.3);
}
.sidebar-link.active .link-icon {
    color: #00e676;
}
.link-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    background: rgba(255,255,255,0.05);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem;
    flex-shrink: 0;
    transition: all 0.2s;
}
.sidebar-link.active .link-icon {
    background: rgba(0,135,81,0.3);
}
.sidebar-link:hover .link-icon {
    background: rgba(255,255,255,0.1);
}
.link-badge {
    margin-left: auto;
    background: #E8112D;
    color: #fff;
    border-radius: 50px;
    padding: 1px 7px;
    font-size: 0.65rem;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    min-width: 18px;
    text-align: center;
}

/* ─── Footer sidebar ─── */
.sidebar-footer {
    padding: 12px 10px;
    border-top: 1px solid rgba(255,255,255,0.07);
    margin-top: 4px;
}
.sidebar-user {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 12px;
    background: rgba(255,255,255,0.04);
    margin-bottom: 6px;
}
.user-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #008751, #fcd116);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}
.user-name {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.78rem;
    color: #fff;
    line-height: 1.2;
}
.user-role {
    font-size: 0.68rem;
    color: rgba(255,255,255,0.4);
    font-family: 'DM Sans', sans-serif;
}
.sidebar-logout {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 12px;
    border-radius: 10px;
    text-decoration: none;
    color: rgba(255,255,255,0.4);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem;
    transition: all 0.2s;
}
.sidebar-logout:hover {
    background: rgba(232,17,45,0.12);
    color: #ff6b7a;
}
</style>

<div class="admin-sidebar">

    <!-- Branding -->
    <div class="sidebar-brand">
        <a href="/admin/dashboard" class="sidebar-brand-logo">
            <div class="brand-icon"><i class="fas fa-leaf"></i></div>
            <div>
                <div class="brand-text">BeninExplore</div>
                <div class="brand-sub">Tableau de bord</div>
            </div>
        </a>
        <div class="admin-role-badge">
            <i class="fas fa-shield-alt" style="font-size:.6rem"></i> Administrateur
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav">
        <div class="nav-section-label">Navigation</div>

        <?php foreach ($admin_menu as $item):
            $is_active = strpos($current_uri, $item['match']) !== false;
            $badge_count = isset($item['badge_key']) ? ($badges[$item['badge_key']] ?? 0) : 0;
        ?>
        <a href="<?= $item['url'] ?>" class="sidebar-link <?= $is_active ? 'active' : '' ?>">
            <span class="link-icon"><i class="fas <?= $item['icon'] ?>"></i></span>
            <?= $item['label'] ?>
            <?php if ($badge_count > 0): ?>
                <span class="link-badge"><?= $badge_count ?></span>
            <?php endif; ?>
        </a>
        <?php endforeach; ?>

        <div class="nav-section-label" style="margin-top:8px">Paramètres</div>
        <a href="/admin/parametres" class="sidebar-link <?= strpos($current_uri, '/admin/parametres') !== false ? 'active' : '' ?>">
            <span class="link-icon"><i class="fas fa-cog"></i></span>
            Paramètres
        </a>
    </div>

    <!-- Footer -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">
                <?= strtoupper(substr($_SESSION['user_prenom'] ?? 'A', 0, 1)) ?>
            </div>
            <div>
                <div class="user-name"><?= htmlspecialchars(($_SESSION['user_prenom'] ?? '') . ' ' . ($_SESSION['user_nom'] ?? '')) ?></div>
                <div class="user-role">Administrateur</div>
            </div>
        </div>
        <a href="/logout" class="sidebar-logout">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </div>

</div>