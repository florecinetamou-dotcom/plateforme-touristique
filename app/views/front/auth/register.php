<?php $title = 'Inscription - BeninExplore'; ?>
<?php
if (!empty($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #06180f;
            position: relative;
        }

        .bg-animated { position: fixed; inset: 0; z-index: 0; overflow: hidden; }
        .bg-animated::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(0,135,81,0.35) 0%, transparent 70%);
            top: -150px; left: -150px;
            animation: float1 8s ease-in-out infinite;
        }
        .bg-animated::after {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,214,0,0.2) 0%, transparent 70%);
            bottom: -100px; right: -100px;
            animation: float2 10s ease-in-out infinite;
        }
        @keyframes float1 {
            0%, 100% { transform: translate(0,0) scale(1); }
            50%       { transform: translate(40px,40px) scale(1.1); }
        }
        @keyframes float2 {
            0%, 100% { transform: translate(0,0) scale(1); }
            50%       { transform: translate(-30px,-30px) scale(1.05); }
        }
        .dots {
            position: fixed; inset: 0; z-index: 0;
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        /* Bouton retour DESKTOP */
        .back-link-desktop {
            position: fixed;
            top: 20px; left: 20px;
            z-index: 10;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            background: rgba(255,255,255,0.12);
            padding: 8px 16px;
            border-radius: 50px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.15);
            transition: all 0.3s;
        }
        .back-link-desktop:hover { background: rgba(255,255,255,0.2); color: white; }

        /* Wrapper */
        .page-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 960px;
        }

        /* Bouton retour MOBILE */
        .back-link-mobile {
            display: none;
            align-items: center;
            gap: 8px;
            align-self: flex-start;
            margin-bottom: 14px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            background: rgba(255,255,255,0.12);
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.15);
            transition: all 0.3s;
        }
        .back-link-mobile:hover { background: rgba(255,255,255,0.2); color: white; }

        .register-wrapper {
            display: flex;
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.5);
        }

        /* Panneau gauche */
        .panel-left {
            width: 300px;
            flex-shrink: 0;
            background: linear-gradient(160deg, #008751 0%, #005c37 60%, #003d24 100%);
            padding: 50px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .panel-left::before {
            content: '';
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            bottom: -70px; right: -70px;
        }
        .panel-left::after {
            content: '';
            position: absolute;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(255,214,0,0.08);
            top: 30px; right: 20px;
        }
        .panel-brand { display: flex; align-items: center; gap: 12px; }
        .panel-brand-icon {
            width: 42px; height: 42px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #FFD600; font-size: 18px;
        }
        .panel-brand-name { font-size: 1.3rem; font-weight: 700; color: white; }
        .panel-brand-name span { color: #FFD600; }
        .panel-content { position: relative; z-index: 1; }
        .panel-content h2 { color: white; font-size: 1.4rem; font-weight: 700; line-height: 1.4; margin-bottom: 12px; }
        .panel-content p { color: rgba(255,255,255,0.6); font-size: 0.875rem; line-height: 1.7; }
        .panel-steps { display: flex; flex-direction: column; gap: 14px; position: relative; z-index: 1; }
        .step-item { display: flex; align-items: center; gap: 12px; }
        .step-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(255,214,0,0.2);
            border: 1.5px solid rgba(255,214,0,0.4);
            display: flex; align-items: center; justify-content: center;
            color: #FFD600; font-size: 0.75rem; font-weight: 700; flex-shrink: 0;
        }
        .step-text { color: rgba(255,255,255,0.75); font-size: 0.82rem; }

        /* Panneau droit */
        .panel-right {
            flex: 1;
            background: white;
            padding: 40px 44px;
            overflow-y: auto;
        }
        .form-title { font-size: 1.4rem; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
        .form-subtitle { color: #888; font-size: 0.875rem; margin-bottom: 20px; }

        .form-label { font-size: 0.8rem; font-weight: 600; color: #444; margin-bottom: 5px; }
        .input-group-text {
            background: #f8f9fa;
            border: 1.5px solid #e8e8e8;
            border-right: none;
            color: #008751; padding: 0 12px;
        }
        .form-control {
            border: 1.5px solid #e8e8e8;
            border-left: none;
            font-size: 0.875rem;
            padding: 9px 12px; color: #333;
        }
        .form-control.no-icon {
            border-left: 1.5px solid #e8e8e8;
            border-radius: 8px !important;
        }
        .form-control:focus { border-color: #008751; box-shadow: none; }
        .input-group:focus-within .input-group-text { border-color: #008751; }
        .toggle-password {
            border: 1.5px solid #e8e8e8;
            border-left: none;
            background: #f8f9fa;
            color: #888; padding: 0 10px; transition: color 0.2s;
        }
        .toggle-password:hover { color: #008751; }

        /* Sélecteur rôle */
        .role-selector { display: flex; gap: 10px; }
        .role-card {
            flex: 1;
            border: 1.5px solid #e8e8e8;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex; align-items: center; gap: 10px;
            position: relative;
        }
        .role-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .role-card-icon {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: #f0faf5;
            display: flex; align-items: center; justify-content: center;
            color: #008751; font-size: 14px; flex-shrink: 0;
            transition: all 0.2s;
        }
        .role-card-label { font-size: 0.82rem; font-weight: 600; color: #333; }
        .role-card-desc  { font-size: 0.73rem; color: #888; }
        .role-card:hover { border-color: #008751; background: #f9fffe; }
        .role-card.selected { border-color: #008751; background: #f0faf5; }
        .role-card.selected .role-card-icon { background: #008751; color: white; }
        .role-card.selected .role-card-label { color: #008751; }

        /* Force mot de passe */
        .password-strength { height: 4px; border-radius: 4px; background: #eee; margin-top: 6px; overflow: hidden; }
        .password-strength-bar { height: 100%; border-radius: 4px; transition: all 0.3s ease; width: 0%; }

        .form-check-input:checked { background-color: #008751; border-color: #008751; }
        .form-check-label { font-size: 0.82rem; color: #555; }

        .btn-register {
            background: linear-gradient(135deg, #008751, #00a862);
            color: white; border: none;
            border-radius: 50px; padding: 12px;
            font-weight: 600; font-size: 0.92rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,135,81,0.3);
        }
        .btn-register:hover {
            color: white; transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,135,81,0.4);
            filter: brightness(1.05);
        }

        .link-benin { color: #008751; font-weight: 600; text-decoration: none; }
        .link-benin:hover { color: #005c37; text-decoration: underline; }

        .alert { border: none; border-radius: 10px; font-size: 0.85rem; padding: 10px 14px; }
        .alert-danger { background: #fee2e2; color: #991b1b; }

        .section-divider {
            font-size: 0.75rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.8px;
            color: #bbb;
            display: flex; align-items: center; gap: 10px;
            margin: 16px 0 12px;
        }
        .section-divider::before,
        .section-divider::after { content: ''; flex: 1; height: 1px; background: #eee; }

        /* ===== MOBILE ===== */
        @media (max-width: 768px) {
            body { align-items: flex-start; padding: 24px 16px; overflow-y: auto; }

            .back-link-desktop { display: none; }
            .back-link-mobile  { display: inline-flex; }

            .panel-left { display: none !important; }

            .register-wrapper { border-radius: 20px; }

            .panel-right { padding: 28px 22px; }

            .role-selector { flex-direction: column; }
        }
    </style>
</head>
<body>

    <div class="bg-animated"></div>
    <div class="dots"></div>

    <!-- Bouton retour desktop -->
    <a href="/" class="back-link-desktop">
        <i class="fas fa-arrow-left me-2"></i>Accueil
    </a>

    <div class="page-wrapper">

        <!-- Bouton retour mobile (dans le flux) -->
        <a href="/" class="back-link-mobile">
            <i class="fas fa-arrow-left"></i>Accueil
        </a>

        <div class="register-wrapper">

            <!-- Panneau gauche -->
            <div class="panel-left d-none d-md-flex flex-column justify-content-between">
                <div class="panel-brand">
                    <div class="panel-brand-icon"><i class="fas fa-map-marked-alt"></i></div>
                    <span class="panel-brand-name">Benin<span>Explore</span></span>
                </div>
                <div class="panel-content">
                    <h2>Rejoignez notre communauté de voyageurs</h2>
                    <p>Créez votre compte gratuitement et commencez à explorer les merveilles du Bénin.</p>
                </div>
                <div class="panel-steps">
                    <div class="step-item">
                        <div class="step-num">1</div>
                        <span class="step-text">Créez votre compte en 2 minutes</span>
                    </div>
                    <div class="step-item">
                        <div class="step-num">2</div>
                        <span class="step-text">Explorez sites et hébergements</span>
                    </div>
                    <div class="step-item">
                        <div class="step-num">3</div>
                        <span class="step-text">Réservez et vivez l'aventure</span>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="panel-right">
                <h1 class="form-title">Créer un compte ✨</h1>
                <p class="form-subtitle">Rejoignez BeninExplore dès maintenant — c'est gratuit</p>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']) ?>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form method="POST" action="/register" novalidate>

                    <div class="section-divider">Identité</div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control no-icon" id="prenom" name="prenom"
                                   value="<?= htmlspecialchars($_SESSION['old']['prenom'] ?? '') ?>"
                                   placeholder="Jean" autocomplete="given-name" required>
                        </div>
                        <div class="col-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control no-icon" id="nom" name="nom"
                                   value="<?= htmlspecialchars($_SESSION['old']['nom'] ?? '') ?>"
                                   placeholder="Gbaguidi" autocomplete="family-name" required>
                        </div>
                    </div>

                    <div class="section-divider">Contact</div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="email" class="form-label">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                                       placeholder="vous@exemple.com" autocomplete="email" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="telephone" class="form-label">Téléphone <span class="text-muted fw-normal">(optionnel)</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control" id="telephone" name="telephone"
                                       value="<?= htmlspecialchars($_SESSION['old']['telephone'] ?? '') ?>"
                                       placeholder="+229 01 23 45 67" autocomplete="tel">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">Mot de passe</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="••••••••" autocomplete="new-password" minlength="6" required>
                                <button class="btn toggle-password" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-1">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <small class="text-muted" id="strengthText">6 caractères minimum</small>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirm" class="form-label">Confirmer</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                                       placeholder="••••••••" autocomplete="new-password" required>
                                <button class="btn toggle-password" type="button" id="togglePasswordConfirm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small id="matchText">&nbsp;</small>
                        </div>
                    </div>

                    <div class="section-divider">Type de compte</div>
                    <div class="role-selector">
                        <label class="role-card selected" id="card-voyageur">
                            <input type="radio" name="role" value="voyageur" checked>
                            <div class="role-card-icon"><i class="fas fa-suitcase"></i></div>
                            <div>
                                <div class="role-card-label">Voyageur</div>
                                <div class="role-card-desc">Explorer & réserver</div>
                            </div>
                        </label>
                        <label class="role-card" id="card-hebergeur">
                            <input type="radio" name="role" value="hebergeur">
                            <div class="role-card-icon"><i class="fas fa-hotel"></i></div>
                            <div>
                                <div class="role-card-label">Hébergeur</div>
                                <div class="role-card-desc">Gérer mes logements</div>
                            </div>
                        </label>
                    </div>

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="conditions" name="conditions" required>
                        <label class="form-check-label" for="conditions">
                            J'accepte les <a href="#" class="link-benin">conditions générales d'utilisation</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-register w-100 mt-3 mb-3">
                        <i class="fas fa-user-plus me-2"></i>Créer mon compte
                    </button>

                    <p class="text-center mb-0" style="font-size:0.85rem; color:#888;">
                        Déjà un compte ? <a href="/login" class="link-benin">Se connecter</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <?php unset($_SESSION['old']); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePwd(btnId, inputId) {
            document.getElementById(btnId).addEventListener('click', function () {
                const input = document.getElementById(inputId);
                const icon  = this.querySelector('i');
                const show  = input.type === 'password';
                input.type  = show ? 'text' : 'password';
                icon.classList.toggle('fa-eye',       !show);
                icon.classList.toggle('fa-eye-slash',  show);
            });
        }
        togglePwd('togglePassword',        'password');
        togglePwd('togglePasswordConfirm', 'password_confirm');

        // Force mot de passe
        document.getElementById('password').addEventListener('input', function () {
            const val  = this.value;
            const bar  = document.getElementById('strengthBar');
            const text = document.getElementById('strengthText');
            let score  = 0;
            if (val.length >= 6)            score++;
            if (val.length >= 10)           score++;
            if (/[A-Z]/.test(val))          score++;
            if (/[0-9]/.test(val))          score++;
            if (/[^A-Za-z0-9]/.test(val))   score++;
            const levels = [
                { pct: '0%',   color: '#eee',   label: '6 caractères minimum' },
                { pct: '25%',  color: '#ef4444', label: 'Très faible' },
                { pct: '50%',  color: '#f97316', label: 'Faible' },
                { pct: '75%',  color: '#eab308', label: 'Correct' },
                { pct: '90%',  color: '#22c55e', label: 'Fort' },
                { pct: '100%', color: '#008751', label: 'Excellent ✓' },
            ];
            const lvl = levels[Math.min(score, 5)];
            bar.style.width      = lvl.pct;
            bar.style.background = lvl.color;
            text.textContent     = lvl.label;
            text.style.color     = lvl.color === '#eee' ? '#aaa' : lvl.color;
        });

        // Correspondance mots de passe
        document.getElementById('password_confirm').addEventListener('input', function () {
            const pwd  = document.getElementById('password').value;
            const text = document.getElementById('matchText');
            if (!this.value) { text.innerHTML = '&nbsp;'; return; }
            if (this.value === pwd) {
                text.textContent = '✓ Les mots de passe correspondent';
                text.style.color = '#008751';
            } else {
                text.textContent = '✗ Les mots de passe ne correspondent pas';
                text.style.color = '#ef4444';
            }
        });

        // Sélecteur rôle
        document.querySelectorAll('.role-card').forEach(card => {
            card.addEventListener('click', function () {
                document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>
</body>
</html>