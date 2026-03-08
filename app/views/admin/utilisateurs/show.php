<?php
$utilisateur  = $utilisateur  ?? null;
$reservations = $reservations ?? [];
$badges       = $badges       ?? [];

if (!$utilisateur) {
    header('Location: /admin/utilisateurs');
    exit;
}

$roleMap = [
    'voyageur'  => ['label' => 'Voyageur',  'class' => 'badge--blue',    'color' => '#3b82f6'],
    'hebergeur' => ['label' => 'Hébergeur', 'class' => 'badge--attente', 'color' => '#f59e0b'],
    'admin'     => ['label' => 'Admin',     'class' => 'badge--green',   'color' => '#008751'],
];
$role = $roleMap[$utilisateur->role ?? ''] ?? ['label' => '—', 'class' => 'badge--grey', 'color' => '#6b7280'];

$statutResMap = [
    'en_attente' => 'badge--attente',
    'confirmee'  => 'badge--green',
    'annulee'    => 'badge--red',
    'terminee'   => 'badge--blue',
    'no_show'    => 'badge--grey',
];

$isSelf = (int)$utilisateur->id === (int)($_SESSION['user_id'] ?? 0);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(($utilisateur->prenom ?? '') . ' ' . ($utilisateur->nom ?? '')) ?> — Admin BeninExplore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php include dirname(__DIR__) . '/partials/admin_styles.php'; ?>
</head>
<body>
<?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>

<div class="main">
    <?php include dirname(__DIR__) . '/partials/topbar.php'; ?>

    <div class="content">

        <div class="page-head">
            <div>
                <p class="label-tag">Utilisateurs</p>
                <h1 class="page-title">
                    <?= htmlspecialchars(($utilisateur->prenom ?? '') . ' ' . ($utilisateur->nom ?? '')) ?>
                </h1>
                <p class="page-sub">Membre depuis le <?= date('d F Y', strtotime($utilisateur->date_inscription)) ?></p>
            </div>
            <a href="/admin/utilisateurs" class="btn-ghost">← Retour</a>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="show-layout">

            <!-- ── COLONNE GAUCHE ── -->
            <div class="show-left">

                <!-- Carte profil -->
                <div class="profile-card">
                    <div class="profile-avatar" style="background:<?= $role['color'] ?>">
                        <?= strtoupper(substr($utilisateur->prenom ?? $utilisateur->nom ?? 'U', 0, 1)) ?>
                    </div>
                    <div class="profile-name">
                        <?= htmlspecialchars(($utilisateur->prenom ?? '') . ' ' . ($utilisateur->nom ?? '')) ?>
                    </div>
                    <div class="profile-email"><?= htmlspecialchars($utilisateur->email ?? '') ?></div>
                    <div style="margin-top:10px">
                        <span class="badge <?= $role['class'] ?>" style="font-size:.78rem;padding:5px 14px">
                            <?= $role['label'] ?>
                        </span>
                        <?php if ($utilisateur->est_verifie): ?>
                        <span class="badge badge--green" style="font-size:.78rem;padding:5px 14px">✅ Actif</span>
                        <?php else: ?>
                        <span class="badge badge--grey" style="font-size:.78rem;padding:5px 14px">⏸ Bloqué</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Infos -->
                <div class="info-block">
                    <h3>Informations</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">ID</span>
                            <span class="info-val">#<?= $utilisateur->id ?></span>
                        </div>
                        <?php if (!empty($utilisateur->telephone)): ?>
                        <div class="info-row">
                            <span class="info-label">Téléphone</span>
                            <span class="info-val"><?= htmlspecialchars($utilisateur->telephone) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-row">
                            <span class="info-label">Inscription</span>
                            <span class="info-val"><?= date('d/m/Y', strtotime($utilisateur->date_inscription)) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dernière connexion</span>
                            <span class="info-val">
                                <?= $utilisateur->derniere_connexion
                                    ? date('d/m/Y H:i', strtotime($utilisateur->derniere_connexion))
                                    : '—' ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Langue</span>
                            <span class="info-val"><?= strtoupper($utilisateur->langue_preferee ?? 'FR') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Changer le rôle -->
                <?php if (!$isSelf): ?>
                <div class="info-block">
                    <h3>Changer le rôle</h3>
                    <form method="POST" action="/admin/utilisateurs/<?= $utilisateur->id ?>/changerRole">
                        <select name="role" class="role-select">
                            <option value="voyageur"  <?= $utilisateur->role === 'voyageur'  ? 'selected' : '' ?>>🧳 Voyageur</option>
                            <option value="hebergeur" <?= $utilisateur->role === 'hebergeur' ? 'selected' : '' ?>>🏨 Hébergeur</option>
                            <option value="admin"     <?= $utilisateur->role === 'admin'     ? 'selected' : '' ?>>🔑 Administrateur</option>
                        </select>
                        <button type="submit" class="btn-primary" style="width:100%;margin-top:10px;justify-content:center">
                            Mettre à jour le rôle
                        </button>
                    </form>
                </div>
                <?php endif; ?>

                <!-- Actions danger -->
                <?php if (!$isSelf): ?>
                <div class="info-block" style="border-color:rgba(232,17,45,.2)">
                    <h3 style="color:#f87171">Zone dangereuse</h3>
                    <div style="display:flex;flex-direction:column;gap:10px">
                        <?php if ($utilisateur->est_verifie): ?>
                        <form method="POST" action="/admin/utilisateurs/<?= $utilisateur->id ?>/bloquer"
                              onsubmit="return confirm('Bloquer ce compte ?')">
                            <button type="submit" class="danger-btn">🚫 Bloquer le compte</button>
                        </form>
                        <?php else: ?>
                        <form method="POST" action="/admin/utilisateurs/<?= $utilisateur->id ?>/debloquer">
                            <button type="submit" class="success-btn">✓ Débloquer le compte</button>
                        </form>
                        <?php endif; ?>
                        <form method="POST" action="/admin/utilisateurs/<?= $utilisateur->id ?>/supprimer"
                              onsubmit="return confirm('Supprimer définitivement ce compte ? Cette action est irréversible.')">
                            <button type="submit" class="danger-btn">🗑 Supprimer le compte</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- ── COLONNE DROITE ── -->
            <div class="show-right">

                <!-- Réservations récentes -->
                <div class="info-block">
                    <h3>📅 Réservations récentes</h3>
                    <?php if (!empty($reservations)): ?>
                    <table class="data-table" style="margin-top:8px">
                        <thead>
                            <tr>
                                <th>Réf</th>
                                <th>Hébergement</th>
                                <th>Arrivée</th>
                                <th>Montant</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $r): ?>
                            <tr>
                                <td>
                                    <a href="/admin/reservations/<?= $r->id ?>"
                                       style="font-family:monospace;font-size:.75rem;color:#a78bfa;text-decoration:none">
                                        #<?= htmlspecialchars($r->reference ?? $r->id) ?>
                                    </a>
                                </td>
                                <td class="td-bold" style="font-size:.82rem">
                                    <?= htmlspecialchars($r->hebergement_nom ?? '—') ?>
                                </td>
                                <td style="font-size:.78rem;color:#9ca3af">
                                    <?= date('d/m/Y', strtotime($r->date_arrivee)) ?>
                                </td>
                                <td style="font-size:.82rem;font-weight:700;color:#4ade80">
                                    <?= number_format($r->montant_total ?? 0, 0, ',', ' ') ?> FCFA
                                </td>
                                <td>
                                    <?php $bc = $statutResMap[$r->statut ?? ''] ?? 'badge--grey'; ?>
                                    <span class="badge <?= $bc ?>" style="font-size:.62rem">
                                        <?= ucfirst(str_replace('_', ' ', $r->statut ?? '')) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="empty-panel">
                        <span style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4">📅</span>
                        Aucune réservation pour cet utilisateur.
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.show-layout { display:grid; grid-template-columns:320px 1fr; gap:24px; align-items:start; }

.profile-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 28px 24px;
    text-align: center;
    margin-bottom: 16px;
}
.profile-avatar {
    width: 80px; height: 80px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; font-weight: 800; color: #fff;
    margin: 0 auto 14px;
}
.profile-name  { font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
.profile-email { font-size: .78rem; color: #6b7280; }

.info-block { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:20px; margin-bottom:14px; }
.info-block h3 { font-size:.72rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:14px; }
.info-grid  { display:flex; flex-direction:column; gap:10px; }
.info-row   { display:flex; justify-content:space-between; align-items:center; padding-bottom:8px; border-bottom:1px solid rgba(255,255,255,.04); }
.info-row:last-child { border-bottom:none; padding-bottom:0; }
.info-label { font-size:.78rem; color:#6b7280; font-weight:500; }
.info-val   { font-size:.83rem; color:#e5e7eb; font-weight:500; text-align:right; }

.role-select {
    width: 100%;
    background: rgba(255,255,255,.06);
    border: 1.5px solid rgba(255,255,255,.1);
    border-radius: 10px;
    padding: 10px 14px;
    font-family: 'Poppins', sans-serif;
    font-size: .85rem;
    color: #fff;
    outline: none;
}
.role-select option { background: #1f2937; }
.role-select:focus { border-color: #008751; }

.danger-btn {
    width: 100%;
    padding: 10px;
    background: rgba(232,17,45,.1);
    border: 1px solid rgba(232,17,45,.2);
    border-radius: 10px;
    color: #f87171;
    font-family: 'Poppins', sans-serif;
    font-size: .83rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
}
.danger-btn:hover { background: #E8112D; color: #fff; border-color: #E8112D; }

.success-btn {
    width: 100%;
    padding: 10px;
    background: rgba(0,135,81,.12);
    border: 1px solid rgba(0,135,81,.25);
    border-radius: 10px;
    color: #4ade80;
    font-family: 'Poppins', sans-serif;
    font-size: .83rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
}
.success-btn:hover { background: #008751; color: #fff; }

.empty-panel { text-align:center; padding:32px 20px; color:#6b7280; font-size:.85rem; }

@media (max-width:1024px) { .show-layout { grid-template-columns:1fr; } }
</style>

</body>
</html>