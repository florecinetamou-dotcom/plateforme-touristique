<?php
$title            = 'Accueil - BeninExplore';
$meta_description = "Découvrez les merveilles du Bénin : sites historiques, nature, culture et hébergements authentiques.";

$stats                   = $stats                   ?? null;
$hebergements_populaires = $hebergements_populaires ?? [];
$villes                  = $villes                  ?? [];
$sites_populaires        = $sites_populaires        ?? [];
$temoignages             = $temoignages             ?? [];

$defaultHeb  = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80';
$defaultSite = 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?auto=format&fit=crop&w=800&q=80';
$defaultVille= 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80';

ob_start();
?>

<!-- ══════════ HERO ══════════ -->
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content container">
        <div class="row align-items-center" style="min-height:88vh;padding-top:80px;padding-bottom:60px">
            <div class="col-lg-7">
                <div class="hero-badge-wrap">
                    <span class="hero-badge">
                        <span class="badge-dot"></span>
                        Bénin · Afrique de l'Ouest
                    </span>
                </div>
                <h1 class="hero-title">
                    Explorez le<br>
                    <span class="hero-accent">Bénin</span> authentique
                </h1>
                <p class="hero-subtitle">
                    Sites classés UNESCO, hébergements vérifiés, destinations uniques.
                    Votre aventure africaine commence ici.
                </p>
                <div class="hero-actions">
                    <a href="/hebergements" class="btn-hero-primary">
                        <i class="fas fa-search me-2"></i>Trouver un hébergement
                    </a>
                    <a href="/sites" class="btn-hero-ghost">
                        <i class="fas fa-landmark me-2"></i>Sites touristiques
                    </a>
                </div>

                <!-- Mini stats dans le hero -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <strong><?= $stats->nb_hebergements ?? '50+' ?></strong>
                        <span>Hébergements</span>
                    </div>
                    <div class="hero-stat-sep"></div>
                    <div class="hero-stat">
                        <strong><?= $stats->nb_sites ?? '30+' ?></strong>
                        <span>Sites</span>
                    </div>
                    <div class="hero-stat-sep"></div>
                    <div class="hero-stat">
                        <strong><?= $stats->nb_villes ?? '15+' ?></strong>
                        <span>Villes</span>
                    </div>
                    <div class="hero-stat-sep"></div>
                    <div class="hero-stat">
                        <strong><?= $stats->nb_voyageurs ?? '5000+' ?></strong>
                        <span>Voyageurs</span>
                    </div>
                </div>
            </div>

            <!-- Carte flottante côté droit -->
            <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                <div class="hero-float-card">
                    <div class="hfc-header">
                        <i class="fas fa-map-marker-alt me-2" style="color:#FFD600"></i>
                        Destination populaire
                    </div>
                    <img src="https://images.unsplash.com/photo-1590608897129-79da3d22b0c2?auto=format&fit=crop&w=600&q=80"
                         alt="Ouidah" class="hfc-img">
                    <div class="hfc-body">
                        <div class="hfc-name">Ouidah, Bénin</div>
                        <div class="hfc-desc">Route des Esclaves · Temple des pythons</div>
                        <div class="hfc-footer">
                            <div class="hfc-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>5.0</span>
                            </div>
                            <a href="/ville/2" class="hfc-btn">Explorer →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="scroll-indicator">
        <div class="scroll-mouse"><div class="scroll-dot"></div></div>
    </div>
</section>

<!-- ══════════ VILLES ══════════ -->
<section class="section-pad">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">Destinations</span>
            <h2 class="section-title">Villes à explorer</h2>
            <p class="section-sub">Du littoral à l'intérieur des terres, chaque ville a son histoire</p>
        </div>

        <div class="row g-4">
            <?php if (!empty($villes)): ?>
                <?php foreach ($villes as $i => $ville): ?>
                <div class="col-md-6 col-lg-4">
                    <a href="/ville/<?= $ville->id ?>" class="dest-card">
                        <div class="dest-img-wrap">
                            <img src="<?= $defaultVille ?>" alt="<?= htmlspecialchars($ville->nom) ?>" class="dest-img">
                            <div class="dest-overlay-btn">Explorer →</div>
                            <span class="dest-badge-top">
                                <i class="fas fa-hotel me-1"></i><?= $ville->nb_hebergements ?> hébergements
                            </span>
                        </div>
                        <div class="dest-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="dest-name"><?= htmlspecialchars($ville->nom) ?></div>
                                    <div class="dest-meta">
                                        <i class="fas fa-landmark me-1"></i><?= $ville->nb_sites ?> sites touristiques
                                    </div>
                                </div>
                                <div class="dest-arrow">→</div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach (['Cotonou', 'Ouidah', 'Abomey'] as $nom): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="dest-card">
                        <div class="dest-img-wrap">
                            <img src="<?= $defaultVille ?>" alt="<?= $nom ?>" class="dest-img">
                        </div>
                        <div class="dest-body">
                            <div class="dest-name"><?= $nom ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <a href="/villes" class="btn-outline-green">Toutes les destinations <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- ══════════ HÉBERGEMENTS ══════════ -->
<section class="section-pad bg-soft">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">Coups de cœur</span>
            <h2 class="section-title">Hébergements populaires</h2>
            <p class="section-sub">Sélectionnés et vérifiés par notre équipe</p>
        </div>

        <div class="row g-4">
            <?php if (!empty($hebergements_populaires)): ?>
                <?php foreach ($hebergements_populaires as $heb): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="hotel-card">
                        <div class="hotel-img-wrap">
                            <img src="<?= htmlspecialchars($heb->photo ?? $defaultHeb) ?>"
                                 alt="<?= htmlspecialchars($heb->nom) ?>" class="hotel-img"
                                 onerror="this.src='<?= $defaultHeb ?>'">
                            <?php if ($heb->note_moyenne > 0): ?>
                            <span class="hotel-note">
                                <i class="fas fa-star text-warning me-1"></i><?= number_format($heb->note_moyenne, 1) ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['user_id'])): ?>
                            <form method="POST" action="/favori/toggle/<?= $heb->id ?>" class="d-inline">
                                <button type="submit" class="hotel-fav" title="Favoris">
                                    <i class="far fa-heart"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                        <div class="hotel-body">
                            <div class="hotel-type"><?= htmlspecialchars($heb->type_nom ?? 'Hébergement') ?></div>
                            <h3 class="hotel-name"><?= htmlspecialchars($heb->nom) ?></h3>
                            <p class="hotel-location">
                                <i class="fas fa-map-marker-alt me-1"></i><?= htmlspecialchars($heb->ville_nom) ?>
                            </p>
                            <div class="hotel-footer">
                                <div>
                                    <span class="hotel-price"><?= number_format($heb->prix_nuit_base, 0, ',', ' ') ?> FCFA</span>
                                    <span class="hotel-per">/nuit</span>
                                </div>
                                <a href="/hebergement/<?= $heb->id ?>" class="btn-sm-green">Voir</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-4">
                <p class="text-muted">Aucun hébergement disponible pour le moment.</p>
                <a href="/hebergements" class="btn-outline-green">Explorer</a>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <a href="/hebergements" class="btn-outline-green">Tous les hébergements <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- ══════════ SITES TOURISTIQUES ══════════ -->
<section class="section-pad">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">À découvrir</span>
            <h2 class="section-title">Sites incontournables</h2>
            <p class="section-sub">Histoire, nature et culture au cœur du Bénin</p>
        </div>

        <?php if (!empty($sites_populaires)): ?>
        <div class="sites-mosaic">
            <?php foreach ($sites_populaires as $i => $site): ?>
            <a href="/site/<?= $site->id ?>" class="site-tile <?= $i === 0 ? 'site-tile--big' : '' ?>">
                <img src="<?= htmlspecialchars($site->photo_url ?? $defaultSite) ?>"
                     alt="<?= htmlspecialchars($site->nom) ?>"
                     onerror="this.src='<?= $defaultSite ?>'">
                <div class="site-tile-overlay">
                    <span class="site-tile-cat"><?= ucfirst($site->categorie ?? 'Site') ?></span>
                    <div class="site-tile-name"><?= htmlspecialchars($site->nom) ?></div>
                    <div class="site-tile-ville">
                        <i class="fas fa-map-marker-alt me-1"></i><?= htmlspecialchars($site->ville_nom) ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Fallback statique -->
        <div class="row g-4">
            <?php foreach ([
                ['Palais d\'Abomey', 'Patrimoine UNESCO', 'Abomey'],
                ['Route des Esclaves', 'Mémoire & histoire', 'Ouidah'],
                ['Ganvié', 'Cité lacustre', 'Cotonou'],
                ['Parc Pendjari', 'Safari & faune', 'Atacora'],
            ] as $s): ?>
            <div class="col-md-6 col-lg-3">
                <div class="site-static-card">
                    <img src="<?= $defaultSite ?>" alt="<?= $s[0] ?>">
                    <div class="ssc-body">
                        <div class="ssc-name"><?= $s[0] ?></div>
                        <div class="ssc-desc"><?= $s[1] ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="text-center mt-5">
            <a href="/sites" class="btn-outline-green">Tous les sites touristiques <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>

<!-- ══════════ POURQUOI NOUS ══════════ -->
<section class="why-section section-pad">
    <div class="container">
        <div class="section-head">
            <span class="section-tag" style="background:rgba(255,255,255,.15);color:#fff">Nos avantages</span>
            <h2 class="section-title text-white">Pourquoi choisir BeninExplore ?</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ([
                ['fa-shield-alt',    'Paiement sécurisé',    'Transactions 100% protégées'],
                ['fa-headset',       'Support 24/7',          'Équipe disponible à tout moment'],
                ['fa-tags',          'Meilleurs prix',        'Tarifs négociés directement'],
                ['fa-map-marked-alt','Voyage authentique',    'Expériences locales uniques'],
            ] as $a): ?>
            <div class="col-6 col-md-3">
                <div class="why-card">
                    <div class="why-icon"><i class="fas <?= $a[0] ?>"></i></div>
                    <div class="why-title"><?= $a[1] ?></div>
                    <div class="why-desc"><?= $a[2] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ TÉMOIGNAGES ══════════ -->
<section class="section-pad bg-soft">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">Avis voyageurs</span>
            <h2 class="section-title">Ils ont voyagé avec nous</h2>
            <p class="section-sub">Des expériences authentiques partagées par notre communauté</p>
        </div>

        <div class="row g-4">
            <?php if (!empty($temoignages)): ?>
                <?php foreach ($temoignages as $t): ?>
                <div class="col-md-4 d-flex">
                    <div class="review-card w-100">
                        <div class="review-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star<?= $i <= $t->note_globale ? '' : '-o' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="review-text">"<?= htmlspecialchars(substr($t->commentaire_public ?? '', 0, 160)) ?>..."</p>
                        <div class="review-author">
                            <?php if (!empty($t->avatar_url)): ?>
                                <img src="<?= htmlspecialchars($t->avatar_url) ?>" class="review-avatar-img" alt="">
                            <?php else: ?>
                                <div class="review-avatar"><?= strtoupper(substr($t->prenom ?? 'V', 0, 1)) ?></div>
                            <?php endif; ?>
                            <div>
                                <div class="review-name"><?= htmlspecialchars($t->prenom . ' ' . substr($t->nom, 0, 1) . '.') ?></div>
                                <div class="review-loc"><i class="fas fa-map-marker-alt me-1"></i><?= htmlspecialchars($t->ville_nom) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ([
                    ['Séjour incroyable à Ouidah ! L\'hébergement était parfait, accueil chaleureux. Je recommande vivement.', 'Marie-Claire D.', 'Cotonou'],
                    ['Le Parc Pendjari est magnifique. Une expérience safari unique que je n\'oublierai jamais !', 'Jean K.', 'Porto-Novo'],
                    ['Ganvié, la Venise de l\'Afrique ! Une expérience unique à ne surtout pas manquer.', 'Sophie A.', 'Paris'],
                ] as $t): ?>
                <div class="col-md-4 d-flex">
                    <div class="review-card w-100">
                        <div class="review-stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="review-text">"<?= $t[0] ?>"</p>
                        <div class="review-author">
                            <div class="review-avatar"><?= strtoupper(substr($t[1], 0, 1)) ?></div>
                            <div>
                                <div class="review-name"><?= $t[1] ?></div>
                                <div class="review-loc"><i class="fas fa-map-marker-alt me-1"></i><?= $t[2] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ══════════ NEWSLETTER ══════════ -->
<section class="newsletter-section section-pad">
    <div class="container">
        <div class="newsletter-box">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <div class="nl-tag">📩 Newsletter</div>
                    <h3 class="nl-title">Restez informé de nos offres</h3>
                    <p class="nl-sub">Recevez nos meilleures offres, nouveautés et conseils de voyage directement dans votre boîte mail.</p>
                </div>
                <div class="col-lg-6">
                    <div class="nl-form">
                        <input type="email" class="nl-input" placeholder="Votre adresse email...">
                        <button class="nl-btn">S'inscrire <i class="fas fa-paper-plane ms-1"></i></button>
                    </div>
                    <p class="nl-note"><i class="fas fa-lock me-1"></i>Pas de spam. Désabonnement à tout moment.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ══════════════════════════════════
   HERO
══════════════════════════════════ */
.hero-section {
    position: relative; min-height: 88vh;
    display: flex; align-items: center; overflow: hidden;
}
.hero-bg {
    position: absolute; inset: 0;
    background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
}
.hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(120deg, rgba(0,15,8,.88) 0%, rgba(0,50,25,.6) 55%, rgba(0,0,0,.15) 100%);
}
.hero-content { position: relative; z-index: 1; width: 100%; }

.hero-badge-wrap { margin-bottom: 18px; }
.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,214,0,.12); border: 1px solid rgba(255,214,0,.3);
    color: #FFD600; padding: 6px 18px; border-radius: 50px;
    font-size: .82rem; font-weight: 600;
    backdrop-filter: blur(8px);
}
.badge-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #FFD600; animation: pulse 1.8s ease infinite;
}
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

.hero-title {
    font-size: clamp(2.2rem, 5.5vw, 4rem);
    font-weight: 800; color: #fff; line-height: 1.1;
    margin-bottom: 20px;
}
.hero-accent { color: #FFD600; }
.hero-subtitle {
    font-size: clamp(.95rem, 2vw, 1.1rem);
    color: rgba(255,255,255,.8); line-height: 1.75;
    margin-bottom: 36px; max-width: 500px;
}
.hero-actions { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 44px; }

.btn-hero-primary {
    background: linear-gradient(135deg, #008751, #00a862);
    color: #fff; border: none; border-radius: 50px;
    padding: 14px 32px; font-weight: 700; font-size: .92rem;
    text-decoration: none; transition: all .3s;
    box-shadow: 0 6px 24px rgba(0,135,81,.45);
}
.btn-hero-primary:hover { color:#fff; transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,135,81,.55); }
.btn-hero-ghost {
    background: rgba(255,255,255,.1); color: #fff;
    border: 1.5px solid rgba(255,255,255,.35); border-radius: 50px;
    padding: 14px 32px; font-weight: 600; font-size: .92rem;
    text-decoration: none; transition: all .3s; backdrop-filter: blur(8px);
}
.btn-hero-ghost:hover { background: rgba(255,255,255,.22); color: #fff; }

/* Hero stats */
.hero-stats {
    display: flex; align-items: center; gap: 0;
    background: rgba(255,255,255,.08); backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 16px; padding: 16px 24px;
    display: inline-flex;
}
.hero-stat { text-align: center; padding: 0 20px; }
.hero-stat strong { display: block; font-size: 1.4rem; font-weight: 800; color: #FFD600; line-height: 1; }
.hero-stat span { font-size: .72rem; color: rgba(255,255,255,.6); margin-top: 3px; display: block; }
.hero-stat-sep { width: 1px; height: 36px; background: rgba(255,255,255,.15); }

/* Floating card */
.hero-float-card {
    background: #fff; border-radius: 20px;
    box-shadow: 0 24px 60px rgba(0,0,0,.22);
    overflow: hidden; width: 300px;
    animation: floatCard 3s ease-in-out infinite;
}
@keyframes floatCard { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
.hfc-header {
    padding: 12px 16px; font-size: .75rem; font-weight: 700;
    color: #008751; background: rgba(0,135,81,.06);
    border-bottom: 1px solid rgba(0,135,81,.1);
}
.hfc-img { width: 100%; height: 160px; object-fit: cover; }
.hfc-body { padding: 14px 16px; }
.hfc-name { font-weight: 700; font-size: .95rem; color: #1a1a2e; margin-bottom: 3px; }
.hfc-desc { font-size: .75rem; color: #888; margin-bottom: 12px; }
.hfc-footer { display: flex; justify-content: space-between; align-items: center; }
.hfc-stars { color: #FFD600; font-size: .75rem; display: flex; align-items: center; gap: 2px; }
.hfc-stars span { color: #1a1a2e; font-weight: 700; margin-left: 4px; }
.hfc-btn {
    background: #008751; color: #fff; border-radius: 50px;
    padding: 6px 16px; font-size: .78rem; font-weight: 600;
    text-decoration: none; transition: all .2s;
}
.hfc-btn:hover { background: #005c37; color: #fff; }

/* Scroll indicator */
.scroll-indicator { position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%); z-index: 1; }
.scroll-mouse { width: 26px; height: 40px; border: 2px solid rgba(255,255,255,.4); border-radius: 13px; position: relative; }
.scroll-dot {
    width: 4px; height: 8px; background: #fff; border-radius: 2px;
    position: absolute; left: 50%; top: 6px; transform: translateX(-50%);
    animation: scrollAnim 1.6s ease-in-out infinite;
}
@keyframes scrollAnim { 0%,100%{opacity:1;top:6px} 50%{opacity:0;top:18px} }

/* ══════════════════════════════════
   GLOBAL
══════════════════════════════════ */
.section-pad { padding: 80px 0; }
.bg-soft { background: #f7faf8; }

.section-head { text-align: center; margin-bottom: 48px; }
.section-tag {
    display: inline-block; background: rgba(0,135,81,.1); color: #008751;
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1.2px; padding: 5px 14px; border-radius: 50px; margin-bottom: 12px;
}
.section-title { font-size: clamp(1.5rem, 3vw, 2.1rem); font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
.section-sub { color: #888; font-size: .92rem; }

.btn-outline-green {
    border: 2px solid #008751; color: #008751;
    background: transparent; border-radius: 50px;
    padding: 10px 28px; font-weight: 600; font-size: .88rem;
    text-decoration: none; transition: all .3s; display: inline-block;
}
.btn-outline-green:hover { background: #008751; color: #fff; transform: translateY(-2px); }

/* ══════════════════════════════════
   DESTINATIONS
══════════════════════════════════ */
.dest-card {
    display: block; text-decoration: none;
    border-radius: 16px; overflow: hidden;
    background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,.07);
    transition: transform .3s, box-shadow .3s; color: inherit;
}
.dest-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,135,81,.14); }
.dest-img-wrap { position: relative; overflow: hidden; }
.dest-img { width: 100%; height: 220px; object-fit: cover; transition: transform .4s; }
.dest-card:hover .dest-img { transform: scale(1.06); }
.dest-overlay-btn {
    position: absolute; inset: 0;
    background: rgba(0,0,0,.38);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: .95rem;
    opacity: 0; transition: opacity .3s;
}
.dest-card:hover .dest-overlay-btn { opacity: 1; }
.dest-badge-top {
    position: absolute; top: 12px; left: 12px;
    background: rgba(0,135,81,.88); color: #fff;
    font-size: .72rem; font-weight: 600;
    padding: 4px 12px; border-radius: 50px;
}
.dest-body { padding: 16px 18px; }
.dest-name { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
.dest-meta { font-size: .78rem; color: #888; }
.dest-arrow { font-size: 1.1rem; color: #ccc; transition: color .2s; }
.dest-card:hover .dest-arrow { color: #008751; }

/* ══════════════════════════════════
   HÉBERGEMENTS
══════════════════════════════════ */
.hotel-card {
    border-radius: 16px; overflow: hidden; background: #fff;
    box-shadow: 0 4px 20px rgba(0,0,0,.07); transition: transform .3s, box-shadow .3s;
}
.hotel-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,135,81,.14); }
.hotel-img-wrap { position: relative; overflow: hidden; }
.hotel-img { width: 100%; height: 200px; object-fit: cover; transition: transform .4s; }
.hotel-card:hover .hotel-img { transform: scale(1.05); }
.hotel-note {
    position: absolute; top: 12px; right: 12px;
    background: rgba(0,0,0,.65); color: #fff;
    font-size: .75rem; font-weight: 600; padding: 4px 10px; border-radius: 50px;
}
.hotel-fav {
    position: absolute; top: 12px; left: 12px;
    background: #fff; border: none; width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #ccc; font-size: 14px; cursor: pointer; transition: all .2s;
    box-shadow: 0 2px 8px rgba(0,0,0,.12);
}
.hotel-fav:hover { color: #ef4444; transform: scale(1.1); }
.hotel-body { padding: 16px; }
.hotel-type { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #008751; margin-bottom: 4px; }
.hotel-name { font-size: .95rem; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
.hotel-location { font-size: .78rem; color: #888; margin-bottom: 14px; }
.hotel-location i { color: #008751; }
.hotel-footer { display: flex; justify-content: space-between; align-items: center; }
.hotel-price { font-size: 1rem; font-weight: 700; color: #008751; }
.hotel-per { font-size: .72rem; color: #aaa; margin-left: 2px; }
.btn-sm-green {
    background: #008751; color: #fff; border-radius: 50px;
    padding: 7px 18px; font-size: .78rem; font-weight: 600;
    text-decoration: none; transition: all .2s;
}
.btn-sm-green:hover { background: #005c37; color: #fff; }

/* ══════════════════════════════════
   SITES — MOSAÏQUE
══════════════════════════════════ */
.sites-mosaic {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(2, 220px);
    gap: 12px;
    margin-bottom: 0;
}
.site-tile {
    position: relative; overflow: hidden; border-radius: 14px;
    text-decoration: none; display: block;
}
.site-tile--big {
    grid-column: 1 / 2;
    grid-row: 1 / 3;
}
.site-tile img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .4s;
}
.site-tile:hover img { transform: scale(1.06); }
.site-tile-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(0deg, rgba(0,0,0,.7) 0%, transparent 50%);
    padding: 16px; display: flex; flex-direction: column; justify-content: flex-end;
}
.site-tile-cat {
    background: rgba(0,135,81,.85); color: #fff;
    font-size: .65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; padding: 3px 10px; border-radius: 50px;
    display: inline-block; margin-bottom: 6px; width: fit-content;
}
.site-tile-name { font-size: .95rem; font-weight: 700; color: #fff; margin-bottom: 3px; }
.site-tile-ville { font-size: .75rem; color: rgba(255,255,255,.7); }

/* Fallback site statique */
.site-static-card { border-radius: 14px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,.08); }
.site-static-card img { width: 100%; height: 180px; object-fit: cover; }
.ssc-body { padding: 14px; background: #fff; }
.ssc-name { font-weight: 700; font-size: .9rem; color: #1a1a2e; }
.ssc-desc { font-size: .75rem; color: #888; }

/* ══════════════════════════════════
   POURQUOI
══════════════════════════════════ */
.why-section { background: linear-gradient(135deg, #0d2b1e 0%, #008751 100%); }
.why-card { text-align: center; padding: 12px 8px; }
.why-icon {
    width: 64px; height: 64px;
    background: rgba(255,255,255,.1); border: 1.5px solid rgba(255,255,255,.2);
    border-radius: 16px; display: flex; align-items: center; justify-content: center;
    color: #FFD600; font-size: 24px; margin: 0 auto 16px; transition: all .3s;
}
.why-card:hover .why-icon { background: rgba(255,214,0,.2); transform: translateY(-4px); }
.why-title { font-size: .92rem; font-weight: 700; color: #fff; margin-bottom: 6px; }
.why-desc { font-size: .78rem; color: rgba(255,255,255,.6); }

/* ══════════════════════════════════
   TÉMOIGNAGES
══════════════════════════════════ */
.review-card {
    background: #fff; border-radius: 16px; padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06); border: 1px solid #f0f0f0;
    transition: all .3s; display: flex; flex-direction: column;
}
.review-card:hover { transform: translateY(-4px); box-shadow: 0 14px 32px rgba(0,135,81,.1); }
.review-stars { color: #FFD600; font-size: .85rem; margin-bottom: 14px; }
.review-text { font-size: .88rem; color: #555; font-style: italic; line-height: 1.75; flex: 1; margin-bottom: 18px; }
.review-author { display: flex; align-items: center; gap: 12px; margin-top: auto; }
.review-avatar {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #008751, #FFD600);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 16px; flex-shrink: 0;
}
.review-avatar-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
.review-name { font-size: .88rem; font-weight: 700; color: #1a1a2e; }
.review-loc { font-size: .72rem; color: #aaa; }

/* ══════════════════════════════════
   NEWSLETTER
══════════════════════════════════ */
.newsletter-section { background: #f7faf8; }
.newsletter-box {
    background: linear-gradient(135deg, #008751 0%, #005c37 100%);
    border-radius: 24px; padding: 50px 48px;
    box-shadow: 0 20px 50px rgba(0,135,81,.25);
}
.nl-tag { color: rgba(255,255,255,.6); font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 8px; }
.nl-title { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 8px; }
.nl-sub { color: rgba(255,255,255,.7); font-size: .88rem; margin: 0; }
.nl-form {
    display: flex; gap: 10px;
    background: #fff; border-radius: 50px;
    padding: 6px 6px 6px 20px;
}
.nl-input { flex: 1; border: none; outline: none; font-size: .88rem; color: #333; background: transparent; }
.nl-btn {
    background: linear-gradient(135deg, #008751, #00a862);
    color: #fff; border: none; border-radius: 50px;
    padding: 10px 24px; font-weight: 600; font-size: .85rem;
    white-space: nowrap; cursor: pointer; transition: all .3s;
}
.nl-btn:hover { filter: brightness(1.1); }
.nl-note { color: rgba(255,255,255,.5); font-size: .75rem; margin-top: 10px; margin-bottom: 0; }

/* ══════════════════════════════════
   RESPONSIVE
══════════════════════════════════ */
@media (max-width: 768px) {
    .hero-stats { flex-wrap: wrap; justify-content: center; }
    .hero-stat-sep { display: none; }
    .sites-mosaic { grid-template-columns: 1fr 1fr; grid-template-rows: auto; }
    .site-tile--big { grid-column: 1 / -1; grid-row: auto; height: 220px; }
    .newsletter-box { padding: 30px 24px; }
    .nl-form { flex-direction: column; border-radius: 16px; padding: 12px; }
    .nl-input { padding: 8px 4px; }
    .nl-btn { border-radius: 10px; }
}
@media (max-width: 576px) {
    .section-pad { padding: 56px 0; }
    .hero-actions { flex-direction: column; }
    .btn-hero-primary, .btn-hero-ghost { text-align: center; }
    .sites-mosaic { grid-template-columns: 1fr; }
    .site-tile--big { height: 220px; }
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>