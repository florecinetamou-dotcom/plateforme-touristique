<?php $title = 'Modifier un hébergement - BeninExplore'; ?>
<?php ob_start(); ?>

<style>
    /* Import des polices - mêmes que le header */
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&display=swap');

    :root {
        --benin-green: #008751;
        --benin-yellow: #FFD600;
        --benin-red: #E8112D;
        --surface: #F7F8FA;
        --card-bg: #ffffff;
        --text-primary: #0f1923;
        --text-secondary: #4a5568;
        --text-muted: #6b7585;
        --border: #E8EBF0;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.06);
        --radius: 20px;
        --radius-sm: 12px;
    }

    .edit-page * { 
        font-family: 'DM Sans', sans-serif; 
    }
    
    .edit-page h1,
    .edit-page h2,
    .edit-page h3,
    .edit-page h4,
    .edit-page label,
    .edit-page .fw-bold,
    .edit-page .btn-back,
    .edit-page .edit-tab,
    .edit-page .section-title,
    .edit-page .photo-badge,
    .edit-page .header-status,
    .edit-page .btn-prev,
    .edit-page .btn-next,
    .edit-page .btn-submit,
    .edit-page .btn-cancel,
    .edit-page .statut-info-box .label,
    .edit-page .current-badge {
        font-family: 'Syne', sans-serif;
        font-weight: 600;
        letter-spacing: -0.02em;
    }

    /* ─── Header avec design cohérent ─── */
    .edit-header {
        background: linear-gradient(135deg, #0f1923 0%, #1a2d20 50%, #0f1923 100%);
        border-radius: var(--radius);
        padding: 24px 28px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }
    .edit-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(0,135,81,0.25) 0%, transparent 70%);
        border-radius: 50%;
    }
    .edit-header::after {
        content: '';
        position: absolute;
        bottom: -30px; left: 25%;
        width: 160px; height: 160px;
        background: radial-gradient(circle, rgba(255,214,0,0.12) 0%, transparent 70%);
        border-radius: 50%;
    }
    .edit-header h4 {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 700;
        margin: 8px 0 4px;
        position: relative; 
        z-index: 1;
        letter-spacing: -0.02em;
    }
    .edit-header p {
        color: rgba(255,255,255,0.5);
        font-size: 0.85rem;
        margin: 0;
        position: relative; 
        z-index: 1;
    }
    .btn-back {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.9);
        border-radius: 50px;
        padding: 8px 18px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s;
        position: relative; 
        z-index: 1;
        margin-bottom: 12px;
    }
    .btn-back:hover { 
        background: rgba(255,255,255,0.18); 
        color: #fff; 
        transform: translateX(-3px);
    }

    /* Statut badge dans le header */
    .header-status {
        position: relative; 
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        margin-top: 12px;
        backdrop-filter: blur(4px);
    }
    .header-status.approuve  { 
        background: rgba(0,135,81,0.2);  
        color: #5cffa7; 
        border: 1px solid rgba(0,135,81,0.4); 
    }
    .header-status.en_attente{ 
        background: rgba(255,214,0,0.15); 
        color: var(--benin-yellow); 
        border: 1px solid rgba(255,214,0,0.3); 
    }
    .header-status.refuse    { 
        background: rgba(232,17,45,0.15);  
        color: #ff8a95; 
        border: 1px solid rgba(232,17,45,0.3); 
    }

    /* ─── Tabs améliorées ─── */
    .edit-tabs {
        display: flex;
        gap: 6px;
        background: var(--surface);
        border-radius: var(--radius);
        padding: 6px;
        margin-bottom: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
    }
    .edit-tab {
        flex: 1;
        text-align: center;
        padding: 12px 8px;
        border-radius: var(--radius-sm);
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 8px;
        transition: all 0.3s;
        border: none; 
        background: transparent;
    }
    .edit-tab i { 
        font-size: 0.8rem;
        color: var(--text-muted);
        transition: color 0.3s;
    }
    .edit-tab.active {
        background: #fff;
        color: var(--benin-green);
        box-shadow: var(--shadow-sm);
    }
    .edit-tab.active i {
        color: var(--benin-green);
    }
    .edit-tab:hover:not(.active) {
        background: rgba(0,135,81,0.04);
        color: var(--text-secondary);
    }

    /* ─── Form card ─── */
    .form-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .progress-bar-wrap { 
        height: 4px; 
        background: var(--border); 
    }
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--benin-green), #00c97a);
        transition: width 0.4s ease;
    }

    .form-panel { 
        display: none; 
        padding: 28px 32px; 
    }
    .form-panel.active { 
        display: block; 
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(8px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .section-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--surface);
        display: flex; 
        align-items: center; 
        gap: 10px;
    }
    .section-title i { 
        color: var(--benin-green); 
        font-size: 0.9rem;
    }

    /* ─── Contrôles du formulaire ─── */
    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 6px;
        letter-spacing: 0.01em;
    }
    .form-label .req { 
        color: var(--benin-red); 
        margin-left: 2px;
    }

    .form-control, .form-select {
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 11px 16px;
        font-size: 0.85rem;
        color: var(--text-primary);
        background: var(--surface);
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--benin-green);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(0,135,81,0.08);
        outline: none;
    }
    textarea.form-control { 
        resize: vertical; 
        min-height: 100px; 
    }

    /* Groupe de nombres avec boutons + et - */
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
        box-shadow: 0 0 0 4px rgba(0,135,81,0.08);
    }
    .num-btn {
        width: 42px; 
        height: 45px;
        border: none; 
        background: transparent;
        color: var(--text-muted); 
        font-size: 0.9rem;
        cursor: pointer;
        display: flex; 
        align-items: center; 
        justify-content: center;
        transition: all 0.2s; 
        flex-shrink: 0;
    }
    .num-btn:hover { 
        background: rgba(0,135,81,0.08); 
        color: var(--benin-green); 
    }
    .num-input {
        flex: 1; 
        border: none; 
        background: transparent;
        text-align: center; 
        font-size: 0.9rem; 
        font-weight: 700;
        font-family: 'Syne', sans-serif; 
        color: var(--text-primary);
        padding: 0; 
        min-width: 0;
    }
    .num-input:focus { 
        outline: none; 
    }

    /* ─── Statut info box ─── */
    .statut-info-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 16px 20px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    .statut-info-box .icon {
        width: 40px; 
        height: 40px; 
        border-radius: 50%;
        display: flex; 
        align-items: center; 
        justify-content: center;
        flex-shrink: 0; 
        font-size: 1rem;
    }
    .statut-info-box.approuve  .icon { 
        background: rgba(0,135,81,0.12);  
        color: var(--benin-green); 
    }
    .statut-info-box.en_attente .icon { 
        background: rgba(255,214,0,0.15); 
        color: #b38600; 
    }
    .statut-info-box.refuse    .icon { 
        background: rgba(232,17,45,0.1);  
        color: var(--benin-red); 
    }
    .statut-info-box .label {
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-primary);
        margin-bottom: 3px;
    }
    .statut-info-box .desc {
        font-size: 0.78rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* ─── Upload de photos ─── */
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
        background: rgba(0,135,81,0.02);
    }
    .photo-upload-zone input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer; z-index: 2;
        width: 100%; height: 100%;
    }
    .photo-main-zone {
        height: 200px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 10px;
        padding: 20px; text-align: center;
    }
    .photo-upload-icon {
        width: 56px; height: 56px; border-radius: 50%;
        background: rgba(0,135,81,0.1);
        display: flex; align-items: center; justify-content: center;
        color: var(--benin-green); font-size: 1.4rem;
        transition: all 0.25s;
    }
    .photo-upload-zone:hover .photo-upload-icon { 
        background: rgba(0,135,81,0.18); 
        transform: scale(1.05); 
    }
    .photo-upload-label { 
        font-weight: 700; 
        font-size: 0.85rem; 
        color: var(--text-primary); 
    }
    .photo-upload-sub { 
        font-size: 0.72rem; 
        color: var(--text-muted); 
    }
    .photo-preview-wrap { 
        position: relative; 
        height: 200px; 
        display: none; 
    }
    .photo-preview-wrap img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        border-radius: calc(var(--radius-sm) - 2px); 
    }
    .photo-remove {
        position: absolute; top: 8px; right: 8px;
        width: 30px; height: 30px; border-radius: 50%;
        background: rgba(15,25,35,0.7); color: #fff;
        border: none; cursor: pointer; z-index: 3;
        display: flex; align-items: center; justify-content: center; font-size: 0.7rem;
        transition: background 0.2s;
    }
    .photo-remove:hover { 
        background: var(--benin-red); 
    }

    /* Photo principale actuelle */
    .current-photo-thumb {
        position: relative; 
        height: 200px; 
        border-radius: var(--radius-sm); 
        overflow: hidden;
        border: 1.5px solid var(--border);
    }
    .current-photo-thumb img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }
    .current-badge {
        position: absolute; bottom: 8px; left: 8px;
        background: rgba(15,25,35,0.75); color: #fff;
        border-radius: 50px; padding: 4px 12px;
        font-size: 0.7rem; font-weight: 700;
        backdrop-filter: blur(4px);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Photos secondaires */
    .secondary-photos-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        gap: 12px; 
        margin-top: 8px;
    }
    .secondary-photo-slot { 
        aspect-ratio: 4/3; 
        position: relative; 
    }
    .secondary-photo-slot .photo-upload-zone {
        height: 100%; display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 5px;
        text-align: center; padding: 8px;
    }
    .secondary-photo-slot .photo-upload-icon { 
        width: 38px; 
        height: 38px; 
        font-size: 0.9rem; 
    }
    .secondary-photo-slot .photo-upload-label { 
        font-size: 0.7rem; 
    }
    .secondary-photo-slot .photo-upload-sub { 
        display: none; 
    }
    .secondary-photo-slot .photo-preview-wrap { 
        height: 100%; 
    }

    .photo-badge {
        display: inline-flex; 
        align-items: center; 
        gap: 6px;
        background: rgba(0,135,81,0.08); 
        color: var(--benin-green);
        border-radius: 50px; 
        padding: 4px 14px;
        font-size: 0.72rem; 
        font-weight: 700;
        margin-bottom: 10px;
    }

    /* ─── Alert error ─── */
    .heb-alert-error {
        background: #fff5f6;
        border: 1px solid rgba(232,17,45,0.15);
        border-left: 4px solid var(--benin-red);
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        margin-bottom: 24px;
        display: flex; 
        align-items: center; 
        gap: 12px;
        font-size: 0.85rem; 
        color: #a00020;
    }

    /* ─── Footer ─── */
    .form-footer {
        padding: 20px 32px;
        background: var(--surface);
        border-top: 1px solid var(--border);
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        gap: 12px;
    }
    .btn-cancel {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 50px;
        transition: all 0.2s;
    }
    .btn-cancel:hover { 
        color: var(--benin-red); 
        background: rgba(232,17,45,0.05);
    }

    .btn-prev {
        background: transparent;
        border: 1.5px solid var(--border);
        color: var(--text-muted);
        border-radius: 50px;
        padding: 10px 24px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer; 
        transition: all 0.2s;
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
    }
    .btn-prev:hover { 
        border-color: var(--benin-green); 
        color: var(--benin-green); 
    }

    .btn-next {
        background: linear-gradient(135deg, var(--benin-green), #00a862);
        border: none; 
        color: #fff;
        border-radius: 50px; 
        padding: 12px 30px;
        font-size: 0.82rem; 
        font-weight: 700;
        cursor: pointer; 
        transition: all 0.25s;
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
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
        padding: 12px 32px;
        font-size: 0.85rem; 
        font-weight: 700;
        cursor: pointer; 
        transition: all 0.25s;
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.15);
    }
    .btn-submit:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 8px 20px rgba(0,0,0,0.2); 
    }

    /* Prix avec préfixe FCFA */
    .price-wrapper {
        position: relative;
    }
    .price-prefix {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--benin-green);
        font-family: 'Syne', sans-serif;
        z-index: 1;
    }
    .price-wrapper input {
        padding-left: 60px !important;
    }

    @media (max-width: 768px) {
        .form-panel { padding: 20px; }
        .form-footer { padding: 16px 20px; flex-wrap: wrap; }
        .edit-tab span.label { display: none; }
        .edit-tab { padding: 12px 0; }
        .edit-tab i { margin: 0; }
        .secondary-photos-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="container-fluid py-4 edit-page">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
        </div>

        <!-- Contenu principal -->
        <div class="col-md-9">

            <!-- Header amélioré -->
            <div class="edit-header">
                <a href="/hebergeur/hebergements" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
                <h4><?= htmlspecialchars($hebergement->nom) ?></h4>
                <p>Modifiez les informations de votre hébergement</p>

                <?php
                    $statut = $hebergement->statut;
                    $statut_labels = [
                        'approuve'   => ['label' => 'Publié',      'icon' => 'fa-check-circle'],
                        'en_attente' => ['label' => 'En révision', 'icon' => 'fa-clock'],
                        'refuse'     => ['label' => 'Non validé',  'icon' => 'fa-times-circle'],
                    ];
                    $s = $statut_labels[$statut] ?? ['label' => $statut, 'icon' => 'fa-circle'];
                ?>
                <div class="header-status <?= $statut ?>">
                    <i class="fas <?= $s['icon'] ?>"></i> <?= $s['label'] ?>
                </div>
            </div>

            <!-- Erreur -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="heb-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Tabs -->
            <div class="edit-tabs">
                <button type="button" class="edit-tab active" onclick="showPanel(1, this)">
                    <i class="fas fa-info-circle"></i><span class="label">Informations</span>
                </button>
                <button type="button" class="edit-tab" onclick="showPanel(2, this)">
                    <i class="fas fa-align-left"></i><span class="label">Description</span>
                </button>
                <button type="button" class="edit-tab" onclick="showPanel(3, this)">
                    <i class="fas fa-sliders-h"></i><span class="label">Capacité & Prix</span>
                </button>
                <button type="button" class="edit-tab" onclick="showPanel(4, this)">
                    <i class="fas fa-camera"></i><span class="label">Photos & Statut</span>
                </button>
            </div>

            <!-- Formulaire -->
            <div class="form-card">
                <div class="progress-bar-wrap">
                    <div class="progress-bar-fill" id="progress-fill" style="width:25%"></div>
                </div>

                <form method="POST" action="/hebergeur/hebergements/update/<?= $hebergement->id ?>" enctype="multipart/form-data">

                    <!-- ── Panel 1 : Infos générales ── -->
                    <div class="form-panel active" id="panel-1">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i> Informations générales
                        </div>
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Nom de l'hébergement <span class="req">*</span></label>
                                <input type="text" name="nom" class="form-control"
                                       value="<?= htmlspecialchars($hebergement->nom) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ville <span class="req">*</span></label>
                                <select name="ville_id" class="form-select" required>
                                    <option value="">— Sélectionner une ville —</option>
                                    <?php foreach ($villes as $ville): ?>
                                        <option value="<?= $ville->id ?>" <?= $hebergement->ville_id == $ville->id ? 'selected' : '' ?>>
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
                                        <option value="<?= $type->id ?>" <?= $hebergement->type_id == $type->id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($type->nom) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Adresse complète <span class="req">*</span></label>
                                <textarea name="adresse" class="form-control" rows="3" required><?= htmlspecialchars($hebergement->adresse) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ── Panel 2 : Description ── -->
                    <div class="form-panel" id="panel-2">
                        <div class="section-title">
                            <i class="fas fa-align-left"></i> Description
                        </div>
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="8"
                                          placeholder="Décrivez votre hébergement : ambiance, services, points forts, quartier…"><?= htmlspecialchars($hebergement->description ?? '') ?></textarea>
                                <div class="mt-2" style="font-size:.75rem;color:var(--text-muted);">
                                    <i class="fas fa-lightbulb me-1" style="color:var(--benin-yellow)"></i>
                                    Une description détaillée augmente vos chances de réservation.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── Panel 3 : Capacité & Prix ── -->
                    <div class="form-panel" id="panel-3">
                        <div class="section-title">
                            <i class="fas fa-sliders-h"></i> Capacité & Tarification
                        </div>
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Prix par nuit <span class="req">*</span></label>
                                <div class="price-wrapper">
                                    <span class="price-prefix">FCFA</span>
                                    <input type="number" name="prix_nuit_base" class="form-control"
                                           value="<?= htmlspecialchars($hebergement->prix_nuit_base) ?>"
                                           min="0" step="1000" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Capacité (personnes)</label>
                                <div class="num-group">
                                    <button type="button" class="num-btn" onclick="decrement('capacite')"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="capacite" id="capacite" class="num-input"
                                           value="<?= htmlspecialchars($hebergement->capacite ?? 2) ?>" min="1" max="50">
                                    <button type="button" class="num-btn" onclick="increment('capacite')"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Chambres</label>
                                <div class="num-group">
                                    <button type="button" class="num-btn" onclick="decrement('chambres')"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="chambres" id="chambres" class="num-input"
                                           value="<?= htmlspecialchars($hebergement->chambres ?? 1) ?>" min="1" max="50">
                                    <button type="button" class="num-btn" onclick="increment('chambres')"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lits</label>
                                <div class="num-group">
                                    <button type="button" class="num-btn" onclick="decrement('lits')"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="lits" id="lits" class="num-input"
                                           value="<?= htmlspecialchars($hebergement->lits ?? 1) ?>" min="1" max="50">
                                    <button type="button" class="num-btn" onclick="increment('lits')"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Salles de bain</label>
                                <div class="num-group">
                                    <button type="button" class="num-btn" onclick="decrement('salles_de_bain')"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="salles_de_bain" id="salles_de_bain" class="num-input"
                                           value="<?= htmlspecialchars($hebergement->salles_de_bain ?? 1) ?>" min="1" max="20">
                                    <button type="button" class="num-btn" onclick="increment('salles_de_bain')"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── Panel 4 : Photos + Statut ── -->
                    <div class="form-panel" id="panel-4">

                        <!-- Photos -->
                        <div class="section-title">
                            <i class="fas fa-camera"></i> Photos de l'hébergement
                        </div>
                        <div class="row g-4">

                            <!-- Photo principale -->
                            <div class="col-12">
                                <div class="photo-badge"><i class="fas fa-star me-1"></i> Photo principale</div>

                                <?php if (!empty($photoPrincipale)): 
                                    $mainUrl = $photoPrincipale->url;
                                    if (!empty($mainUrl) && strpos($mainUrl, 'http') !== 0 && strpos($mainUrl, '/') !== 0) {
                                        $mainUrl = '/' . $mainUrl;
                                    }
                                ?>
                                <div id="current-main-wrap">
                                    <div class="current-photo-thumb">
                                        <img src="<?= htmlspecialchars($mainUrl) ?>" alt="Photo principale actuelle">
                                        <span class="current-badge"><i class="fas fa-check me-1"></i>Actuelle</span>
                                        <button type="button" class="photo-remove" onclick="showMainUpload()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <p class="mt-2" style="font-size:.73rem;color:var(--text-muted)">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Cliquez sur <i class="fas fa-times"></i> pour remplacer la photo principale.
                                    </p>
                                </div>
                                <div id="new-main-wrap" style="display:none">
                                <?php else: ?>
                                <div id="new-main-wrap">
                                <?php endif; ?>
                                    <div class="photo-upload-zone" id="zone-main">
                                        <input type="file" name="photo_principale" id="input-main"
                                               accept="image/jpeg,image/png,image/webp"
                                               onchange="previewPhoto(this, 'zone-main', 'preview-main')">
                                        <div class="photo-main-zone" id="placeholder-main">
                                            <div class="photo-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                            <div class="photo-upload-label">Cliquer ou glisser une photo</div>
                                            <div class="photo-upload-sub">JPG, PNG, WEBP · Max 5 Mo</div>
                                        </div>
                                        <div class="photo-preview-wrap" id="preview-main">
                                            <img src="" alt="Nouvelle photo principale" id="img-main">
                                            <button type="button" class="photo-remove"
                                                    onclick="removePhoto('zone-main','preview-main','placeholder-main','input-main')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Photos secondaires -->
                            <div class="col-12 mt-3">
                                <div class="photo-badge"><i class="fas fa-images me-1"></i> Galerie photos (3 max)</div>
                                <div class="secondary-photos-grid">
                                    <?php for ($i = 1; $i <= 3; $i++):
                                        $existingPhoto = $photosSecondaires[$i-1] ?? null;
                                    ?>
                                    <div class="secondary-photo-slot">
                                        <?php if ($existingPhoto): 
                                            $secUrl = $existingPhoto->url;
                                            if (!empty($secUrl) && strpos($secUrl, 'http') !== 0 && strpos($secUrl, '/') !== 0) {
                                                $secUrl = '/' . $secUrl;
                                            }
                                        ?>
                                            <div class="current-photo-thumb" style="height:100%">
                                                <img src="<?= htmlspecialchars($secUrl) ?>" alt="Photo secondaire">
                                                <span class="current-badge">Photo <?= $i ?></span>
                                                <button type="button" class="photo-remove" onclick="removeSecondary(<?= $i ?>)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="photos_secondaires_existantes[]" 
                                                   value="<?= htmlspecialchars($existingPhoto->url) ?>">
                                        <?php else: ?>
                                            <div class="photo-upload-zone" id="zone-sec-<?= $i ?>">
                                                <input type="file" name="photos_secondaires[]" id="input-sec-<?= $i ?>"
                                                       accept="image/jpeg,image/png,image/webp"
                                                       onchange="previewPhoto(this, 'zone-sec-<?= $i ?>', 'preview-sec-<?= $i ?>')">
                                                <div class="photo-upload-icon"><i class="fas fa-plus"></i></div>
                                                <div class="photo-upload-label">Photo <?= $i ?></div>
                                                <div class="photo-preview-wrap" id="preview-sec-<?= $i ?>">
                                                    <img src="" alt="Photo <?= $i ?>" id="img-sec-<?= $i ?>">
                                                    <button type="button" class="photo-remove"
                                                            onclick="removePhoto('zone-sec-<?= $i ?>','preview-sec-<?= $i ?>',null,'input-sec-<?= $i ?>')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                                <p class="mt-2" style="font-size:.73rem;color:var(--text-muted)">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Ces photos apparaîtront dans la galerie de la page de détail.
                                </p>
                            </div>
                        </div>

                        <!-- Séparateur -->
                        <hr style="border-color:var(--border); margin:28px 0">

                        <!-- Statut -->
                        <div class="section-title mb-3">
                            <i class="fas fa-shield-alt"></i> Statut de publication
                        </div>
                        <?php
                            $statut_descs = [
                                'approuve'   => [
                                    'Hébergement publié',
                                    'Votre hébergement est visible et peut recevoir des réservations.',
                                    'fa-check-circle'
                                ],
                                'en_attente' => [
                                    'En attente de validation',
                                    'Votre hébergement est en cours d\'examen par notre équipe.',
                                    'fa-clock'
                                ],
                                'refuse'     => [
                                    'Hébergement non validé',
                                    'Votre hébergement n\'a pas été approuvé. Contactez le support pour plus d\'informations.',
                                    'fa-times-circle'
                                ],
                            ];
                            $sd = $statut_descs[$statut] ?? ['Statut inconnu', '', 'fa-circle'];
                        ?>
                        <div class="statut-info-box <?= $statut ?>">
                            <div class="icon"><i class="fas <?= $sd[2] ?>"></i></div>
                            <div>
                                <div class="label"><?= $sd[0] ?></div>
                                <div class="desc"><?= $sd[1] ?></div>
                            </div>
                        </div>
                        <p class="mt-2" style="font-size:.78rem;color:var(--text-muted)">
                            <i class="fas fa-info-circle me-1"></i>
                            Le statut est géré par l'administration et ne peut pas être modifié ici.
                        </p>

                    </div>

                    <!-- Footer -->
                    <div class="form-footer">
                        <div>
                            <button type="button" class="btn-prev" id="btn-prev" onclick="prevPanel()" style="display:none">
                                <i class="fas fa-arrow-left"></i> Précédent
                            </button>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="/hebergeur/hebergements" class="btn-cancel">Annuler</a>
                            <button type="button" class="btn-next" id="btn-next" onclick="nextPanel()">
                                Suivant <i class="fas fa-arrow-right"></i>
                            </button>
                            <button type="submit" class="btn-submit" id="btn-submit" style="display:none">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
let currentPanel = 1;
const totalPanels = 4;

function showPanel(num, tabEl) {
    document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.edit-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('panel-' + num).classList.add('active');
    if (tabEl) tabEl.classList.add('active');
    currentPanel = num;
    updateNav();
}

function nextPanel() {
    if (currentPanel < totalPanels) {
        const tabs = document.querySelectorAll('.edit-tab');
        showPanel(currentPanel + 1, tabs[currentPanel]);
    }
}
function prevPanel() {
    if (currentPanel > 1) {
        const tabs = document.querySelectorAll('.edit-tab');
        showPanel(currentPanel - 1, tabs[currentPanel - 2]);
    }
}

function updateNav() {
    document.getElementById('btn-prev').style.display   = currentPanel > 1 ? '' : 'none';
    document.getElementById('btn-next').style.display   = currentPanel < totalPanels ? '' : 'none';
    document.getElementById('btn-submit').style.display = currentPanel === totalPanels ? '' : 'none';
    document.getElementById('progress-fill').style.width = (currentPanel / totalPanels * 100) + '%';
}

function increment(id) { 
    const el = document.getElementById(id); 
    el.value = parseInt(el.value || 1) + 1; 
}

function decrement(id) { 
    const el = document.getElementById(id); 
    if (parseInt(el.value) > parseInt(el.min || 1)) {
        el.value = parseInt(el.value) - 1; 
    }
}

/* ─── Photo principale : remplacer ─── */
function showMainUpload() {
    document.getElementById('current-main-wrap').style.display = 'none';
    document.getElementById('new-main-wrap').style.display = '';
}

/* ─── Photo preview ─── */
function previewPhoto(input, zoneId, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const zone    = document.getElementById(zoneId);
        const preview = document.getElementById(previewId);
        const phId    = 'placeholder-' + zoneId.replace('zone-','');
        const ph      = document.getElementById(phId);
        preview.querySelector('img').src = e.target.result;
        preview.style.display = 'block';
        if (ph) ph.style.display = 'none';
        zone.querySelectorAll('.photo-upload-icon, .photo-upload-label, .photo-upload-sub').forEach(el => el.style.display = 'none');
    };
    reader.readAsDataURL(file);
}

function removePhoto(zoneId, previewId, placeholderId, inputId) {
    const zone    = document.getElementById(zoneId);
    const preview = document.getElementById(previewId);
    document.getElementById(inputId).value = '';
    preview.style.display = 'none';
    preview.querySelector('img').src = '';
    if (placeholderId) document.getElementById(placeholderId).style.display = '';
    zone.querySelectorAll('.photo-upload-icon, .photo-upload-label, .photo-upload-sub').forEach(el => el.style.display = '');
}

function removeSecondary(i) {
    if (confirm('Supprimer cette photo ?')) {
        // Recharger la page pour simplifier
        location.reload();
    }
}

document.querySelectorAll('.photo-upload-zone').forEach(zone => {
    zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', ()  => zone.classList.remove('drag-over'));
    zone.addEventListener('drop',      e => { 
        e.preventDefault(); 
        zone.classList.remove('drag-over');
        const input = zone.querySelector('input[type="file"]');
        if (input) {
            input.files = e.dataTransfer.files;
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }
    });
});
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>