<?php
// Vue pure — toutes les données viennent du DashboardController
// $stats, $hebergements_attente, $derniers_inscrits, $dernieres_reservations, $badges

$stats = $stats ?? [];
$hebergements_attente = $hebergements_attente ?? [];
$derniers_inscrits = $derniers_inscrits ?? [];
$dernieres_reservations = $dernieres_reservations ?? [];
$badges = $badges ?? [];

function statVal($stats, $key)
{
    return number_format($stats[$key] ?? 0, 0, ',', ' ');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — BeninExplore</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #008751;
            --green2: #005c38;
            --yellow: #FFD600;
            --red: #E8112D;
            --dark: #0e1117;
            --dark2: #161b25;
            --sidebar: #111827;
            --card: #1f2937;
            --border: rgba(255, 255, 255, .07);
            --text: #f9fafb;
            --muted: #6b7280;
            --muted2: #9ca3af;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--dark);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ══ SIDEBAR ═══════════════════════════════ */
        .sidebar {
            width: 260px;
            flex-shrink: 0;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 28px 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar__brand {
            padding: 0 24px 28px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .sidebar__brand-name {
            font-size: 1.3rem;
            font-weight: 800;
            color: #fff;
        }

        .sidebar__brand-name em {
            font-style: normal;
            color: var(--yellow);
        }

        .sidebar__brand-tag {
            font-size: .62rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: 3px;
        }

        .sidebar__section {
            padding: 0 12px;
            margin-bottom: 8px;
        }

        .sidebar__section-label {
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 0 12px;
            margin-bottom: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--muted2);
            font-size: .83rem;
            font-weight: 500;
            transition: all .2s;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, .05);
            color: #fff;
        }

        .nav-item.active {
            background: rgba(0, 135, 81, .15);
            color: var(--green);
        }

        .nav-item.active .nav-icon {
            color: var(--green);
        }

        .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--red);
            color: white;
            font-size: .6rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar__footer {
            margin-top: auto;
            padding: 20px 12px 0;
            border-top: 1px solid var(--border);
        }

        /* ══ MAIN ══════════════════════════════════ */
        .main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ══ TOPBAR ════════════════════════════════ */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 32px;
            border-bottom: 1px solid var(--border);
            background: var(--dark);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar__title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
        }

        .topbar__sub {
            font-size: .75rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .topbar__right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar__user {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid var(--border);
            padding: 8px 14px;
            border-radius: 30px;
            font-size: .82rem;
            color: var(--muted2);
        }

        .topbar__avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            color: #fff;
        }

        /* ══ CONTENT ═══════════════════════════════ */
        .content {
            padding: 32px;
            flex: 1;
        }

        /* ══ STAT CARDS ════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px 24px;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .3);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 16px 16px 0 0;
        }

        .stat-card--green::before {
            background: var(--green);
        }

        .stat-card--yellow::before {
            background: var(--yellow);
        }

        .stat-card--red::before {
            background: var(--red);
        }

        .stat-card--blue::before {
            background: #3b82f6;
        }

        .stat-card__label {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .stat-card__val {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-card--yellow .stat-card__val {
            color: var(--yellow);
        }

        .stat-card--red .stat-card__val {
            color: #f87171;
        }

        .stat-card--blue .stat-card__val {
            color: #60a5fa;
        }

        .stat-card--green .stat-card__val {
            color: #4ade80;
        }

        .stat-card__sub {
            font-size: .75rem;
            color: var(--muted);
        }

        .stat-card__sub span {
            color: #4ade80;
            font-weight: 600;
        }

        .stat-card__icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            opacity: .12;
        }

        /* ══ PANELS ════════════════════════════════ */
        .panels {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .panel {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }

        .panel__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .panel__title {
            font-size: .9rem;
            font-weight: 700;
            color: #fff;
        }

        .panel__link {
            font-size: .72rem;
            font-weight: 600;
            color: var(--green);
            text-decoration: none;
        }

        .panel__link:hover {
            text-decoration: underline;
        }

        /* Table hébergements */
        .htable {
            width: 100%;
            border-collapse: collapse;
        }

        .htable th {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 12px 20px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .htable td {
            padding: 14px 20px;
            font-size: .82rem;
            border-bottom: 1px solid rgba(255, 255, 255, .03);
            color: var(--muted2);
            vertical-align: middle;
        }

        .htable tr:last-child td {
            border-bottom: none;
        }

        .htable tr:hover td {
            background: rgba(255, 255, 255, .02);
        }

        .htable td:first-child {
            color: #fff;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .06em;
        }

        .badge--attente {
            background: rgba(255, 214, 0, .12);
            color: var(--yellow);
        }

        .badge--approuve {
            background: rgba(0, 135, 81, .15);
            color: #4ade80;
        }

        .badge--rejete {
            background: rgba(232, 17, 45, .12);
            color: #f87171;
        }

        .badge--confirm {
            background: rgba(59, 130, 246, .12);
            color: #60a5fa;
        }

        .btn-sm {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: .7rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
            border: none;
        }

        .btn-sm--green {
            background: rgba(0, 135, 81, .15);
            color: #4ade80;
        }

        .btn-sm--green:hover {
            background: var(--green);
            color: #fff;
        }

        .btn-sm--red {
            background: rgba(232, 17, 45, .12);
            color: #f87171;
        }

        .btn-sm--red:hover {
            background: var(--red);
            color: #fff;
        }

        /* Utilisateurs list */
        .user-list {
            padding: 8px 0;
        }

        .user-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 24px;
            transition: background .2s;
        }

        .user-item:hover {
            background: rgba(255, 255, 255, .02);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: .84rem;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-date {
            font-size: .7rem;
            color: var(--muted);
            margin-top: 1px;
        }

        .user-role {
            font-size: .62rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .user-role--voyageur {
            background: rgba(99, 179, 237, .12);
            color: #60a5fa;
        }

        .user-role--hebergeur {
            background: rgba(255, 214, 0, .12);
            color: var(--yellow);
        }

        .user-role--admin {
            background: rgba(0, 135, 81, .15);
            color: #4ade80;
        }

        /* Empty state */
        .empty-panel {
            padding: 48px 24px;
            text-align: center;
            color: var(--muted);
            font-size: .85rem;
        }

        .empty-panel .icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
            opacity: .4;
        }

        /* ══ RESERVATIONS TABLE ════════════════════ */
        .res-panel {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        /* ══ RESPONSIVE ════════════════════════════ */
        @media (max-width: 1200px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .panels {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main {
                margin-left: 0;
            }

            .content {
                padding: 20px;
            }

            .stat-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
        }
    </style>
</head>

<body>

    <!-- ══ SIDEBAR ══════════════════════════════════════ -->
    <aside class="sidebar">
        <div class="sidebar__brand">
            <div class="sidebar__brand-name">Benin<em>Explore</em></div>
            <div class="sidebar__brand-tag">Administration</div>
        </div>

        <div class="sidebar__section">
            <p class="sidebar__section-label">Principal</p>
            <a href="/admin/dashboard" class="nav-item active">
                <span class="nav-icon">📊</span> Tableau de bord
            </a>
        </div>

        <div class="sidebar__section">
            <p class="sidebar__section-label">Gestion</p>
            <a href="/admin/hebergements" class="nav-item">
                <span class="nav-icon">🏨</span> Hébergements
                <?php if (($badges['nb_hebergements_attente'] ?? 0) > 0): ?>
                    <span class="nav-badge"><?= $badges['nb_hebergements_attente'] ?></span>
                <?php endif; ?>
            </a>
            <a href="/admin/villes" class="nav-item">
                <span class="nav-icon">📍</span> Villes
            </a>
            <a href="/admin/reservations" class="nav-item">
                <span class="nav-icon">📅</span> Réservations
            </a>
            <a href="/admin/sites" class="nav-item">
                <span class="nav-icon">🏞️</span> Sites touristiques
            </a>
            <a href="/admin/utilisateurs" class="nav-item">
                <span class="nav-icon">👥</span> Utilisateurs
            </a>
            <a href="/admin/avis" class="nav-item">
                <span class="nav-icon">⭐</span> Avis
            </a>
        </div>

        <div class="sidebar__section">
            <p class="sidebar__section-label">Outils</p>
            <a href="/admin/chatbot" class="nav-item">
                <span class="nav-icon">🤖</span> Chatbot
            </a>
        </div>

        <div class="sidebar__footer">
            <a href="/admin/logout" class="nav-item" style="color:#f87171">
                <span class="nav-icon">🚪</span> Déconnexion
            </a>
            <a href="/" class="nav-item">
                <span class="nav-icon">🌐</span> Voir le site
            </a>
        </div>
    </aside>

    <!-- ══ MAIN ═════════════════════════════════════════ -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">
            <div>
                <div class="topbar__title">Tableau de bord</div>
                <div class="topbar__sub">Bienvenue, <?= htmlspecialchars($_SESSION['user_prenom'] ?? 'Admin') ?> ·
                    <?= date('d F Y') ?></div>
            </div>
            <div class="topbar__right">
                <div class="topbar__user">
                    <div class="topbar__avatar">
                        <?= strtoupper(substr($_SESSION['user_prenom'] ?? 'A', 0, 1)) ?>
                    </div>
                    <?= htmlspecialchars(($_SESSION['user_prenom'] ?? '') . ' ' . ($_SESSION['user_nom'] ?? '')) ?>
                </div>
            </div>
        </div>

        <!-- Contenu -->
        <div class="content">

            <!-- ── STAT CARDS ── -->
            <div class="stat-grid">
                <div class="stat-card stat-card--green">
                    <div class="stat-card__icon">👥</div>
                    <div class="stat-card__label">Utilisateurs</div>
                    <div class="stat-card__val"><?= statVal($stats, 'total_utilisateurs') ?></div>
                    <div class="stat-card__sub"><span>+<?= statVal($stats, 'nouveaux_users_mois') ?></span> ce mois
                    </div>
                </div>
                <div class="stat-card stat-card--blue">
                    <div class="stat-card__icon">🏨</div>
                    <div class="stat-card__label">Hébergements</div>
                    <div class="stat-card__val"><?= statVal($stats, 'total_hebergements') ?></div>
                    <div class="stat-card__sub"><span
                            style="color:#f87171"><?= statVal($stats, 'hebergements_attente') ?></span> en attente</div>
                </div>
                <div class="stat-card stat-card--yellow">
                    <div class="stat-card__icon">📅</div>
                    <div class="stat-card__label">Réservations</div>
                    <div class="stat-card__val"><?= statVal($stats, 'total_reservations') ?></div>
                    <div class="stat-card__sub"><span><?= statVal($stats, 'reservations_actives') ?></span> actives
                    </div>
                </div>
                <div class="stat-card stat-card--red">
                    <div class="stat-card__icon">💰</div>
                    <div class="stat-card__label">Revenus du mois</div>
                    <div class="stat-card__val"><?= number_format($stats['revenus_mois'] ?? 0, 0, ',', ' ') ?></div>
                    <div class="stat-card__sub">FCFA confirmés</div>
                </div>
            </div>

            <!-- ── PANELS HÉBERGEMENTS + UTILISATEURS ── -->
            <div class="panels">

                <!-- Hébergements en attente -->
                <div class="panel">
                    <div class="panel__head">
                        <span class="panel__title">🏨 Hébergements en attente</span>
                        <a href="/admin/hebergements" class="panel__link">Voir tout →</a>
                    </div>
                    <?php if (!empty($hebergements_attente)): ?>
                        <table class="htable">
                            <thead>
                                <tr>
                                    <th>Hébergement</th>
                                    <th>Ville</th>
                                    <th>Hébergeur</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hebergements_attente as $h): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($h->nom) ?></td>
                                        <td><?= htmlspecialchars($h->ville_nom ?? '—') ?></td>
                                        <td><?= htmlspecialchars($h->hebergeur_nom ?? '—') ?></td>
                                        <td>
                                            <a href="/admin/hebergements/<?= $h->id ?>/valider" class="btn-sm btn-sm--green">✓
                                                Valider</a>
                                            <a href="/admin/hebergements/<?= $h->id ?>/rejeter" class="btn-sm btn-sm--red">✗
                                                Rejeter</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-panel">
                            <span class="icon">✅</span>
                            Aucun hébergement en attente
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Derniers inscrits -->
                <div class="panel">
                    <div class="panel__head">
                        <span class="panel__title">👥 Derniers inscrits</span>
                        <a href="/admin/utilisateurs" class="panel__link">Voir tout →</a>
                    </div>
                    <?php if (!empty($derniers_inscrits)): ?>
                        <div class="user-list">
                            <?php
                            $colors = ['#008751', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#14b8a6'];
                            foreach ($derniers_inscrits as $i => $u):
                                $initiale = strtoupper(substr($u->prenom ?? $u->nom ?? 'U', 0, 1));
                                $color = $colors[$i % count($colors)];
                                ?>
                                <div class="user-item">
                                    <div class="user-avatar" style="background:<?= $color ?>">
                                        <?= $initiale ?>
                                    </div>
                                    <div class="user-info">
                                        <div class="user-name">
                                            <?= htmlspecialchars(($u->prenom ?? '') . ' ' . ($u->nom ?? '')) ?></div>
                                        <div class="user-date"><?= date('d/m/Y', strtotime($u->date_inscription)) ?></div>
                                    </div>
                                    <span class="user-role user-role--<?= $u->role ?>">
                                        <?= ucfirst($u->role) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-panel">
                            <span class="icon">👤</span>
                            Aucun utilisateur inscrit
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- ── DERNIÈRES RÉSERVATIONS ── -->
            <div class="res-panel">
                <div class="panel__head">
                    <span class="panel__title">📅 Dernières réservations</span>
                    <a href="/admin/reservations" class="panel__link">Voir tout →</a>
                </div>
                <?php if (!empty($dernieres_reservations)): ?>
                    <table class="htable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Voyageur</th>
                                <th>Hébergement</th>
                                <th>Arrivée</th>
                                <th>Départ</th>
                                <th>Montant</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dernieres_reservations as $r): ?>
                                <tr>
                                    <td>#<?= $r->id ?></td>
                                    <td><?= htmlspecialchars(($r->voyageur_prenom ?? '') . ' ' . ($r->voyageur_nom ?? '')) ?>
                                    </td>
                                    <td><?= htmlspecialchars($r->hebergement_nom ?? '—') ?></td>
                                    <td><?= date('d/m/Y', strtotime($r->date_arrivee)) ?></td>
                                    <td><?= date('d/m/Y', strtotime($r->date_depart)) ?></td>
                                    <td><?= number_format($r->montant_total ?? 0, 0, ',', ' ') ?> FCFA</td>
                                    <td>
                                        <?php
                                        $badgeMap = [
                                            'en_attente' => 'attente',
                                            'confirmee' => 'approuve',
                                            'annulee' => 'rejete',
                                            'terminee' => 'confirm',
                                        ];
                                        $bc = $badgeMap[$r->statut ?? ''] ?? 'attente';
                                        ?>
                                        <span
                                            class="badge badge--<?= $bc ?>"><?= ucfirst(str_replace('_', ' ', $r->statut ?? '')) ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-panel">
                        <span class="icon">📅</span>
                        Aucune réservation pour le moment
                    </div>
                <?php endif; ?>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

</body>

</html>