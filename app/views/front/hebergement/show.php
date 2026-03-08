<?php 
$title = $hebergement->nom . ' - BeninExplore';
ob_start(); 
?>

<section class="py-4 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/hebergements" class="text-decoration-none">Hébergements</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($hebergement->nom) ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <!-- Galerie photos -->
        <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="main-img-container shadow-sm">
                    <?php if ($photoPrincipale): ?>
                        <img src="<?= htmlspecialchars($photoPrincipale->url) ?>" 
                             alt="<?= htmlspecialchars($hebergement->nom) ?>" 
                             class="img-fluid rounded-4 w-100 h-100 object-fit-cover">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80" 
                             alt="Image par défaut" class="img-fluid rounded-4 w-100 h-100 object-fit-cover">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row g-3 h-100">
                    <?php 
                    $count = 0;
                    foreach ($photosSecondaires as $photo): 
                        if ($count >= 3) break;
                    ?>
                    <div class="col-6 col-lg-<?= $count < 2 ? '12' : '6' ?> h-50">
                        <img src="<?= htmlspecialchars($photo->url) ?>" 
                             alt="Photo secondaire" class="img-fluid rounded-4 w-100 h-100 object-fit-cover shadow-sm">
                    </div>
                    <?php 
                        $count++;
                    endforeach; 
                    
                    // Si pas assez de photos secondaires, on complète avec des placeholders
                    for ($i = $count; $i < 3; $i++): 
                    ?>
                    <div class="col-6 col-lg-<?= $i < 2 ? '12' : '6' ?> h-50">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80" 
                             alt="Image par défaut" class="img-fluid rounded-4 w-100 h-100 object-fit-cover shadow-sm">
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="fw-bold mb-2"><?= htmlspecialchars($hebergement->nom) ?></h1>
                        <p class="text-muted">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <?= htmlspecialchars($hebergement->adresse) ?>, <?= htmlspecialchars($hebergement->ville_nom) ?>, Bénin
                        </p>
                        <?php if ($hebergement->note_moyenne > 0): ?>
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-warning">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <i class="fas fa-star<?= $i <= round($hebergement->note_moyenne) ? '' : '-o' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-muted small">(<?= $statsAvis->total_avis ?? 0 ?> avis)</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 me-2">
                            <i class="far fa-heart me-2"></i>Favoris
                        </button>
                    </div>
                </div>

                <hr class="my-4">

                <h3 class="fw-bold h5 mb-3">À propos de cet hébergement</h3>
                <p class="text-secondary leading-relaxed">
                    <?= nl2br(htmlspecialchars($hebergement->description)) ?>
                </p>

                <h3 class="fw-bold h5 mt-5 mb-3">Équipements</h3>
                <div class="row g-3">
                    <?php 
                    $equipements = json_decode($hebergement->equipements ?? '[]', true);
                    if (!empty($equipements)):
                        foreach($equipements as $item): 
                    ?>
                    <div class="col-6 col-md-4">
                        <div class="d-flex align-items-center gap-3 p-3 border rounded-3">
                            <i class="fas fa-check-circle text-green fs-5"></i>
                            <span class="small fw-medium"><?= ucfirst($item) ?></span>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else:
                    ?>
                    <div class="col-12">
                        <p class="text-muted">Aucun équipement spécifié.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($avis)): ?>
                <hr class="my-4">
                <h3 class="fw-bold h5 mb-3">Avis des voyageurs</h3>
                <div class="row g-4">
                    <?php foreach ($avis as $a): ?>
                    <div class="col-12">
                        <div class="bg-light p-3 rounded-3">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="fw-bold"><?= htmlspecialchars($a->prenom . ' ' . $a->nom) ?></div>
                                <div class="text-warning small">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="fas fa-star<?= $i <= $a->note_globale ? '' : '-o' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="text-muted small mb-0"><?= nl2br(htmlspecialchars($a->commentaire_public)) ?></p>
                            <small class="text-muted d-block mt-2">
                                <?= date('d/m/Y', strtotime($a->date_creation)) ?>
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 100px; z-index: 10;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <span class="fs-3 fw-bold text-benin"><?= number_format($hebergement->prix_nuit_base, 0, ',', ' ') ?> FCFA</span>
                                <small class="text-muted">/nuit</small>
                            </div>
                            <span class="badge bg-soft-green text-green px-3 py-2">Disponible</span>
                        </div>

                        <form method="GET" action="/hebergement/<?= $hebergement->id ?>/reserver">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Dates de séjour</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="far fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control bg-light border-0" placeholder="Arrivée - Départ" id="dateRange" name="dates">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Voyageurs</label>
                                <select class="form-select bg-light border-0" name="voyageurs">
                                    <option value="1">1 Adulte</option>
                                    <option value="2" selected>2 Adultes</option>
                                    <option value="3">3 Adultes</option>
                                    <option value="4">4 Adultes</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-benin w-100 py-3 fw-bold rounded-pill">
                                Réserver maintenant <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                        <p class="text-center text-muted small mt-3 mb-0">Aucun frais de réservation</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hébergements similaires -->
        <?php if (!empty($similaires)): ?>
        <hr class="my-5">
        <h3 class="fw-bold h4 mb-4">Hébergements similaires</h3>
        <div class="row g-4">
            <?php foreach ($similaires as $sim): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="<?= $sim->photo ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80' ?>" 
                         class="card-img-top" alt="<?= htmlspecialchars($sim->nom) ?>"
                         style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold small"><?= htmlspecialchars($sim->nom) ?></h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt text-benin me-1"></i>
                            <?= htmlspecialchars($sim->ville_nom) ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-benin"><?= number_format($sim->prix_nuit_base, 0, ',', ' ') ?> FCFA</span>
                            <a href="/hebergement/<?= $sim->id ?>" class="btn btn-sm btn-outline-benin">Voir</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Date Range Picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#dateRange", {
        mode: "range",
        locale: "fr",
        minDate: "today",
        dateFormat: "Y-m-d",
        defaultDate: ["today", new Date().fp_incr(3)]
    });
});
</script>

<style>
.main-img-container { height: 500px; }
.bg-soft-green { background-color: rgba(0, 135, 81, 0.1); }
.text-green { color: #008751; }
.btn-benin { background-color: #008751; color: white; border: none; }
.btn-benin:hover { background-color: #005c37; color: white; }
.btn-outline-benin { border-color: #008751; color: #008751; }
.btn-outline-benin:hover { background-color: #008751; color: white; }
.object-fit-cover { object-fit: cover; }
.leading-relaxed { line-height: 1.8; }
@media (max-width: 991px) {
    .main-img-container { height: 350px; }
    .h-50 { height: 180px !important; }
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>