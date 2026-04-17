<?php 
$title = 'Destinations - BeninExplore';
ob_start(); 
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<section class="hero">
    <div class="hero__photo">
        <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?q=80&w=1800&auto=format&fit=crop" alt="Bénin" />
    </div>

    <div class="hero__layer"></div>

    <div class="hero__inner">
        <div class="hero__badge">
            <span class="dot"></span>
            Afrique de l'Ouest
        </div>

        <h1 class="hero__h1">
            Découvrez<br>
            le <span class="accent">Bénin</span>
        </h1>

        <p class="hero__p">
            Des plages de Cotonou aux collines de Natitingou —<br>
            choisissez votre prochaine aventure.
        </p>

        <a href="#destinations" class="hero__btn">
            Explorer les destinations
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </a>
    </div>

    <!-- Bande drapeau -->
    <div class="flag-bar">
        <div style="background:#008751;flex:1"></div>
        <div style="background:#FFD600;flex:1"></div>
        <div style="background:#E8112D;flex:1"></div>
    </div>
</section>

<!-- ══════════════════════════════════════════
     CHIFFRES
══════════════════════════════════════════ -->
<div class="numbers">
    <div class="numbers__item">
        <strong><?= !empty($villes) ? count($villes) : '10+' ?></strong>
        <span>Destinations</span>
    </div>
    <div class="numbers__sep"></div>
    <div class="numbers__item">
        <strong>12</strong>
        <span>Départements</span>
    </div>
    <div class="numbers__sep"></div>
    <div class="numbers__item">
        <strong>121 km</strong>
        <span>De côte</span>
    </div>
    <div class="numbers__sep"></div>
    <div class="numbers__item">
        <strong>500+</strong>
        <span>Hébergements</span>
    </div>
</div>

<!-- ══════════════════════════════════════════
     DESTINATIONS
══════════════════════════════════════════ -->
<section id="destinations" class="dest-section">
    <div class="dest-section__head">
        <div>
            <p class="label-tag">Où aller</p>
            <h2 class="dest-section__title">Nos destinations</h2>
        </div>
        <p class="dest-section__sub">
            Chaque ville du Bénin raconte une histoire unique, entre patrimoine royal, nature sauvage et culture vivante.
        </p>
    </div>

    <?php if (!empty($villes)): ?>
    <div class="dest-grid">
        <?php 
        $fallbacks = [
            'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1559925393-8be0ec4767c8?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1578662996442-48f60103fc96?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?q=80&w=900&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1521295121783-8a321d551ad2?q=80&w=900&auto=format&fit=crop',
        ];
        foreach ($villes as $i => $ville):
            $photo = !empty($ville->photo_url) ? htmlspecialchars($ville->photo_url) : $fallbacks[$i % count($fallbacks)];
            $isBig = ($i === 0 || $i === 3);
        ?>
        <a href="/ville/<?= $ville->id ?>" class="dcard <?= $isBig ? 'dcard--big' : '' ?>">
            <div class="dcard__img">
                <img src="<?= $photo ?>" alt="<?= htmlspecialchars($ville->nom) ?>" loading="<?= $i < 3 ? 'eager' : 'lazy' ?>">
            </div>
            <div class="dcard__overlay"></div>
            <div class="dcard__content">
                <span class="dcard__num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                <div class="dcard__bottom">
                    <h3 class="dcard__name"><?= htmlspecialchars($ville->nom) ?></h3>
                    <?php if (!empty($ville->description)): ?>
                    <p class="dcard__desc"><?= htmlspecialchars(mb_substr($ville->description, 0, 70)) ?>…</p>
                    <?php endif; ?>
                    <div class="dcard__cta">
                        Découvrir
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="empty-box">
        <div class="empty-box__icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <h3>Aucune destination disponible</h3>
        <p>Les villes seront bientôt ajoutées.</p>
    </div>
    <?php endif; ?>
</section>

<!-- ══════════════════════════════════════════
     BANDEAU FINAL
══════════════════════════════════════════ -->
<section class="cta-strip">
    <div class="cta-strip__text">
        <p class="label-tag" style="color:rgba(255,255,255,.5)">Prêt à partir ?</p>
        <h2>Trouvez votre hébergement idéal</h2>
        <p>Des hôtels, lodges et maisons d'hôtes dans toutes les villes du Bénin.</p>
    </div>
    <a href="/hebergements" class="cta-strip__btn">
        Voir les hébergements
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
</section>

<!-- ══════════════════════════════════════════
     CSS
══════════════════════════════════════════ -->
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Poppins', sans-serif;
    background: #FAFAF8;
    color: #111;
}

/* ── HERO ─────────────────────────── */
.hero {
    position: relative;
    height: 100vh;
    min-height: 580px;
    display: flex;
    align-items: center;
    overflow: hidden;
    margin-top: -76px;
    padding-top: 76px;
}

.hero__photo {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.hero__photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 40%;
    animation: zoomIn 12s ease forwards;
}
@keyframes zoomIn {
    from { transform: scale(1.08); }
    to   { transform: scale(1); }
}

.hero__layer {
    position: absolute;
    inset: 0;
    z-index: 1;
    background: linear-gradient(
        135deg,
        rgba(0,0,0,.72) 0%,
        rgba(0,0,0,.38) 55%,
        rgba(0,0,0,.12) 100%
    );
}

.hero__inner {
    position: relative;
    z-index: 2;
    max-width: 700px;
    padding: 0 6vw;
    animation: fadeUp .9s ease .2s both;
}

@keyframes fadeUp {
    from { opacity:0; transform:translateY(28px); }
    to   { opacity:1; transform:translateY(0); }
}

.hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    backdrop-filter: blur(8px);
    color: rgba(255,255,255,.85);
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .16em;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 30px;
    margin-bottom: 28px;
}

.dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #FFD600;
    display: inline-block;
    animation: blink 2s ease infinite;
}
@keyframes blink {
    0%,100% { opacity:1; }
    50%      { opacity:.3; }
}

.hero__h1 {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(3.2rem, 6.5vw, 5.5rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.06;
    letter-spacing: -.02em;
    margin-bottom: 22px;
}

.accent {
    color: #FFD600;
    position: relative;
}
.accent::after {
    content: '';
    position: absolute;
    left: 0; bottom: -4px;
    width: 100%; height: 4px;
    background: #008751;
    border-radius: 2px;
}

.hero__p {
    font-size: clamp(.95rem, 1.3vw, 1.12rem);
    font-weight: 300;
    line-height: 1.75;
    color: rgba(255,255,255,.75);
    margin-bottom: 38px;
}

.hero__btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #008751;
    color: #fff;
    text-decoration: none;
    font-size: .92rem;
    font-weight: 600;
    padding: 15px 30px;
    border-radius: 50px;
    transition: all .3s ease;
}
.hero__btn:hover {
    background: #FFD600;
    color: #111;
    transform: translateY(-3px);
    box-shadow: 0 16px 32px rgba(0,0,0,.25);
}
.hero__btn svg { transition: transform .3s; }
.hero__btn:hover svg { transform: translateY(3px); }

.flag-bar {
    position: absolute;
    right: 0; top: 0; bottom: 0;
    width: 5px;
    display: flex;
    flex-direction: column;
    z-index: 10;
}

/* ── NUMBERS ──────────────────────── */
.numbers {
    display: flex;
    align-items: center;
    background: #fff;
    border-bottom: 1px solid #EBEBEB;
}

.numbers__item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 28px 16px;
    gap: 4px;
    transition: background .25s;
}
.numbers__item:hover { background: #F5FAF7; }

.numbers__item strong {
    font-family: 'Poppins', sans-serif;
    font-size: 2rem;
    font-weight: 800;
    color: #008751;
    line-height: 1;
}

.numbers__item span {
    font-size: .7rem;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #888;
    font-weight: 500;
}

.numbers__sep {
    width: 1px;
    height: 36px;
    background: #EBEBEB;
}

/* ── DESTINATIONS ─────────────────── */
.dest-section {
    padding: 90px 6vw;
    max-width: 1400px;
    margin: 0 auto;
}

.dest-section__head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 32px;
    margin-bottom: 56px;
    flex-wrap: wrap;
}

.label-tag {
    font-size: .7rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    font-weight: 700;
    color: #008751;
    margin-bottom: 10px;
}

.dest-section__title {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 800;
    color: #111;
    line-height: 1.1;
}

.dest-section__sub {
    max-width: 380px;
    font-size: .95rem;
    line-height: 1.7;
    color: #666;
}

/* ── GRID ─────────────────────────── */
.dest-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: 280px;
    gap: 18px;
}

.dcard--big {
    grid-row: span 2;
}

.dcard {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none;
    display: block;
    background: #111;
    cursor: pointer;
}

.dcard__img {
    position: absolute;
    inset: 0;
    overflow: hidden;
}
.dcard__img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .65s ease;
}
.dcard:hover .dcard__img img {
    transform: scale(1.07);
}

.dcard__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0,0,0,.88) 0%,
        rgba(0,0,0,.3) 45%,
        transparent 75%
    );
    transition: background .4s;
}
.dcard:hover .dcard__overlay {
    background: linear-gradient(
        to top,
        rgba(0,0,0,.95) 0%,
        rgba(0,0,0,.5) 55%,
        rgba(0,0,0,.1) 80%
    );
}

.dcard__content {
    position: absolute;
    inset: 0;
    padding: 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    z-index: 2;
}

.dcard__num {
    font-family: 'Poppins', sans-serif;
    font-size: .68rem;
    font-weight: 800;
    letter-spacing: .15em;
    color: #FFD600;
    background: rgba(255,214,0,.13);
    border: 1px solid rgba(255,214,0,.3);
    padding: 4px 10px;
    border-radius: 20px;
    width: fit-content;
}

.dcard__name {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(1.3rem, 2vw, 1.75rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 8px;
}

.dcard--big .dcard__name {
    font-size: clamp(1.8rem, 2.5vw, 2.4rem);
}

.dcard__desc {
    font-size: .84rem;
    line-height: 1.6;
    color: rgba(255,255,255,.6);
    margin-bottom: 14px;
    max-width: 340px;
    opacity: 0;
    transform: translateY(8px);
    transition: all .35s ease;
}
.dcard:hover .dcard__desc {
    opacity: 1;
    transform: translateY(0);
}

.dcard__cta {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .76rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #FFD600;
    opacity: 0;
    transform: translateY(6px);
    transition: all .35s ease .05s;
}
.dcard:hover .dcard__cta {
    opacity: 1;
    transform: translateY(0);
}
.dcard__cta svg { transition: transform .3s; }
.dcard:hover .dcard__cta svg { transform: translateX(4px); }

/* ── EMPTY ────────────────────────── */
.empty-box {
    text-align: center;
    padding: 80px 40px;
    background: #fff;
    border-radius: 18px;
    border: 1px solid #EBEBEB;
}
.empty-box__icon {
    width: 72px; height: 72px;
    background: #F0F8F4;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    color: #008751;
}
.empty-box h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 1.4rem;
    color: #111;
    margin-bottom: 8px;
}
.empty-box p { color: #888; font-size: .9rem; }

/* ── CTA STRIP ────────────────────── */
.cta-strip {
    background: #008751;
    padding: 80px 6vw;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap;
}

.cta-strip__text h2 {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(1.7rem, 3vw, 2.5rem);
    font-weight: 800;
    color: #fff;
    margin: 8px 0 12px;
    line-height: 1.2;
}
.cta-strip__text p {
    color: rgba(255,255,255,.7);
    font-size: .95rem;
    max-width: 420px;
    line-height: 1.65;
}

.cta-strip__btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #FFD600;
    color: #111;
    text-decoration: none;
    font-weight: 700;
    font-size: .92rem;
    padding: 16px 32px;
    border-radius: 50px;
    white-space: nowrap;
    flex-shrink: 0;
    transition: all .3s ease;
}
.cta-strip__btn:hover {
    background: #fff;
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(0,0,0,.15);
}
.cta-strip__btn svg { transition: transform .3s; }
.cta-strip__btn:hover svg { transform: translateX(4px); }

/* ── RESPONSIVE ───────────────────── */
@media (max-width: 1024px) {
    .dest-grid {
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 260px;
    }
    .dcard--big { grid-column: span 2; grid-row: span 1; }
}

@media (max-width: 768px) {
    .numbers { flex-wrap: wrap; }
    .numbers__item { flex: 0 0 50%; border-bottom: 1px solid #EBEBEB; }
    .numbers__sep { display: none; }

    .dest-section { padding: 60px 5vw; }
    .dest-section__head { flex-direction: column; align-items: flex-start; gap: 16px; }
    .dest-section__sub { max-width: 100%; }

    .dest-grid {
        grid-template-columns: 1fr;
        grid-auto-rows: 240px;
    }
    .dcard--big { grid-column: span 1; grid-row: span 1; }
    .dcard__desc, .dcard__cta { opacity: 1; transform: none; }

    .cta-strip { flex-direction: column; align-items: flex-start; padding: 60px 5vw; }
}

@media (max-width: 480px) {
    .hero__h1 { font-size: 2.8rem; }
    .hero__p br { display: none; }
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>