<?php 
$title = 'Mes hébergements - BeninExplore'; 
ob_start(); 
?>

<style>
    /* Couleurs officielles du Bénin */
    :root {
        --benin-green: #008751;
        --benin-yellow: #FFD600;
        --benin-green-light: rgba(0, 135, 81, 0.1);
        --benin-yellow-light: rgba(255, 214, 0, 0.1);
        --benin-gradient: linear-gradient(135deg, var(--benin-green) 0%, var(--benin-yellow) 100%);
    }

    .heb-page { 
        background-color: #f0f7f3; 
        min-height: 100vh; 
        font-family: 'Poppins', sans-serif;
    }
    
    .heb-card {
        border: none;
        border-radius: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        position: relative;
    }

    .heb-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,135,81,0.15) !important;
    }

    .heb-card-img-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .heb-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .heb-card:hover .heb-card-img-wrap img {
        transform: scale(1.1);
    }

    /* Badges de statut */
    .status-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        z-index: 2;
        backdrop-filter: blur(4px);
    }
    .status-approuve { 
        background: var(--benin-green); 
        color: white; 
    }
    .status-en_attente { 
        background: var(--benin-yellow); 
        color: #000; 
    }
    .status-refuse { 
        background: #dc3545; 
        color: white; 
    }

    /* Prix */
    .heb-price {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--benin-green);
        line-height: 1;
    }
    
    .heb-price small {
        font-size: 0.7rem;
        font-weight: 400;
        color: #888;
    }

    /* Boutons */
    .btn-benin {
        background: var(--benin-green);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(0,135,81,0.2);
    }
    .btn-benin:hover {
        background: #006b40;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,135,81,0.3);
    }

    .btn-outline-benin {
        border: 2px solid var(--benin-green);
        color: var(--benin-green);
        background: transparent;
        border-radius: 12px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    .btn-outline-benin:hover {
        background: var(--benin-green);
        color: white;
        transform: translateY(-2px);
    }

    .btn-action {
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: none;
    }
    .btn-action-primary {
        background: var(--benin-green-light);
        color: var(--benin-green);
    }
    .btn-action-primary:hover {
        background: var(--benin-green);
        color: white;
    }
    .btn-action-danger {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    .btn-action-danger:hover {
        background: #dc3545;
        color: white;
    }

    /* Titre page */
    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        position: relative;
        display: inline-block;
    }
    .page-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--benin-gradient);
        border-radius: 4px;
    }

    /* État vide */
    .empty-state {
        text-align: center;
        padding: 60px 40px;
        background: white;
        border-radius: 24px;
        border: 2px dashed rgba(0,135,81,0.2);
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }
    .empty-state h4 {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .empty-state p {
        color: #64748b;
        margin-bottom: 20px;
    }

    /* Info bulle */
    .info-tooltip {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255,255,255,0.9);
        border-radius: 50px;
        padding: 4px 12px;
        font-size: 0.7rem;
        font-weight: 600;
        color: #64748b;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        backdrop-filter: blur(4px);
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .info-tooltip i {
        color: var(--benin-green);
        font-size: 0.6rem;
    }
</style>

<div class="container-fluid py-4 heb-page">
    <div class="row">
        <!-- Sidebar hébergeur -->
        <div class="col-lg-3 col-md-4 mb-4">
            <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
        </div>

        <!-- Contenu principal -->
        <div class="col-lg-9 col-md-8">
            <!-- En-tête de page -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
                <div>
                    <h1 class="page-title">Mes hébergements</h1>
                    <p class="text-muted small mt-3 mb-0">
                        Gérez vos biens et suivez leur statut de validation
                    </p>
                </div>
                <a href="/hebergeur/hebergements/ajouter" class="btn-benin">
                    <i class="fas fa-plus-circle me-2"></i>Nouvel hébergement
                </a>
            </div>

            <?php if (!empty($hebergements)): ?>
                <!-- Statistiques rapides -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="bg-white p-3 rounded-4 shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 p-2 me-2" style="background: var(--benin-green-light);">
                                    <i class="fas fa-check-circle" style="color: var(--benin-green);"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Actifs</small>
                                    <span class="h5 fw-bold mb-0" style="color: var(--benin-green);">
                                        <?= array_reduce($hebergements, fn($c, $h) => $c + ($h->statut === 'approuve' ? 1 : 0), 0) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white p-3 rounded-4 shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 p-2 me-2" style="background: var(--benin-yellow-light);">
                                    <i class="fas fa-clock" style="color: var(--benin-yellow);"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">En attente</small>
                                    <span class="h5 fw-bold mb-0" style="color: var(--benin-yellow);">
                                        <?= array_reduce($hebergements, fn($c, $h) => $c + ($h->statut === 'en_attente' ? 1 : 0), 0) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white p-3 rounded-4 shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 p-2 me-2" style="background: rgba(220,53,69,0.1);">
                                    <i class="fas fa-times-circle" style="color: #dc3545;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Refusés</small>
                                    <span class="h5 fw-bold mb-0" style="color: #dc3545;">
                                        <?= array_reduce($hebergements, fn($c, $h) => $c + ($h->statut === 'refuse' ? 1 : 0), 0) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grille des hébergements -->
                <div class="row g-4">
                    <?php foreach ($hebergements as $heb): ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="heb-card shadow-sm">
                                <div class="heb-card-img-wrap">
                                    <?php
                                        $photoUrl = !empty($heb->photo) ? $heb->photo : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80';
                                        if (!empty($heb->photo) && strpos($photoUrl, 'http') !== 0) {
                                            $photoUrl = '/' . ltrim($photoUrl, '/');
                                        }
                                    ?>
                                    <img src="<?= htmlspecialchars($photoUrl) ?>" 
                                         alt="<?= htmlspecialchars($heb->nom) ?>" 
                                         onerror="this.src='https://via.placeholder.com/400x300?text=Image+non+disponible'">
                                    
                                    <!-- Badge statut -->
                                    <span class="status-badge status-<?= $heb->statut ?>">
                                        <?php if ($heb->statut === 'approuve'): ?>
                                            <i class="fas fa-check-circle me-1"></i> Publié
                                        <?php elseif ($heb->statut === 'en_attente'): ?>
                                            <i class="fas fa-clock me-1"></i> En révision
                                        <?php else: ?>
                                            <i class="fas fa-times-circle me-1"></i> Non validé
                                        <?php endif; ?>
                                    </span>

                                    <!-- Info supplémentaire -->
                                    <?php if ($heb->statut === 'en_attente'): ?>
                                        <div class="info-tooltip">
                                            <i class="fas fa-info-circle"></i>
                                            En attente de validation
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body p-3">
                                    <!-- Titre et localisation -->
                                    <h5 class="card-title fw-bold text-truncate mb-1" title="<?= htmlspecialchars($heb->nom) ?>">
                                        <?= htmlspecialchars($heb->nom) ?>
                                    </h5>
                                    <p class="text-muted small mb-3">
                                        <i class="fas fa-map-marker-alt me-1" style="color: var(--benin-green);"></i>
                                        <?= htmlspecialchars($heb->ville_nom ?? 'Bénin') ?>
                                    </p>

                                    <!-- Prix et note -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="heb-price">
                                            <?= number_format($heb->prix_nuit_base, 0, ',', ' ') ?> 
                                            <small>/nuit</small>
                                        </div>
                                        <?php if ($heb->note_moyenne > 0): ?>
                                            <span class="badge bg-dark">
                                                <i class="fas fa-star text-warning me-1" style="font-size: 0.7rem;"></i>
                                                <?= number_format($heb->note_moyenne, 1) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Actions -->
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="/hebergeur/hebergements/edit/<?= $heb->id ?>" 
                                           class="btn-action btn-action-primary flex-grow-1">
                                            <i class="fas fa-edit"></i>
                                            <span>Modifier</span>
                                        </a>
                                        <form method="POST" action="/hebergeur/hebergements/delete/<?= $heb->id ?>" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet hébergement ? Cette action est irréversible.')" 
                                              class="m-0">
                                            <button type="submit" class="btn-action btn-action-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- État vide -->
                <div class="empty-state shadow-sm">
                    <div class="mb-4">
                        <i class="fas fa-home" style="font-size: 4rem; color: rgba(0,135,81,0.2);"></i>
                    </div>
                    <h4>Bienvenue dans l'espace hébergeur</h4>
                    <p class="text-muted mb-4">
                        Commencez par ajouter votre premier hébergement pour le proposer aux voyageurs du monde entier.
                    </p>
                    <a href="/hebergeur/hebergements/ajouter" class="btn-benin">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter un hébergement
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>