<?php
$reservation = $reservation ?? null;
$badges      = $badges      ?? [];

if (!$reservation) {
    header('Location: /admin/reservations');
    exit;
}

$statutMap = [
    'en_attente' => ['label' => 'En attente',  'class' => 'badge--attente'],
    'confirmee'  => ['label' => 'Confirmée',   'class' => 'badge--green'],
    'annulee'    => ['label' => 'Annulée',     'class' => 'badge--red'],
    'terminee'   => ['label' => 'Terminée',    'class' => 'badge--blue'],
    'no_show'    => ['label' => 'No show',     'class' => 'badge--grey'],
];
$statut = $statutMap[$reservation->statut ?? ''] ?? ['label' => '—', 'class' => 'badge--grey'];

$modeMap = [
    'carte'        => '💳 Carte bancaire',
    'mobile_money' => '📱 Mobile Money',
    'especes'      => '💵 Espèces',
    'virement'     => '🏦 Virement bancaire',
];

// Calcul durée
$arrivee = new DateTime($reservation->date_arrivee);
$depart  = new DateTime($reservation->date_depart);
$duree   = $arrivee->diff($depart)->days;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation #<?= htmlspecialchars($reservation->reference) ?> — Admin</title>
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
                <p class="label-tag">Réservations</p>
                <h1 class="page-title">
                    Réservation <span class="ref">#<?= htmlspecialchars($reservation->reference) ?></span>
                </h1>
                <p class="page-sub">
                    Effectuée le <?= date('d/m/Y à H:i', strtotime($reservation->date_reservation)) ?>
                </p>
            </div>
            <a href="/admin/reservations" class="btn-ghost">← Retour</a>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="res-layout">

            <!-- ── GAUCHE ── -->
            <div class="res-left">

                <!-- Récapitulatif séjour -->
                <div class="res-recap">
                    <div class="res-recap__dates">
                        <div class="date-block">
                            <div class="date-block__label">Arrivée</div>
                            <div class="date-block__val"><?= date('d', strtotime($reservation->date_arrivee)) ?></div>
                            <div class="date-block__month"><?= date('M Y', strtotime($reservation->date_arrivee)) ?></div>
                        </div>
                        <div class="date-block__sep">
                            <div class="sep-line"></div>
                            <div class="sep-nights"><?= $duree ?> nuit<?= $duree > 1 ? 's' : '' ?></div>
                            <div class="sep-line"></div>
                        </div>
                        <div class="date-block">
                            <div class="date-block__label">Départ</div>
                            <div class="date-block__val"><?= date('d', strtotime($reservation->date_depart)) ?></div>
                            <div class="date-block__month"><?= date('M Y', strtotime($reservation->date_depart)) ?></div>
                        </div>
                    </div>
                    <div class="res-recap__details">
                        <div class="recap-item">
                            <span>👥 Voyageurs</span>
                            <span><?= $reservation->nombre_voyageurs ?? '—' ?></span>
                        </div>
                        <div class="recap-item">
                            <span>🏨 Hébergement</span>
                            <span><?= htmlspecialchars($reservation->hebergement_nom ?? '—') ?></span>
                        </div>
                        <div class="recap-item">
                            <span>📍 Ville</span>
                            <span><?= htmlspecialchars($reservation->ville_nom ?? '—') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Détails financiers -->
                <div class="info-block">
                    <h3>💰 Détails financiers</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Prix / nuit</span>
                            <span class="info-val"><?= number_format($reservation->prix_nuit_base ?? 0, 0, ',', ' ') ?> FCFA</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Durée</span>
                            <span class="info-val"><?= $duree ?> nuit<?= $duree > 1 ? 's' : '' ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Montant total</span>
                            <span class="info-val" style="color:#4ade80;font-weight:700;font-size:1rem">
                                <?= number_format($reservation->montant_total ?? 0, 0, ',', ' ') ?> FCFA
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Acompte versé</span>
                            <span class="info-val"><?= number_format($reservation->accompte_verse ?? 0, 0, ',', ' ') ?> FCFA</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Reste à payer</span>
                            <span class="info-val" style="color:#f87171">
                                <?= number_format(($reservation->montant_total ?? 0) - ($reservation->accompte_verse ?? 0), 0, ',', ' ') ?> FCFA
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Mode de paiement</span>
                            <span class="info-val"><?= $modeMap[$reservation->mode_paiement ?? ''] ?? '—' ?></span>
                        </div>
                        <?php if (!empty($reservation->paiement_id)): ?>
                        <div class="info-row">
                            <span class="info-label">ID paiement</span>
                            <span class="info-val" style="font-size:.75rem;font-family:monospace">
                                <?= htmlspecialchars($reservation->paiement_id) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Notes -->
                <?php if (!empty($reservation->notes)): ?>
                <div class="info-block">
                    <h3>📝 Notes</h3>
                    <p style="font-size:.88rem;color:#9ca3af;line-height:1.7">
                        <?= nl2br(htmlspecialchars($reservation->notes)) ?>
                    </p>
                </div>
                <?php endif; ?>

            </div>

            <!-- ── DROITE ── -->
            <div class="res-right">

                <!-- Statut & Actions -->
                <div class="decision-card">
                    <h3>Statut de la réservation</h3>
                    <div style="margin-bottom:18px">
                        <span class="badge <?= $statut['class'] ?>" style="font-size:.85rem;padding:6px 16px">
                            <?= $statut['label'] ?>
                        </span>
                    </div>

                    <?php if ($reservation->statut === 'en_attente'): ?>
                    <div class="decision-btns">
                        <form method="POST" action="/admin/reservations/<?= $reservation->id ?>/confirmer">
                            <button type="submit" class="decision-btn decision-btn--green">✓ Confirmer la réservation</button>
                        </form>
                        <form method="POST" action="/admin/reservations/<?= $reservation->id ?>/annuler"
                              onsubmit="return confirm('Annuler cette réservation ?')">
                            <button type="submit" class="decision-btn decision-btn--red">✗ Annuler</button>
                        </form>
                    </div>
                    <?php elseif ($reservation->statut === 'confirmee'): ?>
                    <div class="decision-btns">
                        <form method="POST" action="/admin/reservations/<?= $reservation->id ?>/annuler"
                              onsubmit="return confirm('Annuler cette réservation confirmée ?')">
                            <button type="submit" class="decision-btn decision-btn--red">✗ Annuler</button>
                        </form>
                    </div>
                    <?php endif; ?>

                    <!-- Dates clés -->
                    <div style="margin-top:18px;padding-top:18px;border-top:1px solid var(--border)">
                        <?php if ($reservation->date_confirmation): ?>
                        <div style="font-size:.75rem;color:#6b7280;margin-bottom:6px">
                            ✅ Confirmée le <?= date('d/m/Y à H:i', strtotime($reservation->date_confirmation)) ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($reservation->date_annulation): ?>
                        <div style="font-size:.75rem;color:#f87171">
                            ❌ Annulée le <?= date('d/m/Y à H:i', strtotime($reservation->date_annulation)) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Voyageur -->
                <div class="info-block">
                    <h3>👤 Voyageur</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Nom</span>
                            <span class="info-val">
                                <?= htmlspecialchars(($reservation->voyageur_prenom ?? '') . ' ' . ($reservation->voyageur_nom ?? '')) ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-val" style="font-size:.75rem">
                                <?= htmlspecialchars($reservation->voyageur_email ?? '—') ?>
                            </span>
                        </div>
                        <?php if (!empty($reservation->voyageur_tel)): ?>
                        <div class="info-row">
                            <span class="info-label">Téléphone</span>
                            <span class="info-val"><?= htmlspecialchars($reservation->voyageur_tel) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.ref { font-family:monospace; color:#a78bfa; font-size:1.3rem; }
.res-layout { display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start; }

/* Récapitulatif dates */
.res-recap {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 18px;
}
.res-recap__dates {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-bottom: 24px;
    padding-bottom: 24px;
    border-bottom: 1px solid var(--border);
}
.date-block { text-align: center; }
.date-block__label { font-size:.65rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:#6b7280; margin-bottom:4px; }
.date-block__val   { font-size:2.8rem; font-weight:800; color:#fff; line-height:1; }
.date-block__month { font-size:.8rem; color:#9ca3af; margin-top:4px; }
.date-block__sep   { flex:1; display:flex; align-items:center; gap:10px; }
.sep-line          { flex:1; height:1px; background:var(--border); }
.sep-nights        { font-size:.72rem; font-weight:700; color:#008751; white-space:nowrap; background:rgba(0,135,81,.1); padding:4px 12px; border-radius:20px; }

.res-recap__details { display:flex; flex-direction:column; gap:10px; }
.recap-item { display:flex; justify-content:space-between; font-size:.85rem; color:#9ca3af; }
.recap-item span:last-child { color:#fff; font-weight:600; }

/* Info blocks */
.info-block { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:20px; margin-bottom:16px; }
.info-block h3 { font-size:.75rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:14px; }
.info-grid  { display:flex; flex-direction:column; gap:10px; }
.info-row   { display:flex; justify-content:space-between; align-items:center; padding-bottom:8px; border-bottom:1px solid rgba(255,255,255,.04); }
.info-row:last-child { border-bottom:none; padding-bottom:0; }
.info-label { font-size:.78rem; color:#6b7280; font-weight:500; }
.info-val   { font-size:.83rem; color:#e5e7eb; font-weight:500; text-align:right; }

/* Decision */
.decision-card  { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:22px; margin-bottom:16px; }
.decision-card h3 { font-size:.75rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:14px; }
.decision-btns  { display:flex; flex-direction:column; gap:10px; }
.decision-btn   { width:100%; padding:12px; border:none; border-radius:10px; font-family:'Poppins',sans-serif; font-size:.88rem; font-weight:700; cursor:pointer; transition:all .2s; }
.decision-btn--green { background:rgba(0,135,81,.15); color:#4ade80; }
.decision-btn--green:hover { background:#008751; color:#fff; }
.decision-btn--red { background:rgba(232,17,45,.12); color:#f87171; }
.decision-btn--red:hover { background:#E8112D; color:#fff; }

@media (max-width:1024px) { .res-layout { grid-template-columns:1fr; } }
</style>

</body>
</html>