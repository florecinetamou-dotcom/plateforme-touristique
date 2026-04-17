<?php
/**
 * Logique de traitement et Helpers
 */
$title = 'Sites touristiques - BeninExplore';
$meta_description = 'Découvrez tous les sites touristiques du Bénin et planifiez votre prochaine aventure culturelle.';
$meta_keywords = 'sites touristiques Bénin, voyage Bénin, tourisme Bénin, Ouidah, Ganvié, Pendjari';

// Protection et récupération des filtres
$searchValue = htmlspecialchars($filters['search'] ?? '', ENT_QUOTES, 'UTF-8');
$currentCategorie = $filters['categorie'] ?? '';
$currentVille = $filters['ville'] ?? '';

/**
 * Retourne une image par défaut selon la catégorie
 */
function getDefaultImageByCategory(?string $category): string {
    $base = "https://images.unsplash.com/";
    $images = [
        'historique' => $base . "photo-1590608897129-79da3d22b0c2?auto=format&fit=crop&w=800&q=80",
        'nature'     => $base . "photo-1500614922032-b6dd337b1313?auto=format&fit=crop&w=800&q=80",
        'culture'    => $base . "photo-1523805081446-99395ebbf92f?auto=format&fit=crop&w=800&q=80",
        'default'    => $base . "photo-1590608897129-79da3d22b0c2?auto=format&fit=crop&w=800&q=80"
    ];
    return $images[$category] ?? $images['default'];
}

ob_start();
?>

<style>
    :root { --benin-green: #008751; --benin-green-dark: #006b3f; }
    .btn-benin { background-color: var(--benin-green); color: white; border: none; transition: 0.2s; }
    .btn-benin:hover { background-color: var(--benin-green-dark); color: white; }
    .btn-outline-benin { border: 2px solid var(--benin-green); color: var(--benin-green); background: transparent; }
    .btn-outline-benin:hover { background-color: var(--benin-green); color: white; }
    .text-benin { color: var(--benin-green); }
    
    .hover-card { transition: all 0.3s cubic-bezier(.25,.8,.25,1); border-radius: 12px !important; }
    .hover-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    
    .card-img-wrapper { height: 220px; overflow: hidden; position: relative; }
    .card-img-top { transition: transform 0.5s ease; object-fit: cover; }
    .card:hover .card-img-top { transform: scale(1.1); }
    
    .badge-category { position: absolute; top: 15px; right: 15px; backdrop-filter: blur(4px); }
    .pagination .page-link { color: var(--benin-green); border: none; margin: 0 3px; border-radius: 8px; }
    .pagination .page-item.active .page-link { background-color: var(--benin-green); }
</style>

<div class="bg-light py-4 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Accueil</a></li>
                <li class="breadcrumb-item active text-benin fw-bold" aria-current="page">Sites touristiques</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <h1 class="h2 fw-bold mb-1">Explorer le Bénin</h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-map-marked-alt text-benin me-2"></i>
                    <strong><?= number_format($totalSites ?? count($sites)) ?></strong> destinations incroyables
                </p>
            </div>
            <?php if (!empty($currentCategorie) || !empty($currentVille) || !empty($searchValue)): ?>
                <a href="/sites" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="fas fa-times-circle me-1"></i> Effacer les filtres
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<section class="py-4 shadow-sm bg-white sticky-top" style="top: 0; z-index: 1020;">
    <div class="container">
        <form method="GET" action="/sites" id="filterForm" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="categorie" class="form-label small fw-bold">Catégorie</label>
                <select name="categorie" id="categorie" class="form-select border-0 bg-light" onchange="this.form.submit()">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $key => $label): ?>
                        <option value="<?= htmlspecialchars($key) ?>" <?= $currentCategorie == $key ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="ville" class="form-label small fw-bold">Localisation</label>
                <select name="ville" id="ville" class="form-select border-0 bg-light" onchange="this.form.submit()">
                    <option value="">Tout le pays</option>
                    <?php foreach ($villes as $ville): ?>
                        <option value="<?= (int) $ville->id ?>" <?= $currentVille == $ville->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ville->nom) ?> <?= isset($ville->nb_sites) ? "({$ville->nb_sites})" : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="search" class="form-label small fw-bold">Recherche libre</label>
                <div class="input-group">
                    <span class="input-group-text border-0 bg-light"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-0 bg-light" 
                           placeholder="Ex: Palais de Porto-Novo..." value="<?= $searchValue ?>">
                </div>
            </div>
        </form>
    </div>
</section>

<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <?php if (empty($sites)): ?>
            <div class="text-center py-5">
                <img src="/assets/img/empty-state.svg" alt="Aucun résultat" style="width: 200px;" class="mb-4 opacity-50">
                <h3 class="fw-bold text-muted">Oups ! Aucun trésor trouvé.</h3>
                <p>Essayez d'élargir votre recherche ou de changer de ville.</p>
                <a href="/sites" class="btn btn-benin px-4 rounded-pill mt-3">Voir tous les sites</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($sites as $site): 
<<<<<<< HEAD
                    // ✅ CORRECTION : Suppression de filter_var pour accepter les chemins locaux
                    $imageUrl = !empty($site->photo_url) 
=======
                    $imageUrl = (!empty($site->photo_url) && filter_var($site->photo_url, FILTER_VALIDATE_URL)) 
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                                ? htmlspecialchars($site->photo_url) 
                                : getDefaultImageByCategory($site->categorie ?? null);
                ?>
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-img-wrapper">
                                <img src="<?= $imageUrl ?>" class="card-img-top h-100 w-100" 
                                     alt="<?= htmlspecialchars($site->nom) ?>" loading="lazy"
                                     onerror="this.src='<?= getDefaultImageByCategory('default') ?>'">
                                
                                <?php if (!empty($site->categorie)): ?>
                                    <span class="badge badge-category bg-benin px-3 py-2 rounded-pill shadow-sm">
                                        <?= htmlspecialchars($categories[$site->categorie] ?? $site->categorie) ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="card-body d-flex flex-column p-4">
                                <div class="mb-2">
                                    <i class="fas fa-map-marker-alt text-benin me-1"></i>
                                    <span class="small text-muted fw-bold"><?= htmlspecialchars($site->ville_nom ?? 'Bénin') ?></span>
                                </div>
                                
                                <h2 class="h5 card-title fw-bold mb-3">
                                    <a href="/site/<?= (int) $site->id ?>" class="text-dark text-decoration-none stretched-link">
                                        <?= htmlspecialchars($site->nom) ?>
                                    </a>
                                </h2>

                                <p class="card-text text-muted small mb-4">
                                    <?= htmlspecialchars(mb_strimwidth(strip_tags($site->description ?? ''), 0, 110, "...")) ?>
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center border-top pt-3">
                                    <span class="text-benin fw-bold small">Découvrir <i class="fas fa-chevron-right ms-1"></i></span>
                                    <?php if (!empty($site->prix_visite)): ?>
                                        <span class="badge bg-light text-dark border fw-normal">
                                            <?= number_format($site->prix_visite, 0, ',', ' ') ?> FCFA
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center border-0">
                        <li class="page-item <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link shadow-sm" href="?<?= http_build_query(array_merge($filters, ['page' => $pagination['current_page'] - 1])) ?>">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </li>
                        <?php 
<<<<<<< HEAD
=======
                        // Affichage intelligent des pages (ex: 1, 2, 3...)
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
                        for ($i = 1; $i <= $pagination['total_pages']; $i++): 
                            if ($i == 1 || $i == $pagination['total_pages'] || abs($i - $pagination['current_page']) <= 2): ?>
                                <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                    <a class="page-link shadow-sm" href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>"><?= $i ?></a>
                                </li>
                            <?php elseif ($i == 2 || $i == $pagination['total_pages'] - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <li class="page-item <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : '' ?>">
                            <a class="page-link shadow-sm" href="?<?= http_build_query(array_merge($filters, ['page' => $pagination['current_page'] + 1])) ?>">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<script>
<<<<<<< HEAD
=======
    // Debounce pour la recherche pour éviter de recharger à chaque lettre
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    let timeout = null;
    const searchInput = document.getElementById('search');
    
    searchInput?.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            this.form.submit();
        }, 600);
    });

<<<<<<< HEAD
=======
    // Replacer le curseur à la fin du texte après le rechargement (si besoin d'AJAX plus tard)
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    if (searchInput && searchInput.value !== "") {
        searchInput.focus();
        const val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;
    }
</script>

<?php
$content = ob_get_clean();

<<<<<<< HEAD
=======
// Gestion propre de l'affichage
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
$headerPath = dirname(__DIR__, 2) . '/layout/header.php';
$footerPath = dirname(__DIR__, 2) . '/layout/footer.php';

if (file_exists($headerPath)) {
    include $headerPath;
}

<<<<<<< HEAD
echo $content;
=======
echo $content; // Un seul echo ici !
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc

if (file_exists($footerPath)) {
    include $footerPath;
}
?>