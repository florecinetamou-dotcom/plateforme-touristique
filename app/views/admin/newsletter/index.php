<?php
$utilisateurs = $utilisateurs ?? [];
$total_utilisateurs = $total_utilisateurs ?? 0;
$newsletter_inscrits = $newsletter_inscrits ?? 0;
$non_inscrits = $total_utilisateurs - $newsletter_inscrits;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Newsletter' ?> - Admin BeninExplore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php include dirname(__DIR__) . '/partials/admin_styles.php'; ?>

    <style>
        :root {
            --green:       #008751;
            --green-dark:  #006b3f;
            --green-light: #e6f4ed;
            --green-glow:  rgba(0,135,81,0.15);
            --yellow:      #FFD600;
            --red:         #e53935;
            --red-light:   #fdecea;
            --text:        #1a2e1f;
            --text-muted:  #6b7e72;
            --border:      #dce8e0;
            --bg:          #f4f8f5;
            --white:       #ffffff;
            --shadow-sm:   0 2px 8px rgba(0,135,81,0.08);
            --shadow-md:   0 6px 24px rgba(0,135,81,0.12);
            --radius:      14px;
            --radius-sm:   8px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* ── Page layout ── */
        .nl-page { padding: 32px; max-width: 1200px; }

        /* ── Page header ── */
        .page-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 32px;
        }
        .label-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--green);
            background: var(--green-light);
            border: 1px solid rgba(0,135,81,.2);
            border-radius: 50px;
            padding: 4px 12px;
            margin-bottom: 8px;
        }
        .page-title {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.02em;
            line-height: 1.1;
        }
        .page-sub {
            font-size: .85rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* ── Alerts ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            font-size: .875rem;
            font-weight: 500;
            margin-bottom: 24px;
            border-left: 4px solid;
        }
        .alert--success {
            background: var(--green-light);
            border-color: var(--green);
            color: var(--green-dark);
        }
        .alert--error {
            background: var(--red-light);
            border-color: var(--red);
            color: var(--red);
        }

        /* ── Stat cards ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: box-shadow .2s, transform .2s;
        }
        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .stat-icon.green  { background: var(--green-light); color: var(--green); }
        .stat-icon.yellow { background: #fffbe6; color: #b8860b; }
        .stat-icon.gray   { background: #f0f0f0; color: #888; }
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
        }
        .stat-label {
            font-size: .78rem;
            color: var(--text-muted);
            margin-top: 3px;
        }

        /* ── Main grid ── */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            align-items: start;
        }

        /* ── Cards ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-header-icon {
            width: 34px; height: 34px;
            background: var(--green-light);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--green);
            font-size: 14px;
            flex-shrink: 0;
        }
        .card-header h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }
        .card-body { padding: 24px; }

        /* ── Form ── */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 7px;
        }
        .form-label span { color: var(--red); }
        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Poppins', sans-serif;
            font-size: .875rem;
            color: var(--text);
            background: var(--white);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px var(--green-glow);
        }
        textarea.form-control { resize: vertical; min-height: 180px; line-height: 1.6; }
        .form-hint {
            font-size: .72rem;
            color: var(--text-muted);
            margin-top: 5px;
        }

        /* Cible select avec icônes */
        select.form-control { cursor: pointer; }

        /* ── Test email section ── */
        .test-section {
            background: #f8fbf9;
            border: 1.5px dashed var(--border);
            border-radius: var(--radius-sm);
            padding: 16px;
            margin-bottom: 20px;
        }
        .test-section-title {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .25s;
            text-decoration: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--green), #00a862);
            color: white;
            box-shadow: 0 4px 14px rgba(0,135,81,.3);
            width: 100%;
            justify-content: center;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,135,81,.4);
            filter: brightness(1.05);
        }

        /* ── Users table ── */
        .users-card { margin-top: 24px; }
        .table-search {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
        }
        .table-search input {
            width: 100%;
            padding: 9px 14px 9px 38px;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-size: .85rem;
            outline: none;
            background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%236b7e72' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.099zm-5.242 1.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z'/%3E%3C/svg%3E") no-repeat 12px center;
            transition: border-color .2s;
        }
        .table-search input:focus { border-color: var(--green); }

        .users-table-wrap { max-height: 380px; overflow-y: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f8fbf9; position: sticky; top: 0; z-index: 1; }
        th {
            padding: 11px 16px;
            text-align: left;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            border-bottom: 1.5px solid var(--border);
        }
        td {
            padding: 12px 16px;
            font-size: .85rem;
            color: var(--text);
            border-bottom: 1px solid #f0f5f2;
        }
        tbody tr:hover { background: #f9fcfa; }
        tbody tr:last-child td { border-bottom: none; }

        .badge-nl {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
        }
        .badge-nl.yes { background: var(--green-light); color: var(--green); }
        .badge-nl.no  { background: #f0f0f0; color: #999; }

        .user-avatar-sm {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, var(--green), var(--yellow));
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            color: white; font-size: .75rem; font-weight: 700;
            flex-shrink: 0;
        }
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-name { font-weight: 600; font-size: .85rem; }
        .user-role {
            font-size: .7rem;
            color: var(--text-muted);
        }

        .table-footer {
            padding: 12px 24px;
            border-top: 1px solid var(--border);
            font-size: .78rem;
            color: var(--text-muted);
            background: #f8fbf9;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .main-grid { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .nl-page { padding: 16px; }
            .stats-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>

<div class="main">
    <?php include dirname(__DIR__) . '/partials/topbar.php'; ?>

    <div class="content nl-page">

        <!-- En-tête -->
        <div class="page-head">
            <div>
                <span class="label-tag">✉️ Communication</span>
                <h1 class="page-title">Newsletter</h1>
                <p class="page-sub">Gérez vos campagnes email et vos abonnés</p>
            </div>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">
            ✅ <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">
            ❌ <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <!-- Statistiques -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon green">👥</div>
                <div>
                    <div class="stat-value"><?= $total_utilisateurs ?></div>
                    <div class="stat-label">Total utilisateurs</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">📨</div>
                <div>
                    <div class="stat-value"><?= $newsletter_inscrits ?></div>
                    <div class="stat-label">Abonnés newsletter</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon gray">🔕</div>
                <div>
                    <div class="stat-value"><?= $non_inscrits ?></div>
                    <div class="stat-label">Non abonnés</div>
                </div>
            </div>
        </div>

        <!-- Formulaire + info -->
        <div class="main-grid">

            <!-- Formulaire d'envoi -->
            <div class="card">
                <div class="card-header">
                    <div class="card-header-icon">✉️</div>
                    <h3>Composer un email</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="/admin/newsletter/send">

                        <div class="form-group">
                            <label class="form-label">Sujet <span>*</span></label>
                            <input type="text" name="sujet" class="form-control" required
                                   placeholder="Ex: Découvrez nos nouveautés du mois">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Destinataires <span>*</span></label>
                            <select name="cible" class="form-control" required>
                                <option value="tous">📧 Tous les utilisateurs (<?= $total_utilisateurs ?>)</option>
                                <option value="newsletter">📨 Abonnés newsletter (<?= $newsletter_inscrits ?>)</option>
                                <option value="voyageurs">✈️ Voyageurs uniquement</option>
                                <option value="hebergeurs">🏨 Hébergeurs uniquement</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Contenu du message <span>*</span></label>
                            <textarea name="contenu" class="form-control" required
                                      placeholder="Bonjour {prenom},&#10;&#10;Votre message ici..."></textarea>
                            <p class="form-hint">💡 Utilisez <strong>{prenom}</strong> et <strong>{nom}</strong> pour personnaliser chaque email.</p>
                        </div>

                       

                        <button type="submit" class="btn btn-primary">
                            📧 Envoyer la campagne
                        </button>

                    </form>
                </div>
            </div>

            <!-- Conseils -->
            <div style="display:flex;flex-direction:column;gap:16px;">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon">💡</div>
                        <h3>Conseils d'envoi</h3>
                    </div>
                    <div class="card-body" style="padding:20px;">
                        <ul style="list-style:none;display:flex;flex-direction:column;gap:12px;">
                            <li style="display:flex;gap:10px;font-size:.83rem;color:#444;">
                                <span style="color:var(--green);font-size:1rem;">✓</span>
                                Toujours envoyer un <strong>email de test</strong> avant l'envoi groupé.
                            </li>
                            <li style="display:flex;gap:10px;font-size:.83rem;color:#444;">
                                <span style="color:var(--green);font-size:1rem;">✓</span>
                                Utilisez <strong>{prenom}</strong> pour personnaliser et améliorer le taux d'ouverture.
                            </li>
                            <li style="display:flex;gap:10px;font-size:.83rem;color:#444;">
                                <span style="color:var(--green);font-size:1rem;">✓</span>
                                Préférez les envois aux <strong>abonnés newsletter</strong> pour éviter le spam.
                            </li>
                            <li style="display:flex;gap:10px;font-size:.83rem;color:#444;">
                                <span style="color:var(--green);font-size:1rem;">✓</span>
                                Rédigez un <strong>objet court et accrocheur</strong> (moins de 50 caractères).
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card" style="background:linear-gradient(135deg,#008751,#00a862);border:none;">
                    <div class="card-body" style="padding:20px;">
                        <div style="color:rgba(255,255,255,.7);font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Taux d'abonnement</div>
                        <?php $taux = $total_utilisateurs > 0 ? round(($newsletter_inscrits / $total_utilisateurs) * 100) : 0; ?>
                        <div style="font-size:2.5rem;font-weight:800;color:white;line-height:1;"><?= $taux ?>%</div>
                        <div style="color:rgba(255,255,255,.7);font-size:.8rem;margin-top:4px;">des utilisateurs abonnés</div>
                        <div style="margin-top:14px;height:6px;background:rgba(255,255,255,.2);border-radius:50px;overflow:hidden;">
                            <div style="width:<?= $taux ?>%;height:100%;background:#FFD600;border-radius:50px;transition:width 1s ease;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

       

    </div>
</div>

<script>
// Recherche en temps réel
document.getElementById('searchUsers')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#usersTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

</body>
</html>