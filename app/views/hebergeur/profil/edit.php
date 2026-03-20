<?php $title = 'Modifier mon profil - BeninExplore'; ?>
<?php ob_start(); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

.edit-heb * { font-family: 'DM Sans', sans-serif; }
.edit-heb h1,.edit-heb h2,.edit-heb h3,.edit-heb h4,.edit-heb h5,.edit-heb label,.edit-heb .fw-bold { font-family: 'Syne', sans-serif; }

.edit-heb { background: #f0f7f3; min-height: 100vh; }

.edit-card {
    background: #fff; border: 1px solid #E8EBF0;
    border-radius: 16px; padding: 24px 28px;
    box-shadow: 0 2px 12px rgba(0,0,0,.04); margin-bottom: 18px;
}
.edit-card-title {
    font-family: 'Syne', sans-serif; font-size: .72rem;
    text-transform: uppercase; letter-spacing: .1em;
    color: #6b7585; margin-bottom: 18px;
    padding-bottom: 10px; border-bottom: 1px solid #F7F8FA;
    display: flex; align-items: center; gap: 8px;
}
.edit-card-title i { color: #008751; }

.form-label { font-size: .78rem; font-weight: 700; color: #0f1923; margin-bottom: 6px; }
.form-label .req { color: #E8112D; }
.form-control, .form-select {
    border: 1.5px solid #E8EBF0; border-radius: 10px;
    padding: 10px 14px; font-size: .88rem;
    font-family: 'DM Sans', sans-serif;
    background: #F7F8FA; color: #0f1923; transition: all .2s;
}
.form-control:focus, .form-select:focus {
    border-color: #008751; background: #fff;
    box-shadow: 0 0 0 3px rgba(0,135,81,.1); outline: none;
}
.form-control:disabled { opacity: .5; cursor: not-allowed; }
textarea.form-control { resize: vertical; min-height: 80px; }
.lock-hint { font-size: .7rem; color: #b0b8c4; margin-top: 3px; display: flex; align-items: center; gap: 4px; }

/* Avatar */
.avatar-wrap { position: relative; display: inline-block; }
.avatar-img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #E8EBF0; }
.avatar-ph {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, #008751, #00c97a);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-size: 1.8rem; font-weight: 800;
    color: #fff; border: 3px solid #E8EBF0;
}
.avatar-btn {
    position: absolute; bottom: 0; right: 0;
    width: 26px; height: 26px; border-radius: 50%;
    background: #008751; color: #fff; border: 2px solid #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; cursor: pointer; transition: all .2s;
}
.avatar-btn:hover { background: #005c37; transform: scale(1.1); }

.btn-save {
    background: linear-gradient(135deg, #008751, #00a862);
    color: #fff; border: none; border-radius: 50px;
    padding: 10px 32px; font-family: 'Syne', sans-serif;
    font-size: .85rem; font-weight: 700; cursor: pointer;
    transition: all .25s; box-shadow: 0 4px 14px rgba(0,135,81,.3);
}
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,135,81,.4); }
.btn-cancel {
    color: #6b7585; text-decoration: none; font-size: .82rem;
    font-family: 'Syne', sans-serif; transition: color .2s;
}
.btn-cancel:hover { color: #E8112D; }
</style>

<div class="container-fluid py-4 edit-heb">
<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <?php include dirname(__DIR__, 2) . '/layout/sidebar-hebergeur.php'; ?>
    </div>

    <!-- Contenu -->
    <div class="col-md-9">

        <!-- Header -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="/hebergeur/profil"
               style="width:36px;height:36px;border-radius:50%;background:#fff;border:1.5px solid #E8EBF0;display:flex;align-items:center;justify-content:center;color:#0f1923;text-decoration:none;transition:all .2s"
               onmouseover="this.style.borderColor='#008751';this.style.color='#008751'"
               onmouseout="this.style.borderColor='#E8EBF0';this.style.color='#0f1923'">
                <i class="fas fa-arrow-left" style="font-size:.75rem"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-0">Modifier mon profil</h4>
                <p style="color:#6b7585;font-size:.78rem;margin:0">Mettez à jour vos informations</p>
            </div>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 small">
            <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); endif; ?>

        <form method="POST" action="/hebergeur/profil/update" enctype="multipart/form-data">

            <!-- Avatar -->
            <div class="edit-card">
                <div class="edit-card-title"><i class="fas fa-camera"></i> Photo de profil</div>
                <div class="d-flex align-items-center gap-4">
                    <div class="avatar-wrap">
                        <?php if (!empty($user->avatar_url)): ?>
                            <img src="<?= htmlspecialchars($user->avatar_url) ?>" class="avatar-img" id="avatar-preview" alt="Avatar">
                        <?php else: ?>
                            <div class="avatar-ph" id="avatar-placeholder">
                                <?= strtoupper(substr($user->prenom ?? 'H', 0, 1)) ?>
                            </div>
                            <img src="" class="avatar-img" id="avatar-preview" style="display:none" alt="">
                        <?php endif; ?>
                        <label for="avatar-input" class="avatar-btn" title="Changer">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" name="avatar" id="avatar-input" style="display:none"
                               accept="image/jpeg,image/png,image/webp"
                               onchange="previewAvatar(this)">
                    </div>
                    <div>
                        <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:.85rem;color:#0f1923;margin-bottom:3px">
                            <?= htmlspecialchars($user->prenom . ' ' . $user->nom) ?>
                        </div>
                        <div style="font-size:.76rem;color:#6b7585">Cliquez sur 📷 pour changer</div>
                        <div style="font-size:.7rem;color:#b0b8c4;margin-top:2px">JPG, PNG, WEBP — max 2 Mo</div>
                    </div>
                </div>
            </div>

            <!-- Infos personnelles -->
            <div class="edit-card">
                <div class="edit-card-title"><i class="fas fa-user"></i> Informations personnelles</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user->prenom ?? '') ?>" disabled>
                        <div class="lock-hint"><i class="fas fa-lock" style="font-size:.6rem"></i> Non modifiable</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user->nom ?? '') ?>" disabled>
                        <div class="lock-hint"><i class="fas fa-lock" style="font-size:.6rem"></i> Non modifiable</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user->email) ?>" disabled>
                        <div class="lock-hint"><i class="fas fa-lock" style="font-size:.6rem"></i> Non modifiable</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-control"
                               value="<?= htmlspecialchars($user->telephone ?? '') ?>"
                               placeholder="+229 XX XX XX XX">
                    </div>
                </div>
            </div>

            <!-- Infos établissement -->
            <div class="edit-card">
                <div class="edit-card-title"><i class="fas fa-building"></i> Mon établissement</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nom de l'établissement <span class="req">*</span></label>
                        <input type="text" name="nom_etablissement" class="form-control"
                               value="<?= htmlspecialchars($profil->nom_etablissement ?? '') ?>"
                               placeholder="Ex: Hôtel Le Bénin, Villa Bel Air…">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Adresse</label>
                        <textarea name="adresse" class="form-control" rows="2"
                                  placeholder="Rue, quartier, ville…"><?= htmlspecialchars($profil->adresse ?? '') ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Numéro SIRET</label>
                        <input type="text" name="numero_siret" class="form-control"
                               value="<?= htmlspecialchars($profil->numero_siret ?? '') ?>"
                               placeholder="14 chiffres" maxlength="14">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description de l'établissement</label>
                        <textarea name="description" class="form-control" rows="4"
                                  placeholder="Décrivez votre établissement, vos services, votre ambiance…"><?= htmlspecialchars($profil->description ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Préférences -->
            <div class="edit-card">
                <div class="edit-card-title"><i class="fas fa-sliders-h"></i> Préférences</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Langue préférée</label>
                        <select name="langue" class="form-select">
                            <option value="fr" <?= ($user->langue_preferee ?? 'fr') === 'fr' ? 'selected' : '' ?>>🇫🇷 Français</option>
                            <option value="en" <?= ($user->langue_preferee ?? '') === 'en' ? 'selected' : '' ?>>🇬🇧 English</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check pb-2">
                            <input class="form-check-input" type="checkbox" name="newsletter"
                                   id="newsletter" value="1"
                                   <?= ($user->newsletter ?? 0) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="newsletter"
                                   style="font-size:.83rem;font-family:'Syne',sans-serif;font-weight:600">
                                Recevoir la newsletter
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex align-items-center justify-content-between">
                <a href="/hebergeur/profil" class="btn-cancel">← Annuler</a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>
</div>
</div>

<script>
function previewAvatar(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('avatar-preview');
        const ph      = document.getElementById('avatar-placeholder');
        preview.src           = e.target.result;
        preview.style.display = 'block';
        if (ph) ph.style.display = 'none';
    };
    reader.readAsDataURL(file);
}
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>