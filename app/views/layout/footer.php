<?php
// Villes dynamiques depuis la BDD
$footerVilles = [];
try {
    $pdo = \Core\Database::getInstance();
    $stmt = $pdo->query("SELECT id, nom FROM ville WHERE est_active = 1 ORDER BY nom ASC LIMIT 6");
    $footerVilles = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch (\Exception $e) {
    $footerVilles = [];
}
?>

</main>

<footer class="site-footer">

    <!-- Vague décorative -->
    <div class="footer-wave">
        <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C240,80 480,0 720,40 C960,80 1200,0 1440,40 L1440,80 L0,80 Z" fill="#0a1f14"/>
        </svg>
    </div>

    <div class="footer-body">
        <div class="container">
            <div class="row g-5">

                <!-- ── Branding ── -->
                <div class="col-lg-4 col-md-12">
                    <a href="/" class="footer-brand">
                        <div class="footer-brand-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span>Benin<strong>Explore</strong></span>
                    </a>
                    <p class="footer-desc mt-3">
                        Votre guide de référence pour explorer le Bénin authentique —
                        sites historiques, nature, culture et hébergements de qualité.
                    </p>

                    <!-- Drapeau Bénin -->
                    <div class="benin-flag">
                        <span class="flag-green"></span>
                        <span class="flag-yellow"></span>
                        <span class="flag-red"></span>
                        <span class="flag-label">🇧🇯 Fait au Bénin</span>
                    </div>

                    <!-- Réseaux sociaux -->
                    <div class="social-row mt-4">
                        <a href="#" class="social-btn" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-btn" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-btn" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-btn" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="social-btn" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- ── Navigation ── -->
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="footer-col-title">Explorer</div>
                    <ul class="footer-links">
                        <li><a href="/"><i class="fas fa-home"></i>Accueil</a></li>
                        <li><a href="/hebergements"><i class="fas fa-bed"></i>Hébergements</a></li>
                        <li><a href="/sites"><i class="fas fa-landmark"></i>Sites</a></li>
                        <li><a href="/villes"><i class="fas fa-city"></i>Villes</a></li>
                        <li><a href="/about"><i class="fas fa-info-circle"></i>À propos</a></li>
                        <li><a href="/contact"><i class="fas fa-envelope"></i>Contact</a></li>
                    </ul>
                </div>

                <!-- ── Destinations dynamiques ── -->
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="footer-col-title">Destinations</div>
                    <ul class="footer-links">
                        <?php if (!empty($footerVilles)): ?>
                            <?php foreach ($footerVilles as $v): ?>
                            <li>
                                <a href="/ville/<?= $v->id ?>">
                                    <i class="fas fa-map-pin"></i><?= htmlspecialchars($v->nom) ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="/villes"><i class="fas fa-map-pin"></i>Cotonou</a></li>
                            <li><a href="/villes"><i class="fas fa-map-pin"></i>Ouidah</a></li>
                            <li><a href="/villes"><i class="fas fa-map-pin"></i>Abomey</a></li>
                            <li><a href="/villes"><i class="fas fa-map-pin"></i>Porto-Novo</a></li>
                            <li><a href="/villes"><i class="fas fa-map-pin"></i>Parakou</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- ── Contact ── -->
                <div class="col-lg-4 col-md-4">
                    <div class="footer-col-title">Contact</div>
                    <ul class="footer-contact-list">
                        <li>
                            <div class="fc-icon"><i class="fas fa-phone"></i></div>
                            <div>
                                <div class="fc-label">Téléphone</div>
                                <div class="fc-val">+229 01 23 45 67</div>
                            </div>
                        </li>
                        <li>
                            <div class="fc-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="fc-label">Email</div>
                                <div class="fc-val">contact@beninexplore.bj</div>
                            </div>
                        </li>
                        <li>
                            <div class="fc-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <div class="fc-label">Adresse</div>
                                <div class="fc-val">Cotonou, Bénin</div>
                            </div>
                        </li>
                        <li>
                            <div class="fc-icon"><i class="fas fa-clock"></i></div>
                            <div>
                                <div class="fc-label">Horaires</div>
                                <div class="fc-val">Lun – Ven, 8h – 18h</div>
                            </div>
                        </li>
                    </ul>

                    <!-- CTA devenir hébergeur -->
                    <a href="/register" class="footer-cta">
                        <i class="fas fa-hotel me-2"></i>
                        Devenir hébergeur
                        <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- ── Bottom bar ── -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <div class="footer-copy">
                    &copy; <?= date('Y') ?> BeninExplore. Tous droits réservés.
                </div>
                <div class="footer-bottom-links">
                    <a href="#">Confidentialité</a>
                    <span>·</span>
                    <a href="#">Conditions</a>
                    <span>·</span>
                    <a href="#">Aide</a>
                
                    
                </div>
                
            </div>
        </div>
    </div>

</footer>

<style>
/* ══════════════════════════════════
   FOOTER
══════════════════════════════════ */
.site-footer {
    position: relative;
    background: transparent;
    margin-top: 0;
}

.footer-wave {
    display: block;
    line-height: 0;
    margin-bottom: -2px;
}
.footer-wave svg {
    display: block;
    width: 100%;
    height: 80px;
}

.footer-body {
    background: #0a1f14;
    padding: 56px 0 44px;
}

/* ── Branding ── */
.footer-brand {
    display: inline-flex; align-items: center; gap: 10px;
    text-decoration: none;
}
.footer-brand-icon {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #008751, #FFD600);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 17px;
    box-shadow: 0 4px 14px rgba(0,135,81,.35);
    flex-shrink: 0;
}
.footer-brand span {
    font-size: 1.25rem; color: rgba(255,255,255,.85);
    letter-spacing: -.02em;
}
.footer-brand strong { color: #FFD600; font-weight: 800; }

.footer-desc {
    color: rgba(255,255,255,.4);
    font-size: .85rem; line-height: 1.75; margin: 0;
    max-width: 340px;
}

/* Drapeau */
.benin-flag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
    border-radius: 50px; padding: 6px 14px; margin-top: 16px;
}
.flag-green, .flag-yellow, .flag-red {
    width: 10px; height: 10px; border-radius: 50%;
}
.flag-green  { background: #008751; }
.flag-yellow { background: #FFD600; }
.flag-red    { background: #E8112D; }
.flag-label  { font-size: .72rem; color: rgba(255,255,255,.5); margin-left: 2px; }

/* Réseaux sociaux */
.social-row { display: flex; gap: 8px; }
.social-btn {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    color: rgba(255,255,255,.5);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; text-decoration: none;
    transition: all .25s;
}
.social-btn:hover {
    background: #008751; border-color: #008751;
    color: #fff; transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,135,81,.4);
}

/* ── Colonnes ── */
.footer-col-title {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .12em;
    color: rgba(255,255,255,.3); margin-bottom: 18px;
    padding-bottom: 10px; position: relative;
}
.footer-col-title::after {
    content: '';
    position: absolute; bottom: 0; left: 0;
    width: 24px; height: 2px;
    background: linear-gradient(90deg, #008751, #FFD600);
    border-radius: 2px;
}

/* ── Liens ── */
.footer-links {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 8px;
}
.footer-links a {
    color: rgba(255,255,255,.4); text-decoration: none;
    font-size: .84rem; display: flex; align-items: center; gap: 8px;
    transition: all .2s; padding: 3px 0;
}
.footer-links a i {
    width: 16px; text-align: center;
    font-size: .7rem; color: #008751;
    transition: transform .2s;
}
.footer-links a:hover {
    color: rgba(255,255,255,.9);
    padding-left: 4px;
}
.footer-links a:hover i { transform: translateX(3px); color: #FFD600; }

/* ── Contact ── */
.footer-contact-list {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 14px;
    margin-bottom: 20px;
}
.footer-contact-list li {
    display: flex; align-items: flex-start; gap: 12px;
}
.fc-icon {
    width: 32px; height: 32px; flex-shrink: 0;
    background: rgba(0,135,81,.15);
    border: 1px solid rgba(0,135,81,.25);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: #00c76a; font-size: 12px;
    margin-top: 1px;
}
.fc-label { font-size: .68rem; color: rgba(255,255,255,.3); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 1px; }
.fc-val   { font-size: .83rem; color: rgba(255,255,255,.65); }

/* CTA hébergeur */
.footer-cta {
    display: flex; align-items: center; gap: 8px;
    background: rgba(0,135,81,.15);
    border: 1px solid rgba(0,135,81,.3);
    color: #4ade80; border-radius: 10px;
    padding: 11px 16px; font-size: .82rem; font-weight: 600;
    text-decoration: none; transition: all .25s;
}
.footer-cta:hover {
    background: #008751; border-color: #008751;
    color: #fff; transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,135,81,.3);
}

/* ── Bottom bar ── */
.footer-bottom {
    background: #060f0a;
    padding: 14px 0;
    border-top: 1px solid rgba(255,255,255,.05);
}
.footer-bottom-inner {
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap; gap: 10px;
}
.footer-copy { color: rgba(255,255,255,.25); font-size: .78rem; }
.footer-bottom-links {
    display: flex; align-items: center; gap: 8px;
}
.footer-bottom-links a {
    color: rgba(255,255,255,.25); text-decoration: none;
    font-size: .75rem; transition: color .2s;
}
.footer-bottom-links a:hover { color: #FFD600; }
.footer-bottom-links span { color: rgba(255,255,255,.12); }
.footer-heart {
    color: rgba(255,255,255,.2); font-size: .75rem;
}
.footer-heart i {
    color: #E8112D; margin: 0 2px;
    animation: heartbeat 1.5s ease infinite;
}
@keyframes heartbeat {
    0%,100% { transform: scale(1); }
    50%      { transform: scale(1.25); }
}

@media (max-width: 768px) {
    .footer-bottom-inner { flex-direction: column; text-align: center; }
    .footer-desc { max-width: 100%; }
}
</style>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/main.js"></script>

<!-- Widget Chatbot -->
<?php include __DIR__ . '/chatbot_widget.php'; ?>
</body>
</html>