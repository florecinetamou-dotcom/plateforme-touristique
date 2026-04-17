<?php
$title  = 'Nouveau mot de passe - BeninExplore';
$token  = $token  ?? '';
$errors = $errors ?? [];
ob_start();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap');

.reset-page * { font-family: 'DM Sans', sans-serif; }
.reset-page h1,.reset-page h2,.reset-page label,.reset-page .fw-bold { font-family: 'Syne', sans-serif; }

.reset-page {
    min-height: 100vh; background: #F7F8FA;
    display: flex; align-items: center; padding: 40px 0;
}
.reset-card {
    background: #fff; border: 1px solid #E8EBF0;
    border-radius: 24px; padding: 48px 44px;
    box-shadow: 0 8px 40px rgba(0,0,0,.07);
    max-width: 460px; margin: 0 auto;
    animation: cardIn .5s ease both;
}
@keyframes cardIn { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

.reset-logo { display: flex; align-items: center; gap: 8px; justify-content: center; margin-bottom: 32px; text-decoration: none; }
.reset-logo-icon { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg,#008751,#00a862); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 15px; }
.reset-logo span { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:800; color:#0f1923; }
.reset-logo span em { color:#008751; font-style:normal; }

.reset-icon { width:72px; height:72px; border-radius:20px; background:linear-gradient(135deg,rgba(0,135,81,.12),rgba(0,135,81,.06)); border:1.5px solid rgba(0,135,81,.2); display:flex; align-items:center; justify-content:center; margin:0 auto 20px; font-size:1.8rem; }
.reset-title { font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:800; color:#0f1923; text-align:center; margin-bottom:8px; }
.reset-sub { color:#6b7585; font-size:.88rem; line-height:1.7; text-align:center; margin-bottom:32px; }

.form-label { font-size:.78rem; font-weight:700; color:#0f1923; margin-bottom:7px; display:block; }
.pwd-wrap { position:relative; margin-bottom:18px; }
.pwd-input { width:100%; border:1.5px solid #E8EBF0; border-radius:12px; padding:11px 44px 11px 14px; font-size:.9rem; font-family:'DM Sans',sans-serif; background:#F7F8FA; color:#0f1923; transition:all .2s; outline:none; }
.pwd-input:focus { border-color:#008751; background:#fff; box-shadow:0 0 0 3px rgba(0,135,81,.1); }
.pwd-toggle { position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; color:#b0b8c4; cursor:pointer; font-size:.85rem; transition:color .15s; }
.pwd-toggle:hover { color:#008751; }

.force-bar { height:4px; border-radius:2px; background:#E8EBF0; margin-top:8px; overflow:hidden; }
.force-fill { height:100%; border-radius:2px; transition:width .3s,background .3s; width:0; }
.force-label { font-size:.7rem; color:#6b7585; margin-top:4px; }

.btn-reset { width:100%; background:linear-gradient(135deg,#008751,#00a862); color:#fff; border:none; border-radius:12px; padding:13px; font-family:'Syne',sans-serif; font-size:.9rem; font-weight:700; cursor:pointer; transition:all .3s; margin-top:8px; box-shadow:0 6px 20px rgba(0,135,81,.3); }
.btn-reset:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(0,135,81,.4); }

.error-list { background:rgba(232,17,45,.05); border:1.5px solid rgba(232,17,45,.2); border-radius:12px; padding:14px 16px; margin-bottom:20px; }
.error-list li { font-size:.82rem; color:#c0001a; padding:3px 0; list-style:none; display:flex; align-items:center; gap:7px; }
.error-list li::before { content:'✕'; font-size:.65rem; }

.back-link { display:flex; align-items:center; justify-content:center; gap:7px; color:#6b7585; text-decoration:none; font-size:.84rem; font-weight:600; margin-top:20px; transition:color .2s; font-family:'Syne',sans-serif; }
.back-link:hover { color:#008751; }
</style>

<div class="reset-page">
<div class="container">
<div class="row justify-content-center">
<div class="col-12">
<div class="reset-card">

    <a href="/" class="reset-logo">
        <div class="reset-logo-icon"><i class="fas fa-map-marked-alt"></i></div>
        <span>Benin<em>Explore</em></span>
    </a>

    <div class="reset-icon">🔒</div>
    <h2 class="reset-title">Nouveau mot de passe</h2>
    <p class="reset-sub">Choisissez un mot de passe sécurisé pour votre compte.</p>

    <?php if (!empty($errors)): ?>
    <ul class="error-list">
        <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form method="POST" action="/reset_password">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <div>
            <label class="form-label">Nouveau mot de passe</label>
            <div class="pwd-wrap">
                <input type="password" name="new_password" id="new-pwd" class="pwd-input"
                       placeholder="••••••••" required autocomplete="new-password"
                       oninput="checkStrength(this.value)">
                <button type="button" class="pwd-toggle" onclick="togglePwd('new-pwd',this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <div class="force-bar"><div class="force-fill" id="force-fill"></div></div>
            <div class="force-label" id="force-label"></div>
        </div>

        <div style="margin-top:16px">
            <label class="form-label">Confirmer le mot de passe</label>
            <div class="pwd-wrap">
                <input type="password" name="confirm_password" id="confirm-pwd" class="pwd-input"
                       placeholder="••••••••" required autocomplete="new-password">
                <button type="button" class="pwd-toggle" onclick="togglePwd('confirm-pwd',this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-reset">
            <i class="fas fa-lock me-2"></i>Enregistrer le nouveau mot de passe
        </button>
    </form>

    <a href="/login" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à la connexion
    </a>

</div>
</div>
</div>
</div>
</div>

<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    input.type     = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}
function checkStrength(val) {
    const fill  = document.getElementById('force-fill');
    const label = document.getElementById('force-label');
    if (!val.length) { fill.style.width='0'; label.textContent=''; return; }
    let score = 0;
    if (val.length >= 6)  score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        {pct:'20%',color:'#E8112D',text:'Très faible'},
        {pct:'40%',color:'#ff7700',text:'Faible'},
        {pct:'60%',color:'#FCD116',text:'Moyen'},
        {pct:'80%',color:'#00c97a',text:'Fort'},
        {pct:'100%',color:'#008751',text:'Très fort 💪'},
    ];
    const lvl = levels[Math.min(score-1,4)] ?? levels[0];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent     = lvl.text;
    label.style.color     = lvl.color;
}
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>