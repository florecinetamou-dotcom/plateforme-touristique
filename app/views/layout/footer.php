</main>

<footer class="site-footer mt-5">

    <!-- Vague décorative -->
    <div class="footer-wave">
        <svg viewBox="0 0 1440 70" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,35 C360,70 1080,0 1440,35 L1440,70 L0,70 Z" fill="#0d2b1e"/>
        </svg>
    </div>

    <div class="footer-body">
        <div class="container">
            <div class="row g-5">

                <!-- Branding -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="footer-logo-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <span class="footer-brand-name">Benin<span>Explore</span></span>
                    </div>
                    <p class="footer-desc">
                        Votre guide de référence pour explorer le Bénin authentique — sites historiques, nature, culture et hébergements de qualité.
                    </p>
                    <!-- Réseaux sociaux -->
                    <div class="social-links mt-4">
                        <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-btn" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Liens rapides -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-heading">Navigation</h6>
                    <ul class="footer-links">
                        <li><a href="/"><i class="fas fa-chevron-right"></i>Accueil</a></li>
                        <li><a href="/hebergements"><i class="fas fa-chevron-right"></i>Hébergements</a></li>
                        <li><a href="/sites"><i class="fas fa-chevron-right"></i>Sites</a></li>
                        <li><a href="/villes"><i class="fas fa-chevron-right"></i>Villes</a></li>
                        <li><a href="/about"><i class="fas fa-chevron-right"></i>À propos</a></li>
                        <li><a href="/contact"><i class="fas fa-chevron-right"></i>Contact</a></li>
                    </ul>
                </div>

                <!-- Destinations -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="footer-heading">Destinations</h6>
                    <ul class="footer-links">
                        <li><a href="/ville/1"><i class="fas fa-map-pin"></i>Cotonou</a></li>
                        <li><a href="/ville/2"><i class="fas fa-map-pin"></i>Ouidah</a></li>
                        <li><a href="/ville/3"><i class="fas fa-map-pin"></i>Abomey</a></li>
                        <li><a href="/ville/4"><i class="fas fa-map-pin"></i>Porto-Novo</a></li>
                        <li><a href="/ville/5"><i class="fas fa-map-pin"></i>Parakou</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-heading">Contact</h6>
                    <ul class="footer-contact">
                        <li>
                            <div class="contact-icon"><i class="fas fa-phone"></i></div>
                            <span>+229 01 23 45 67</span>
                        </li>
                        <li>
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <span>contact@benintourisme.bj</span>
                        </li>
                        <li>
                            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <span>Cotonou, Bénin</span>
                        </li>
                        <li>
                            <div class="contact-icon"><i class="fas fa-clock"></i></div>
                            <span>Lun – Ven, 8h – 18h</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Bas de footer -->
    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <small>&copy; <?= date('Y') ?> BeninExplore. Tous droits réservés.</small>
                <div class="footer-bottom-links">
                    <a href="#">Politique de confidentialité</a>
                    <span class="separator">·</span>
                    <a href="#">Conditions d'utilisation</a>
                    <span class="separator">·</span>
                    <a href="#">Aide</a>
                </div>
                <div class="made-with">
                    Fait avec <i class="fas fa-heart"></i> au Bénin 🇧🇯
                </div>
            </div>
        </div>
    </div>

</footer>

<style>
/* ===== FOOTER ===== */
.site-footer {
    position: relative;
    background: transparent;
}
.footer-wave svg {
    display: block;
    width: 100%;
    height: 70px;
}
.footer-body {
    background: #0d2b1e;
    padding: 50px 0 40px;
}
.footer-bottom {
    background: #081a12;
    padding: 16px 0;
}

/* Logo */
.footer-logo-icon {
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, #008751, #FFD600);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
}
.footer-brand-name {
    font-size: 1.3rem;
    font-weight: 700;
    color: white;
    letter-spacing: -0.3px;
}
.footer-brand-name span {
    color: #FFD600;
}
.footer-desc {
    color: rgba(255,255,255,0.5);
    font-size: 0.875rem;
    line-height: 1.7;
    margin: 0;
}

/* Réseaux sociaux */
.social-links {
    display: flex;
    gap: 10px;
}
.social-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.25s ease;
}
.social-btn:hover {
    background: #008751;
    border-color: #008751;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,135,81,0.35);
}

/* Titres des colonnes */
.footer-heading {
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
}
.footer-heading::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 28px;
    height: 2px;
    background: linear-gradient(90deg, #008751, #FFD600);
    border-radius: 2px;
}

/* Liens footer */
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.footer-links a {
    color: rgba(255,255,255,0.5);
    text-decoration: none;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}
.footer-links a i {
    font-size: 10px;
    color: #008751;
    transition: transform 0.2s ease;
}
.footer-links a:hover {
    color: white;
    padding-left: 4px;
}
.footer-links a:hover i {
    transform: translateX(3px);
}

/* Contact */
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.footer-contact li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    color: rgba(255,255,255,0.5);
    font-size: 0.875rem;
    line-height: 1.5;
}
.contact-icon {
    width: 32px;
    height: 32px;
    background: rgba(0,135,81,0.15);
    border: 1px solid rgba(0,135,81,0.25);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #00c76a;
    font-size: 13px;
    flex-shrink: 0;
}

/* Bas de footer */
.footer-bottom small,
.footer-bottom {
    color: rgba(255,255,255,0.3);
    font-size: 0.8rem;
}
.footer-bottom-links {
    display: flex;
    align-items: center;
    gap: 8px;
}
.footer-bottom-links a {
    color: rgba(255,255,255,0.35);
    text-decoration: none;
    font-size: 0.8rem;
    transition: color 0.2s;
}
.footer-bottom-links a:hover {
    color: #FFD600;
}
.separator {
    color: rgba(255,255,255,0.2);
}
.made-with {
    color: rgba(255,255,255,0.3);
    font-size: 0.8rem;
}
.made-with i {
    color: #E8112D;
    margin: 0 2px;
    animation: heartbeat 1.5s ease infinite;
}
@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}
</style>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="/assets/js/main.js"></script>

</body>
</html>