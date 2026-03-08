<?php $title = 'À propos - BeninExplore'; ?>
<?php $meta_description = 'Découvrez notre mission, notre équipe et notre engagement pour promouvoir le tourisme au Bénin.'; ?>
<?php ob_start(); ?>

<!-- ===== HERO ===== -->
<section class="about-hero">
    <div class="about-hero-overlay"></div>
    <div class="container position-relative z-1 text-center">
        <span class="section-tag-white">Notre histoire</span>
        <h1 class="about-hero-title">À propos de <span class="text-yellow">BeninExplore</span></h1>
        <p class="about-hero-sub">
            Une plateforme née d'une passion pour le Bénin et ses richesses culturelles,<br class="d-none d-md-block">
            avec la mission de les faire découvrir au monde entier.
        </p>
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item active text-white">À propos</li>
            </ol>
        </nav>
    </div>
</section>

<!-- ===== NOTRE HISTOIRE ===== -->
<section class="py-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="story-img-wrap">
                    <img src="https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Notre histoire" class="story-img">
                    <div class="story-card-float">
                        <div class="story-float-icon"><i class="fas fa-award"></i></div>
                        <div>
                            <div class="story-float-title">Depuis 2024</div>
                            <div class="story-float-sub">Au service du tourisme béninois</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <span class="section-tag">Notre histoire</span>
                <h2 class="section-title mt-2">Une plateforme née d'une passion pour le Bénin</h2>
                <p class="text-muted mb-3" style="line-height:1.8;">
                    BeninExplore est né en 2024 d'un constat simple : le Bénin, avec ses palais royaux classés UNESCO, sa Route des Esclaves, sa cité lacustre de Ganvié et son Parc Pendjari, mérite une vitrine numérique à la hauteur de sa richesse.
                </p>
                <p class="text-muted mb-4" style="line-height:1.8;">
                    Notre équipe de passionnés met tout en œuvre pour valoriser l'authenticité de chaque destination et offrir aux voyageurs une expérience de réservation simple, sécurisée et humaine.
                </p>

                <div class="story-stats">
                    <div class="story-stat">
                        <div class="story-stat-num">2024</div>
                        <div class="story-stat-label">Année de création</div>
                    </div>
                    <div class="story-stat-divider"></div>
                    <div class="story-stat">
                        <div class="story-stat-num">5 000+</div>
                        <div class="story-stat-label">Voyageurs satisfaits</div>
                    </div>
                    <div class="story-stat-divider"></div>
                    <div class="story-stat">
                        <div class="story-stat-num">12</div>
                        <div class="story-stat-label">Villes couvertes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== MISSION / VISION / VALEURS ===== -->
<section class="py-section bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Notre engagement</span>
            <h2 class="section-title mt-2">Ce qui nous guide</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="mvv-card">
                    <div class="mvv-icon" style="background: rgba(0,135,81,0.1); color: #008751;">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="mvv-title">Mission</h3>
                    <p class="mvv-desc">Promouvoir le tourisme béninois en offrant une plateforme de réservation simple, sécurisée et accessible à tous les voyageurs du monde.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mvv-card mvv-card-featured">
                    <div class="mvv-icon" style="background: rgba(255,255,255,0.2); color: #FFD600;">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="mvv-title text-white">Vision</h3>
                    <p class="mvv-desc text-white" style="opacity:0.85;">Devenir la référence incontournable du tourisme en Afrique de l'Ouest, en mettant le Bénin sur la carte des grandes destinations mondiales.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mvv-card">
                    <div class="mvv-icon" style="background: rgba(232,17,45,0.1); color: #E8112D;">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="mvv-title">Valeurs</h3>
                    <p class="mvv-desc">Authenticité, innovation, transparence et tourisme responsable. Nous croyons que le voyage doit profiter aux communautés locales.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CHIFFRES CLÉS ===== -->
<section class="stats-band">
    <div class="container">
        <div class="stats-band-inner">
            <?php
            $stats = [
                ['num' => '50+',   'label' => 'Hébergements', 'icon' => 'fa-hotel'],
                ['num' => '30+',   'label' => 'Sites touristiques', 'icon' => 'fa-landmark'],
                ['num' => '15+',   'label' => 'Villes', 'icon' => 'fa-city'],
                ['num' => '5 000+','label' => 'Voyageurs', 'icon' => 'fa-users'],
            ];
            foreach ($stats as $s): ?>
            <div class="stats-band-item">
                <div class="stats-band-icon"><i class="fas <?= $s['icon'] ?>"></i></div>
                <div class="stats-band-num"><?= $s['num'] ?></div>
                <div class="stats-band-label"><?= $s['label'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== ÉQUIPE ===== -->
<section class="py-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Les humains derrière le projet</span>
            <h2 class="section-title mt-2">Notre équipe</h2>
            <p class="section-sub">Des passionnés du Bénin qui œuvrent chaque jour pour vous offrir le meilleur.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php
            $team = [
                ['initiales' => 'JD', 'nom' => 'Jean Dupont',    'poste' => 'CEO & Fondateur',         'color' => '#008751'],
                ['initiales' => 'MS', 'nom' => 'Marie Soglo',    'poste' => 'Directrice Marketing',    'color' => '#FFD600'],
                ['initiales' => 'KA', 'nom' => 'Koffi Adjovi',   'poste' => 'Responsable Technique',   'color' => '#E8112D'],
                ['initiales' => 'AD', 'nom' => 'Aminata Diallo', 'poste' => 'Relation Clientèle',      'color' => '#005c37'],
            ];
            foreach ($team as $m): ?>
            <div class="col-6 col-md-3">
                <div class="team-card">
                    <div class="team-avatar" style="background: linear-gradient(135deg, <?= $m['color'] ?>, <?= $m['color'] ?>99);">
                        <?= $m['initiales'] ?>
                    </div>
                    <h3 class="team-name"><?= $m['nom'] ?></h3>
                    <p class="team-poste"><?= $m['poste'] ?></p>
                    <div class="team-socials">
                        <a href="#" class="team-social" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="team-social" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== AVANTAGES ===== -->
<section class="py-section bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Pourquoi nous choisir</span>
            <h2 class="section-title mt-2">Nos engagements</h2>
        </div>
        <div class="row g-4">
            <?php
            $avantages = [
                ['icon' => 'fa-check-circle',  'titre' => 'Hébergements vérifiés',   'desc' => 'Chaque établissement est inspecté et validé par notre équipe avant d\'être publié sur la plateforme.'],
                ['icon' => 'fa-credit-card',   'titre' => 'Paiement sécurisé',       'desc' => 'Toutes vos transactions sont protégées par un chiffrement SSL de dernière génération.'],
                ['icon' => 'fa-headset',       'titre' => 'Support 24/7',             'desc' => 'Notre équipe est disponible à toute heure pour répondre à vos questions et résoudre vos problèmes.'],
                ['icon' => 'fa-map-marked-alt','titre' => 'Expériences authentiques', 'desc' => 'Nous travaillons directement avec des acteurs locaux pour garantir des expériences de voyage uniques.'],
                ['icon' => 'fa-leaf',          'titre' => 'Tourisme responsable',     'desc' => 'Nous encourageons des pratiques touristiques durables qui respectent l\'environnement et les cultures locales.'],
                ['icon' => 'fa-tags',          'titre' => 'Meilleurs tarifs',         'desc' => 'Nos partenariats directs avec les hébergeurs nous permettent de vous offrir les meilleurs prix du marché.'],
            ];
            foreach ($avantages as $a): ?>
            <div class="col-md-6 col-lg-4">
                <div class="avantage-card">
                    <div class="avantage-icon"><i class="fas <?= $a['icon'] ?>"></i></div>
                    <div>
                        <h3 class="avantage-title"><?= $a['titre'] ?></h3>
                        <p class="avantage-desc"><?= $a['desc'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== TÉMOIGNAGES ===== -->
<section class="py-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Avis</span>
            <h2 class="section-title mt-2">Ils nous font confiance</h2>
        </div>
        <div class="row g-4">
            <?php
            $avis = [
                ['texte' => '"Service impeccable du début à la fin. La réservation était simple et l\'hébergement correspondait parfaitement aux photos. Je recommande vivement !"', 'nom' => 'Pierre K.',    'ville' => 'Cotonou'],
                ['texte' => '"Réservation simple et rapide ! En moins de 5 minutes j\'avais ma confirmation. L\'équipe support a été très réactive quand j\'ai eu une question."',    'nom' => 'Fatima D.',   'ville' => 'Abomey'],
                ['texte' => '"Des lieux magnifiques à découvrir. BeninExplore m\'a fait découvrir des endroits que je n\'aurais jamais trouvés seul. Merci pour cette belle aventure."','nom' => 'Jean-Marc L.','ville' => 'Paris'],
            ];
            foreach ($avis as $a): ?>
            <div class="col-md-4 d-flex">
                <div class="review-card w-100">
                    <div class="review-quote"><i class="fas fa-quote-left"></i></div>
                    <div class="review-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="review-text"><?= $a['texte'] ?></p>
                    <div class="review-author">
                        <div class="review-avatar"><?= strtoupper(substr($a['nom'], 0, 1)) ?></div>
                        <div>
                            <div class="review-name"><?= $a['nom'] ?></div>
                            <div class="review-location"><i class="fas fa-map-marker-alt me-1"></i><?= $a['ville'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="cta-title">Prêt à explorer le Bénin ?</h2>
        <p class="cta-sub">Rejoignez des milliers de voyageurs qui ont découvert les merveilles du Bénin grâce à BeninExplore.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="/hebergements" class="btn btn-cta-primary">
                <i class="fas fa-search me-2"></i>Explorer les hébergements
            </a>
            <a href="/contact" class="btn btn-cta-outline">
                <i class="fas fa-envelope me-2"></i>Nous contacter
            </a>
        </div>
    </div>
</section>

<style>
/* ===== HERO ===== */
.about-hero {
    position: relative;
    padding: 120px 0 70px;
    background: url('https://images.unsplash.com/photo-1590608897129-79da3d22b0c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
}
.about-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,30,15,0.88) 0%, rgba(0,87,51,0.75) 100%);
}
.about-hero-title {
    font-size: clamp(1.8rem, 4vw, 3rem);
    font-weight: 800; color: white;
    margin: 12px 0 16px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
}
.text-yellow { color: #FFD600; }
.about-hero-sub {
    color: rgba(255,255,255,0.8);
    font-size: 1rem; line-height: 1.7;
    max-width: 600px; margin: 0 auto;
}
.section-tag-white {
    display: inline-block;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    font-size: 0.75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1.2px;
    padding: 5px 14px; border-radius: 50px;
}

/* ===== GÉNÉRAL ===== */
.py-section { padding: 80px 0; }
.bg-soft { background: #f7faf8; }
.section-header { text-align: center; margin-bottom: 48px; }
.section-tag {
    display: inline-block;
    background: rgba(0,135,81,0.1);
    color: #008751;
    font-size: 0.75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1.2px;
    padding: 5px 14px; border-radius: 50px;
}
.section-title { font-size: clamp(1.4rem, 3vw, 1.9rem); font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
.section-sub { color: #888; font-size: 0.95rem; }

/* ===== HISTOIRE ===== */
.story-img-wrap { position: relative; }
.story-img { width: 100%; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
.story-card-float {
    position: absolute; bottom: -20px; right: -16px;
    background: white;
    border-radius: 16px;
    padding: 16px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    min-width: 220px;
}
.story-float-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #008751, #00a862);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #FFD600; font-size: 20px; flex-shrink: 0;
}
.story-float-title { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; }
.story-float-sub { font-size: 0.78rem; color: #888; }
.story-stats { display: flex; align-items: center; gap: 24px; flex-wrap: wrap; }
.story-stat-num { font-size: 1.6rem; font-weight: 800; color: #008751; line-height: 1; }
.story-stat-label { font-size: 0.78rem; color: #888; margin-top: 2px; }
.story-stat-divider { width: 1px; height: 40px; background: #e0e0e0; }

/* ===== MVV ===== */
.mvv-card {
    background: white;
    border-radius: 20px;
    padding: 32px 28px;
    height: 100%;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
    transition: transform 0.3s, box-shadow 0.3s;
}
.mvv-card:hover { transform: translateY(-6px); box-shadow: 0 14px 35px rgba(0,135,81,0.12); }
.mvv-card-featured {
    background: linear-gradient(135deg, #008751, #005c37);
    border: none;
}
.mvv-icon {
    width: 56px; height: 56px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    margin-bottom: 18px;
}
.mvv-title { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 10px; }
.mvv-desc { font-size: 0.88rem; color: #666; line-height: 1.7; margin: 0; }

/* ===== STATS BAND ===== */
.stats-band { background: linear-gradient(135deg, #0d2b1e, #008751); padding: 50px 0; }
.stats-band-inner {
    display: flex; justify-content: space-around; align-items: center;
    flex-wrap: wrap; gap: 30px;
}
.stats-band-item { text-align: center; }
.stats-band-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.1);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: #FFD600; font-size: 20px;
    margin: 0 auto 12px;
}
.stats-band-num { font-size: 2rem; font-weight: 800; color: white; line-height: 1; }
.stats-band-label { font-size: 0.82rem; color: rgba(255,255,255,0.7); margin-top: 4px; }

/* ===== ÉQUIPE ===== */
.team-card {
    background: white;
    border-radius: 18px;
    padding: 28px 20px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    border: 1px solid #f0f0f0;
    transition: all 0.3s;
}
.team-card:hover { transform: translateY(-6px); box-shadow: 0 14px 35px rgba(0,135,81,0.12); }
.team-avatar {
    width: 72px; height: 72px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 1.3rem; font-weight: 800;
    margin: 0 auto 14px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
.team-name { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
.team-poste { font-size: 0.78rem; color: #888; margin-bottom: 14px; }
.team-socials { display: flex; justify-content: center; gap: 8px; }
.team-social {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: #f5f5f5;
    color: #888;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; text-decoration: none;
    transition: all 0.2s;
}
.team-social:hover { background: #008751; color: white; transform: translateY(-2px); }

/* ===== AVANTAGES ===== */
.avantage-card {
    display: flex; align-items: flex-start; gap: 16px;
    background: white;
    border-radius: 14px;
    padding: 22px 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
    transition: all 0.3s;
    height: 100%;
}
.avantage-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,135,81,0.1); border-color: rgba(0,135,81,0.2); }
.avantage-icon {
    width: 46px; height: 46px;
    background: rgba(0,135,81,0.1);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #008751; font-size: 18px; flex-shrink: 0;
    transition: all 0.3s;
}
.avantage-card:hover .avantage-icon { background: #008751; color: white; }
.avantage-title { font-size: 0.92rem; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
.avantage-desc { font-size: 0.82rem; color: #777; line-height: 1.6; margin: 0; }

/* ===== TÉMOIGNAGES ===== */
.review-card {
    background: white; border-radius: 18px; padding: 28px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
    display: flex; flex-direction: column;
    transition: all 0.3s;
}
.review-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,135,81,0.1); }
.review-quote { color: rgba(0,135,81,0.15); font-size: 2rem; line-height: 1; margin-bottom: 10px; }
.review-stars { color: #FFD600; font-size: 0.85rem; margin-bottom: 14px; }
.review-text { font-size: 0.88rem; color: #555; font-style: italic; line-height: 1.7; flex: 1; margin-bottom: 20px; }
.review-author { display: flex; align-items: center; gap: 12px; margin-top: auto; }
.review-avatar {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #008751, #FFD600);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 16px; flex-shrink: 0;
}
.review-name { font-size: 0.88rem; font-weight: 700; color: #1a1a2e; }
.review-location { font-size: 0.75rem; color: #aaa; }

/* ===== CTA ===== */
.cta-section {
    background: linear-gradient(135deg, #008751, #005c37);
    padding: 80px 0;
}
.cta-title { font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color: white; margin-bottom: 12px; }
.cta-sub { color: rgba(255,255,255,0.8); font-size: 1rem; max-width: 520px; margin: 0 auto 32px; }
.btn-cta-primary {
    background: white; color: #008751;
    border: none; border-radius: 50px;
    padding: 13px 30px; font-weight: 700;
    transition: all 0.3s;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
.btn-cta-primary:hover { color: #005c37; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,0.2); }
.btn-cta-outline {
    background: transparent; color: white;
    border: 2px solid rgba(255,255,255,0.5);
    border-radius: 50px;
    padding: 13px 30px; font-weight: 600;
    transition: all 0.3s;
}
.btn-cta-outline:hover { background: rgba(255,255,255,0.15); color: white; border-color: white; }

@media (max-width: 768px) {
    .story-card-float { right: 0; min-width: auto; }
    .stats-band-inner { gap: 20px; }
    .stats-band-num { font-size: 1.5rem; }
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>