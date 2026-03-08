<?php
$current_page = $_SERVER['REQUEST_URI'];
$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['user_role'] ?? null;
$user_name = $_SESSION['user_name'] ?? 'Mon compte';

// Fonction helper pour les liens actifs
function isActive(string $path, string $current): string {
    if ($path === '/') return $current === '/' ? 'active' : '';
    return strpos($current, $path) === 0 ? 'active' : '';
}
?>

<nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <div class="brand-icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <span class="brand-text">Benin<span class="brand-accent">Explore</span></span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Menu">
            <span class="toggler-bar"></span>
            <span class="toggler-bar"></span>
            <span class="toggler-bar"></span>
        </button>

        <!-- Navigation -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= isActive('/', $current_page) ?>" href="/">
                        <i class="fas fa-home me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= isActive('/hebergements', $current_page) ?>" href="/hebergements">
                        <i class="fas fa-bed me-1"></i>Hébergements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= isActive('/villes', $current_page) ?>" href="/villes">
                        <i class="fas fa-city me-1"></i>Villes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= isActive('/sites', $current_page) ?>" href="/sites">
                        <i class="fas fa-landmark me-1"></i>Sites
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= isActive('/about', $current_page) ?>" href="/about">
                        <i class="fas fa-info-circle me-1"></i>À propos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= isActive('/contact', $current_page) ?>" href="/contact">
                        <i class="fas fa-envelope me-1"></i>Contact
                    </a>
                </li>
            </ul>

            <!-- Menu utilisateur -->
            <div class="d-flex align-items-center gap-2">
                <?php if ($user_id): ?>
                    <div class="dropdown">
                        <button class="btn btn-user dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <?= strtoupper(substr($user_name, 0, 1)) ?>
                            </div>
                            <span class="user-name d-none d-xl-inline"><?= htmlspecialchars($user_name) ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end user-dropdown shadow">
                            <!-- En-tête du dropdown -->
                            <li class="dropdown-header">
                                <div class="d-flex align-items-center gap-2 py-1">
                                    <div class="user-avatar-lg">
                                        <?= strtoupper(substr($user_name, 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($user_name) ?></div>
                                        <div class="small text-muted"><?= ucfirst($user_role ?? 'Visiteur') ?></div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>

                            <li>
                                <a class="dropdown-item" href="/profile">
                                    <i class="fas fa-user me-2"></i>Mon profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/reservations">
                                    <i class="fas fa-calendar-check me-2"></i>Mes réservations
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/favoris">
                                    <i class="fas fa-heart me-2"></i>Mes favoris
                                </a>
                            </li>

                            <?php if ($user_role === 'hebergeur'): ?>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item item-special" href="/hebergeur/dashboard">
                                        <i class="fas fa-hotel me-2"></i>Espace hébergeur
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if ($user_role === 'admin'): ?>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item item-admin" href="/admin">
                                        <i class="fas fa-tachometer-alt me-2"></i>Administration
                                    </a>
                                </li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <a class="dropdown-item item-danger" href="/logout">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="/login" class="btn btn-nav-outline">
                        <i class="fas fa-sign-in-alt me-1"></i>Connexion
                    </a>
                    <a href="/register" class="btn btn-nav-solid">
                        <i class="fas fa-user-plus me-1"></i>Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<style>
/* ===== NAVBAR ===== */
#mainNavbar {
    background: rgba(255, 255, 255, 0.97);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(0, 135, 81, 0.1);
    padding: 10px 0;
    transition: box-shadow 0.3s ease;
}
#mainNavbar.scrolled {
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
}

/* ===== LOGO ===== */
.brand-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #008751, #00a862);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    box-shadow: 0 3px 10px rgba(0,135,81,0.3);
}
.brand-text {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a2e;
    letter-spacing: -0.3px;
}
.brand-accent {
    color: #008751;
}

/* ===== LIENS DE NAVIGATION ===== */
.nav-link {
    color: #444 !important;
    font-size: 0.88rem;
    font-weight: 500;
    padding: 8px 14px !important;
    border-radius: 8px;
    transition: all 0.2s ease;
    position: relative;
}
.nav-link:hover {
    color: #008751 !important;
    background: rgba(0, 135, 81, 0.07);
}
.nav-link.active {
    color: #008751 !important;
    background: rgba(0, 135, 81, 0.1);
    font-weight: 600;
}
.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%);
    width: 18px;
    height: 2.5px;
    background: linear-gradient(90deg, #008751, #FFD600);
    border-radius: 2px;
}

/* ===== BOUTONS AUTH ===== */
.btn-nav-outline {
    border: 1.5px solid #008751;
    color: #008751;
    background: transparent;
    border-radius: 50px;
    padding: 7px 18px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.25s ease;
}
.btn-nav-outline:hover {
    background: #008751;
    color: white;
    box-shadow: 0 4px 12px rgba(0,135,81,0.25);
}
.btn-nav-solid {
    background: linear-gradient(135deg, #008751, #00a862);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 7px 18px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.25s ease;
    box-shadow: 0 3px 10px rgba(0,135,81,0.25);
}
.btn-nav-solid:hover {
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0,135,81,0.35);
    filter: brightness(1.05);
}

/* ===== BOUTON UTILISATEUR ===== */
.btn-user {
    background: transparent;
    border: 1.5px solid rgba(0,135,81,0.25);
    border-radius: 50px;
    padding: 5px 14px 5px 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    color: #333;
    font-size: 0.85rem;
    font-weight: 500;
}
.btn-user:hover, .btn-user:focus {
    background: rgba(0,135,81,0.06);
    border-color: #008751;
    color: #008751;
    box-shadow: none;
}
.user-avatar {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #008751, #FFD600);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}
.user-avatar-lg {
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, #008751, #FFD600);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    font-weight: 700;
    flex-shrink: 0;
}

/* ===== DROPDOWN ===== */
.user-dropdown {
    border: none;
    border-radius: 14px;
    padding: 8px;
    min-width: 220px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12) !important;
    margin-top: 8px !important;
    animation: dropdownFadeIn 0.2s ease;
}
@keyframes dropdownFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.dropdown-header {
    padding: 6px 10px 10px;
    color: inherit;
}
.dropdown-divider {
    border-color: #f0f0f0;
}
.dropdown-item {
    border-radius: 8px;
    padding: 9px 14px;
    font-size: 0.875rem;
    color: #333;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
}
.dropdown-item i {
    color: #008751;
    width: 16px;
    text-align: center;
}
.dropdown-item:hover {
    background: rgba(0,135,81,0.08);
    color: #008751;
    transform: translateX(3px);
}
.dropdown-item.item-special {
    color: #008751;
    font-weight: 500;
}
.dropdown-item.item-admin {
    color: #0d6efd;
    font-weight: 600;
}
.dropdown-item.item-admin i { color: #0d6efd; }
.dropdown-item.item-admin:hover { background: rgba(13,110,253,0.08); color: #0d6efd; }
.dropdown-item.item-danger { color: #dc3545; }
.dropdown-item.item-danger i { color: #dc3545; }
.dropdown-item.item-danger:hover { background: rgba(220,53,69,0.08); color: #dc3545; }

/* ===== TOGGLER MOBILE ===== */
.navbar-toggler {
    border: none;
    padding: 6px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    background: transparent;
}
.navbar-toggler:focus { box-shadow: none; }
.toggler-bar {
    display: block;
    width: 24px;
    height: 2px;
    background: #008751;
    border-radius: 2px;
    transition: all 0.3s ease;
}

/* ===== MOBILE ===== */
@media (max-width: 991px) {
    .navbar-collapse {
        background: white;
        border-radius: 14px;
        padding: 12px;
        margin-top: 10px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    .nav-link {
        padding: 10px 14px !important;
    }
    .navbar-nav {
        gap: 2px !important;
        margin-bottom: 12px;
    }
    .d-flex.align-items-center.gap-2 {
        flex-direction: column;
        width: 100%;
    }
    .btn-nav-outline, .btn-nav-solid {
        width: 100%;
        text-align: center;
        justify-content: center;
    }
}
</style>

<script>
// Effet ombre navbar au scroll
window.addEventListener('scroll', function () {
    const navbar = document.getElementById('mainNavbar');
    navbar.classList.toggle('scrolled', window.scrollY > 10);
});
</script>