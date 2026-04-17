<?php
$title    = $hebergement->nom . ' - BeninExplore';
$isFavori = $isFavori ?? false;
$defaultImg = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80';
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

.show-page * { font-family:'DM Sans',sans-serif; box-sizing:border-box; }
.show-page h1,.show-page h2,.show-page h3,.show-page h4,.show-page .fw-bold { font-family:'Syne',sans-serif; }
.show-page { background:var(--surface); }

/* ── Breadcrumb ── */
.show-breadcrumb {
    background:#fff; border-bottom:1px solid var(--border);
    padding:12px 0;
}
.show-breadcrumb ol { margin:0; }
.show-breadcrumb a { color:var(--green); text-decoration:none; font-size:.82rem; }
.show-breadcrumb .active { color:var(--muted); font-size:.82rem; }

/* ══════════════════════════════════
   GALERIE
══════════════════════════════════ */
.gallery-section { background:#fff; padding:0; }

.gallery-main {
    position:relative; overflow:hidden; cursor:pointer;
    background:#0f1923;
}
.gallery-main img {
    width:100%; height:480px; object-fit:cover;
    transition:transform .4s ease; display:block;
}
.gallery-main:hover img { transform:scale(1.02); }

/* Bouton voir toutes les photos */
.gallery-all-btn {
    position:absolute; bottom:16px; right:16px;
    background:rgba(255,255,255,.95); color:var(--text);
    border:none; border-radius:10px; padding:9px 18px;
    font-family:'Syne',sans-serif; font-size:.78rem; font-weight:700;
    cursor:pointer; transition:all .2s;
    display:flex; align-items:center; gap:7px;
    box-shadow:0 4px 14px rgba(0,0,0,.15);
}
.gallery-all-btn:hover { background:#fff; transform:translateY(-2px); }

/* Thumbnails */
.gallery-thumbs {
    display:grid; grid-template-columns:repeat(4,1fr); gap:3px;
    background:#fff;
}
.gallery-thumb {
    aspect-ratio:4/3; overflow:hidden; cursor:pointer; position:relative;
}
.gallery-thumb img {
    width:100%; height:100%; object-fit:cover;
    transition:all .3s; filter:brightness(.9);
}
.gallery-thumb:hover img { filter:brightness(1); transform:scale(1.04); }
.gallery-thumb.active img { filter:brightness(1); outline:3px solid var(--green); outline-offset:-3px; }

/* Lightbox */
.lightbox {
    position:fixed; inset:0; background:rgba(0,0,0,.92); z-index:9999;
    display:none; align-items:center; justify-content:center;
    padding:20px;
}
.lightbox.open { display:flex; }
.lightbox img { max-width:90vw; max-height:88vh; border-radius:12px; object-fit:contain; }
.lightbox-close {
    position:fixed; top:20px; right:24px;
    background:rgba(255,255,255,.1); border:none; color:#fff;
    width:42px; height:42px; border-radius:50%; font-size:1.1rem;
    cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition:background .2s;
}
.lightbox-close:hover { background:rgba(255,255,255,.2); }
.lightbox-nav {
    position:fixed; top:50%; transform:translateY(-50%);
    background:rgba(255,255,255,.1); border:none; color:#fff;
    width:46px; height:46px; border-radius:50%; font-size:1.1rem;
    cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition:background .2s;
}
.lightbox-nav:hover { background:rgba(255,255,255,.25); }
.lightbox-prev { left:16px; }
.lightbox-next { right:16px; }

/* ══════════════════════════════════
   CONTENU
══════════════════════════════════ */
.show-content { padding:32px 0 60px; }

/* ── Header hébergement ── */
.heb-header { margin-bottom:24px; }
.heb-tag {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(0,135,81,.1); color:var(--green);
    border:1px solid rgba(0,135,81,.2); border-radius:50px;
    padding:4px 14px; font-size:.72rem; font-weight:700;
    letter-spacing:.04em; text-transform:uppercase; margin-bottom:10px;
}
.heb-title { font-size:clamp(1.5rem,3vw,2.2rem); font-weight:800; color:var(--text); margin-bottom:8px; line-height:1.2; }
.heb-location { color:var(--muted); font-size:.9rem; margin-bottom:12px; display:flex; align-items:center; gap:6px; }
.heb-location i { color:var(--red); }

.heb-meta-row { display:flex; flex-wrap:wrap; gap:16px; align-items:center; margin-bottom:16px; }
.heb-meta-item { display:flex; align-items:center; gap:6px; font-size:.82rem; color:var(--muted); }
.heb-meta-item i { color:var(--green); width:14px; text-align:center; }
.heb-meta-item strong { color:var(--text); }

/* Note */
.heb-rating { display:flex; align-items:center; gap:8px; }
.stars-row { color:#f59e0b; font-size:.85rem; display:flex; gap:2px; }
.rating-score { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:800; color:var(--text); }
.rating-count { font-size:.78rem; color:var(--muted); }

/* Bouton favori */
.btn-favori-toggle {
    display:inline-flex; align-items:center; gap:7px;
    border:1.5px solid var(--border); background:#fff;
    color:var(--muted); border-radius:50px; padding:8px 18px;
    font-size:.82rem; font-weight:600; cursor:pointer;
    transition:all .2s; font-family:'Syne',sans-serif;
}
.btn-favori-toggle:hover { border-color:var(--red); color:var(--red); }
.btn-favori-toggle.actif { border-color:var(--red); color:var(--red); background:rgba(232,17,45,.05); }

/* ── Sections contenu ── */
.content-section {
    background:var(--card); border-radius:var(--radius);
    border:1px solid var(--border); padding:24px 28px;
    margin-bottom:20px; box-shadow:var(--shadow);
}
.section-title {
    font-family:'Syne',sans-serif; font-size:1rem; font-weight:700;
    color:var(--text); margin-bottom:16px; padding-bottom:12px;
    border-bottom:1px solid var(--surface); display:flex; align-items:center; gap:8px;
}
.section-title i { color:var(--green); }

/* Description */
.heb-description { font-size:.9rem; color:#444; line-height:1.85; }

/* Équipements */
.equipements-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:10px; }
.equip-item {
    display:flex; align-items:center; gap:10px;
    background:var(--surface); border-radius:10px; padding:10px 14px;
    font-size:.82rem; color:var(--text); border:1px solid var(--border);
}
.equip-item i { color:var(--green); font-size:.85rem; width:16px; text-align:center; }

/* Avis */
.avis-header { display:flex; align-items:center; gap:16px; margin-bottom:20px; }
.avis-score-big {
    background:linear-gradient(135deg,var(--green),var(--green2));
    color:#fff; border-radius:14px; padding:16px 20px;
    text-align:center; min-width:80px; flex-shrink:0;
}
.avis-score-big .score { font-family:'Syne',sans-serif; font-size:2.2rem; font-weight:800; line-height:1; }
.avis-score-big .score-label { font-size:.68rem; opacity:.8; margin-top:4px; }
.avis-info { flex:1; }
.avis-stars-big { color:#f59e0b; font-size:1rem; margin-bottom:4px; }
.avis-count-text { font-size:.82rem; color:var(--muted); }

.avis-card {
    background:var(--surface); border-radius:12px; padding:16px 18px;
    border:1px solid var(--border); margin-bottom:12px;
}
.avis-card:last-child { margin-bottom:0; }
.avis-card-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px; }
.avis-author { display:flex; align-items:center; gap:10px; }
.avis-avatar {
    width:36px; height:36px; border-radius:50%;
    background:linear-gradient(135deg,var(--green),var(--green2));
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-weight:700; font-size:.85rem; flex-shrink:0;
}
.avis-name { font-weight:700; font-size:.85rem; color:var(--text); }
.avis-date { font-size:.72rem; color:var(--muted); }
.avis-stars { color:#f59e0b; font-size:.75rem; }
.avis-text { font-size:.85rem; color:#555; line-height:1.7; }

/* ── Carte réservation (sticky) ── */
.booking-card {
    background:var(--card); border-radius:var(--radius);
    border:1px solid var(--border); box-shadow:0 8px 32px rgba(0,0,0,.1);
    overflow:hidden; position:sticky; top:20px;
}
.booking-header {
    background:linear-gradient(135deg,#0f1923,#1a2d20);
    padding:20px 22px;
}
.booking-price { font-family:'Syne',sans-serif; font-size:1.9rem; font-weight:800; color:#fff; line-height:1; }
.booking-price small { font-size:.75rem; font-weight:400; color:rgba(255,255,255,.6); font-family:'DM Sans',sans-serif; }
.booking-badge {
    background:rgba(0,201,122,.15); color:#4ade80;
    border:1px solid rgba(0,201,122,.3); border-radius:50px;
    padding:4px 12px; font-size:.7rem; font-weight:700; font-family:'Syne',sans-serif;
}
.booking-body { padding:20px 22px; }
.booking-label { font-family:'Syne',sans-serif; font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:6px; display:block; }
.booking-input {
    width:100%; border:1.5px solid var(--border); border-radius:10px;
    padding:10px 14px; font-size:.88rem; font-family:'DM Sans',sans-serif;
    background:var(--surface); color:var(--text); outline:none; transition:all .2s;
}
.booking-input:focus { border-color:var(--green); background:#fff; box-shadow:0 0 0 3px rgba(0,135,81,.08); }
.btn-book {
    width:100%; background:linear-gradient(135deg,var(--green),var(--green2));
    color:#fff; border:none; border-radius:12px; padding:14px;
    font-family:'Syne',sans-serif; font-size:.92rem; font-weight:700;
    cursor:pointer; transition:all .3s; margin-top:6px;
    box-shadow:0 6px 20px rgba(0,135,81,.3);
    display:flex; align-items:center; justify-content:center; gap:8px;
}
.btn-book:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(0,135,81,.4); }

.booking-infos { padding:14px 22px; border-top:1px solid var(--border); }
.booking-info-row { display:flex; align-items:center; gap:8px; font-size:.78rem; color:var(--muted); margin-bottom:6px; }
.booking-info-row:last-child { margin-bottom:0; }
.booking-info-row i { color:var(--green); width:14px; text-align:center; }

/* ── Similaires ── */
.sim-card {
    background:var(--card); border-radius:14px; overflow:hidden;
    border:1px solid var(--border); box-shadow:var(--shadow);
    transition:all .25s; text-decoration:none; display:block; color:inherit;
}
.sim-card:hover { transform:translateY(-4px); box-shadow:0 12px 30px rgba(0,135,81,.12); }
.sim-img { width:100%; height:160px; object-fit:cover; }
.sim-body { padding:14px; }
.sim-name { font-family:'Syne',sans-serif; font-size:.9rem; font-weight:700; color:var(--text); margin-bottom:4px; }
.sim-loc { font-size:.75rem; color:var(--muted); margin-bottom:10px; display:flex; align-items:center; gap:5px; }
.sim-loc i { color:var(--green); font-size:.65rem; }
.sim-footer { display:flex; justify-content:space-between; align-items:center; }
.sim-price { font-family:'Syne',sans-serif; font-size:.95rem; font-weight:800; color:var(--green); }
.sim-price small { font-size:.65rem; font-weight:400; color:var(--muted); }
.btn-sim {
    background:var(--green); color:#fff; border-radius:50px;
    padding:5px 14px; font-size:.72rem; font-weight:700;
    text-decoration:none; transition:all .2s; font-family:'Syne',sans-serif;
}
.btn-sim:hover { background:#005c37; color:#fff; }

@media (max-width:991px) {
    .gallery-main img { height:320px; }
    .gallery-thumbs { grid-template-columns:repeat(4,1fr); }
}
@media (max-width:576px) {
    .gallery-main img { height:240px; }
    .gallery-thumbs { grid-template-columns:repeat(4,1fr); gap:2px; }
    .content-section { padding:18px; }
    .equipements-grid { grid-template-columns:1fr 1fr; }
}
</style>

<!-- Breadcrumb -->
<div class="show-breadcrumb">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/">Accueil</a></li>
            <li class="breadcrumb-item"><a href="/hebergements">Hébergements</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($hebergement->nom) ?></li>
        </ol>
    </div>
</div>

<!-- Galerie -->
<div class="gallery-section">
    <?php
    $allPhotos = [];
    if ($photoPrincipale) $allPhotos[] = $photoPrincipale->url;
    foreach ($photosSecondaires as $p) $allPhotos[] = $p->url;
    if (empty($allPhotos)) $allPhotos[] = $defaultImg;
    ?>

    <!-- Photo principale -->
    <div class="gallery-main" onclick="openLightbox(0)">
        <img src="<?= htmlspecialchars($allPhotos[0]) ?>" alt="<?= htmlspecialchars($hebergement->nom) ?>" id="mainGalleryImg">
        <?php if (count($allPhotos) > 1): ?>
        <button class="gallery-all-btn" onclick="event.stopPropagation();openLightbox(0)">
            <i class="fas fa-th-large"></i> Voir <?= count($allPhotos) ?> photo<?= count($allPhotos) > 1 ? 's' : '' ?>
        </button>
        <?php endif; ?>
    </div>

    <!-- Thumbnails -->
    <?php if (count($allPhotos) > 1): ?>
    <div class="gallery-thumbs">
        <?php foreach (array_slice($allPhotos, 0, 4) as $i => $url): ?>
        <div class="gallery-thumb <?= $i === 0 ? 'active' : '' ?>" onclick="setMainPhoto(<?= $i ?>)">
            <img src="<?= htmlspecialchars($url) ?>" alt="Photo <?= $i + 1 ?>">
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="fas fa-times"></i></button>
    <button class="lightbox-nav lightbox-prev" onclick="event.stopPropagation();navLightbox(-1)"><i class="fas fa-chevron-left"></i></button>
    <img src="" alt="" id="lightboxImg" onclick="event.stopPropagation()">
    <button class="lightbox-nav lightbox-next" onclick="event.stopPropagation();navLightbox(1)"><i class="fas fa-chevron-right"></i></button>
</div>

<!-- Contenu principal -->
<div class="show-page show-content">
<div class="container">
<div class="row g-4">

    <!-- ── Colonne gauche ── -->
    <div class="col-lg-8">

        <!-- Header -->
        <div class="heb-header">
            <?php if (!empty($hebergement->type_nom)): ?>
            <div class="heb-tag"><i class="fas fa-tag"></i> <?= htmlspecialchars($hebergement->type_nom) ?></div>
            <?php endif; ?>

            <h1 class="heb-title"><?= htmlspecialchars($hebergement->nom) ?></h1>

            <div class="heb-location">
                <i class="fas fa-map-marker-alt"></i>
                <?= htmlspecialchars($hebergement->adresse ?? '') ?>
                <?= !empty($hebergement->adresse) ? ', ' : '' ?>
                <?= htmlspecialchars($hebergement->ville_nom) ?>, Bénin
            </div>

            <div class="heb-meta-row">
                <?php if ($hebergement->capacite): ?>
                <div class="heb-meta-item"><i class="fas fa-users"></i><strong><?= $hebergement->capacite ?></strong> personnes</div>
                <?php endif; ?>
                <?php if ($hebergement->chambres): ?>
                <div class="heb-meta-item"><i class="fas fa-door-open"></i><strong><?= $hebergement->chambres ?></strong> chambre<?= $hebergement->chambres > 1 ? 's' : '' ?></div>
                <?php endif; ?>
                <?php if ($hebergement->lits): ?>
                <div class="heb-meta-item"><i class="fas fa-bed"></i><strong><?= $hebergement->lits ?></strong> lit<?= $hebergement->lits > 1 ? 's' : '' ?></div>
                <?php endif; ?>
                <?php if ($hebergement->salles_de_bain): ?>
                <div class="heb-meta-item"><i class="fas fa-bath"></i><strong><?= $hebergement->salles_de_bain ?></strong> salle<?= $hebergement->salles_de_bain > 1 ? 's' : '' ?> de bain</div>
                <?php endif; ?>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <?php if ($hebergement->note_moyenne > 0): ?>
                <div class="heb-rating">
                    <div class="stars-row">
                        <?php for($i=1;$i<=5;$i++): ?>
                        <i class="fas fa-star<?= $i <= round($hebergement->note_moyenne) ? '' : '-o' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-score"><?= number_format($hebergement->note_moyenne, 1) ?></span>
                    <span class="rating-count">(<?= $statsAvis->total_avis ?? 0 ?> avis)</span>
                </div>
                <?php endif; ?>

                <!-- Favori -->
                <?php if (!empty($_SESSION['user_id'])): ?>
                <form method="POST" action="/favori/toggle/<?= $hebergement->id ?>" class="favori-form" data-id="<?= $hebergement->id ?>">
                    <button type="submit" class="btn-favori-toggle <?= $isFavori ? 'actif' : '' ?>">
                        <i class="<?= $isFavori ? 'fas' : 'far' ?> fa-heart"></i>
                        <span><?= $isFavori ? 'Sauvegardé' : 'Sauvegarder' ?></span>
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Description -->
        <?php if (!empty($hebergement->description)): ?>
        <div class="content-section">
            <div class="section-title"><i class="fas fa-info-circle"></i> À propos</div>
            <p class="heb-description"><?= nl2br(htmlspecialchars($hebergement->description)) ?></p>
        </div>
        <?php endif; ?>

        <!-- Équipements -->
        <?php
        $equipements = json_decode($hebergement->equipements ?? '[]', true);
        if (!empty($equipements)):
        ?>
        <div class="content-section">
            <div class="section-title"><i class="fas fa-concierge-bell"></i> Équipements</div>
            <div class="equipements-grid">
                <?php foreach ($equipements as $item): ?>
                <div class="equip-item">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars(ucfirst($item)) ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Avis -->
        <?php if (!empty($avis)): ?>
        <div class="content-section">
            <div class="section-title"><i class="fas fa-star"></i> Avis des voyageurs</div>

            <?php if ($hebergement->note_moyenne > 0): ?>
            <div class="avis-header">
                <div class="avis-score-big">
                    <div class="score"><?= number_format($hebergement->note_moyenne, 1) ?></div>
                    <div class="score-label">sur 5</div>
                </div>
                <div class="avis-info">
                    <div class="avis-stars-big">
                        <?php for($i=1;$i<=5;$i++): ?>
                        <i class="fas fa-star<?= $i <= round($hebergement->note_moyenne) ? '' : '-o' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <div class="avis-count-text"><?= $statsAvis->total_avis ?? 0 ?> avis de voyageurs</div>
                </div>
            </div>
            <?php endif; ?>

            <?php foreach ($avis as $a): ?>
            <div class="avis-card">
                <div class="avis-card-header">
                    <div class="avis-author">
                        <div class="avis-avatar"><?= strtoupper(substr($a->prenom ?? 'V', 0, 1)) ?></div>
                        <div>
                            <div class="avis-name"><?= htmlspecialchars($a->prenom . ' ' . substr($a->nom, 0, 1) . '.') ?></div>
                            <div class="avis-date"><?= date('d/m/Y', strtotime($a->date_creation)) ?></div>
                        </div>
                    </div>
                    <div class="avis-stars">
                        <?php for($i=1;$i<=5;$i++): ?>
                        <i class="fas fa-star<?= $i <= $a->note_globale ? '' : '-o' ?>"></i>
                        <?php endfor; ?>
                    </div>
                </div>
                <p class="avis-text"><?= nl2br(htmlspecialchars($a->commentaire_public)) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>

    <!-- ── Colonne droite : réservation ── -->
    <div class="col-lg-4">
        <div class="booking-card">
            <div class="booking-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="booking-price">
                        <?= number_format($hebergement->prix_nuit_base, 0, ',', ' ') ?> FCFA
                        <small>/nuit</small>
                    </div>
                    <span class="booking-badge">✅ Disponible</span>
                </div>
                <?php if ($hebergement->note_moyenne > 0): ?>
                <div style="color:rgba(255,255,255,.6);font-size:.75rem">
                    <i class="fas fa-star" style="color:#f59e0b"></i>
                    <?= number_format($hebergement->note_moyenne, 1) ?> · <?= $statsAvis->total_avis ?? 0 ?> avis
                </div>
                <?php endif; ?>
            </div>

            <div class="booking-body">
                <form method="GET" action="/hebergement/<?= $hebergement->id ?>/reserver">
                    <div class="mb-3">
                        <span class="booking-label">Dates de séjour</span>
                        <div style="position:relative">
                            <i class="far fa-calendar-alt" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#b0b8c4;font-size:.85rem"></i>
                            <input type="text" class="booking-input" style="padding-left:38px"
                                   placeholder="Arrivée — Départ" id="dateRange" name="dates">
                        </div>
                    </div>
                    <div class="mb-4">
                        <span class="booking-label">Voyageurs</span>
                        <select class="booking-input" name="voyageurs">
                            <?php for($i=1; $i<=min(10,$hebergement->capacite ?? 10); $i++): ?>
                            <option value="<?= $i ?>" <?= $i === 2 ? 'selected' : '' ?>>
                                <?= $i ?> Adulte<?= $i > 1 ? 's' : '' ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-book">
                        <i class="fas fa-calendar-check"></i>
                        Réserver maintenant
                    </button>
                </form>
            </div>

            <div class="booking-infos">
                <div class="booking-info-row"><i class="fas fa-shield-alt"></i> Paiement 100% sécurisé</div>
                <div class="booking-info-row"><i class="fas fa-ban"></i> Annulation gratuite</div>
                <div class="booking-info-row"><i class="fas fa-headset"></i> Support disponible 24h/7j</div>
            </div>
        </div>
    </div>

</div>

<!-- Hébergements similaires -->
<?php if (!empty($similaires)): ?>
<div style="margin-top:48px">
    <h3 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:700;color:var(--text);margin-bottom:20px">
        Hébergements similaires
    </h3>
    <div class="row g-3">
        <?php foreach ($similaires as $sim): ?>
        <div class="col-md-4">
            <a href="/hebergement/<?= $sim->id ?>" class="sim-card">
                <img src="<?= htmlspecialchars($sim->photo ?? $defaultImg) ?>"
                     alt="<?= htmlspecialchars($sim->nom) ?>" class="sim-img"
                     onerror="this.src='<?= $defaultImg ?>'">
                <div class="sim-body">
                    <div class="sim-name"><?= htmlspecialchars($sim->nom) ?></div>
                    <div class="sim-loc">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= htmlspecialchars($sim->ville_nom) ?>
                    </div>
                    <div class="sim-footer">
                        <div class="sim-price">
                            <?= number_format($sim->prix_nuit_base, 0, ',', ' ') ?> FCFA
                            <small>/nuit</small>
                        </div>
                        <span class="btn-sim">Voir →</span>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

</div><!-- /container -->
</div><!-- /show-page -->

<!-- Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>

<script>
// ── Photos ──
const allPhotos = <?= json_encode($allPhotos) ?>;
let currentIdx = 0;

function setMainPhoto(idx) {
    currentIdx = idx;
    document.getElementById('mainGalleryImg').src = allPhotos[idx];
    document.querySelectorAll('.gallery-thumb').forEach((t,i) => t.classList.toggle('active', i === idx));
}

function openLightbox(idx) {
    currentIdx = idx;
    document.getElementById('lightboxImg').src = allPhotos[idx];
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}

function navLightbox(dir) {
    currentIdx = (currentIdx + dir + allPhotos.length) % allPhotos.length;
    document.getElementById('lightboxImg').src = allPhotos[currentIdx];
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') navLightbox(1);
    if (e.key === 'ArrowLeft')  navLightbox(-1);
});

// ── Flatpickr ──
document.addEventListener('DOMContentLoaded', () => {
    flatpickr("#dateRange", {
        mode: "range", locale: "fr", minDate: "today",
        dateFormat: "Y-m-d",
        defaultDate: ["today", new Date(Date.now() + 3*864e5)]
    });

    // ── Favori AJAX ──
    document.querySelector('.favori-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        fetch(this.action, { method:'POST', headers:{'X-Requested-With':'XMLHttpRequest'} })
        .then(r => r.json())
        .then(data => {
            if (data.redirect) { location.href = data.redirect; return; }
            const btn  = this.querySelector('.btn-favori-toggle');
            const icon = btn.querySelector('i');
            const text = btn.querySelector('span');
            if (data.actif) {
                btn.classList.add('actif');
                icon.className = 'fas fa-heart';
                text.textContent = 'Sauvegardé';
            } else {
                btn.classList.remove('actif');
                icon.className = 'far fa-heart';
                text.textContent = 'Sauvegarder';
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