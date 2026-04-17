<?php
$stats = $stats ?? [];
$old   = $_SESSION['old'] ?? [];
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin — BeninExplore</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:  #008751;
            --green2: #005c38;
            --yellow: #FFD600;
            --red:    #E8112D;
            --dark:   #0e1117;
            --dark2:  #161b25;
            --grey:   #6b7280;
            --light:  #F5F5F0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--dark);
            overflow: hidden;
        }

        /* ══ FOND ANIMÉ ══════════════════════════ */
        .bg-blobs {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: .35;
            animation: drift 14s ease-in-out infinite alternate;
        }
        .blob--1 {
            width: 500px; height: 500px;
            background: var(--green);
            top: -120px; left: -120px;
            animation-delay: 0s;
        }
        .blob--2 {
            width: 400px; height: 400px;
            background: var(--yellow);
            bottom: -100px; right: 200px;
            animation-delay: -4s;
            opacity: .18;
        }
        .blob--3 {
            width: 300px; height: 300px;
            background: var(--red);
            top: 30%; right: -80px;
            animation-delay: -8s;
            opacity: .2;
        }
        @keyframes drift {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(40px, 30px) scale(1.08); }
        }

        /* ══ LAYOUT ══════════════════════════════ */
        .page {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            align-items: stretch;
        }

        /* ══ PANNEAU GAUCHE ══════════════════════ */
        .left {
            width: 420px;
            flex-shrink: 0;
            padding: 60px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(255,255,255,.06);
        }

        .brand {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .brand__name {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.02em;
        }
        .brand__name em {
            font-style: normal;
            color: var(--yellow);
        }
        .brand__tag {
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(255,255,255,.35);
        }

        /* Drapeau décoratif */
        .flag-deco {
            display: flex;
            gap: 4px;
            margin-top: 6px;
        }
        .flag-deco span {
            height: 3px;
            border-radius: 2px;
            flex: 1;
        }

        /* Stats */
        .stats-block { flex: 1; display: flex; flex-direction: column; justify-content: center; gap: 4px; }

        .stats-label {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
            margin-bottom: 16px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-radius: 12px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.06);
            margin-bottom: 10px;
            transition: background .2s;
        }
        .stat-item:hover { background: rgba(255,255,255,.07); }
        .stat-item:last-child { margin-bottom: 0; }

        .stat-item__info { display: flex; align-items: center; gap: 12px; }

        .stat-item__icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .stat-item__icon--green  { background: rgba(0,135,81,.2);  }
        .stat-item__icon--yellow { background: rgba(255,214,0,.15); }
        .stat-item__icon--blue   { background: rgba(99,179,237,.15);}

        .stat-item__label {
            font-size: .8rem;
            color: rgba(255,255,255,.55);
            font-weight: 400;
        }
        .stat-item__val {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
        }

        .left-footer {
            font-size: .65rem;
            color: rgba(255,255,255,.2);
            line-height: 1.6;
        }

        /* ══ PANNEAU DROIT — FORMULAIRE ══════════ */
        .right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .form-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 44px;
        }

        .form-card__head {
            margin-bottom: 32px;
        }
        .form-card__head h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
            letter-spacing: -.02em;
        }
        .form-card__head p {
            font-size: .85rem;
            color: rgba(255,255,255,.45);
            font-weight: 300;
        }

        /* Erreur */
        .alert-err {
            background: rgba(232,17,45,.12);
            border: 1px solid rgba(232,17,45,.3);
            color: #ff6b7a;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: .8rem;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        /* Champs */
        .field { margin-bottom: 18px; }
        .field label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: rgba(255,255,255,.5);
            margin-bottom: 8px;
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        .field input {
            width: 100%;
            padding: 13px 18px;
            background: rgba(255,255,255,.07);
            border: 1.5px solid rgba(255,255,255,.1);
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: .88rem;
            color: #fff;
            outline: none;
            transition: border-color .2s, background .2s, box-shadow .2s;
        }
        .field input::placeholder { color: rgba(255,255,255,.25); }
        .field input:focus {
            border-color: var(--green);
            background: rgba(0,135,81,.08);
            box-shadow: 0 0 0 3px rgba(0,135,81,.15);
        }

        /* Remember */
        .remember {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
            cursor: pointer;
        }
        .remember input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--green);
            cursor: pointer;
        }
        .remember span {
            font-size: .78rem;
            color: rgba(255,255,255,.4);
        }

        /* Bouton */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--green);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: .92rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .25s, transform .2s, box-shadow .25s;
            letter-spacing: .02em;
        }
        .btn-submit:hover {
            background: var(--green2);
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0,135,81,.35);
        }
        .btn-submit:active { transform: translateY(0); }

        .back-link {
            text-align: center;
            margin-top: 22px;
            font-size: .76rem;
            color: rgba(255,255,255,.25);
        }
        .back-link a {
            color: rgba(255,255,255,.45);
            text-decoration: none;
            font-weight: 500;
            transition: color .2s;
        }
        .back-link a:hover { color: var(--yellow); }

        /* ══ RESPONSIVE ══════════════════════════ */
        @media (max-width: 900px) {
            .left { display: none; }
        }
        @media (max-width: 480px) {
            .form-card { padding: 36px 28px; border-radius: 20px; }
            .form-card__head h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

<!-- Blobs de fond -->
<div class="bg-blobs">
    <div class="blob blob--1"></div>
    <div class="blob blob--2"></div>
    <div class="blob blob--3"></div>
</div>

<div class="page">

    <!-- ── GAUCHE ──────────────────────────── -->
    <div class="left">
        <div class="brand">
            <div class="brand__name">Benin<em>Explore</em></div>
            <div class="brand__tag">Espace Administration</div>
            <div class="flag-deco">
                <span style="background:#008751"></span>
                <span style="background:#FFD600"></span>
                <span style="background:#E8112D"></span>
            </div>
        </div>

        <div class="stats-block">
            <p class="stats-label">Vue d'ensemble</p>

            <div class="stat-item">
                <div class="stat-item__info">
                    <div class="stat-item__icon stat-item__icon--green">🏨</div>
                    <span class="stat-item__label">Hébergements actifs</span>
                </div>
                <span class="stat-item__val"><?= $stats['hebergements'] ?? 0 ?></span>
            </div>

            <div class="stat-item">
                <div class="stat-item__info">
                    <div class="stat-item__icon stat-item__icon--yellow">📍</div>
                    <span class="stat-item__label">Villes disponibles</span>
                </div>
                <span class="stat-item__val"><?= $stats['villes'] ?? 0 ?></span>
            </div>

            <div class="stat-item">
                <div class="stat-item__info">
                    <div class="stat-item__icon stat-item__icon--blue">👥</div>
                    <span class="stat-item__label">Utilisateurs inscrits</span>
                </div>
                <span class="stat-item__val"><?= $stats['utilisateurs'] ?? 0 ?></span>
            </div>
        </div>

        <div class="left-footer">
            © <?= date('Y') ?> BeninExplore<br>
            Accès strictement réservé aux administrateurs.
        </div>
    </div>

    <!-- ── DROITE ───────────────────────────── -->
    <div class="right">
        <div class="form-card">

            <div class="form-card__head">
                <h1>Connexion</h1>
                <p>Accédez au tableau de bord administrateur.</p>
            </div>

            <?php if ($error): ?>
            <div class="alert-err">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="/admin/login/post">

                <div class="field">
                    <label for="email">Adresse email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="admin@beninexplore.bj"
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <label class="remember">
                    <input type="checkbox" name="remember">
                    <span>Se souvenir de moi pendant 30 jours</span>
                </label>

                <button type="submit" class="btn-submit">Se connecter</button>

            </form>

            <div class="back-link">
                <a href="/">← Retour au site</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>