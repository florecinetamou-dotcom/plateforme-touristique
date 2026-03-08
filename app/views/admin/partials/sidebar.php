<?php
$currentUrl = $_SERVER['REQUEST_URI'];
if (!function_exists('isActive')) {
    function isActive(string $path): string {
        return strpos($_SERVER['REQUEST_URI'], $path) === 0 ? 'active' : '';
    }
}
$badges = $badges ?? [];
?>
<aside class="sidebar">
    <div class="sidebar__brand">
        <div class="sidebar__brand-name">Benin<em>Explore</em></div>
        <div class="sidebar__brand-tag">Administration</div>
    </div>

    <div class="sidebar__section">
        <p class="sidebar__section-label">Principal</p>
        <a href="/admin/dashboard" class="nav-item <?= isActive('/admin/dashboard') ?>">
            <span class="nav-icon">📊</span> Tableau de bord
        </a>
    </div>

    <div class="sidebar__section">
        <p class="sidebar__section-label">Gestion</p>
        <a href="/admin/hebergements" class="nav-item <?= isActive('/admin/hebergements') ?>">
            <span class="nav-icon">🏨</span> Hébergements
            <?php if (($badges['nb_hebergements_attente'] ?? 0) > 0): ?>
                <span class="nav-badge"><?= $badges['nb_hebergements_attente'] ?></span>
            <?php endif; ?>
        </a>
        <a href="/admin/villes" class="nav-item <?= isActive('/admin/villes') ?>">
            <span class="nav-icon">📍</span> Villes
        </a>
        <a href="/admin/sites" class="nav-item <?= isActive('/admin/sites') ?>">
            <span class="nav-icon">🏞️</span> Sites touristiques
        </a>
        <a href="/admin/reservations" class="nav-item <?= isActive('/admin/reservations') ?>">
            <span class="nav-icon">📅</span> Réservations
        </a>
        <a href="/admin/utilisateurs" class="nav-item <?= isActive('/admin/utilisateurs') ?>">
            <span class="nav-icon">👥</span> Utilisateurs
        </a>
        <a href="/admin/avis" class="nav-item <?= isActive('/admin/avis') ?>">
            <span class="nav-icon">⭐</span> Avis
        </a>
        
    </div>

    <div class="sidebar__section">
        <p class="sidebar__section-label">Outils</p>
        <a href="/admin/chatbot" class="nav-item <?= isActive('/admin/chatbot') ?>">
            <span class="nav-icon">🤖</span> Chatbot
        </a>
    </div>

    <div class="sidebar__footer">
        <a href="/" class="nav-item">
            <span class="nav-icon">🌐</span> Voir le site
        </a>
        <a href="/admin/logout" class="nav-item" style="color:#f87171">
            <span class="nav-icon">🚪</span> Déconnexion
        </a>
    </div>
</aside>