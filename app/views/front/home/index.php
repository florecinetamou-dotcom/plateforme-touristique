<?php $title = 'Accueil - BeninExplore'; ?>
<?php $meta_description = 'Découvrez les merveilles du Bénin : sites historiques, hébergements authentiques et destinations uniques en Afrique de l\'Ouest.'; ?>
<?php ob_start(); ?>

<!-- ===== HERO ===== -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content container">
        <div class="row align-items-center min-vh-80">
            <div class="col-lg-7">
                <span class="hero-badge">
                    <i class="fas fa-map-marker-alt me-1"></i>Bénin, Afrique de l'Ouest
                </span>
                <h1 class="hero-title">
                    Découvrez les merveilles du <span class="hero-accent">Bénin</span>
                </h1>
                <p class="hero-subtitle">
                    Explorez des hébergements authentiques, des sites historiques classés UNESCO et vivez une expérience inoubliable au cœur de l'Afrique.
                </p>
                <div class="hero-actions">
                    <a href="/hebergements" class="btn btn-hero-primary">
                        <i class="fas fa-search me-2"></i>Explorer les hébergements
                    </a>
                    <a href="/sites" class="btn btn-hero-outline">
                        <i class="fas fa-landmark me-2"></i>Voir les sites
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="scroll-indicator">
        <div class="scroll-dot"></div>
    </div>
</section>

<!-- ===== STATS ===== -->
<section class="stats-section">
    <div class="container">
        <div class="stats-wrapper">
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label"><i class="fas fa-hotel me-1"></i>Hébergements</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">30+</div>
                <div class="stat-label"><i class="fas fa-landmark me-1"></i>Sites touristiques</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">15+</div>
                <div class="stat-label"><i class="fas fa-city me-1"></i>Villes</div>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <div class="stat-number">5 000+</div>
                <div class="stat-label"><i class="fas fa-users me-1"></i>Voyageurs</div>
            </div>
        </div>
    </div>
</section>

<!-- ===== DESTINATIONS ===== -->
<section class="py-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Destinations</span>
            <h2 class="section-title">Les villes incontournables</h2>
            <p class="section-sub">Du littoral à l'intérieur des terres, chaque ville a son histoire</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="dest-card w-100">
                    <div class="dest-img-wrap">
                        <img src="https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Cotonou" class="dest-img">
                        <div class="dest-overlay">
                            <a href="/ville/1" class="dest-btn">Explorer <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                        <span class="dest-badge"><i class="fas fa-hotel me-1"></i>50+ hébergements</span>
                    </div>
                    <div class="dest-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="dest-name">Cotonou</h3>
                                <p class="dest-desc">Capitale économique, marchés animés, plages</p>
                            </div>
                            <div class="dest-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 d-flex">
                <div class="dest-card w-100">
                    <div class="dest-img-wrap">
                        <img src="https://images.unsplash.com/photo-1590608897129-79da3d22b0c2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Ouidah" class="dest-img">
                        <div class="dest-overlay">
                            <a href="/ville/2" class="dest-btn">Explorer <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                        <span class="dest-badge"><i class="fas fa-landmark me-1"></i>30+ sites</span>
                    </div>
                    <div class="dest-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="dest-name">Ouidah</h3>
                                <p class="dest-desc">Route des Esclaves, temple des pythons</p>
                            </div>
                            <div class="dest-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 d-flex">
                <div class="dest-card w-100">
                    <div class="dest-img-wrap">
                        <img src="https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Abomey" class="dest-img">
                        <div class="dest-overlay">
                            <a href="/ville/3" class="dest-btn">Explorer <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                        <span class="dest-badge"><i class="fas fa-crown me-1"></i>UNESCO</span>
                    </div>
                    <div class="dest-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="dest-name">Abomey</h3>
                                <p class="dest-desc">Palais royaux, histoire du Dahomey</p>
                            </div>
                            <div class="dest-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="/villes" class="btn btn-outline-green">
                Toutes les destinations <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- ===== HÉBERGEMENTS ===== -->
<section class="py-section bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Coups de cœur</span>
            <h2 class="section-title">Hébergements populaires</h2>
            <p class="section-sub">Sélectionnés et vérifiés par notre équipe</p>
        </div>

        <div class="row g-4">
            <?php
            $hotels = [
                ['nom' => 'Hôtel Azalaï Cotonou', 'ville' => 'Cotonou', 'prix' => '85 000', 'note' => '4.8', 'id' => 1],
                ['nom' => 'Novotel Orisha',        'ville' => 'Cotonou', 'prix' => '45 000', 'note' => '4.6', 'id' => 2],
                ['nom' => 'Chez Mama',             'ville' => 'Ouidah',  'prix' => '25 000', 'note' => '4.9', 'id' => 3],
            ];
            foreach ($hotels as $h): ?>
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="hotel-card w-100">
                    <div class="hotel-img-wrap">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="<?= $h['nom'] ?>" class="hotel-img">
                        <span class="hotel-note"><i class="fas fa-star text-warning me-1"></i><?= $h['note'] ?></span>
                        <button class="hotel-fav" aria-label="Ajouter aux favoris">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="hotel-body">
                        <h3 class="hotel-name"><?= $h['nom'] ?></h3>
                        <p class="hotel-location">
                            <i class="fas fa-map-marker-alt me-1"></i><?= $h['ville'] ?>
                        </p>
                        <div class="hotel-footer">
                            <div>
                                <span class="hotel-price"><?= $h['prix'] ?> FCFA</span>
                                <span class="hotel-per">/nuit</span>
                            </div>
                            <a href="/hebergement/<?= $h['id'] ?>" class="btn btn-sm btn-green">Voir</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="/hebergements" class="btn btn-outline-green">
                Tous les hébergements <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- ===== SITES INCONTOURNABLES ===== -->
<section class="py-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2">
                <div class="sites-img-wrap">
                    <img src="https://images.unsplash.com/photo-1523805009345-7448845a9e53?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Sites du Bénin" class="sites-img">
                    <div class="sites-img-badge">
                        <i class="fas fa-award me-2"></i>Patrimoine mondial UNESCO
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <span class="section-tag">Sites</span>
                <h2 class="section-title mt-2">À ne pas manquer</h2>
                <p class="text-muted mb-4">Du Nord au Sud, le Bénin regorge de trésors culturels, historiques et naturels qui vous laisseront sans voix.</p>

                <div class="sites-list">
                    <?php
                    $sites_list = [
                        ['nom' => 'Palais d\'Abomey',    'desc' => 'Patrimoine UNESCO',     'icon' => 'fa-crown'],
                        ['nom' => 'Route des Esclaves',  'desc' => 'Mémoire & histoire',    'icon' => 'fa-road'],
                        ['nom' => 'Ganvié',              'desc' => 'Cité lacustre unique',  'icon' => 'fa-water'],
                        ['nom' => 'Parc Pendjari',       'desc' => 'Safari & faune sauvage','icon' => 'fa-paw'],
                    ];
                    foreach ($sites_list as $s): ?>
                    <div class="site-item">
                        <div class="site-icon">
                            <i class="fas <?= $s['icon'] ?>"></i>
                        </div>
                        <div>
                            <div class="site-name"><?= $s['nom'] ?></div>
                            <div class="site-desc"><?= $s['desc'] ?></div>
                        </div>
                        <i class="fas fa-chevron-right site-arrow ms-auto"></i>
                    </div>
                    <?php endforeach; ?>
                </div>

                <a href="/sites" class="btn btn-green mt-4">
                    Découvrir tous les sites <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== POURQUOI NOUS ===== -->
<section class="why-section py-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag" style="background:rgba(255,255,255,0.15); color:white;">Nos avantages</span>
            <h2 class="section-title text-white">Pourquoi choisir BeninExplore ?</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php
            $avantages = [
                ['icon' => 'fa-shield-alt',   'titre' => 'Paiement sécurisé',   'desc' => 'Transactions 100% sécurisées'],
                ['icon' => 'fa-headset',      'titre' => 'Support 24/7',         'desc' => 'Une équipe toujours disponible'],
                ['icon' => 'fa-tags',         'titre' => 'Meilleurs prix',       'desc' => 'Tarifs négociés directement'],
                ['icon' => 'fa-map-marked-alt','titre' => 'Voyage authentique',  'desc' => 'Expériences locales uniques'],
            ];
            foreach ($avantages as $a): ?>
            <div class="col-6 col-md-3">
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas <?= $a['icon'] ?>"></i>
                    </div>
                    <div class="why-title"><?= $a['titre'] ?></div>
                    <div class="why-desc"><?= $a['desc'] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== TÉMOIGNAGES ===== -->
<section class="py-section bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Avis</span>
            <h2 class="section-title">Ils ont voyagé avec nous</h2>
        </div>

        <div class="row g-4">
            <?php
            $temoignages = [
                ['texte' => '"Séjour incroyable à Ouidah ! L\'hébergement était parfait, l\'accueil chaleureux. Je recommande vivement."', 'nom' => 'Marie-Claire D.', 'ville' => 'Cotonou'],
                ['texte' => '"Le Parc Pendjari est magnifique. Une expérience safari unique que je n\'oublierai jamais !"',               'nom' => 'Jean K.',         'ville' => 'Porto-Novo'],
                ['texte' => '"Ganvié, la Venise de l\'Afrique ! Une expérience unique à ne surtout pas manquer lors de votre visite."',  'nom' => 'Sophie A.',       'ville' => 'Paris'],
            ];
            foreach ($temoignages as $i => $t): ?>
            <div class="col-md-4 d-flex">
                <div class="review-card w-100">
                    <div class="review-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="review-text"><?= $t['texte'] ?></p>
                    <div class="review-author">
                        <div class="review-avatar"><?= strtoupper(substr($t['nom'], 0, 1)) ?></div>
                        <div>
                            <div class="review-name"><?= $t['nom'] ?></div>
                            <div class="review-location"><i class="fas fa-map-marker-alt me-1"></i><?= $t['ville'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== NEWSLETTER ===== -->
<section class="newsletter-section py-section">
    <div class="container">
        <div class="newsletter-box">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h3 class="newsletter-title">Restez informé de nos offres</h3>
                    <p class="newsletter-sub">Recevez nos meilleures offres, nouveautés et conseils de voyage directement dans votre boîte mail.</p>
                </div>
                <div class="col-lg-6">
                    <div class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Votre adresse email...">
                        <button class="newsletter-btn">
                            S'inscrire <i class="fas fa-paper-plane ms-1"></i>
                        </button>
                    </div>
                    <p class="newsletter-note"><i class="fas fa-lock me-1"></i>Pas de spam, désabonnement à tout moment.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ===== HERO ===== */
.hero-section {
    position: relative;
    min-height: 88vh;
    background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
    display: flex;
    align-items: center;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, rgba(0,20,10,0.82) 0%, rgba(0,60,30,0.5) 60%, rgba(0,0,0,0.2) 100%);
}
.hero-content {
    position: relative;
    z-index: 1;
    padding-top: 80px;
    padding-bottom: 60px;
}
.min-vh-80 { min-height: 80vh; }
.hero-badge {
    display: inline-block;
    background: rgba(255,214,0,0.2);
    border: 1px solid rgba(255,214,0,0.4);
    color: #FFD600;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 0.82rem;
    font-weight: 500;
    margin-bottom: 20px;
    backdrop-filter: blur(8px);
}
.hero-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    color: white;
    line-height: 1.15;
    margin-bottom: 20px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
}
.hero-accent { color: #FFD600; }
.hero-subtitle {
    font-size: clamp(1rem, 2vw, 1.15rem);
    color: rgba(255,255,255,0.85);
    line-height: 1.7;
    margin-bottom: 36px;
    max-width: 540px;
}
.hero-actions { display: flex; flex-wrap: wrap; gap: 14px; }
.btn-hero-primary {
    background: linear-gradient(135deg, #008751, #00a862);
    color: white; border: none;
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s;
    box-shadow: 0 6px 20px rgba(0,135,81,0.4);
}
.btn-hero-primary:hover { color: white; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,135,81,0.5); }
.btn-hero-outline {
    background: rgba(255,255,255,0.12);
    color: white;
    border: 1.5px solid rgba(255,255,255,0.4);
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s;
    backdrop-filter: blur(8px);
}
.btn-hero-outline:hover { background: rgba(255,255,255,0.22); color: white; }

/* Scroll indicator */
.scroll-indicator {
    position: absolute;
    bottom: 30px; left: 50%;
    transform: translateX(-50%);
    z-index: 1;
}
.scroll-dot {
    width: 28px; height: 44px;
    border: 2px solid rgba(255,255,255,0.5);
    border-radius: 14px;
    position: relative;
}
.scroll-dot::after {
    content: '';
    position: absolute;
    width: 4px; height: 8px;
    background: white;
    border-radius: 2px;
    left: 50%; top: 6px;
    transform: translateX(-50%);
    animation: scrollDot 1.6s ease-in-out infinite;
}
@keyframes scrollDot {
    0%, 100% { opacity: 1; transform: translateX(-50%) translateY(0); }
    50%       { opacity: 0; transform: translateX(-50%) translateY(12px); }
}

/* ===== STATS ===== */
.stats-section {
    background: linear-gradient(135deg, #008751, #005c37);
    padding: 0;
}
.stats-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 28px 0;
    flex-wrap: wrap;
    gap: 20px;
}
.stat-item { text-align: center; }
.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}
.stat-label { font-size: 0.82rem; color: rgba(255,255,255,0.75); margin-top: 4px; }
.stat-divider {
    width: 1px; height: 40px;
    background: rgba(255,255,255,0.2);
}
@media (max-width: 576px) { .stat-divider { display: none; } }

/* ===== SECTIONS ===== */
.py-section { padding: 80px 0; }
.bg-soft { background: #f7faf8; }

.section-header { text-align: center; margin-bottom: 48px; }
.section-tag {
    display: inline-block;
    background: rgba(0,135,81,0.1);
    color: #008751;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    padding: 5px 14px;
    border-radius: 50px;
    margin-bottom: 12px;
}
.section-title { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
.section-sub { color: #888; font-size: 0.95rem; }

/* Boutons globaux */
.btn-green {
    background: linear-gradient(135deg, #008751, #00a862);
    color: white; border: none;
    border-radius: 50px;
    padding: 10px 26px;
    font-weight: 600;
    font-size: 0.88rem;
    transition: all 0.3s;
    box-shadow: 0 4px 14px rgba(0,135,81,0.25);
}
.btn-green:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 22px rgba(0,135,81,0.35); }
.btn-outline-green {
    border: 2px solid #008751;
    color: #008751;
    background: transparent;
    border-radius: 50px;
    padding: 10px 26px;
    font-weight: 600;
    font-size: 0.88rem;
    transition: all 0.3s;
}
.btn-outline-green:hover { background: #008751; color: white; transform: translateY(-2px); }

/* ===== DESTINATIONS ===== */
.dest-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    background: white;
}
.dest-card:hover { transform: translateY(-6px); box-shadow: 0 14px 35px rgba(0,135,81,0.15); }
.dest-img-wrap { position: relative; overflow: hidden; }
.dest-img { width: 100%; height: 220px; object-fit: cover; transition: transform 0.4s ease; }
.dest-card:hover .dest-img { transform: scale(1.05); }
.dest-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.3s;
}
.dest-card:hover .dest-overlay { opacity: 1; }
.dest-btn {
    background: white; color: #008751;
    padding: 10px 24px; border-radius: 50px;
    font-weight: 600; font-size: 0.88rem;
    text-decoration: none;
    transition: all 0.2s;
}
.dest-btn:hover { background: #008751; color: white; }
.dest-badge {
    position: absolute; top: 12px; left: 12px;
    background: rgba(0,135,81,0.9);
    color: white; font-size: 0.75rem; font-weight: 600;
    padding: 4px 12px; border-radius: 50px;
    backdrop-filter: blur(4px);
}
.dest-body { padding: 18px; }
.dest-name { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
.dest-desc { font-size: 0.82rem; color: #888; margin: 0; }
.dest-stars { color: #FFD600; font-size: 0.75rem; white-space: nowrap; }

/* ===== HOTELS ===== */
.hotel-card {
    border-radius: 16px;
    overflow: hidden;
    background: white;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
}
.hotel-card:hover { transform: translateY(-6px); box-shadow: 0 14px 35px rgba(0,135,81,0.15); }
.hotel-img-wrap { position: relative; overflow: hidden; }
.hotel-img { width: 100%; height: 190px; object-fit: cover; transition: transform 0.4s; }
.hotel-card:hover .hotel-img { transform: scale(1.05); }
.hotel-note {
    position: absolute; top: 12px; right: 12px;
    background: rgba(0,0,0,0.7);
    color: white; font-size: 0.78rem; font-weight: 600;
    padding: 4px 10px; border-radius: 50px;
}
.hotel-fav {
    position: absolute; top: 12px; left: 12px;
    background: white; border: none;
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #ccc; font-size: 14px;
    transition: all 0.2s; cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.hotel-fav:hover { color: #ef4444; transform: scale(1.1); }
.hotel-body { padding: 16px; }
.hotel-name { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
.hotel-location { font-size: 0.8rem; color: #888; margin-bottom: 14px; }
.hotel-location i { color: #008751; }
.hotel-footer { display: flex; justify-content: space-between; align-items: center; }
.hotel-price { font-size: 1rem; font-weight: 700; color: #008751; }
.hotel-per { font-size: 0.75rem; color: #aaa; margin-left: 2px; }

/* ===== SITES ===== */
.sites-img-wrap { position: relative; }
.sites-img { width: 100%; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); }
.sites-img-badge {
    position: absolute;
    bottom: -16px; left: 24px;
    background: white;
    color: #008751;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 50px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}
.sites-list { display: flex; flex-direction: column; gap: 12px; }
.site-item {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 16px;
    border: 1.5px solid #eee;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s;
}
.site-item:hover { border-color: #008751; background: #f0faf5; }
.site-icon {
    width: 40px; height: 40px;
    background: rgba(0,135,81,0.1);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #008751; font-size: 16px; flex-shrink: 0;
}
.site-name { font-size: 0.9rem; font-weight: 600; color: #1a1a2e; }
.site-desc { font-size: 0.78rem; color: #888; }
.site-arrow { color: #ccc; font-size: 12px; }
.site-item:hover .site-arrow { color: #008751; }

/* ===== POURQUOI ===== */
.why-section {
    background: linear-gradient(135deg, #0d2b1e 0%, #008751 100%);
}
.why-card { text-align: center; padding: 10px; }
.why-icon {
    width: 64px; height: 64px;
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.2);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    color: #FFD600; font-size: 24px;
    margin: 0 auto 16px;
    transition: all 0.3s;
}
.why-card:hover .why-icon { background: rgba(255,214,0,0.2); transform: translateY(-4px); }
.why-title { font-size: 0.95rem; font-weight: 700; color: white; margin-bottom: 6px; }
.why-desc { font-size: 0.8rem; color: rgba(255,255,255,0.6); }

/* ===== TÉMOIGNAGES ===== */
.review-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
    transition: all 0.3s;
    display: flex; flex-direction: column;
}
.review-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,135,81,0.1); }
.review-stars { color: #FFD600; font-size: 0.85rem; margin-bottom: 14px; }
.review-text { font-size: 0.9rem; color: #555; font-style: italic; line-height: 1.7; flex: 1; margin-bottom: 18px; }
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

/* ===== NEWSLETTER ===== */
.newsletter-section { background: #f7faf8; }
.newsletter-box {
    background: linear-gradient(135deg, #008751 0%, #005c37 100%);
    border-radius: 24px;
    padding: 50px 48px;
    box-shadow: 0 20px 50px rgba(0,135,81,0.25);
}
.newsletter-title { font-size: 1.5rem; font-weight: 700; color: white; margin-bottom: 8px; }
.newsletter-sub { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin: 0; }
.newsletter-form {
    display: flex; gap: 10px;
    background: white;
    border-radius: 50px;
    padding: 6px 6px 6px 20px;
}
.newsletter-input {
    flex: 1; border: none; outline: none;
    font-size: 0.9rem; color: #333;
    background: transparent;
}
.newsletter-btn {
    background: linear-gradient(135deg, #008751, #00a862);
    color: white; border: none;
    border-radius: 50px;
    padding: 10px 24px;
    font-weight: 600; font-size: 0.88rem;
    white-space: nowrap;
    transition: all 0.3s;
}
.newsletter-btn:hover { filter: brightness(1.1); }
.newsletter-note {
    color: rgba(255,255,255,0.55);
    font-size: 0.78rem;
    margin-top: 10px; margin-bottom: 0;
}

@media (max-width: 576px) {
    .newsletter-box { padding: 30px 24px; }
    .newsletter-form { flex-direction: column; border-radius: 16px; padding: 12px; }
    .newsletter-input { padding: 8px 4px; }
    .newsletter-btn { border-radius: 10px; }
    .hero-actions { flex-direction: column; }
    .btn-hero-primary, .btn-hero-outline { text-align: center; }
    .stats-wrapper { gap: 12px; }
    .stat-number { font-size: 1.5rem; }
}
</style>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>