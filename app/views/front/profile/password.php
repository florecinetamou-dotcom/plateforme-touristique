<?php
$title = 'Changer mon mot de passe - BeninExplore';
ob_start();
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

.pwd-page * { font-family: 'DM Sans', sans-serif; }
.pwd-page h1,.pwd-page h2,.pwd-page h3,.pwd-page h4,.pwd-page label,.pwd-page .fw-bold { font-family: 'Syne', sans-serif; }

.pwd-page { background: #F7F8FA; min-height: 100vh; padding: 32px 0 60px; }

.pwd-card {
    background: #fff; border: 1px solid #E8EBF0;
    border-radius: 18px; padding: 36px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    max-width: 520px; margin: 0 auto;
}
.form-label { font-size: .78rem; font-weight: 700; color: #0f1923; margin-bottom: 6px; }
.form-label .req { color: #E8112D; }

.pwd-field { position: relative; }
.pwd-field .form-control {
    border: 1.5px solid #E8EBF0; border-radius: 10px;
    padding: 10px 44px 10px 14px;
    font-size: .88rem; background: #F7F8FA;
    font-family: 'DM Sans', sans-serif;
    transition: all .2s; width: 100%;
}
.pwd-field .form-control:focus {
    border-color: #008751; background: #fff;
    box-shadow: 0 0 0 3px rgba(0,135,81,.1); outline: none;
}
.pwd-toggle {
    position: absolute; right: 12px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    color: #b0b8c4; cursor: pointer;
    font-size: .85rem; padding: 4px;
    transition: color .15s;
}
.pwd-toggle:hover { color: #008751; }

/* Force meter */
.force-bar {
    height: 4px; border-radius: 2px;
    background: #E8EBF0; margin-top: 8px;
    overflow: hidden;
}
.force-fill {
    height: 100%; border-radius: 2px;
    transition: width .3s, background .3s;
    width: 0;
}
.force-label { font-size: .7rem; color: #6b7585; margin-top: 4px; }

.btn-save {
    background: linear-gradient(135deg, #008751, #00a862);
    color: #fff; border: none; border-radius: 50px;
    padding: 11px 36px; font-family: 'Syne', sans-serif;
    font-size: .85rem; font-weight: 700; cursor: pointer;
    transition: all .25s; width: 100%;
    box-shadow: 0 4px 14px rgba(0,135,81,.3);
}
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,135,81,.4); }

.rules { background: #F7F8FA; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; }
.rules li { font-size: .78rem; color: #6b7585; padding: 3px 0; list-style: none; display: flex; align-items: center; gap: 7px; }
.rules li i { font-size: .65rem; width: 14px; }
.rules li.ok { color: #008751; }
.rules li.ok i { color: #008751; }
</style>

<div class="pwd-page">
<div class="container">

    <!-- Header -->
    <div class="d-flex align-items-center gap-3 mb-4" style="max-width:520px;margin:0 auto 20px">
        <a href="/profile" style="width:38px;height:38px;border-radius:50%;background:#fff;border:1.5px solid #E8EBF0;display:flex;align-items:center;justify-content:center;color:#0f1923;text-decoration:none;transition:all .2s"
           onmouseover="this.style.borderColor='#008751';this.style.color='#008751'"
           onmouseout="this.style.borderColor='#E8EBF0';this.style.color='#0f1923'">
            <i class="fas fa-arrow-left" style="font-size:.8rem"></i>
        </a>
        <div>
            <h4 style="font-family:'Syne',sans-serif;font-weight:800;margin:0;font-size:1.3rem">Changer mon mot de passe</h4>
            <p style="color:#6b7585;font-size:.8rem;margin:0">Choisissez un mot de passe sécurisé</p>
        </div>
    </div>

    <!-- Alertes -->
    <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 small" style="max-width:520px;margin:0 auto 16px">
        <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); endif; ?>

    <div class="pwd-card">

        <!-- Règles -->
        <ul class="rules" id="rules-list">
            <li id="rule-length"><i class="fas fa-circle"></i> Au moins 6 caractères</li>
            <li id="rule-match"><i class="fas fa-circle"></i> Les mots de passe correspondent</li>
        </ul>

        <form method="POST" action="/profile/password">

            <!-- Mot de passe actuel -->
            <div class="mb-4">
                <label class="form-label">Mot de passe actuel <span class="req">*</span></label>
                <div class="pwd-field">
                    <input type="password" name="current_password" id="current" class="form-control"
                           placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="pwd-toggle" onclick="togglePwd('current', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Nouveau mot de passe -->
            <div class="mb-3">
                <label class="form-label">Nouveau mot de passe <span class="req">*</span></label>
                <div class="pwd-field">
                    <input type="password" name="new_password" id="new-pwd" class="form-control"
                           placeholder="••••••••" required autocomplete="new-password"
                           oninput="checkStrength(this.value); checkMatch()">
                    <button type="button" class="pwd-toggle" onclick="togglePwd('new-pwd', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="force-bar"><div class="force-fill" id="force-fill"></div></div>
                <div class="force-label" id="force-label"></div>
            </div>

            <!-- Confirmer -->
            <div class="mb-4">
                <label class="form-label">Confirmer le mot de passe <span class="req">*</span></label>
                <div class="pwd-field">
                    <input type="password" name="confirm_password" id="confirm-pwd" class="form-control"
                           placeholder="••••••••" required autocomplete="new-password"
                           oninput="checkMatch()">
                    <button type="button" class="pwd-toggle" onclick="togglePwd('confirm-pwd', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-lock me-2"></i>Changer le mot de passe
            </button>

        </form>
    </div>
</div>
</div>

<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type    = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type    = 'password';
        icon.className = 'fas fa-eye';
    }
}

function checkStrength(val) {
    const fill  = document.getElementById('force-fill');
    const label = document.getElementById('force-label');
    const rule  = document.getElementById('rule-length');

    if (val.length === 0) {
        fill.style.width = '0'; fill.style.background = ''; label.textContent = ''; return;
    }

    let score = 0;
    if (val.length >= 6)  score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { pct: '20%', color: '#E8112D', text: 'Très faible' },
        { pct: '40%', color: '#ff7700', text: 'Faible' },
        { pct: '60%', color: '#FCD116', text: 'Moyen' },
        { pct: '80%', color: '#00c97a', text: 'Fort' },
        { pct: '100%', color: '#008751', text: 'Très fort 💪' },
    ];
    const lvl = levels[Math.min(score - 1, 4)] ?? levels[0];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent     = lvl.text;
    label.style.color     = lvl.color;

    // Règle longueur
    if (val.length >= 6) {
        rule.classList.add('ok');
        rule.querySelector('i').className = 'fas fa-check-circle';
    } else {
        rule.classList.remove('ok');
        rule.querySelector('i').className = 'fas fa-circle';
    }
}

function checkMatch() {
    const newPwd  = document.getElementById('new-pwd').value;
    const confirm = document.getElementById('confirm-pwd').value;
    const rule    = document.getElementById('rule-match');

    if (confirm.length > 0 && newPwd === confirm) {
        rule.classList.add('ok');
        rule.querySelector('i').className = 'fas fa-check-circle';
    } else {
        rule.classList.remove('ok');
        rule.querySelector('i').className = 'fas fa-circle';
    }
}
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>