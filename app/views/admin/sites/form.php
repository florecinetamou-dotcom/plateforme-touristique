<?php
$site              = $site              ?? null;
$villes            = $villes            ?? [];
$badges            = $badges            ?? [];
$mode              = $mode              ?? 'create';
$photoPrincipale   = $photoPrincipale   ?? null;
$photosSecondaires = $photosSecondaires ?? [];

$isEdit     = $mode === 'edit';
$pageTitle  = $isEdit ? 'Modifier un site' : 'Ajouter un site';
$formAction = $isEdit ? "/admin/sites/{$site->id}/update" : '/admin/sites/store';

$categories = [
    'historique' => '🏛️ Historique',
    'nature'     => '🌿 Nature',
    'culturel'   => '🎭 Culturel',
    'religieux'  => '⛪ Religieux',
    'autre'      => '📍 Autre',
];

function val($site, $key, $default = '') {
    return htmlspecialchars($site->$key ?? $default);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> — Admin BeninExplore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php include dirname(__DIR__) . '/partials/admin_styles.php'; ?>
</head>
<body>
<?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>

<div class="main">
    <?php include dirname(__DIR__) . '/partials/topbar.php'; ?>

    <div class="content">

        <!-- En-tête -->
        <div class="page-head">
            <div>
                <p class="label-tag">Sites touristiques</p>
                <h1 class="page-title"><?= $pageTitle ?></h1>
            </div>
            <a href="/admin/sites" class="btn-ghost">← Retour à la liste</a>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error"><?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Formulaire -->
        <form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data" class="form-card">

            <div class="form-grid">

                <!-- Nom -->
                <div class="form-group form-group--full">
                    <label>Nom du site <span class="required">*</span></label>
                    <input type="text" name="nom" value="<?= val($site, 'nom') ?>"
                           placeholder="Ex: Palais Royal d'Abomey" required>
                </div>

                <!-- Ville -->
                <div class="form-group">
                    <label>Ville <span class="required">*</span></label>
                    <select name="ville_id" required>
                        <option value="">— Choisir une ville —</option>
                        <?php foreach ($villes as $v): ?>
                        <option value="<?= $v->id ?>" <?= ($site->ville_id ?? '') == $v->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($v->nom) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Catégorie -->
                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="categorie">
                        <?php foreach ($categories as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($site->categorie ?? 'autre') === $key ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Description -->
                <div class="form-group form-group--full">
                    <label>Description</label>
                    <textarea name="description" rows="4"
                              placeholder="Décrivez ce site touristique…"><?= val($site, 'description') ?></textarea>
                </div>

                <!-- Adresse -->
                <div class="form-group form-group--full">
                    <label>Adresse</label>
                    <input type="text" name="adresse" value="<?= val($site, 'adresse') ?>"
                           placeholder="Ex: Quartier Djime, Abomey">
                </div>

                <!-- Latitude / Longitude -->
                <div class="form-group">
                    <label>Latitude</label>
                    <input type="number" step="any" name="latitude"
                           value="<?= val($site, 'latitude') ?>" placeholder="Ex: 7.1815">
                </div>
                <div class="form-group">
                    <label>Longitude</label>
                    <input type="number" step="any" name="longitude"
                           value="<?= val($site, 'longitude') ?>" placeholder="Ex: 1.9823">
                </div>

                <!-- Prix entrée -->
                <div class="form-group">
                    <label>Prix d'entrée (FCFA)</label>
                    <input type="number" step="0.01" min="0" name="prix_entree"
                           value="<?= val($site, 'prix_entree', '0') ?>" placeholder="0 = Gratuit">
                </div>

                <!-- Horaires -->
                <div class="form-group">
                    <label>Heure d'ouverture</label>
                    <input type="time" name="heure_ouverture" value="<?= val($site, 'heure_ouverture') ?>">
                </div>
                <div class="form-group">
                    <label>Heure de fermeture</label>
                    <input type="time" name="heure_fermeture" value="<?= val($site, 'heure_fermeture') ?>">
                </div>

                <!-- ══════════════════════════════════
                     SECTION PHOTOS
                ══════════════════════════════════ -->
                <div class="form-group form-group--full">
                    <label>Photos du site</label>

                    <!-- Photo principale -->
                    <div class="photo-section-label">
                        <span class="photo-badge"><i>★</i> Photo principale</span>
                    </div>

                    <div class="photo-upload-zone" id="zone-main">
                        <input type="file" name="photo_principale" id="input-main"
                               accept="image/jpeg,image/png,image/webp"
                               onchange="previewPhoto(this, 'zone-main', 'preview-main', 'placeholder-main')">

                        <!-- Placeholder -->
                        <div class="photo-placeholder" id="placeholder-main"
                             <?= $photoPrincipale ? 'style="display:none"' : '' ?>>
                            <div class="upload-icon">☁</div>
                            <div class="upload-label">Cliquer ou glisser une photo</div>
                            <div class="upload-sub">JPG, PNG, WEBP · Max 3 Mo · Photo de couverture</div>
                        </div>

                        <!-- Prévisualisation -->
                        <div class="photo-preview-wrap" id="preview-main"
                             <?= $photoPrincipale ? '' : 'style="display:none"' ?>>
                            <img src="<?= $photoPrincipale ? htmlspecialchars($photoPrincipale->url) : '' ?>"
                                 id="img-main" alt="Photo principale">
                            <button type="button" class="photo-remove"
                                    onclick="removePhoto('zone-main','preview-main','placeholder-main','input-main')">✕</button>
                        </div>
                    </div>

                    <!-- Photos secondaires -->
                    <div class="photo-section-label" style="margin-top:20px">
                        <span class="photo-badge photo-badge--grey"><i>⊞</i> Galerie (3 photos max)</span>
                    </div>

                    <div class="secondary-photos-grid">
                        <?php for ($i = 1; $i <= 3; $i++):
                            $secPhoto = $photosSecondaires[$i - 1] ?? null;
                        ?>
                        <div class="secondary-photo-slot">
                            <div class="photo-upload-zone photo-upload-zone--sm" id="zone-sec-<?= $i ?>">
                                <input type="file" name="photos_secondaires[]" id="input-sec-<?= $i ?>"
                                       accept="image/jpeg,image/png,image/webp"
                                       onchange="previewPhoto(this, 'zone-sec-<?= $i ?>', 'preview-sec-<?= $i ?>', null)">

                                <div class="photo-placeholder photo-placeholder--sm"
                                     id="placeholder-sec-<?= $i ?>"
                                     <?= $secPhoto ? 'style="display:none"' : '' ?>>
                                    <div class="upload-icon" style="font-size:1.1rem">+</div>
                                    <div class="upload-label" style="font-size:.7rem">Photo <?= $i ?></div>
                                </div>

                                <div class="photo-preview-wrap" id="preview-sec-<?= $i ?>"
                                     <?= $secPhoto ? '' : 'style="display:none"' ?>>
                                    <img src="<?= $secPhoto ? htmlspecialchars($secPhoto->url) : '' ?>"
                                         id="img-sec-<?= $i ?>" alt="Photo <?= $i ?>">
                                    <button type="button" class="photo-remove photo-remove--sm"
                                            onclick="removePhoto('zone-sec-<?= $i ?>','preview-sec-<?= $i ?>','placeholder-sec-<?= $i ?>','input-sec-<?= $i ?>')">✕</button>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>

                    <p class="field-hint" style="margin-top:10px">
                        Les nouvelles photos uploadées s'ajoutent. Pour supprimer une photo existante, utilisez la page de modification.
                    </p>
                </div>

                <!-- Publié -->
                <div class="form-group form-group--full">
                    <label class="checkbox-label">
                        <input type="checkbox" name="est_valide" value="1"
                               <?= ($site->est_valide ?? 1) ? 'checked' : '' ?>>
                        <span>Publier ce site (visible sur le site)</span>
                    </label>
                </div>

            </div><!-- /form-grid -->

            <div class="form-actions">
                <a href="/admin/sites" class="btn-ghost">Annuler</a>
                <button type="submit" class="btn-primary">
                    <?= $isEdit ? '💾 Enregistrer les modifications' : '✅ Créer le site' ?>
                </button>
            </div>

        </form>

    </div>
</div>

<style>
/* ── Form card ── */
.form-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 32px;
    max-width: 900px;
}
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 28px;
}
.form-group { display: flex; flex-direction: column; gap: 7px; }
.form-group--full { grid-column: 1 / -1; }
.form-group > label:first-child {
    font-size: .78rem;
    font-weight: 600;
    color: rgba(255,255,255,.55);
    letter-spacing: .06em;
    text-transform: uppercase;
}
.required { color: #f87171; }
.form-group input,
.form-group select,
.form-group textarea {
    background: rgba(255,255,255,.06);
    border: 1.5px solid rgba(255,255,255,.1);
    border-radius: 10px;
    padding: 11px 14px;
    font-family: 'Poppins', sans-serif;
    font-size: .88rem;
    color: #fff;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    width: 100%;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #008751;
    box-shadow: 0 0 0 3px rgba(0,135,81,.15);
}
.form-group input::placeholder,
.form-group textarea::placeholder { color: rgba(255,255,255,.25); }
.form-group select option { background: #1f2937; color: #fff; }
.form-group textarea { resize: vertical; min-height: 100px; }
.field-hint { font-size: .72rem; color: #6b7280; }
.checkbox-label {
    display: flex; align-items: center; gap: 10px;
    cursor: pointer; font-size: .88rem; color: rgba(255,255,255,.7);
}
.checkbox-label input { width: 16px; height: 16px; accent-color: #008751; }
.form-actions {
    display: flex; justify-content: flex-end; gap: 12px;
    padding-top: 20px; border-top: 1px solid rgba(255,255,255,.07);
}

/* ── Photo badges ── */
.photo-section-label { margin-bottom: 10px; }
.photo-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(0,135,81,.15); color: #4ade80;
    border: 1px solid rgba(0,135,81,.3);
    border-radius: 50px; padding: 4px 14px;
    font-size: .72rem; font-weight: 600;
}
.photo-badge--grey {
    background: rgba(255,255,255,.06); color: rgba(255,255,255,.5);
    border-color: rgba(255,255,255,.1);
}

/* ── Zone upload ── */
.photo-upload-zone {
    position: relative;
    border: 2px dashed rgba(255,255,255,.15);
    border-radius: 12px;
    background: rgba(255,255,255,.03);
    cursor: pointer;
    transition: all .25s;
    overflow: hidden;
    height: 180px;
}
.photo-upload-zone:hover {
    border-color: #008751;
    background: rgba(0,135,81,.05);
}
.photo-upload-zone input[type="file"] {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer; z-index: 2;
    width: 100%; height: 100%;
}
.photo-upload-zone--sm { height: 100%; }

/* ── Placeholder ── */
.photo-placeholder {
    height: 100%;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 8px;
    text-align: center; padding: 20px;
}
.photo-placeholder--sm { gap: 4px; }
.upload-icon {
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(0,135,81,.15); color: #4ade80;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
}
.upload-label { font-size: .8rem; font-weight: 600; color: rgba(255,255,255,.7); }
.upload-sub   { font-size: .7rem; color: #6b7280; }

/* ── Prévisualisation ── */
.photo-preview-wrap {
    position: relative;
    height: 100%;
}
.photo-preview-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    border-radius: 10px;
    display: block;
}
.photo-remove {
    position: absolute; top: 8px; right: 8px;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(15,25,35,.8); color: #fff;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; z-index: 3;
    transition: background .2s;
}
.photo-remove:hover { background: #E8112D; }
.photo-remove--sm { width: 22px; height: 22px; font-size: .65rem; top: 5px; right: 5px; }

/* ── Grille secondaires ── */
.secondary-photos-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}
.secondary-photo-slot {
    aspect-ratio: 4/3;
}
.secondary-photo-slot .photo-upload-zone {
    height: 100%;
}

@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
    .form-group--full { grid-column: 1; }
    .secondary-photos-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; }
}
</style>

<script>
function previewPhoto(input, zoneId, previewId, placeholderId) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        const img     = preview.querySelector('img');
        img.src = e.target.result;
        preview.style.display = 'block';

        if (placeholderId) {
            document.getElementById(placeholderId).style.display = 'none';
        }
        // Cacher les éléments placeholder dans la zone (secondaires)
        const zone = document.getElementById(zoneId);
        zone.querySelectorAll('.photo-placeholder').forEach(el => el.style.display = 'none');
    };
    reader.readAsDataURL(file);
}

function removePhoto(zoneId, previewId, placeholderId, inputId) {
    const preview = document.getElementById(previewId);
    const input   = document.getElementById(inputId);

    preview.style.display = 'none';
    preview.querySelector('img').src = '';
    input.value = '';

    if (placeholderId) {
        document.getElementById(placeholderId).style.display = '';
    }
    const zone = document.getElementById(zoneId);
    zone.querySelectorAll('.photo-placeholder').forEach(el => el.style.display = '');
}

// Drag & drop highlight
document.querySelectorAll('.photo-upload-zone').forEach(zone => {
    zone.addEventListener('dragover',  e => { e.preventDefault(); zone.style.borderColor = '#008751'; });
    zone.addEventListener('dragleave', ()  => zone.style.borderColor = '');
    zone.addEventListener('drop',      e => { e.preventDefault(); zone.style.borderColor = ''; });
});
</script>

</body>
</html>