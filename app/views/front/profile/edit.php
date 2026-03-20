<?php
$title = 'Modifier mon profil - BeninExplore';
ob_start();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

.edit-page * { font-family: 'DM Sans', sans-serif; }
.edit-page h1,.edit-page h2,.edit-page h3,.edit-page h4,.edit-page label,.edit-page .fw-bold { font-family: 'Syne', sans-serif; }

.edit-page { background: #F7F8FA; min-height: 100vh; padding: 32px 0 60px; }

.edit-card {
    background: #fff; border: 1px solid #E8EBF0;
    border-radius: 18px; padding: 32px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    margin-bottom: 20px;
}
.edit-card-title {
    font-family: 'Syne', sans-serif; font-size: .75rem;
    text-transform: uppercase; letter-spacing: .1em;
    color: #6b7585; margin-bottom: 20px;
    padding-bottom: 12px; border-bottom: 1px solid #F7F8FA;
    display: flex; align-items: center; gap: 8px;
}
.edit-card-title i { color: #008751; }

.form-label { font-size: .78rem; font-weight: 700; color: #0f1923; margin-bottom: 6px; letter-spacing: .01em; }
.form-label .req { color: #E8112D; }
.form-control, .form-select {
    border: 1.5px solid #E8EBF0; border-radius: 10px;
    padding: 10px 14px; font-size: .88rem;
    font-family: 'DM Sans', sans-serif;
    background: #F7F8FA; color: #0f1923;
    transition: all .2s;
}
.form-control:focus, .form-select:focus {
    border-color: #008751; background: #fff;
    box-shadow: 0 0 0 3px rgba(0,135,81,.1); outline: none;
}
.form-control:disabled { opacity: .5; cursor: not-allowed; }

/* Avatar upload */
.avatar-wrap { position: relative; display: inline-block; }
.avatar-img {
    width: 90px; height: 90px; border-radius: 50%;
    object-fit: cover; border: 3px solid #E8EBF0;
}
.avatar-placeholder {
    width: 90px; height: 90px; border-radius: 50%;
    background: linear-gradient(135deg, #008751, #00c97a);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-size: 2rem;
    font-weight: 800; color: #fff; border: 3px solid #E8EBF0;
}
.avatar-btn {
    position: absolute; bottom: 0; right: 0;
    width: 28px; height: 28px; border-radius: 50%;
    background: #008751; color: #fff; border: 2px solid #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; cursor: pointer; transition: all .2s;
}
.avatar-btn:hover { background: #005c37; transform: scale(1.1); }
.avatar-input { display: none; }

.btn-save {
    background: linear-gradient(135deg, #008751, #00a862);
    color: #fff; border: none; border-radius: 50px;
    padding: 11px 36px; font-family: 'Syne', sans-serif;
    font-size: .85rem; font-weight: 700; cursor: pointer;
    transition: all .25s;
    box-shadow: 0 4px 14px rgba(0,135,81,.3);
}
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,135,81,.4); }

.btn-cancel {
    color: #6b7585; text-decoration: none;
    font-size: .82rem; font-family: 'Syne', sans-serif;
    transition: color .2s;
}
.btn-cancel:hover { color: #E8112D; }

.field-locked {
    background: #F7F8FA; border-color: #E8EBF0;
    color: #6b7585; cursor: not-allowed;
}
.lock-hint { font-size: .7rem; color: #b0b8c4; margin-top: 4px; display: flex; align-items: center; gap: 4px; }
</style>

<div class="edit-page">
<div class="container" style="max-width:720px">

    <!-- Header -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="/profile" style="width:38px;height:38px;border-radius:50%;background:#fff;border:1.5px solid #E8EBF0;display:flex;align-items:center;justify-content:center;color:#0f1923;text-decoration:none;transition:all .2s"
           onmouseover="this.style.borderColor='#008751';this.style.color='#008751'"
           onmouseout="this.style.borderColor='#E8EBF0';this.style.color='#0f1923'">
            <i class="fas fa-arrow-left" style="font-size:.8rem"></i>
        </a>
        <div>
            <h4 style="font-family:'Syne',sans-serif;font-weight:800;margin:0;font-size:1.3rem">Modifier mon profil</h4>
            <p style="color:#6b7585;font-size:.8rem;margin:0">Mettez à jour vos informations personnelles</p>
        </div>
    </div>

    <!-- Alertes -->
    <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 small">
        <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); endif; ?>

    <form method="POST" action="/profile/edit" enctype="multipart/form-data">

        <!-- Avatar -->
        <div class="edit-card">
            <div class="edit-card-title"><i class="fas fa-camera"></i> Photo de profil</div>
            <div class="d-flex align-items-center gap-4">
                <div class="avatar-wrap">
                    <?php if (!empty($user->avatar_url)): ?>
                        <img src="<?= htmlspecialchars($user->avatar_url) ?>" class="avatar-img" id="avatar-preview" alt="Avatar">
                    <?php else: ?>
                        <div class="avatar-placeholder" id="avatar-placeholder">
                            <?= strtoupper(substr($user->prenom ?? 'U', 0, 1)) ?>
                        </div>
                        <img src="" class="avatar-img" id="avatar-preview" style="display:none" alt="Avatar">
                    <?php endif; ?>
                    <label for="avatar-input" class="avatar-btn" title="Changer la photo">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" name="avatar" id="avatar-input" class="avatar-input"
                           accept="image/jpeg,image/png,image/webp,image/gif"
                           onchange="previewAvatar(this)">
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:.88rem;color:#0f1923;margin-bottom:4px">
                        <?= htmlspecialchars($user->prenom . ' ' . $user->nom) ?>
                    </div>
                    <div style="font-size:.78rem;color:#6b7585">Cliquez sur l'icône 📷 pour changer la photo</div>
                    <div style="font-size:.72rem;color:#b0b8c4;margin-top:3px">JPG, PNG, WEBP — max 2 Mo</div>
                </div>
            </div>
        </div>

        <!-- Infos personnelles -->
        <div class="edit-card">
            <div class="edit-card-title"><i class="fas fa-user"></i> Informations personnelles</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Prénom <span class="req">*</span></label>
                    <input type="text" name="prenom" class="form-control"
                           value="<?= htmlspecialchars($user->prenom ?? '') ?>" required
                           placeholder="Votre prénom">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="req">*</span></label>
                    <input type="text" name="nom" class="form-control"
                           value="<?= htmlspecialchars($user->nom ?? '') ?>" required
                           placeholder="Votre nom">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control field-locked"
                           value="<?= htmlspecialchars($user->email) ?>" disabled>
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
                        <label class="form-check-label" for="newsletter" style="font-size:.85rem;font-family:'Syne',sans-serif;font-weight:600">
                            Recevoir la newsletter
                        </label>
                        <div style="font-size:.72rem;color:#b0b8c4;margin-top:2px">Offres et nouveautés BeninExplore</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center justify-content-between">
            <a href="/profile" class="btn-cancel">← Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save me-2"></i>Enregistrer les modifications
            </button>
        </div>

    </form>
</div>
</div>

<script>
function previewAvatar(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview     = document.getElementById('avatar-preview');
        const placeholder = document.getElementById('avatar-placeholder');
        preview.src           = e.target.result;
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
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