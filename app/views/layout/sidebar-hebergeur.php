<?php
$current_page = $_SERVER['REQUEST_URI'];
$user_name = $_SESSION['user_name'] ?? 'Hébergeur';
$initiale = strtoupper(substr($user_name, 0, 1));

function isHebergeurActive(string $path, string $current, bool $exact = false): string
{
    if ($exact)
        return $current === $path ? 'active' : '';
    return strpos($current, $path) !== false ? 'active' : '';
}
?>

<div class="heb-sidebar">
    <!-- Profil -->
    <div class="heb-sidebar-profile">
        <div class="heb-avatar"><?= $initiale ?></div>
        <div>
            <div class="heb-sidebar-name"><?= htmlspecialchars($user_name) ?></div>
            <div class="heb-sidebar-role"><i class="fas fa-circle me-1"
                    style="font-size:7px; color:#22c55e;"></i>Hébergeur actif</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="heb-nav">
        <div class="heb-nav-label">Principal</div>

        <a href="/hebergeur/dashboard"
            class="heb-nav-item <?= isHebergeurActive('/hebergeur/dashboard', $current_page) ?>">
            <div class="heb-nav-icon"><i class="fas fa-tachometer-alt"></i></div>
            <span>Tableau de bord</span>
        </a>

        <a href="/hebergeur/reservations"
            class="heb-nav-item <?= isHebergeurActive('/hebergeur/reservations', $current_page) ?>">
            <div class="heb-nav-icon"><i class="fas fa-calendar-check"></i></div>
            <span>Réservations</span>
            <?php if (!empty($stats->reservations_en_attente) && $stats->reservations_en_attente > 0): ?>
                <span class="heb-badge"><?= $stats->reservations_en_attente ?></span>
            <?php endif; ?>
        </a>

        <div class="heb-nav-label mt-3">Hébergements</div>

        <a href="/hebergeur/hebergements"
            class="heb-nav-item <?= isHebergeurActive('/hebergeur/hebergements', $current_page) ?>">
            <div class="heb-nav-icon"><i class="fas fa-building"></i></div>
            <span>Mes hébergements</span>
        </a>

        <a href="/hebergeur/hebergements/create"
            class="heb-nav-item <?= isHebergeurActive('/hebergeur/hebergements/create', $current_page) ?>">
            <div class="heb-nav-icon"><i class="fas fa-plus"></i></div>
            <span>Ajouter un hébergement</span>
        </a>

        <div class="heb-nav-label mt-3">Compte</div>

        <a href="/hebergeur/profil" class="heb-nav-item <?= isHebergeurActive('/hebergeur/profil', $current_page) ?>">
            <div class="heb-nav-icon"><i class="fas fa-user-cog"></i></div>
            <span>Mon profil</span>
        </a>

        <a href="/logout" class="heb-nav-item heb-nav-logout">
            <div class="heb-nav-icon"><i class="fas fa-sign-out-alt"></i></div>
            <span>Déconnexion</span>
        </a>
    </nav>

    <!-- Lien retour site -->
    <a href="/" class="heb-back-site">
        <i class="fas fa-arrow-left me-2"></i>Retour au site
    </a>
</div>

<style>
    .heb-sidebar {
        background: white;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
        overflow: hidden;
        position: sticky;
        top: 88px;
    }

    /* Profil */
    .heb-sidebar-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px;
        background: linear-gradient(135deg, #008751, #005c37);
        border-bottom: none;
    }

    .heb-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .heb-sidebar-name {
        font-size: 0.9rem;
        font-weight: 700;
        color: white;
        line-height: 1.2;
    }

    .heb-sidebar-role {
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.75);
        margin-top: 2px;
    }

    /* Navigation */
    .heb-nav {
        padding: 16px 12px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .heb-nav-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #bbb;
        padding: 0 10px;
        margin-bottom: 4px;
    }

    .heb-nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #555;
        text-decoration: none;
        transition: all 0.2s ease;
        position: relative;
    }

    .heb-nav-item:hover {
        background: rgba(0, 135, 81, 0.07);
        color: #008751;
        transform: translateX(3px);
    }

    .heb-nav-item.active {
        background: rgba(0, 135, 81, 0.1);
        color: #008751;
        font-weight: 600;
    }

    .heb-nav-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        background: #f5f5f5;
        color: #888;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .heb-nav-item:hover .heb-nav-icon,
    .heb-nav-item.active .heb-nav-icon {
        background: #008751;
        color: white;
    }

    .heb-badge {
        margin-left: auto;
        background: #ef4444;
        color: white;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 50px;
    }

    .heb-nav-logout {
        color: #ef4444;
        margin-top: 4px;
    }

    .heb-nav-logout:hover {
        background: rgba(239, 68, 68, 0.08);
        color: #ef4444;
    }

    .heb-nav-logout:hover .heb-nav-icon {
        background: #ef4444;
    }

    /* Retour site */
    .heb-back-site {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px;
        font-size: 0.8rem;
        color: #aaa;
        text-decoration: none;
        border-top: 1px solid #f0f0f0;
        transition: color 0.2s;
    }

    .heb-back-site:hover {
        color: #008751;
    }
</style>