<?php $title = 'Connexion - BeninExplore'; ?>
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
            overflow: hidden;
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

        /* Bouton retour DESKTOP — fixé en haut à gauche */
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

        /* Wrapper global */
        .page-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 900px;
        }

        /* Bouton retour MOBILE — dans le flux, au-dessus du formulaire */
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

        .login-wrapper {
            display: flex;
            width: 100%;
            min-height: 540px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.5);
        }

        /* Panneau gauche */
        .panel-left {
            flex: 1;
            background: linear-gradient(160deg, #008751 0%, #005c37 60%, #003d24 100%);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .panel-left::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            bottom: -80px; right: -80px;
        }
        .panel-left::after {
            content: '';
            position: absolute;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,214,0,0.08);
            top: 30px; right: 20px;
        }
        .panel-brand { display: flex; align-items: center; gap: 12px; }
        .panel-brand-icon {
            width: 44px; height: 44px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #FFD600; font-size: 20px;
        }
        .panel-brand-name { font-size: 1.4rem; font-weight: 700; color: white; }
        .panel-brand-name span { color: #FFD600; }
        .panel-content { position: relative; z-index: 1; }
        .panel-content h2 { color: white; font-size: 1.6rem; font-weight: 700; line-height: 1.3; margin-bottom: 14px; }
        .panel-content p { color: rgba(255,255,255,0.65); font-size: 0.9rem; line-height: 1.7; }
        .panel-features { display: flex; flex-direction: column; gap: 12px; position: relative; z-index: 1; }
        .feature-item { display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,0.8); font-size: 0.85rem; }
        .feature-icon {
            width: 30px; height: 30px;
            background: rgba(255,214,0,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #FFD600; font-size: 12px; flex-shrink: 0;
        }

        /* Panneau droit */
        .panel-right {
            width: 420px;
            background: white;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-title { font-size: 1.5rem; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
        .form-subtitle { color: #888; font-size: 0.875rem; margin-bottom: 28px; }

        .input-group-text {
            background: #f8f9fa;
            border: 1.5px solid #e8e8e8;
            border-right: none;
            color: #008751; padding: 0 14px;
        }
        .form-control {
            border: 1.5px solid #e8e8e8;
            border-left: none;
            font-size: 0.9rem;
            padding: 10px 14px;
            color: #333;
        }
        .form-control:focus { border-color: #008751; box-shadow: none; background: white; }
        .input-group:focus-within .input-group-text { border-color: #008751; }
        .toggle-password {
            border: 1.5px solid #e8e8e8;
            border-left: none;
            background: #f8f9fa;
            color: #888; padding: 0 12px;
            transition: color 0.2s;
        }
        .toggle-password:hover { color: #008751; }
        .form-label { font-size: 0.82rem; font-weight: 600; color: #444; margin-bottom: 6px; }
        .form-check-input:checked { background-color: #008751; border-color: #008751; }
        .form-check-label { font-size: 0.82rem; color: #666; }

        .btn-login {
            background: linear-gradient(135deg, #008751, #00a862);
            color: white; border: none;
            border-radius: 50px; padding: 12px;
            font-weight: 600; font-size: 0.92rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,135,81,0.3);
        }
        .btn-login:hover {
            color: white; transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,135,81,0.4);
            filter: brightness(1.05);
        }

        .link-benin { color: #008751; font-weight: 600; text-decoration: none; }
        .link-benin:hover { color: #005c37; text-decoration: underline; }

        .alert { border: none; border-radius: 10px; font-size: 0.85rem; padding: 10px 14px; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }

        /* ===== MOBILE ===== */
        @media (max-width: 768px) {
            body { align-items: flex-start; padding: 24px 16px; overflow-y: auto; }

            .back-link-desktop { display: none; }
            .back-link-mobile  { display: inline-flex; }

            .panel-left { display: none !important; }

            .login-wrapper { min-height: auto; border-radius: 20px; }

            .panel-right {
                width: 100%;
                padding: 32px 24px;
            }
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

        <div class="login-wrapper">

            <!-- Panneau gauche -->
            <div class="panel-left d-none d-md-flex flex-column justify-content-between">
                <div class="panel-brand">
                    <div class="panel-brand-icon"><i class="fas fa-map-marked-alt"></i></div>
                    <span class="panel-brand-name">Benin<span>Explore</span></span>
                </div>
                <div class="panel-content">
                    <h2>Explorez le Bénin comme jamais auparavant</h2>
                    <p>Accédez à votre compte pour réserver des hébergements, découvrir des sites touristiques et planifier votre aventure béninoise.</p>
                </div>
                <div class="panel-features">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-landmark"></i></div>
                        <span>Sites historiques & culturels</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-bed"></i></div>
                        <span>Hébergements vérifiés</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
                        <span>Réservation en quelques clics</span>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="panel-right">
                <h1 class="form-title">Bon retour ! 👋</h1>
                <p class="form-subtitle">Connectez-vous à votre compte BeninExplore</p>

                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']) ?>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form method="POST" action="/login" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                                   placeholder="vous@exemple.com" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="••••••••" autocomplete="current-password" required>
                            <button class="btn toggle-password" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>
                        <a href="/forgot_password" class="link-benin" style="font-size:0.82rem;">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                    </button>

                    <p class="text-center mb-0" style="font-size:0.85rem; color:#888;">
                        Pas encore de compte ? <a href="/register" class="link-benin">Créer un compte</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <?php unset($_SESSION['old']); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const pwd  = document.getElementById('password');
            const icon = this.querySelector('i');
            const show = pwd.type === 'password';
            pwd.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye',       !show);
            icon.classList.toggle('fa-eye-slash',  show);
        });
    </script>
</body>
</html>