<?php $title = 'Ajouter un hébergement - BeninExplore'; ?>
<?php ob_start(); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap');

:root {
    --benin-green: #008751;
    --benin-yellow: #FCD116;
    --benin-red: #E8112D;
    --surface: #F7F8FA;
    --card-bg: #ffffff;
    --text-primary: #0f1923;
    --text-muted: #6b7585;
    --border: #E8EBF0;
    --border-focus: #008751;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
    --radius: 16px;
    --radius-sm: 10px;
}

.create-page * { font-family: 'DM Sans', sans-serif; }
.create-page h1,.create-page h2,.create-page h3,.create-page h4,.create-page h5,.create-page .fw-bold,.create-page label { font-family: 'Syne', sans-serif; }

/* ─── Header ─── */
.create-header {
    background: linear-gradient(135deg, #0f1923 0%, #1a2d20 50%, #0f1923 100%);
    border-radius: var(--radius);
    padding: 24px 28px;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.create-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 180px; height: 180px;
    background: radial-gradient(circle, rgba(0,135,81,0.25) 0%, transparent 70%);
    border-radius: 50%;
}
.create-header::after {
    content: '';
    position: absolute;
    bottom: -30px; left: 25%;
    width: 140px; height: 140px;
    background: radial-gradient(circle, rgba(252,209,22,0.1) 0%, transparent 70%);
    border-radius: 50%;
}
.create-header h4 {
    color: #fff;
    font-size: 1.35rem;
    font-weight: 800;
    margin: 0;
    letter-spacing: -0.02em;
    position: relative; z-index: 1;
}
.create-header p {
    color: rgba(255,255,255,0.5);
    font-size: 0.82rem;
    margin: 4px 0 0;
    position: relative; z-index: 1;
}
.btn-back {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.8);
    border-radius: 50px;
    padding: 7px 16px;
    font-size: 0.78rem;
    font-family: 'Syne', sans-serif;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s;
    position: relative; z-index: 1;
    margin-bottom: 14px;
}
.btn-back:hover {
    background: rgba(255,255,255,0.18);
    color: #fff;
}

/* ─── Steps nav ─── */
.steps-nav {
    display: flex;
    gap: 0;
    background: var(--surface);
    border-radius: var(--radius);
    padding: 6px;
    margin-bottom: 24px;
    border: 1px solid var(--border);
}
.step-tab {
    flex: 1;
    text-align: center;
    padding: 10px 8px;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: all 0.25s;
    font-size: 0.78rem;
    font-family: 'Syne', sans-serif;
    font-weight: 600;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
}
.step-tab .step-num {
    width: 22px; height: 22px;
    border-radius: 50%;
    background: var(--border);
    color: var(--text-muted);
    font-size: 0.7rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.25s;
}
.step-tab.active {
    background: #fff;
    color: var(--benin-green);
    box-shadow: var(--shadow-sm);
}
.step-tab.active .step-num {
    background: var(--benin-green);
    color: #fff;
}
.step-tab.done {
    color: var(--benin-green);
}
.step-tab.done .step-num {
    background: rgba(0,135,81,0.12);
    color: var(--benin-green);
}

/* ─── Form card ─── */
.form-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.form-section {
    padding: 24px 28px;
    display: none;
}
.form-section.active { display: block; }

.section-title {
    font-family: 'Syne', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--surface);
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-title i {
    color: var(--benin-green);
    font-size: 0.9rem;
}

/* ─── Form controls ─── */
.form-label {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 6px;
    letter-spacing: 0.01em;
}
.form-label .req { color: var(--benin-red); }

.form-control, .form-select {
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 10px 14px;
    font-size: 0.85rem;
    color: var(--text-primary);
    font-family: 'DM Sans', sans-serif;
    background: var(--surface);
    transition: all 0.2s;
}
.form-control:focus, .form-select:focus {
    border-color: var(--benin-green);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0,135,81,0.1);
    outline: none;
}
.form-control::placeholder { color: #b0b8c4; }

textarea.form-control { resize: vertical; min-height: 90px; }

/* ─── Photo upload ─── */
.photo-upload-zone {
    border: 2px dashed var(--border);
    border-radius: var(--radius-sm);
    background: var(--surface);
    transition: all 0.25s;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.photo-upload-zone:hover, .photo-upload-zone.drag-over {
    border-color: var(--benin-green);
    background: rgba(0,135,81,0.04);
}
.photo-upload-zone input[type="file"] {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer; z-index: 2;
    width: 100%; height: 100%;
}
.photo-main-zone {
    height: 180px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 8px;
    padding: 20px;
    text-align: center;
}
.photo-upload-icon {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: rgba(0,135,81,0.1);
    display: flex; align-items: center; justify-content: center;
    color: var(--benin-green);
    font-size: 1.3rem;
    transition: all 0.25s;
}
.photo-upload-zone:hover .photo-upload-icon {
    background: rgba(0,135,81,0.18);
    transform: scale(1.08);
}
.photo-upload-label {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.82rem;
    color: var(--text-primary);
}
.photo-upload-sub {
    font-size: 0.73rem;
    color: var(--text-muted);
}
.photo-preview-wrap {
    position: relative;
    height: 180px;
    display: none;
}
.photo-preview-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    border-radius: calc(var(--radius-sm) - 2px);
}
.photo-preview-wrap .photo-remove {
    position: absolute;
    top: 8px; right: 8px;
    width: 28px; height: 28px;
    border-radius: 50%;
    background: rgba(15,25,35,0.7);
    color: #fff;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem;
    transition: background 0.2s;
    z-index: 3;
}
.photo-preview-wrap .photo-remove:hover { background: var(--benin-red); }

/* Secondary photos grid */
.secondary-photos-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}
.secondary-photo-slot {
    aspect-ratio: 4/3;
    position: relative;
}
.secondary-photo-slot .photo-upload-zone {
    height: 100%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 4px;
    text-align: center; padding: 10px;
}
.secondary-photo-slot .photo-upload-icon {
    width: 34px; height: 34px;
    font-size: 0.9rem;
}
.secondary-photo-slot .photo-upload-label { font-size: 0.72rem; }
.secondary-photo-slot .photo-upload-sub { font-size: 0.67rem; display: none; }
.secondary-photo-slot .photo-preview-wrap { height: 100%; aspect-ratio: 4/3; }

.photo-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(0,135,81,0.1);
    color: var(--benin-green);
    border-radius: 50px;
    padding: 3px 10px;
    font-size: 0.7rem;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    margin-bottom: 8px;
}

/* Number input group */
.num-group {
    display: flex;
    align-items: center;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    background: var(--surface);
    overflow: hidden;
    transition: all 0.2s;
}
.num-group:focus-within {
    border-color: var(--benin-green);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0,135,81,0.1);
}
.num-btn {
    width: 38px; height: 42px;
    border: none;
    background: transparent;
    color: var(--text-muted);
    font-size: 1rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
    flex-shrink: 0;
}
.num-btn:hover { background: rgba(0,135,81,0.08); color: var(--benin-green); }
.num-input {
    flex: 1;
    border: none;
    background: transparent;
    text-align: center;
    font-size: 0.88rem;
    font-weight: 700;
    font-family: 'Syne', sans-serif;
    color: var(--text-primary);
    padding: 0;
    min-width: 0;
}
.num-input:focus { outline: none; }

/* ─── Alert error ─── */
.heb-alert-error {
    background: #fff5f6;
    border: 1px solid rgba(232,17,45,0.2);
    border-left: 4px solid var(--benin-red);
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.84rem;
    color: #a00020;
}

/* ─── Form footer ─── */
.form-footer {
    padding: 18px 28px;
    background: var(--surface);
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}

.btn-prev {
    background: transparent;
    border: 1.5px solid var(--border);
    color: var(--text-muted);
    border-radius: 50px;
    padding: 9px 22px;
    font-size: 0.82rem;
    font-family: 'Syne', sans-serif;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-prev:hover { border-color: var(--benin-green); color: var(--benin-green); }

.btn-next {
    background: linear-gradient(135deg, var(--benin-green), #00a862);
    border: none;
    color: #fff;
    border-radius: 50px;
    padding: 10px 28px;
    font-size: 0.82rem;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    display: inline-flex; align-items: center; gap: 7px;
    box-shadow: 0 4px 14px rgba(0,135,81,0.3);
}
.btn-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,135,81,0.4);
}

.btn-submit {
    background: linear-gradient(135deg, #0f1923, #1a2d20);
    border: none;
    color: #fff;
    border-radius: 50px;
    padding: 10px 32px;
    font-size: 0.85rem;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    display: inline-flex; align-items: center; gap: 8px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.2);
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

.btn-cancel {
    color: var(--text-muted);
    text-decoration: none;
    font-size: 0.8rem;
    font-family: 'Syne', sans-serif;
    transition: color 0.2s;
}
.btn-cancel:hover { color: var(--benin-red); }

/* ─── Progress bar ─── */
.progress-bar-wrap {
    height: 3px;
    background: var(--border);
    border-radius: 0;
}
.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--benin-green), #00c97a);
    border-radius: 0;
    transition: width 0.4s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateX(12px); }
    to   { opacity: 1; transform: translateX(0); }
}
.form-section.active { animation: fadeIn 0.3s ease; }

@media (max-width: 576px) {
    .form-section { padding: 18px; }
    .form-footer { padding: 14px 18px; flex-wrap: wrap; }
    .step-tab span.label { display: none; }
}
</style>

<div class="container-fluid py-4 create-page">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
        </div>

        <!-- Contenu principal -->
        <div class="col-md-9">

            <!-- Header -->
            <div class="create-header">
                <a href="/hebergeur/hebergements" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Mes hébergements
                </a>
                <h4>Ajouter un hébergement</h4>
                <p>Remplissez les informations pour publier votre annonce</p>
            </div>

            <!-- Erreur -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="heb-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Steps nav -->
            <div class="steps-nav">
                <div class="step-tab active" id="tab-1" onclick="goToStep(1)">
                    <span class="step-num">1</span>
                    <span class="label">Informations</span>
                </div>
                <div class="step-tab" id="tab-2" onclick="goToStep(2)">
                    <span class="step-num">2</span>
                    <span class="label">Détails</span>
                </div>
                <div class="step-tab" id="tab-3" onclick="goToStep(3)">
                    <span class="step-num">3</span>
                    <span class="label">Capacité & Prix</span>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="form-card">
                <div class="progress-bar-wrap">
                    <div class="progress-bar-fill" id="progress-fill" style="width:33%"></div>
                </div>

                <form method="POST" action="/hebergeur/hebergements/store" id="main-form" enctype="multipart/form-data">

                    <!-- ── ÉTAPE 1 : Infos générales + Photos ── -->
                    <div class="form-section active" id="step-1">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i> Informations générales
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nom de l'hébergement <span class="req">*</span></label>
                                <input type="text" name="nom" class="form-control"
                                       placeholder="Ex : Villa Bel Air, Hôtel Le Plateau…"
                                       value="<?= htmlspecialchars($_SESSION['old']['nom'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ville <span class="req">*</span></label>
                                <select name="ville_id" class="form-select" required>
                                    <option value="">— Sélectionner une ville —</option>
                                    <?php foreach ($villes as $ville): ?>
                                        <option value="<?= $ville->id ?>" <?= ($_SESSION['old']['ville_id'] ?? '') == $ville->id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($ville->nom) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Type d'hébergement</label>
                                <select name="type_id" class="form-select">
                                    <option value="">— Sélectionner un type —</option>
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?= $type->id ?>" <?= ($_SESSION['old']['type_id'] ?? '') == $type->id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($type->nom) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Adresse complète <span class="req">*</span></label>
                                <textarea name="adresse" class="form-control" rows="2"
                                          placeholder="Rue, quartier, repères…" required><?= htmlspecialchars($_SESSION['old']['adresse'] ?? '') ?></textarea>
                            </div>

                        </div>
                    </div>

                    <!-- ── ÉTAPE 2 : Description ── -->
                    <div class="form-section" id="step-2">
                        <div class="section-title">
                            <i class="fas fa-align-left"></i> Description de l'hébergement
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="6"
                                          placeholder="Décrivez votre hébergement : ambiance, services, points forts, accès…"><?= htmlspecialchars($_SESSION['old']['description'] ?? '') ?></textarea>
                                <div style="font-size:.75rem;color:var(--text-muted);margin-top:6px;">
                                    <i class="fas fa-lightbulb me-1" style="color:var(--benin-yellow)"></i>
                                    Une bonne description augmente vos chances de réservation.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── ÉTAPE 3 : Capacité & Prix ── -->
                    <div class="form-section" id="step-3">
                        <div class="section-title">
                            <i class="fas fa-sliders-h"></i> Capacité & Tarification
                        </div>
                        <div class="row g-3">

                            <!-- Prix -->
                            <div class="col-12">
                                <label class="form-label">Prix par nuit (FCFA) <span class="req">*</span></label>
                                <div style="position:relative">
                                    <input type="number" name="prix_nuit_base" class="form-control"
                                           style="padding-left:60px"
                                           placeholder="15 000"
                                           value="<?= htmlspecialchars($_SESSION['old']['prix_nuit_base'] ?? '') ?>"
                                           min="0" step="1000" required>
                                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:.78rem;font-weight:700;color:var(--benin-green);font-family:'Syne',sans-serif">FCFA</span>
                                </div>
                            </div>

                            <!-- Capacité -->
                            <div class="col-md-6">
                                <label class="form-label">Capacité (personnes)</label>
                                <div class="num-group">
                                    <button type="button" class="num-btn" onclick="decrement('capacite')"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="capacite" id="capacite" class="num-input"
                                           value="<?= htmlspecialchars($_SESSION['old']['capacite'] ?? '2') ?>" min="1" max="50">
                                    <button type="button" class="num-btn" onclick="increment('capacite')"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>

                            <!-- Chambres -->
                            <div class="col-md-6">
                                <label class="form-label">Chambres</label>
                                <div class="num-group">
                                    <button type="button" class="num-btn" onclick="decrement('chambres')"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="chambres" id="chambres" class="num-input"
                                           value="<?= htmlspecialchars($_SESSION['old']['chambres'] ?? '1') ?>" min="1" max="50">
                                    <button type="button" class="num-btn" onclick="increment('chambres')"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>

                            <!-- Lits -->
                            <div class="col-md-6">
                                <label class="form-label">Lits</label>
                                <div class="num-group">
                                    <button type="button" class="num-btn" onclick="decrement('lits')"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="lits" id="lits" class="num-input"
                                           value="<?= htmlspecialchars($_SESSION['old']['lits'] ?? '1') ?>" min="1" max="50">
                                    <button type="button" class="num-btn" onclick="increment('lits')"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>

                            <!-- Salles de bain -->
                            <div class="col-md-6">
                                <label class="form-label">Salles de bain</label>
                                <div class="num-group">
                                    <button type="button" class="num-btn" onclick="decrement('salles_de_bain')"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="salles_de_bain" id="salles_de_bain" class="num-input"
                                           value="<?= htmlspecialchars($_SESSION['old']['salles_de_bain'] ?? '1') ?>" min="1" max="20">
                                    <button type="button" class="num-btn" onclick="increment('salles_de_bain')"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>

                            <!-- ── Photos ── -->
                            <div class="col-12" style="margin-top:8px">
                                <div class="section-title" style="margin-bottom:12px; margin-top:8px">
                                    <i class="fas fa-camera"></i> Photos de l'hébergement
                                </div>

                                <!-- Photo principale -->
                                <div class="photo-badge"><i class="fas fa-star"></i> Photo principale</div>
                                <div class="photo-upload-zone" id="zone-main">
                                    <input type="file" name="photo_principale" id="input-main"
                                           accept="image/jpeg,image/png,image/webp"
                                           onchange="previewPhoto(this, 'zone-main', 'preview-main')">
                                    <div class="photo-main-zone" id="placeholder-main">
                                        <div class="photo-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                        <div class="photo-upload-label">Cliquer ou glisser une photo</div>
                                        <div class="photo-upload-sub">JPG, PNG, WEBP · Max 5 Mo<br>Cette photo apparaîtra sur la carte de votre hébergement</div>
                                    </div>
                                    <div class="photo-preview-wrap" id="preview-main">
                                        <img src="" alt="Aperçu principal" id="img-main">
                                        <button type="button" class="photo-remove" onclick="removePhoto('zone-main','preview-main','placeholder-main','input-main')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- 3 photos secondaires -->
                                <div class="photo-badge" style="margin-top:16px"><i class="fas fa-images"></i> Photos de la galerie (3 max)</div>
                                <div class="secondary-photos-grid">
                                    <?php for ($i = 1; $i <= 3; $i++): ?>
                                    <div class="secondary-photo-slot">
                                        <div class="photo-upload-zone" id="zone-sec-<?= $i ?>">
                                            <input type="file" name="photos_secondaires[]" id="input-sec-<?= $i ?>"
                                                   accept="image/jpeg,image/png,image/webp"
                                                   onchange="previewPhoto(this, 'zone-sec-<?= $i ?>', 'preview-sec-<?= $i ?>')">
                                            <div class="photo-upload-icon"><i class="fas fa-plus"></i></div>
                                            <div class="photo-upload-label">Photo <?= $i ?></div>
                                            <div class="photo-upload-sub">JPG, PNG, WEBP</div>
                                            <div class="photo-preview-wrap" id="preview-sec-<?= $i ?>">
                                                <img src="" alt="Photo <?= $i ?>" id="img-sec-<?= $i ?>">
                                                <button type="button" class="photo-remove"
                                                        onclick="removePhoto('zone-sec-<?= $i ?>','preview-sec-<?= $i ?>',null,'input-sec-<?= $i ?>')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="form-footer">
                        <div>
                            <button type="button" class="btn-prev" id="btn-prev" onclick="prevStep()" style="display:none">
                                <i class="fas fa-arrow-left"></i> Précédent
                            </button>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="/hebergeur/hebergements" class="btn-cancel">Annuler</a>
                            <button type="button" class="btn-next" id="btn-next" onclick="nextStep()">
                                Suivant <i class="fas fa-arrow-right"></i>
                            </button>
                            <button type="submit" class="btn-submit" id="btn-submit" style="display:none">
                                <i class="fas fa-check-circle"></i> Enregistrer l'hébergement
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
let currentStep = 1;
const totalSteps = 3;

function goToStep(step) {
    document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.step-tab').forEach(t => t.classList.remove('active'));
    for (let i = 1; i < step; i++) {
        document.getElementById('tab-' + i).classList.add('done');
    }
    document.getElementById('step-' + step).classList.add('active');
    document.getElementById('tab-' + step).classList.add('active');
    document.getElementById('tab-' + step).classList.remove('done');
    currentStep = step;
    updateNav();
}

function nextStep() { if (currentStep < totalSteps) goToStep(currentStep + 1); }
function prevStep()  { if (currentStep > 1)         goToStep(currentStep - 1); }

function updateNav() {
    document.getElementById('btn-prev').style.display   = currentStep > 1 ? '' : 'none';
    document.getElementById('btn-next').style.display   = currentStep < totalSteps ? '' : 'none';
    document.getElementById('btn-submit').style.display = currentStep === totalSteps ? '' : 'none';
    document.getElementById('progress-fill').style.width = (currentStep / totalSteps * 100) + '%';
}

function increment(id) {
    const el = document.getElementById(id);
    el.value = parseInt(el.value || 1) + 1;
}
function decrement(id) {
    const el = document.getElementById(id);
    if (parseInt(el.value) > parseInt(el.min || 1)) el.value = parseInt(el.value) - 1;
}

/* ─── Photo preview ─── */
function previewPhoto(input, zoneId, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const zone    = document.getElementById(zoneId);
        const preview = document.getElementById(previewId);
        const ph      = zone.querySelector('[id^="placeholder"]');
        // Find the img inside the preview wrap
        const img = preview.querySelector('img');
        img.src = e.target.result;
        preview.style.display = 'block';
        if (ph) ph.style.display = 'none';
        // Hide the plus icon & labels in secondary slots
        zone.querySelectorAll('.photo-upload-icon, .photo-upload-label, .photo-upload-sub').forEach(el => el.style.display = 'none');
    };
    reader.readAsDataURL(file);
}

function removePhoto(zoneId, previewId, placeholderId, inputId) {
    const zone    = document.getElementById(zoneId);
    const preview = document.getElementById(previewId);
    const input   = document.getElementById(inputId);
    preview.style.display = 'none';
    preview.querySelector('img').src = '';
    input.value = '';
    if (placeholderId) {
        document.getElementById(placeholderId).style.display = '';
    }
    zone.querySelectorAll('.photo-upload-icon, .photo-upload-label, .photo-upload-sub').forEach(el => el.style.display = '');
}

/* Drag & drop highlight */
document.querySelectorAll('.photo-upload-zone').forEach(zone => {
    zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', ()  => zone.classList.remove('drag-over'));
    zone.addEventListener('drop',      e => { e.preventDefault(); zone.classList.remove('drag-over'); });
});
</script>

<?php
unset($_SESSION['old']);
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>