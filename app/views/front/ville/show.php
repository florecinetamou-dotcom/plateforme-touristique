<?php 
$title = $ville->nom . ' - BeninExplore';
ob_start(); 
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- ══════════════════════════════════════════
     HERO VILLE
══════════════════════════════════════════ -->
<section class="vhero">
    <div class="vhero__bg">
        <img 
            src="<?= !empty($ville->photo_url) ? htmlspecialchars($ville->photo_url) : 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?q=80&w=1800&auto=format&fit=crop' ?>" 
            alt="<?= htmlspecialchars($ville->nom) ?>"
        />
        <div class="vhero__layer"></div>
    </div>

    <!-- Fil d'ariane -->
    <div class="vhero__breadcrumb">
        <a href="/">Accueil</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        <a href="/villes">Destinations</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        <span><?= htmlspecialchars($ville->nom) ?></span>
    </div>

    <div class="vhero__content">
        <div class="vhero__tag">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Bénin
        </div>
        <h1 class="vhero__title"><?= htmlspecialchars($ville->nom) ?></h1>
        <?php if (!empty($ville->description)): ?>
        <p class="vhero__desc"><?= htmlspecialchars(mb_substr($ville->description, 0, 160)) ?>…</p>
        <?php endif; ?>

        <!-- Stats rapides dans le hero -->
        <div class="vhero__stats">
            <div class="vhero__stat">
                <strong><?= count($hebergements) ?></strong>
                <span>Hébergements</span>
            </div>
            <div class="vhero__stat-sep"></div>
            <div class="vhero__stat">
                <strong><?= count($sites) ?></strong>
                <span>Sites touristiques</span>
            </div>
            <?php if (!empty($ville->latitude)): ?>
            <div class="vhero__stat-sep"></div>
            <div class="vhero__stat">
                <strong>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#FFD600" stroke="#FFD600" stroke-width="1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/></svg>
                </strong>
                <span>Géolocalisée</span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Drapeau -->
    <div class="flag-bar">
        <div style="background:#008751;flex:1"></div>
        <div style="background:#FFD600;flex:1"></div>
        <div style="background:#E8112D;flex:1"></div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     CONTENU PRINCIPAL
══════════════════════════════════════════ -->
<div class="vpage">

    <!-- ── HÉBERGEMENTS ───────────────────── -->
    <section class="vsection">
        <div class="vsection__head">
            <div>
                <p class="label-tag">Où dormir</p>
                <h2 class="vsection__title">Hébergements à <span><?= htmlspecialchars($ville->nom) ?></span></h2>
            </div>
            <?php if (!empty($hebergements)): ?>
            <a href="/hebergements?ville=<?= $ville->id ?>" class="vsee-all">
                Voir tout
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <?php endif; ?>
        </div>

        <?php if (empty($hebergements)): ?>
        <div class="vempty">
            <div class="vempty__icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <h3>Aucun hébergement disponible</h3>
            <p>Soyez le premier à proposer un hébergement dans cette ville.</p>
            <a href="/hebergements" class="vbtn vbtn--outline">Voir tous les hébergements</a>
        </div>

        <?php else: ?>
        <div class="heb-grid">
            <?php foreach ($hebergements as $heb): 
                $photo = $heb->photo ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=900&auto=format&fit=crop';
            ?>
            <a href="/hebergement/<?= $heb->id ?>" class="hcard">
                <div class="hcard__img">
                    <img src="<?= htmlspecialchars($photo) ?>" alt="<?= htmlspecialchars($heb->nom) ?>" loading="lazy">
                    <?php if (!empty($heb->type_nom)): ?>
                    <span class="hcard__badge"><?= htmlspecialchars($heb->type_nom) ?></span>
                    <?php endif; ?>
                </div>
                <div class="hcard__body">
                    <div class="hcard__top">
                        <h3 class="hcard__name"><?= htmlspecialchars($heb->nom) ?></h3>
                        <?php if (!empty($heb->note_moyenne) && $heb->note_moyenne > 0): ?>
                        <div class="hcard__rating">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#FFD600" stroke="#FFD600" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <?= number_format($heb->note_moyenne, 1) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="hcard__loc">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?= htmlspecialchars($ville->nom) ?>
                    </div>
                    <div class="hcard__footer">
                        <div class="hcard__price">
                            <span class="hcard__price-num"><?= number_format($heb->prix_nuit_base, 0, ',', ' ') ?></span>
                            <span class="hcard__price-unit"> FCFA / nuit</span>
                        </div>
                        <div class="hcard__cta">
                            Voir
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>

    <!-- ── SITES TOURISTIQUES ──────────────── -->
    <?php if (!empty($sites)): ?>
    <section class="vsection vsection--alt">
        <div class="vsection__head">
            <div>
                <p class="label-tag">À découvrir</p>
                <h2 class="vsection__title">Sites touristiques</h2>
            </div>
            <a href="/sites?ville=<?= $ville->id ?>" class="vsee-all">
                Voir tout
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="sites-grid">
            <?php foreach ($sites as $site): ?>
            <a href="/site/<?= $site->id ?>" class="scard">
                <div class="scard__img">
                    <img 
                        src="<?= !empty($site->image_principale) ? htmlspecialchars($site->image_principale) : 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?q=80&w=700&auto=format&fit=crop' ?>" 
                        alt="<?= htmlspecialchars($site->nom) ?>"
                        loading="lazy"
                    >
                    <div class="scard__overlay"></div>
                    <?php if (!empty($site->categorie)): ?>
                    <span class="scard__cat"><?= htmlspecialchars($site->categorie) ?></span>
                    <?php endif; ?>
                </div>
                <div class="scard__body">
                    <h3 class="scard__name"><?= htmlspecialchars($site->nom) ?></h3>
                    <?php if (!empty($site->description)): ?>
                    <p class="scard__desc"><?= htmlspecialchars(mb_substr($site->description, 0, 80)) ?>…</p>
                    <?php endif; ?>
                    <div class="scard__link">
                        Découvrir
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ── CARTE ───────────────────────────── -->
    <?php if (!empty($ville->latitude) && !empty($ville->longitude)): ?>
    <section class="vsection">
        <div class="vsection__head">
            <div>
                <p class="label-tag">Où se trouve</p>
                <h2 class="vsection__title">Localisation de <span><?= htmlspecialchars($ville->nom) ?></span></h2>
            </div>
        </div>
        <div class="vmap-wrap">
            <div id="villeMap"></div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ── CTA RÉSERVATION ─────────────────── -->
    <section class="vcta">
        <div class="vcta__inner">
            <div class="vcta__text">
                <p class="label-tag" style="color:rgba(255,255,255,.5)">Prêt à partir ?</p>
                <h2>Planifiez votre séjour<br>à <em><?= htmlspecialchars($ville->nom) ?></em></h2>
                <p>Comparez les hébergements et réservez en quelques clics.</p>
            </div>
            <div class="vcta__actions">
                <a href="/hebergements?ville=<?= $ville->id ?>" class="vbtn vbtn--yellow">
                    Voir les hébergements
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="/villes" class="vbtn vbtn--ghost">
                    Autres destinations
                </a>
            </div>
        </div>
    </section>

</div><!-- /vpage -->

<!-- ══════════════════════════════════════════
     CSS
══════════════════════════════════════════ -->
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body { font-family: 'Poppins', sans-serif; background: #FAFAF8; color: #111; }

/* ── HERO ─────────────────────────── */
.vhero {
    position: relative;
    height: 520px;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
    margin-top: -76px;
    padding-top: 76px;
}

.vhero__bg {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.vhero__bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 40%;
    animation: zoomIn 10s ease forwards;
}
@keyframes zoomIn {
    from { transform: scale(1.06); }
    to   { transform: scale(1); }
}

.vhero__layer {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0,0,0,.85) 0%,
        rgba(0,0,0,.4) 50%,
        rgba(0,0,0,.15) 100%
    );
}

/* Breadcrumb */
.vhero__breadcrumb {
    position: absolute;
    top: 96px;
    left: 6vw;
    z-index: 5;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .72rem;
    font-weight: 500;
    color: rgba(255,255,255,.6);
    animation: fadeUp .7s ease .1s both;
}
.vhero__breadcrumb a {
    color: rgba(255,255,255,.6);
    text-decoration: none;
    transition: color .2s;
}
.vhero__breadcrumb a:hover { color: #FFD600; }
.vhero__breadcrumb span { color: rgba(255,255,255,.9); }

/* Content */
.vhero__content {
    position: relative;
    z-index: 3;
    padding: 0 6vw 52px;
    animation: fadeUp .8s ease .2s both;
    width: 100%;
    max-width: 860px;
}

@keyframes fadeUp {
    from { opacity:0; transform:translateY(24px); }
    to   { opacity:1; transform:translateY(0); }
}

.vhero__tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(0,135,81,.25);
    border: 1px solid rgba(0,135,81,.5);
    color: #6effc7;
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 20px;
    margin-bottom: 18px;
}

.vhero__title {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(2.6rem, 5vw, 4.5rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.05;
    letter-spacing: -.02em;
    margin-bottom: 14px;
}

.vhero__desc {
    font-size: clamp(.88rem, 1.1vw, 1rem);
    font-weight: 300;
    line-height: 1.7;
    color: rgba(255,255,255,.72);
    max-width: 560px;
    margin-bottom: 28px;
}

/* Stats hero */
.vhero__stats {
    display: flex;
    align-items: center;
    gap: 0;
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 14px;
    padding: 14px 24px;
    width: fit-content;
    gap: 24px;
}

.vhero__stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
}
.vhero__stat strong {
    font-size: 1.5rem;
    font-weight: 800;
    color: #FFD600;
    line-height: 1;
}
.vhero__stat span {
    font-size: .62rem;
    font-weight: 500;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: rgba(255,255,255,.55);
}

.vhero__stat-sep {
    width: 1px;
    height: 32px;
    background: rgba(255,255,255,.15);
}

/* Flag */
.flag-bar {
    position: absolute;
    right: 0; top: 0; bottom: 0;
    width: 5px;
    display: flex;
    flex-direction: column;
    z-index: 10;
}

/* ── PAGE LAYOUT ──────────────────── */
.vpage {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 6vw;
}

/* ── SECTIONS ─────────────────────── */
.vsection {
    padding: 72px 0;
    border-bottom: 1px solid #EBEBEB;
}
.vsection:last-of-type { border-bottom: none; }
.vsection--alt { background: #F5FAF7; margin: 0 -6vw; padding: 72px 6vw; }

.vsection__head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.label-tag {
    font-size: .68rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    font-weight: 700;
    color: #008751;
    margin-bottom: 8px;
}

.vsection__title {
    font-size: clamp(1.5rem, 2.5vw, 2rem);
    font-weight: 800;
    color: #111;
    line-height: 1.15;
}
.vsection__title span { color: #008751; }

.vsee-all {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .8rem;
    font-weight: 700;
    color: #008751;
    text-decoration: none;
    border: 1.5px solid #008751;
    padding: 8px 18px;
    border-radius: 30px;
    white-space: nowrap;
    transition: all .25s;
}
.vsee-all:hover {
    background: #008751;
    color: white;
}
.vsee-all svg { transition: transform .25s; }
.vsee-all:hover svg { transform: translateX(3px); }

/* ── HÉBERGEMENTS GRID ────────────── */
.heb-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

.hcard {
    text-decoration: none;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #EBEBEB;
    display: flex;
    flex-direction: column;
    transition: transform .3s ease, box-shadow .3s ease;
}
.hcard:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,135,81,.1);
}

.hcard__img {
    position: relative;
    height: 190px;
    overflow: hidden;
}
.hcard__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}
.hcard:hover .hcard__img img { transform: scale(1.06); }

.hcard__badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(6px);
    color: white;
    font-size: .62rem;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 20px;
}

.hcard__body {
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
}

.hcard__top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
}

.hcard__name {
    font-size: 1rem;
    font-weight: 700;
    color: #111;
    line-height: 1.3;
}

.hcard__rating {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: .8rem;
    font-weight: 700;
    color: #111;
    white-space: nowrap;
    flex-shrink: 0;
}

.hcard__loc {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .75rem;
    color: #888;
    font-weight: 500;
}

.hcard__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid #F0F0F0;
}

.hcard__price-num {
    font-size: 1rem;
    font-weight: 800;
    color: #008751;
}
.hcard__price-unit {
    font-size: .72rem;
    color: #888;
    font-weight: 400;
}

.hcard__cta {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .75rem;
    font-weight: 700;
    color: #fff;
    background: #008751;
    padding: 7px 14px;
    border-radius: 20px;
    transition: background .25s;
}
.hcard:hover .hcard__cta { background: #005c38; }

/* ── SITES GRID ───────────────────── */
.sites-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

.scard {
    text-decoration: none;
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
    border: 1px solid #E8E8E8;
    display: flex;
    flex-direction: column;
    transition: transform .3s ease, box-shadow .3s ease;
}
.scard:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 32px rgba(0,135,81,.1);
}

.scard__img {
    position: relative;
    height: 160px;
    overflow: hidden;
}
.scard__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}
.scard:hover .scard__img img { transform: scale(1.06); }

.scard__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.45), transparent 60%);
}

.scard__cat {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #FFD600;
    color: #111;
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 3px 9px;
    border-radius: 20px;
}

.scard__body {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.scard__name {
    font-size: .92rem;
    font-weight: 700;
    color: #111;
    line-height: 1.3;
}

.scard__desc {
    font-size: .78rem;
    line-height: 1.6;
    color: #777;
    flex: 1;
}

.scard__link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .72rem;
    font-weight: 700;
    color: #008751;
    margin-top: 6px;
    transition: gap .25s;
}
.scard:hover .scard__link { gap: 8px; }

/* ── CARTE ────────────────────────── */
.vmap-wrap {
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #EBEBEB;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
}

#villeMap {
    height: 380px;
    width: 100%;
}

/* ── EMPTY ────────────────────────── */
.vempty {
    text-align: center;
    padding: 70px 40px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #EBEBEB;
}
.vempty__icon {
    width: 68px; height: 68px;
    background: #F0F8F4;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
    color: #008751;
}
.vempty h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #111;
    margin-bottom: 8px;
}
.vempty p { font-size: .88rem; color: #888; margin-bottom: 20px; }

/* ── BOUTONS ──────────────────────── */
.vbtn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: .88rem;
    font-weight: 700;
    padding: 13px 26px;
    border-radius: 50px;
    text-decoration: none;
    transition: all .3s ease;
    cursor: pointer;
    border: none;
}
.vbtn--yellow {
    background: #FFD600;
    color: #111;
}
.vbtn--yellow:hover {
    background: #e6c200;
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(255,214,0,.3);
}
.vbtn--outline {
    background: transparent;
    border: 2px solid #008751;
    color: #008751;
}
.vbtn--outline:hover {
    background: #008751;
    color: white;
}
.vbtn--ghost {
    background: rgba(255,255,255,.12);
    border: 1.5px solid rgba(255,255,255,.25);
    color: white;
}
.vbtn--ghost:hover {
    background: rgba(255,255,255,.2);
    transform: translateY(-2px);
}

/* ── CTA FINAL ────────────────────── */
.vcta {
    background: #008751;
    margin: 0 -6vw;
    padding: 80px 6vw;
    position: relative;
    overflow: hidden;
}
.vcta::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 80% at 90% 50%, rgba(255,214,0,.12) 0%, transparent 70%),
        radial-gradient(ellipse 40% 60% at 10% 50%, rgba(0,0,0,.15) 0%, transparent 70%);
}

.vcta__inner {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap;
    max-width: 1300px;
}

.vcta__text h2 {
    font-size: clamp(1.7rem, 3vw, 2.5rem);
    font-weight: 800;
    color: #fff;
    margin: 8px 0 12px;
    line-height: 1.2;
}
.vcta__text h2 em {
    font-style: italic;
    color: #FFD600;
}
.vcta__text p {
    color: rgba(255,255,255,.65);
    font-size: .92rem;
    max-width: 400px;
    line-height: 1.65;
}

.vcta__actions {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}

/* ── RESPONSIVE ───────────────────── */
@media (max-width: 1024px) {
    .heb-grid { grid-template-columns: repeat(2, 1fr); }
    .sites-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .vhero { height: auto; min-height: 420px; padding-bottom: 0; }
    .vhero__content { padding-bottom: 40px; }
    .vhero__stats { gap: 16px; padding: 12px 18px; }
    .vhero__stat strong { font-size: 1.2rem; }

    .heb-grid { grid-template-columns: 1fr; }
    .sites-grid { grid-template-columns: repeat(2, 1fr); }

    .vsection__head { flex-direction: column; align-items: flex-start; }

    .vcta__inner { flex-direction: column; align-items: flex-start; }
}

@media (max-width: 480px) {
    .vhero__title { font-size: 2.4rem; }
    .vhero__stats { flex-wrap: wrap; gap: 12px; }
    .sites-grid { grid-template-columns: 1fr; }
    .vcta__actions { flex-direction: column; width: 100%; }
    .vbtn { justify-content: center; }
}
</style>

<!-- ══════════════════════════════════════════
     JS CARTE
══════════════════════════════════════════ -->
<?php if (!empty($ville->latitude) && !empty($ville->longitude)): ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat = <?= (float)$ville->latitude ?>;
    const lng = <?= (float)$ville->longitude ?>;

    const map = L.map('villeMap', { zoomControl: true, scrollWheelZoom: false })
                 .setView([lat, lng], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const icon = L.divIcon({
        className: '',
        html: `<div style="
            background:#008751;
            width:36px;height:36px;
            border-radius:50% 50% 50% 0;
            transform:rotate(-45deg);
            border:3px solid white;
            box-shadow:0 4px 12px rgba(0,0,0,.3);
        "></div>`,
        iconSize: [36, 36],
        iconAnchor: [18, 36]
    });

    L.marker([lat, lng], { icon })
     .addTo(map)
     .bindPopup(`<strong style="font-family:Poppins,sans-serif"><?= addslashes(htmlspecialchars($ville->nom)) ?></strong>`)
     .openPopup();
});
</script>
<?php endif; ?>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>