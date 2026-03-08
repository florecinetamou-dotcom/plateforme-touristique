<?php $title = 'Contact - BeninExplore'; ?>
<?php $meta_description = 'Contactez notre équipe pour toute question concernant vos réservations ou voyages au Bénin.'; ?>
<?php ob_start(); ?>

<!-- ===== HERO ===== -->
<section class="contact-hero">
    <div class="contact-hero-overlay"></div>
    <div class="container position-relative z-1 text-center">
        <span class="section-tag-white">Support</span>
        <h1 class="contact-hero-title">Contactez-<span class="text-yellow">nous</span></h1>
        <p class="contact-hero-sub">Notre équipe est disponible pour répondre à toutes vos questions sur vos réservations et vos voyages au Bénin.</p>
        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item active text-white">Contact</li>
            </ol>
        </nav>
    </div>
</section>

<!-- ===== CARDS INFO RAPIDES (flottantes) ===== -->
<section class="info-cards-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-3 col-6">
                <div class="info-card">
                    <div class="info-card-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="info-card-title">Téléphone</div>
                    <div class="info-card-value">+229 01 23 45 67</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="info-card">
                    <div class="info-card-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-card-title">Email</div>
                    <div class="info-card-value">contact@benintourisme.bj</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="info-card">
                    <div class="info-card-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="info-card-title">Adresse</div>
                    <div class="info-card-value">Bd de la Marina, Cotonou</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="info-card">
                    <div class="info-card-icon"><i class="fas fa-clock"></i></div>
                    <div class="info-card-title">Horaires</div>
                    <div class="info-card-value">Lun – Ven, 8h – 18h</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FORMULAIRE + SIDEBAR ===== -->
<section class="py-section">
    <div class="container">
        <div class="row g-5">

            <!-- Formulaire -->
            <div class="col-lg-7">
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon"><i class="fas fa-paper-plane"></i></div>
                        <div>
                            <h2 class="form-card-title">Envoyez-nous un message</h2>
                            <p class="form-card-sub">Nous répondons sous 24h en moyenne</p>
                        </div>
                    </div>

                    <?php if (!empty($_SESSION['success'])): ?>
                        <div class="alert-custom alert-success-custom">
                            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert-custom alert-danger-custom">
                            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']) ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <form method="POST" action="/contact" novalidate>
                        <?php if (!empty($_SESSION['csrf_token'])): ?>
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nom" class="field-label">Nom complet <span class="text-danger">*</span></label>
                                <div class="input-group contact-input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                                           id="nom" name="nom"
                                           value="<?= htmlspecialchars($_SESSION['old']['nom'] ?? '') ?>"
                                           placeholder="Jean Dupont" required>
                                </div>
                                <?php if (isset($errors['nom'])): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($errors['nom']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="field-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group contact-input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                           id="email" name="email"
                                           value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                                           placeholder="vous@exemple.com" required>
                                </div>
                                <?php if (isset($errors['email'])): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($errors['email']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Sujet en chips -->
                            <div class="col-12">
                                <label class="field-label">Sujet <span class="text-danger">*</span></label>
                                <div class="sujet-grid">
                                    <?php
                                    $sujets = [
                                        ['val' => 'reservation', 'icon' => 'fa-calendar-check', 'label' => 'Réservation'],
                                        ['val' => 'hebergement', 'icon' => 'fa-hotel',          'label' => 'Hébergement'],
                                        ['val' => 'site',        'icon' => 'fa-landmark',       'label' => 'Site touristique'],
                                        ['val' => 'partenariat', 'icon' => 'fa-handshake',      'label' => 'Partenariat'],
                                        ['val' => 'autre',       'icon' => 'fa-comment',        'label' => 'Autre'],
                                    ];
                                    foreach ($sujets as $s):
                                        $selected = ($_SESSION['old']['sujet'] ?? '') === $s['val'];
                                    ?>
                                    <label class="sujet-chip <?= $selected ? 'selected' : '' ?>">
                                        <input type="radio" name="sujet" value="<?= $s['val'] ?>" <?= $selected ? 'checked' : '' ?> required>
                                        <i class="fas <?= $s['icon'] ?>"></i><?= $s['label'] ?>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (isset($errors['sujet'])): ?>
                                    <div class="field-error mt-1"><i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($errors['sujet']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-12">
                                <label for="message" class="field-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control contact-textarea <?= isset($errors['message']) ? 'is-invalid' : '' ?>"
                                          id="message" name="message" rows="5"
                                          placeholder="Bonjour, je souhaiterais avoir des informations sur..."
                                          required><?= htmlspecialchars($_SESSION['old']['message'] ?? '') ?></textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <?php if (isset($errors['message'])): ?>
                                        <div class="field-error"><i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($errors['message']) ?></div>
                                    <?php else: ?>
                                        <small class="text-muted">Minimum 10 caractères</small>
                                    <?php endif; ?>
                                    <small class="text-muted char-count">0 / 500</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="rgpd-check">
                                    <input type="checkbox" name="rgpd" required>
                                    <span>J'accepte la <a href="/confidentialite" class="link-green">politique de confidentialité</a> et le traitement de mes données.</span>
                                </label>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-submit w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-5">
                <div class="sidebar-card mb-4">
                    <h3 class="sidebar-title"><i class="fas fa-address-card me-2 text-green"></i>Nos coordonnées</h3>
                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <div class="contact-info-label">Adresse</div>
                                <div class="contact-info-value">Boulevard de la Marina<br>Cotonou, Bénin</div>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <div class="contact-info-label">Téléphone</div>
                                <div class="contact-info-value">+229 01 23 45 67</div>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="contact-info-label">Email</div>
                                <div class="contact-info-value">contact@benintourisme.bj</div>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                            <div>
                                <div class="contact-info-label">Horaires d'ouverture</div>
                                <div class="contact-info-value">Lun – Ven : 8h00 – 18h00<br><span style="color:#aaa;font-size:0.78rem;">Sam – Dim : Fermé</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-socials">
                        <a href="#" class="sidebar-social" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="sidebar-social" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="sidebar-social" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="sidebar-social" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Indicateur disponibilité -->
                <div class="sidebar-card response-card">
                    <div class="response-indicator"></div>
                    <div>
                        <div class="response-title">Nous sommes disponibles</div>
                        <div class="response-sub">Temps de réponse moyen : <strong>moins de 24h</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="py-section bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">FAQ</span>
            <h2 class="section-title mt-2">Questions fréquentes</h2>
            <p class="section-sub">Les réponses aux questions les plus posées</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion faq-accordion" id="faqAccordion">
                    <?php
                    $faqs = [
                        ['q' => 'Comment modifier ma réservation ?',
                         'r' => 'Connectez-vous à votre compte, rendez-vous dans "Mes réservations" et cliquez sur "Modifier". Vous pouvez changer les dates jusqu\'à 48h avant votre arrivée.'],
                        ['q' => 'Quels sont les moyens de paiement acceptés ?',
                         'r' => 'Nous acceptons les cartes bancaires (Visa, Mastercard), le Mobile Money (MTN, Moov), les virements bancaires et le paiement en espèces à l\'hébergement.'],
                        ['q' => 'Puis-je annuler ma réservation ?',
                         'r' => 'Oui, l\'annulation est gratuite jusqu\'à 24h avant la date d\'arrivée. Au-delà, des frais peuvent s\'appliquer selon la politique de l\'hébergement.'],
                        ['q' => 'Comment savoir si un hébergement est vérifié ?',
                         'r' => 'Tous les hébergements affichent un badge "Vérifié" s\'ils ont été inspectés par notre équipe. Cela garantit que les photos et descriptions sont conformes à la réalité.'],
                        ['q' => 'Comment devenir hébergeur sur BeninExplore ?',
                         'r' => 'Créez un compte en choisissant le rôle "Hébergeur", soumettez votre établissement et notre équipe vous contactera sous 48h.'],
                    ];
                    foreach ($faqs as $i => $faq): ?>
                    <div class="accordion-item faq-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button faq-btn <?= $i > 0 ? 'collapsed' : '' ?>"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq<?= $i ?>"
                                    aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                                <span class="faq-num"><?= $i + 1 ?></span>
                                <?= $faq['q'] ?>
                            </button>
                        </h3>
                        <div id="faq<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body faq-body"><?= $faq['r'] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* HERO */
.contact-hero {
    position: relative; padding: 120px 0 70px;
    background: url('https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
}
.contact-hero-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0,30,15,0.88), rgba(0,87,51,0.75)); }
.contact-hero-title { font-size: clamp(1.8rem,4vw,3rem); font-weight: 800; color: white; margin: 12px 0 16px; text-shadow: 0 2px 20px rgba(0,0,0,0.3); }
.text-yellow { color: #FFD600; }
.contact-hero-sub { color: rgba(255,255,255,0.8); font-size: 1rem; line-height: 1.7; max-width: 560px; margin: 0 auto; }
.section-tag-white { display: inline-block; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: white; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; padding: 5px 14px; border-radius: 50px; }

/* INFO CARDS */
.info-cards-section { background: white; margin-top: -40px; position: relative; z-index: 2; padding: 0 0 20px; }
.info-card { background: white; border-radius: 16px; padding: 24px 16px; text-align: center; box-shadow: 0 8px 30px rgba(0,0,0,0.1); border: 1px solid #f0f0f0; transition: all 0.3s; height: 100%; }
.info-card:hover { transform: translateY(-4px); box-shadow: 0 14px 35px rgba(0,135,81,0.12); }
.info-card-icon { width: 48px; height: 48px; background: rgba(0,135,81,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #008751; font-size: 18px; margin: 0 auto 12px; transition: all 0.3s; }
.info-card:hover .info-card-icon { background: #008751; color: white; }
.info-card-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #aaa; margin-bottom: 5px; }
.info-card-value { font-size: 0.82rem; font-weight: 600; color: #333; }

/* GÉNÉRAL */
.py-section { padding: 80px 0; }
.bg-soft { background: #f7faf8; }
.section-header { text-align: center; margin-bottom: 48px; }
.section-tag { display: inline-block; background: rgba(0,135,81,0.1); color: #008751; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; padding: 5px 14px; border-radius: 50px; }
.section-title { font-size: clamp(1.4rem,3vw,1.9rem); font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
.section-sub { color: #888; font-size: 0.95rem; }
.text-green { color: #008751; }
.link-green { color: #008751; font-weight: 600; text-decoration: none; }
.link-green:hover { text-decoration: underline; }

/* FORM CARD */
.form-card { background: white; border-radius: 20px; padding: 36px; box-shadow: 0 6px 30px rgba(0,0,0,0.08); border: 1px solid #f0f0f0; }
.form-card-header { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0; }
.form-card-icon { width: 48px; height: 48px; background: linear-gradient(135deg, #008751, #00a862); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; flex-shrink: 0; }
.form-card-title { font-size: 1.15rem; font-weight: 700; color: #1a1a2e; margin: 0; }
.form-card-sub { font-size: 0.82rem; color: #888; margin: 0; }
.field-label { font-size: 0.82rem; font-weight: 600; color: #444; margin-bottom: 6px; display: block; }
.field-error { font-size: 0.78rem; color: #dc3545; margin-top: 4px; }

/* Inputs */
.contact-input-group .input-group-text { background: #f8f9fa; border: 1.5px solid #e8e8e8; border-right: none; color: #008751; padding: 0 14px; }
.contact-input-group .form-control { border: 1.5px solid #e8e8e8; border-left: none; font-size: 0.875rem; padding: 10px 14px; }
.contact-input-group .form-control:focus { border-color: #008751; box-shadow: none; }
.contact-input-group:focus-within .input-group-text { border-color: #008751; }
.contact-textarea { border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.875rem; padding: 12px 14px; resize: vertical; }
.contact-textarea:focus { border-color: #008751; box-shadow: none; }

/* Sujet chips */
.sujet-grid { display: flex; flex-wrap: wrap; gap: 8px; }
.sujet-chip { display: inline-flex; align-items: center; gap: 7px; padding: 8px 14px; border: 1.5px solid #e8e8e8; border-radius: 50px; font-size: 0.82rem; font-weight: 500; color: #555; cursor: pointer; transition: all 0.2s; user-select: none; }
.sujet-chip input { display: none; }
.sujet-chip:hover { border-color: #008751; color: #008751; background: rgba(0,135,81,0.05); }
.sujet-chip.selected { border-color: #008751; background: rgba(0,135,81,0.1); color: #008751; font-weight: 600; }

/* RGPD */
.rgpd-check { display: flex; align-items: flex-start; gap: 10px; font-size: 0.82rem; color: #555; cursor: pointer; }
.rgpd-check input { margin-top: 3px; accent-color: #008751; flex-shrink: 0; }

/* Bouton submit */
.btn-submit { background: linear-gradient(135deg, #008751, #00a862); color: white; border: none; border-radius: 50px; padding: 13px; font-weight: 600; font-size: 0.95rem; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,135,81,0.3); }
.btn-submit:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,135,81,0.4); }

/* Alertes */
.alert-custom { border-radius: 10px; padding: 12px 16px; font-size: 0.875rem; margin-bottom: 20px; }
.alert-success-custom { background: #d1fae5; color: #065f46; }
.alert-danger-custom  { background: #fee2e2; color: #991b1b; }

/* SIDEBAR */
.sidebar-card { background: white; border-radius: 20px; padding: 28px; box-shadow: 0 6px 30px rgba(0,0,0,0.07); border: 1px solid #f0f0f0; }
.sidebar-title { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 20px; }
.contact-info-list { display: flex; flex-direction: column; gap: 16px; }
.contact-info-item { display: flex; align-items: flex-start; gap: 14px; }
.contact-info-icon { width: 38px; height: 38px; background: rgba(0,135,81,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #008751; font-size: 14px; flex-shrink: 0; }
.contact-info-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #aaa; margin-bottom: 2px; }
.contact-info-value { font-size: 0.875rem; color: #333; line-height: 1.5; }
.sidebar-socials { display: flex; gap: 10px; margin-top: 22px; padding-top: 20px; border-top: 1px solid #f0f0f0; }
.sidebar-social { width: 36px; height: 36px; border-radius: 50%; background: #f5f5f5; color: #888; display: flex; align-items: center; justify-content: center; font-size: 14px; text-decoration: none; transition: all 0.2s; }
.sidebar-social:hover { background: #008751; color: white; transform: translateY(-2px); }

/* Indicateur disponibilité */
.response-card { display: flex; align-items: center; gap: 14px; padding: 18px 22px; }
.response-indicator { width: 12px; height: 12px; border-radius: 50%; background: #22c55e; flex-shrink: 0; box-shadow: 0 0 0 4px rgba(34,197,94,0.2); animation: pulse-dot 2s ease infinite; }
@keyframes pulse-dot { 0%,100% { box-shadow: 0 0 0 4px rgba(34,197,94,0.2); } 50% { box-shadow: 0 0 0 8px rgba(34,197,94,0.1); } }
.response-title { font-size: 0.9rem; font-weight: 700; color: #1a1a2e; }
.response-sub { font-size: 0.78rem; color: #888; }

/* FAQ */
.faq-accordion { display: flex; flex-direction: column; gap: 10px; }
.faq-item { border: 1.5px solid #eee !important; border-radius: 14px !important; overflow: hidden; }
.faq-btn { background: white !important; color: #1a1a2e !important; font-weight: 600; font-size: 0.92rem; padding: 18px 20px; display: flex; align-items: center; gap: 14px; box-shadow: none !important; }
.faq-btn:not(.collapsed) { color: #008751 !important; }
.faq-num { width: 26px; height: 26px; background: rgba(0,135,81,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #008751; font-size: 0.75rem; font-weight: 700; flex-shrink: 0; }
.faq-body { font-size: 0.875rem; color: #555; line-height: 1.7; padding: 0 20px 18px 60px; background: white; }

@media (max-width: 768px) {
    .form-card { padding: 22px 18px; }
    .info-cards-section { margin-top: -20px; }
    .faq-body { padding-left: 20px; }
}
</style>

<script>
// Compteur de caractères
document.getElementById('message').addEventListener('input', function () {
    const count = this.value.length;
    document.querySelector('.char-count').textContent = count + ' / 500';
    if (count > 500) this.value = this.value.substring(0, 500);
});

// Sélecteur de sujet en chips
document.querySelectorAll('.sujet-chip').forEach(chip => {
    chip.addEventListener('click', function () {
        document.querySelectorAll('.sujet-chip').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
    });
});
</script>

<?php
unset($_SESSION['old'], $_SESSION['errors']);
$content = ob_get_clean();
require dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
require dirname(__DIR__, 2) . '/layout/footer.php';
?>