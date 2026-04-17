<?php
$title = 'Mes favoris - BeninExplore';
ob_start();
?>

<!-- Bannière -->
<div class="bg-light py-3 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 fw-bold mb-0">
                    <i class="fas fa-heart text-danger me-2"></i>Mes favoris
                </h1>
                <p class="text-muted small mb-0"><?= count($favoris) ?> hébergement<?= count($favoris) > 1 ? 's' : '' ?> sauvegardé<?= count($favoris) > 1 ? 's' : '' ?></p>
            </div>
            <a href="/hebergements" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fas fa-search me-1"></i> Explorer
            </a>
        </div>
    </div>
</div>

<section class="py-4">
    <div class="container">

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); endif; ?>

        <?php if (empty($favoris)): ?>
        <!-- État vide -->
        <div class="text-center py-5">
            <div class="mb-4" style="font-size:4rem">🏨</div>
            <h4 class="fw-bold mb-2">Aucun favori pour le moment</h4>
            <p class="text-muted mb-4">Explorez nos hébergements et cliquez sur ❤️ pour les sauvegarder ici.</p>
            <a href="/hebergements" class="btn btn-benin rounded-pill px-4">
                <i class="fas fa-search me-2"></i>Explorer les hébergements
            </a>
        </div>

        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($favoris as $heb): ?>
            <div class="col-md-6 col-lg-4" id="favori-card-<?= $heb->id ?>">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden hover-card">

                    <!-- Image -->
                    <div style="position:relative;height:200px;overflow:hidden">
                        <img src="<?= $heb->photo ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80' ?>"
                             class="w-100 h-100"
                             style="object-fit:cover;transition:transform .4s"
                             alt="<?= htmlspecialchars($heb->nom) ?>">

                        <!-- Bouton retirer favori -->
                        <form method="POST" action="/favori/toggle/<?= $heb->id ?>"
                              class="favori-form" data-id="<?= $heb->id ?>">
                            <button type="submit"
                                    class="btn-favori actif"
                                    title="Retirer des favoris">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>

                        <!-- Badge statut -->
                        <?php if ($heb->statut === 'approuve'): ?>
                        <span style="position:absolute;bottom:10px;left:10px;background:rgba(0,135,81,.9);color:#fff;font-size:.68rem;font-weight:700;padding:3px 10px;border-radius:50px">
                            ✅ Disponible
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="card-body p-3">
                        <h5 class="fw-bold mb-1 text-truncate"><?= htmlspecialchars($heb->nom) ?></h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt text-benin me-1"></i>
                            <?= htmlspecialchars($heb->ville_nom ?? 'Bénin') ?>
                        </p>

                        <!-- Infos capacité -->
                        <div class="d-flex gap-3 mb-3 text-muted" style="font-size:.78rem">
                            <?php if ($heb->chambres): ?>
                            <span><i class="fas fa-door-open me-1"></i><?= $heb->chambres ?> ch.</span>
                            <?php endif; ?>
                            <?php if ($heb->capacite): ?>
                            <span><i class="fas fa-users me-1"></i><?= $heb->capacite ?> pers.</span>
                            <?php endif; ?>
                            <?php if ($heb->lits): ?>
                            <span><i class="fas fa-bed me-1"></i><?= $heb->lits ?> lit(s)</span>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-benin" style="font-size:1.1rem">
                                    <?= number_format($heb->prix_nuit_base, 0, ',', ' ') ?> FCFA
                                </span>
                                <small class="text-muted">/nuit</small>
                            </div>
                            <a href="/hebergement/<?= $heb->id ?>" class="btn btn-outline-benin btn-sm rounded-pill px-3">
                                Voir <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>

                        <!-- Date d'ajout -->
                        <p class="text-muted mt-2 mb-0" style="font-size:.72rem">
                            <i class="far fa-clock me-1"></i>
                            Ajouté le <?= date('d/m/Y', strtotime($heb->date_ajout)) ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<style>
.btn-benin { background-color: #008751; color: white; border: none; }
.btn-benin:hover { background-color: #005c37; color: white; }
.btn-outline-benin { border-color: #008751; color: #008751; }
.btn-outline-benin:hover { background-color: #008751; color: white; }
.text-benin { color: #008751; }
.hover-card { transition: transform .25s, box-shadow .25s; }
.hover-card:hover { transform: translateY(-6px); box-shadow: 0 12px 28px rgba(0,135,81,.15) !important; }
.hover-card:hover img { transform: scale(1.06); }

/* Bouton favori */
.btn-favori {
    position: absolute; top: 10px; right: 10px;
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.95);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; z-index: 2;
    transition: all .2s;
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
}
.btn-favori i { color: #ccc; transition: all .2s; }
.btn-favori.actif i { color: #e8112d; }
.btn-favori:hover { transform: scale(1.15); }
</style>

<script>
document.querySelectorAll('.favori-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const id   = this.dataset.id;
        const btn  = this.querySelector('.btn-favori');
        const card = document.getElementById('favori-card-' + id);

        fetch(this.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.redirect) { window.location.href = data.redirect; return; }
            if (data.success && !data.actif) {
                // Retirer la carte avec animation
                card.style.transition = 'opacity .4s, transform .4s';
                card.style.opacity    = '0';
                card.style.transform  = 'scale(.9)';
                setTimeout(() => {
                    card.remove();
                    // Mettre à jour le compteur
                    const remaining = document.querySelectorAll('[id^="favori-card-"]').length;
                    const subtitle  = document.querySelector('.text-muted.small.mb-0');
                    if (subtitle) {
                        subtitle.textContent = remaining + ' hébergement' + (remaining > 1 ? 's' : '') + ' sauvegardé' + (remaining > 1 ? 's' : '');
                    }
                    if (remaining === 0) location.reload();
                }, 400);
            }
        })
        .catch(() => form.submit());
    });
});
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>