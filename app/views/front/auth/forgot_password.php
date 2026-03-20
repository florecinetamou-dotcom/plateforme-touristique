<?php
$errors  = $errors  ?? [];
$success = $success ?? false;
unset($_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - BeninExplore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<style>
* { font-family:'DM Sans',sans-serif; box-sizing:border-box; margin:0; padding:0; }
h1,h2,h3,label { font-family:'Syne',sans-serif; }

body {
    min-height:100vh; background:#F7F8FA;
    display:flex; align-items:center;
    padding:40px 0; position:relative; overflow:hidden;
}
body::before {
    content:''; position:fixed; top:-200px; right:-200px;
    width:500px; height:500px; border-radius:50%;
    background:radial-gradient(circle,rgba(0,135,81,.06) 0%,transparent 70%);
    pointer-events:none;
}
body::after {
    content:''; position:fixed; bottom:-200px; left:-200px;
    width:400px; height:400px; border-radius:50%;
    background:radial-gradient(circle,rgba(252,209,22,.05) 0%,transparent 70%);
    pointer-events:none;
}

.forgot-card {
    background:#fff; border:1px solid #E8EBF0;
    border-radius:24px; padding:48px 44px;
    box-shadow:0 8px 40px rgba(0,0,0,.07);
    max-width:460px; margin:0 auto;
    position:relative; z-index:1;
    animation:cardIn .5s ease both;
}
@keyframes cardIn { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

.forgot-logo { display:flex;align-items:center;gap:8px;justify-content:center;margin-bottom:32px;text-decoration:none; }
.forgot-logo-icon { width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#008751,#00a862);display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px;box-shadow:0 4px 12px rgba(0,135,81,.3); }
.forgot-logo span { font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:#0f1923; }
.forgot-logo span em { color:#008751;font-style:normal; }

.forgot-icon-wrap { width:72px;height:72px;border-radius:20px;background:linear-gradient(135deg,rgba(0,135,81,.12),rgba(0,135,81,.06));border:1.5px solid rgba(0,135,81,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:1.8rem;position:relative; }
.forgot-icon-wrap::after { content:'';position:absolute;inset:-6px;border-radius:26px;border:1px solid rgba(0,135,81,.1); }

.forgot-title { font-family:'Syne',sans-serif;font-size:1.6rem;font-weight:800;color:#0f1923;margin-bottom:8px;text-align:center; }
.forgot-sub { color:#6b7585;font-size:.88rem;line-height:1.7;text-align:center;margin-bottom:32px;max-width:320px;margin-left:auto;margin-right:auto; }

.form-label { font-size:.78rem;font-weight:700;color:#0f1923;margin-bottom:7px;letter-spacing:.01em;display:block; }
.input-wrap { position:relative; }
.input-icon { position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#b0b8c4;font-size:.9rem;pointer-events:none; }
.forgot-input { width:100%;border:1.5px solid #E8EBF0;border-radius:12px;padding:11px 14px 11px 42px;font-size:.9rem;background:#F7F8FA;color:#0f1923;transition:all .2s;outline:none; }
.forgot-input:focus { border-color:#008751;background:#fff;box-shadow:0 0 0 3px rgba(0,135,81,.1); }
.forgot-input.is-invalid { border-color:#E8112D; }
.forgot-input::placeholder { color:#c4cbd4; }
.error-msg { font-size:.75rem;color:#E8112D;margin-top:6px;display:flex;align-items:center;gap:5px; }

.btn-forgot { width:100%;background:linear-gradient(135deg,#008751,#00a862);color:#fff;border:none;border-radius:12px;padding:13px;font-family:'Syne',sans-serif;font-size:.9rem;font-weight:700;cursor:pointer;transition:all .3s;margin-top:24px;box-shadow:0 6px 20px rgba(0,135,81,.3);display:flex;align-items:center;justify-content:center;gap:8px; }
.btn-forgot:hover { transform:translateY(-2px);box-shadow:0 10px 28px rgba(0,135,81,.4); }

.success-box { background:rgba(0,135,81,.06);border:1.5px solid rgba(0,135,81,.2);border-radius:12px;padding:16px 20px;margin-top:20px;display:flex;align-items:flex-start;gap:12px; }
.success-box i { color:#008751;font-size:1.1rem;margin-top:1px;flex-shrink:0; }
.success-box p { font-size:.85rem;color:#0f5c38;margin:0;line-height:1.6; }

.forgot-divider { height:1px;background:#F0F2F5;margin:28px 0; }
.back-link { display:flex;align-items:center;justify-content:center;gap:7px;color:#6b7585;text-decoration:none;font-size:.84rem;font-weight:600;margin-top:20px;transition:color .2s;font-family:'Syne',sans-serif; }
.back-link:hover { color:#008751; }
.forgot-notes { display:flex;flex-direction:column;gap:8px;margin-top:28px; }
.forgot-note { display:flex;align-items:center;gap:8px;font-size:.75rem;color:#b0b8c4;justify-content:center; }
.forgot-note i { color:#008751;font-size:.7rem; }
</style>
</head>
<body>

<div class="container">
<div class="row justify-content-center">
<div class="col-12">
<div class="forgot-card">

    <a href="/" class="forgot-logo">
        <div class="forgot-logo-icon"><i class="fas fa-map-marked-alt"></i></div>
        <span>Benin<em>Explore</em></span>
    </a>

    <div class="forgot-icon-wrap">🔑</div>
    <h2 class="forgot-title">Mot de passe oublié ?</h2>
    <p class="forgot-sub">
        Pas d'inquiétude. Saisissez votre email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
    </p>

    <form method="POST" action="/forgot_password" id="forgotForm">
        <?php if (!empty($_SESSION['csrf_token'])): ?>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <?php endif; ?>

        <div class="mb-1">
            <label for="email" class="form-label">Adresse email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" id="email" name="email"
                       class="forgot-input <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                       value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                       placeholder="votre@email.com" required autocomplete="email">
            </div>
            <?php if (!empty($errors['email'])): ?>
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($errors['email']) ?>
            </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-forgot">
            <i class="fas fa-paper-plane"></i>
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <?php if ($success): ?>
    <div class="success-box">
        <i class="fas fa-check-circle"></i>
        <p>Si un compte existe avec cette adresse email, vous recevrez un lien de réinitialisation dans quelques instants. Vérifiez vos spams.</p>
    </div>
    <?php endif; ?>

    <div class="forgot-divider"></div>

    <a href="/login" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à la connexion
    </a>

    <div class="forgot-notes">
        <div class="forgot-note"><i class="fas fa-clock"></i> Le lien est valable pendant 1 heure</div>
        <div class="forgot-note"><i class="fas fa-shield-alt"></i> Vos données sont protégées</div>
    </div>

</div>
</div>
</div>
</div>

<script>
document.getElementById('forgotForm').addEventListener('submit', function() {
    const btn = this.querySelector('.btn-forgot');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
    btn.disabled = true;
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>