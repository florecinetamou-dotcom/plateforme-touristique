<?php
$site   = $site   ?? null;
$villes = $villes ?? [];
$badges = $badges ?? [];
$mode   = $mode   ?? 'create';

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

                <!-- Photo -->
                <div class="form-group form-group--full">
                    <label>Photo du site</label>
                    <?php if (!empty($site->photo_url)): ?>
                    <div class="photo-preview">
                        <img src="<?= htmlspecialchars($site->photo_url) ?>" alt="Photo actuelle">
                        <p class="photo-hint">Choisir un nouveau fichier pour remplacer la photo actuelle.</p>
                    </div>
                    <?php endif; ?>
                    <input type="file" name="photo" accept="image/jpeg,image/png,image/webp">
                    <p class="field-hint">JPG, PNG ou WEBP — max 3 Mo</p>
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
.form-group label {
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
.field-hint { font-size: .72rem; color: #6b7280; margin-top: 4px; }
.photo-preview { margin-bottom: 10px; }
.photo-preview img { width: 180px; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(255,255,255,.1); }
.photo-hint { font-size: .72rem; color: #6b7280; margin-top: 6px; }
.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: .88rem;
    color: rgba(255,255,255,.7);
}
.checkbox-label input { width: 16px; height: 16px; accent-color: #008751; }
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,.07);
}
@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
    .form-group--full { grid-column: 1; }
}
</style>

</body>
</html>