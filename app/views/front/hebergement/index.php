<?php
$title            = 'Hébergements - BeninExplore';
$meta_description = 'Trouvez l\'hébergement idéal pour votre séjour au Bénin.';

$hebergements = $hebergements ?? [];
$villes       = $villes       ?? [];
$types        = $types        ?? [];
$filters      = $filters      ?? [];
$total        = $total        ?? 0;
$total_pages  = $total_pages  ?? 1;
$page         = $page         ?? 1;
$favorisIds   = $favorisIds   ?? [];
$prixRange    = $prixRange    ?? null;

// Construire l'URL de pagination
function pageUrl(int $p, array $filters): string {
    $q = $filters;
    $q['page'] = $p;
    return '/hebergements?' . http_build_query(array_filter($q, fn($v) => $v !== ''));
}

ob_start();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

:root {
    --green:  #008751;
    --green2: #00a862;
    --yellow: #FCD116;
    --red:    #E8112D;
    --surface:#F4F7F5;
    --card:   #ffffff;
    --border: #E8EDF0;
    --text:   #0f1923;
    --muted:  #6b7585;
    --radius: 16px;
    --shadow: 0 4px 20px rgba(0,0,0,.07);
}

.heb-page * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
.heb-page h1,.heb-page h2,.heb-page h3,.heb-page h4,.heb-page .fw-bold { font-family: 'Syne', sans-serif; }

.heb-page { background: var(--surface); min-height: 100vh; }

/* ── Hero ── */
.heb-hero {
    background: linear-gradient(120deg, rgba(0,15,8,.88) 0%, rgba(0,80,40,.65) 55%, rgba(0,0,0,.2) 100%),
                url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
    padding: 72px 0 52px;
}
.heb-hero h1 { font-family:'Syne',sans-serif; font-size:clamp(1.8rem,4vw,3rem); font-weight:800; color:#fff; margin-bottom:8px; }
.heb-hero p  { color:rgba(255,255,255,.65); font-size:.95rem; margin:0; }
.heb-hero-count {
    display: inline-flex; align-items:center; gap:8px;
    background: rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2);
    border-radius:50px; padding:6px 18px; font-size:.8rem;
    color:rgba(255,255,255,.8); margin-bottom:16px; backdrop-filter:blur(8px);
}

/* ── Barre filtres ── */
.filter-bar {
    background: #fff; border-bottom:1px solid var(--border);
    padding: 18px 0; position: sticky; top:0; z-index:100;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.filter-form { display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end; }
.filter-group { display:flex; flex-direction:column; gap:5px; }
.filter-label { font-family:'Syne',sans-serif; font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); }
.filter-input, .filter-select {
    border:1.5px solid var(--border); border-radius:10px;
    padding:9px 14px; font-size:.85rem; font-family:'DM Sans',sans-serif;
    background:#F7F8FA; color:var(--text); outline:none; transition:all .2s;
    height: 42px;
}
.filter-input:focus, .filter-select:focus { border-color:var(--green); background:#fff; box-shadow:0 0 0 3px rgba(0,135,81,.08); }
.filter-input { min-width:220px; }
.filter-select { min-width:150px; }
.filter-select-sm { min-width:120px; }

/* Prix range */
.price-range-wrap { display:flex; gap:8px; align-items:center; }
.price-input {
    width:110px; border:1.5px solid var(--border); border-radius:10px;
    padding:9px 12px; font-size:.82rem; background:#F7F8FA; height:42px;
    outline:none; transition:all .2s; font-family:'DM Sans',sans-serif;
}
.price-input:focus { border-color:var(--green); background:#fff; }
.price-sep { color:var(--muted); font-size:.8rem; flex-shrink:0; }

/* Boutons filtres */
.btn-filter {
    background:linear-gradient(135deg,var(--green),var(--green2));
    color:#fff; border:none; border-radius:10px;
    padding:0 22px; height:42px; font-family:'Syne',sans-serif;
    font-size:.82rem; font-weight:700; cursor:pointer; transition:all .25s;
    box-shadow:0 4px 12px rgba(0,135,81,.25); white-space:nowrap;
}
.btn-filter:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(0,135,81,.35); }
.btn-reset {
    background:transparent; border:1.5px solid var(--border);
    color:var(--muted); border-radius:10px; padding:0 16px; height:42px;
    font-size:.82rem; font-weight:600; cursor:pointer; transition:all .2s;
    text-decoration:none; display:flex; align-items:center; white-space:nowrap;
    font-family:'Syne',sans-serif;
}
.btn-reset:hover { border-color:var(--red); color:var(--red); }

/* Chips filtres actifs */
.active-filters { display:flex; gap:8px; flex-wrap:wrap; margin-top:12px; }
.filter-chip {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(0,135,81,.1); border:1px solid rgba(0,135,81,.2);
    color:var(--green); border-radius:50px; padding:4px 12px;
    font-size:.74rem; font-weight:600; font-family:'Syne',sans-serif;
}

/* ── Toolbar (résultats + tri) ── */
.results-toolbar {
    display:flex; justify-content:space-between; align-items:center;
    margin-bottom:24px; flex-wrap:wrap; gap:12px;
}
.results-count { font-size:.88rem; color:var(--muted); }
.results-count strong { color:var(--text); font-family:'Syne',sans-serif; }

.sort-select {
    border:1.5px solid var(--border); border-radius:50px;
    padding:7px 16px; font-size:.82rem; background:#fff;
    outline:none; cursor:pointer; transition:all .2s;
    font-family:'DM Sans',sans-serif; color:var(--text);
}
.sort-select:focus { border-color:var(--green); }

/* ── Cartes hébergements ── */
.heb-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:22px; }

.heb-card {
    background:var(--card); border-radius:var(--radius);
    overflow:hidden; box-shadow:var(--shadow);
    border:1px solid var(--border); transition:all .3s;
    display:flex; flex-direction:column;
}
.heb-card:hover { transform:translateY(-6px); box-shadow:0 16px 40px rgba(0,135,81,.12); border-color:rgba(0,135,81,.2); }

.heb-card-img {
    position:relative; height:210px; overflow:hidden; flex-shrink:0;
}
.heb-card-img img {
    width:100%; height:100%; object-fit:cover;
    transition:transform .4s ease;
}
.heb-card:hover .heb-card-img img { transform:scale(1.06); }

/* Badge type */
.heb-type-badge {
    position:absolute; top:12px; left:12px;
    background:rgba(0,0,0,.55); color:#fff; backdrop-filter:blur(6px);
    border-radius:50px; padding:4px 12px; font-size:.68rem; font-weight:700;
    letter-spacing:.04em; text-transform:uppercase;
}

/* Badge note */
.heb-note-badge {
    position:absolute; top:12px; right:50px;
    background:rgba(255,255,255,.95); color:var(--text);
    border-radius:50px; padding:4px 10px; font-size:.75rem; font-weight:700;
    box-shadow:0 2px 8px rgba(0,0,0,.12);
}
.heb-note-badge i { color:#f59e0b; font-size:.65rem; }

/* Bouton favori */
.heb-fav-btn {
    position:absolute; top:10px; right:10px;
    width:34px; height:34px; border-radius:50%;
    background:rgba(255,255,255,.92); border:none; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    font-size:.85rem; transition:all .2s;
    box-shadow:0 2px 8px rgba(0,0,0,.12); z-index:2;
}
.heb-fav-btn i { color:#ccc; transition:all .2s; }
.heb-fav-btn.actif i { color:var(--red); }
.heb-fav-btn:hover { transform:scale(1.12); }
.heb-fav-btn:hover i { color:var(--red); }

.heb-card-body { padding:18px; flex:1; display:flex; flex-direction:column; }
.heb-card-type { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--green); margin-bottom:4px; }
.heb-card-name { font-family:'Syne',sans-serif; font-size:1rem; font-weight:700; color:var(--text); margin-bottom:6px; line-height:1.3; }
.heb-card-loc  { font-size:.78rem; color:var(--muted); margin-bottom:10px; display:flex; align-items:center; gap:5px; }
.heb-card-loc i { color:var(--green); font-size:.7rem; }

/* Infos capacité */
.heb-card-meta { display:flex; gap:14px; margin-bottom:14px; }
.heb-meta-item { font-size:.73rem; color:var(--muted); display:flex; align-items:center; gap:4px; }
.heb-meta-item i { color:var(--green); font-size:.65rem; }

.heb-card-footer { display:flex; justify-content:space-between; align-items:center; margin-top:auto; padding-top:12px; border-top:1px solid var(--border); }
.heb-price { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:800; color:var(--green); }
.heb-price small { font-size:.7rem; font-weight:400; color:var(--muted); font-family:'DM Sans',sans-serif; }
.btn-voir {
    background:var(--green); color:#fff; border:none; border-radius:50px;
    padding:7px 18px; font-size:.78rem; font-weight:700; cursor:pointer;
    text-decoration:none; transition:all .2s; font-family:'Syne',sans-serif;
    display:inline-flex; align-items:center; gap:5px;
}
.btn-voir:hover { background:#005c37; color:#fff; transform:translateX(2px); }

/* ── État vide ── */
.empty-state {
    text-align:center; padding:60px 20px;
    background:var(--card); border-radius:var(--radius);
    border:1px solid var(--border);
}
.empty-state .empty-icon { font-size:3.5rem; margin-bottom:16px; opacity:.4; }
.empty-state h4 { font-family:'Syne',sans-serif; font-weight:700; color:var(--text); margin-bottom:8px; }
.empty-state p  { color:var(--muted); font-size:.88rem; }

/* ── Pagination ── */
.pagination-wrap { display:flex; justify-content:center; gap:6px; margin-top:40px; flex-wrap:wrap; }
.page-btn {
    min-width:38px; height:38px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-size:.82rem; font-weight:600; text-decoration:none;
    border:1.5px solid var(--border); color:var(--muted); background:#fff;
    transition:all .2s; font-family:'Syne',sans-serif;
}
.page-btn:hover { border-color:var(--green); color:var(--green); }
.page-btn.active { background:var(--green); border-color:var(--green); color:#fff; }
.page-btn.disabled { opacity:.4; pointer-events:none; }

@media (max-width:768px) {
    .filter-form { flex-direction:column; }
    .filter-input, .filter-select, .filter-select-sm { width:100%; min-width:unset; }
    .price-range-wrap { width:100%; }
    .price-input { flex:1; }
    .heb-grid { grid-template-columns:1fr; }
}
</style>

<div class="heb-page">

    <!-- Hero -->
    <div class="heb-hero">
        <div class="container">
            <div class="heb-hero-count">
                <i class="fas fa-hotel" style="color:var(--yellow)"></i>
                <?= $total ?> hébergement<?= $total > 1 ? 's' : '' ?> disponible<?= $total > 1 ? 's' : '' ?>
            </div>
            <h1>Où séjourner au Bénin ?</h1>
            <p>Hébergements vérifiés, prix transparents, réservation facile.</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filter-bar">
        <div class="container">
            <form method="GET" action="/hebergements" class="filter-form" id="filterForm">

                <!-- Recherche -->
                <div class="filter-group" style="flex:1;min-width:200px">
                    <div class="filter-label">Recherche</div>
                    <div style="position:relative">
                        <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#b0b8c4;font-size:.8rem"></i>
                        <input type="text" name="q" class="filter-input" style="padding-left:36px"
                               placeholder="Nom, description..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                    </div>
                </div>

                <!-- Ville -->
                <div class="filter-group">
                    <div class="filter-label">Ville</div>
                    <select name="ville" class="filter-select">
                        <option value="">Toutes les villes</option>
                        <?php foreach ($villes as $v): ?>
                        <option value="<?= $v->id ?>" <?= ($filters['ville_id'] ?? '') == $v->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($v->nom) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Type -->
                <div class="filter-group">
                    <div class="filter-label">Type</div>
                    <select name="type" class="filter-select filter-select-sm">
                        <option value="">Tous les types</option>
                        <?php foreach ($types as $t): ?>
                        <option value="<?= $t->id ?>" <?= ($filters['type_id'] ?? '') == $t->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t->nom) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Prix -->
                <div class="filter-group">
                    <div class="filter-label">Prix / nuit (FCFA)</div>
                    <div class="price-range-wrap">
                        <input type="number" name="prix_min" class="price-input"
                               placeholder="<?= $prixRange ? number_format($prixRange->min_prix, 0) : 'Min' ?>"
                               value="<?= htmlspecialchars($filters['prix_min'] ?? '') ?>" min="0" step="5000">
                        <span class="price-sep">—</span>
                        <input type="number" name="prix_max" class="price-input"
                               placeholder="<?= $prixRange ? number_format($prixRange->max_prix, 0) : 'Max' ?>"
                               value="<?= htmlspecialchars($filters['prix_max'] ?? '') ?>" min="0" step="5000">
                    </div>
                </div>

                <!-- Capacité -->
                <div class="filter-group">
                    <div class="filter-label">Personnes min.</div>
                    <select name="capacite" class="filter-select filter-select-sm">
                        <option value="">Toutes</option>
                        <?php foreach ([1,2,3,4,5,6,8,10] as $c): ?>
                        <option value="<?= $c ?>" <?= ($filters['capacite'] ?? '') == $c ? 'selected' : '' ?>>
                            <?= $c ?>+ pers.
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Boutons -->
                <div class="filter-group" style="justify-content:flex-end">
                    <div class="filter-label" style="opacity:0">.</div>
                    <div style="display:flex;gap:8px">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search me-1"></i> Filtrer
                        </button>
                        <a href="/hebergements" class="btn-reset">✕ Effacer</a>
                    </div>
                </div>

            </form>

            <!-- Chips filtres actifs -->
            <?php
            $hasFilters = !empty($filters['search']) || !empty($filters['ville_id']) || !empty($filters['type_id'])
                       || !empty($filters['prix_min']) || !empty($filters['prix_max']) || !empty($filters['capacite']);
            ?>
            <?php if ($hasFilters): ?>
            <div class="active-filters">
                <?php if (!empty($filters['search'])): ?>
                <span class="filter-chip">🔍 <?= htmlspecialchars($filters['search']) ?></span>
                <?php endif; ?>
                <?php if (!empty($filters['prix_min']) || !empty($filters['prix_max'])): ?>
                <span class="filter-chip">💰
                    <?= !empty($filters['prix_min']) ? number_format($filters['prix_min'], 0, ',', ' ') . ' FCFA' : '' ?>
                    <?= (!empty($filters['prix_min']) && !empty($filters['prix_max'])) ? ' — ' : '' ?>
                    <?= !empty($filters['prix_max']) ? number_format($filters['prix_max'], 0, ',', ' ') . ' FCFA' : '' ?>
                </span>
                <?php endif; ?>
                <?php if (!empty($filters['capacite'])): ?>
                <span class="filter-chip">👥 <?= $filters['capacite'] ?>+ personnes</span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container py-4">

        <!-- Toolbar -->
        <div class="results-toolbar">
            <div class="results-count">
                <strong><?= $total ?></strong> hébergement<?= $total > 1 ? 's' : '' ?> trouvé<?= $total > 1 ? 's' : '' ?>
                <?php if ($total_pages > 1): ?>
                · Page <strong><?= $page ?></strong> / <?= $total_pages ?>
                <?php endif; ?>
            </div>
            <select class="sort-select" onchange="applySort(this.value)">
                <option value="note"      <?= ($filters['tri'] ?? 'note') === 'note'      ? 'selected' : '' ?>>⭐ Mieux notés</option>
                <option value="prix_asc"  <?= ($filters['tri'] ?? '') === 'prix_asc'  ? 'selected' : '' ?>>💰 Prix croissant</option>
                <option value="prix_desc" <?= ($filters['tri'] ?? '') === 'prix_desc' ? 'selected' : '' ?>>💰 Prix décroissant</option>
                <option value="recent"    <?= ($filters['tri'] ?? '') === 'recent'    ? 'selected' : '' ?>>🆕 Plus récents</option>
                <option value="nom"       <?= ($filters['tri'] ?? '') === 'nom'       ? 'selected' : '' ?>>🔤 Alphabétique</option>
            </select>
        </div>

        <!-- Grille -->
        <?php if (empty($hebergements)): ?>
        <div class="empty-state">
            <div class="empty-icon">🏨</div>
            <h4>Aucun hébergement trouvé</h4>
            <p>Essayez de modifier vos critères de recherche.</p>
            <a href="/hebergements" class="btn-filter" style="display:inline-flex;margin-top:16px;text-decoration:none">
                Voir tous les hébergements
            </a>
        </div>
        <?php else: ?>

        <div class="heb-grid">
            <?php foreach ($hebergements as $heb): ?>
            <?php
            $photoUrl = !empty($heb->photo) ? htmlspecialchars($heb->photo) : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80';
            $isFav    = in_array($heb->id, $favorisIds);
            ?>
            <div class="heb-card">
                <div class="heb-card-img">
                    <img src="<?= $photoUrl ?>" alt="<?= htmlspecialchars($heb->nom) ?>"
                         onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80'">

                    <?php if (!empty($heb->type_nom)): ?>
                    <span class="heb-type-badge"><?= htmlspecialchars($heb->type_nom) ?></span>
                    <?php endif; ?>

                    <?php if ($heb->note_moyenne > 0): ?>
                    <span class="heb-note-badge">
                        <i class="fas fa-star"></i> <?= number_format($heb->note_moyenne, 1) ?>
                    </span>
                    <?php endif; ?>

                    <!-- Bouton favori -->
                    <?php if (!empty($_SESSION['user_id'])): ?>
                    <form method="POST" action="/favori/toggle/<?= $heb->id ?>" class="favori-form-card" data-id="<?= $heb->id ?>">
                        <button type="submit" class="heb-fav-btn <?= $isFav ? 'actif' : '' ?>" title="<?= $isFav ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>">
                            <i class="<?= $isFav ? 'fas' : 'far' ?> fa-heart"></i>
                        </button>
                    </form>
                    <?php else: ?>
                    <a href="/login" class="heb-fav-btn" title="Connectez-vous pour ajouter aux favoris">
                        <i class="far fa-heart"></i>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="heb-card-body">
                    <?php if (!empty($heb->type_nom)): ?>
                    <div class="heb-card-type"><?= htmlspecialchars($heb->type_nom) ?></div>
                    <?php endif; ?>

                    <div class="heb-card-name"><?= htmlspecialchars($heb->nom) ?></div>

                    <div class="heb-card-loc">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= htmlspecialchars($heb->ville_nom) ?>
                    </div>

                    <!-- Capacité, chambres, lits -->
                    <div class="heb-card-meta">
                        <?php if ($heb->capacite): ?>
                        <span class="heb-meta-item"><i class="fas fa-users"></i> <?= $heb->capacite ?> pers.</span>
                        <?php endif; ?>
                        <?php if ($heb->chambres): ?>
                        <span class="heb-meta-item"><i class="fas fa-door-open"></i> <?= $heb->chambres ?> ch.</span>
                        <?php endif; ?>
                        <?php if ($heb->lits): ?>
                        <span class="heb-meta-item"><i class="fas fa-bed"></i> <?= $heb->lits ?> lit(s)</span>
                        <?php endif; ?>
                    </div>

                    <div class="heb-card-footer">
                        <div class="heb-price">
                            <?= number_format($heb->prix_nuit_base, 0, ',', ' ') ?> FCFA
                            <small>/nuit</small>
                        </div>
                        <a href="/hebergement/<?= $heb->id ?>" class="btn-voir">
                            Voir <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination-wrap">
            <?php if ($page > 1): ?>
            <a href="<?= pageUrl($page - 1, $filters) ?>" class="page-btn">
                <i class="fas fa-chevron-left"></i>
            </a>
            <?php endif; ?>

            <?php
            $start = max(1, $page - 2);
            $end   = min($total_pages, $page + 2);
            if ($start > 1): ?>
            <a href="<?= pageUrl(1, $filters) ?>" class="page-btn">1</a>
            <?php if ($start > 2): ?><span class="page-btn disabled">…</span><?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
            <a href="<?= pageUrl($i, $filters) ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>

            <?php if ($end < $total_pages): ?>
            <?php if ($end < $total_pages - 1): ?><span class="page-btn disabled">…</span><?php endif; ?>
            <a href="<?= pageUrl($total_pages, $filters) ?>" class="page-btn"><?= $total_pages ?></a>
            <?php endif; ?>

            <?php if ($page < $total_pages): ?>
            <a href="<?= pageUrl($page + 1, $filters) ?>" class="page-btn">
                <i class="fas fa-chevron-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</div>

<script>
// Tri — soumettre le formulaire avec le tri sélectionné
function applySort(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('tri', val);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

// Toggle favori AJAX sur les cartes
document.querySelectorAll('.favori-form-card').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn  = this.querySelector('.heb-fav-btn');
        const icon = btn.querySelector('i');
        fetch(this.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.redirect) { window.location.href = data.redirect; return; }
            if (data.actif) {
                btn.classList.add('actif');
                icon.className = 'fas fa-heart';
            } else {
                btn.classList.remove('actif');
                icon.className = 'far fa-heart';
            }
        })
        .catch(() => this.submit());
    });
});
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>