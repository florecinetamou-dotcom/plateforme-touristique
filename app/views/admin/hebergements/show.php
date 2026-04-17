<?php
$hebergement     = $hebergement     ?? null;
$photoPrincipale = $photoPrincipale ?? null;
$autresPhotos    = $autresPhotos    ?? [];
$badges          = $badges          ?? [];

if (!$hebergement) {
    header('Location: /admin/hebergements');
    exit;
}

$statutMap = [
    'en_attente' => ['label' => 'En attente',  'class' => 'badge--attente'],
    'approuve'   => ['label' => 'Approuvé',    'class' => 'badge--green'],
    'rejete'     => ['label' => 'Rejeté',      'class' => 'badge--red'],
    'suspendu'   => ['label' => 'Suspendu',    'class' => 'badge--grey'],
];
$statut = $statutMap[$hebergement->statut ?? ''] ?? ['label' => '—', 'class' => 'badge--grey'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($hebergement->nom) ?> — Admin BeninExplore</title>
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
                <p class="label-tag">Hébergements</p>
                <h1 class="page-title"><?= htmlspecialchars($hebergement->nom) ?></h1>
                <p class="page-sub">
                    <?= htmlspecialchars($hebergement->ville_nom ?? '—') ?> ·
                    <?= htmlspecialchars($hebergement->type_nom  ?? '—') ?>
                </p>
            </div>
            <a href="/admin/hebergements" class="btn-ghost">← Retour à la liste</a>
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

                <!-- Photo principale -->
                <div class="photo-principale">
                    <?php if ($photoPrincipale): ?>
                    <img id="main-photo"
                         src="<?= htmlspecialchars($photoPrincipale->url) ?>"
                         alt="Photo principale">
                    <span class="photo-tag">Photo principale</span>
                    <?php else: ?>
                    <div class="no-photo">🏨<br><small>Aucune photo</small></div>
                    <?php endif; ?>
                </div>

                <!-- 3 autres photos -->
                <?php if (!empty($autresPhotos)): ?>
                <div class="autres-photos">
                    <?php foreach ($autresPhotos as $p): ?>
                    <div class="autre-photo-card"
                         onclick="switchPhoto('<?= htmlspecialchars($p->url) ?>', this)">
                        <img src="<?= htmlspecialchars($p->url) ?>" alt="">
                        <?php if (!empty($p->description)): ?>
                        <div class="autre-photo-desc"><?= htmlspecialchars($p->description) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Description -->
                <?php if (!empty($hebergement->description)): ?>
                <div class="info-block" style="margin-top:24px">
                    <h3>Description</h3>
                    <p class="desc-text"><?= nl2br(htmlspecialchars($hebergement->description)) ?></p>
                </div>
                <?php endif; ?>

                <!-- Équipements -->
                <?php if (!empty($hebergement->equipements)): ?>
                <div class="info-block">
                    <h3>Équipements</h3>
                    <div class="equip-list">
                        <?php foreach (explode(',', $hebergement->equipements) as $eq): ?>
                        <span class="equip-tag"><?= htmlspecialchars(trim($eq)) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- ── COLONNE DROITE ── -->
            <div class="show-right">

                <!-- Décision admin -->
                <div class="decision-card">
                    <h3>Décision Admin</h3>
                    <p class="decision-status">
                        Statut actuel :
                        <span class="badge <?= $statut['class'] ?>"><?= $statut['label'] ?></span>
                    </p>
                    <div class="decision-btns">
                        <?php if ($hebergement->statut !== 'approuve'): ?>
                        <form method="POST" action="/admin/hebergements/<?= $hebergement->id ?>/valider">
                            <button type="submit" class="decision-btn decision-btn--green">✓ Approuver l'annonce</button>
                        </form>
                        <?php endif; ?>
                        <?php if ($hebergement->statut !== 'rejete'): ?>
                        <form method="POST" action="/admin/hebergements/<?= $hebergement->id ?>/rejeter"
                              onsubmit="return confirm('Rejeter cet hébergement ?')">
                            <button type="submit" class="decision-btn decision-btn--red">✗ Rejeter l'annonce</button>
                        </form>
                        <?php endif; ?>
                        <?php if ($hebergement->statut === 'approuve'): ?>
                        <form method="POST" action="/admin/hebergements/<?= $hebergement->id ?>/rejeter"
                              onsubmit="return confirm('Suspendre cet hébergement ?')">
                            <button type="submit" class="decision-btn decision-btn--yellow">⏸ Suspendre</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Hébergeur -->
                <div class="info-block">
                    <h3>Hébergeur</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Nom</span>
                            <span class="info-val">
                                <?= htmlspecialchars(($hebergement->hebergeur_prenom ?? '') . ' ' . ($hebergement->hebergeur_nom ?? '')) ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-val" style="font-size:.76rem">
                                <?= htmlspecialchars($hebergement->hebergeur_email ?? '—') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Détails -->
                <div class="info-block">
                    <h3>Détails</h3>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Ville</span>
                            <span class="info-val"><?= htmlspecialchars($hebergement->ville_nom ?? '—') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Type</span>
                            <span class="info-val"><?= htmlspecialchars($hebergement->type_nom ?? '—') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Prix / nuit</span>
                            <span class="info-val" style="color:#4ade80;font-weight:700">
                                <?= number_format($hebergement->prix_nuit_base ?? 0, 0, ',', ' ') ?> FCFA
                            </span>
                        </div>
                        <?php if (!empty($hebergement->capacite)): ?>
                        <div class="info-row">
                            <span class="info-label">Capacité</span>
                            <span class="info-val"><?= $hebergement->capacite ?> personnes</span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($hebergement->chambres)): ?>
                        <div class="info-row">
                            <span class="info-label">Chambres</span>
                            <span class="info-val"><?= $hebergement->chambres ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-row">
                            <span class="info-label">Créé le</span>
                            <span class="info-val">
                                <?= date('d/m/Y', strtotime($hebergement->date_creation ?? 'now')) ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Photos</span>
                            <span class="info-val">
                                <?= $photoPrincipale ? 1 : 0 ?> principale +
                                <?= count($autresPhotos) ?> autre<?= count($autresPhotos) > 1 ? 's' : '' ?>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.show-layout { display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start; }
.photo-principale { position:relative; border-radius:16px; overflow:hidden; border:1px solid var(--border); background:var(--card); }
.photo-principale img { width:100%; height:340px; object-fit:cover; display:block; transition:opacity .3s; }
.photo-tag { position:absolute; top:14px; left:14px; background:rgba(0,135,81,.85); color:#fff; font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; padding:4px 12px; border-radius:20px; }
.no-photo { width:100%; height:280px; display:flex; flex-direction:column; align-items:center; justify-content:center; font-size:3rem; color:#6b7280; }
.autres-photos { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin-top:12px; }
.autre-photo-card { border-radius:10px; overflow:hidden; border:2px solid var(--border); cursor:pointer; transition:border-color .2s,transform .2s; background:var(--card); }
.autre-photo-card:hover { border-color:var(--green); transform:translateY(-2px); }
.autre-photo-card.active { border-color:var(--green); }
.autre-photo-card img { width:100%; height:90px; object-fit:cover; display:block; }
.autre-photo-desc { padding:6px 8px; font-size:.68rem; color:#6b7280; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.info-block { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:20px; margin-bottom:16px; }
.info-block h3 { font-size:.75rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:14px; }
.info-grid { display:flex; flex-direction:column; gap:10px; }
.info-row { display:flex; justify-content:space-between; align-items:center; padding-bottom:8px; border-bottom:1px solid rgba(255,255,255,.04); }
.info-row:last-child { border-bottom:none; padding-bottom:0; }
.info-label { font-size:.78rem; color:#6b7280; font-weight:500; }
.info-val { font-size:.83rem; color:#e5e7eb; font-weight:500; text-align:right; }
.desc-text { font-size:.88rem; color:#9ca3af; line-height:1.75; }
.equip-list { display:flex; flex-wrap:wrap; gap:8px; }
.equip-tag { background:rgba(255,255,255,.06); border:1px solid var(--border); color:var(--muted2); font-size:.72rem; font-weight:500; padding:4px 12px; border-radius:20px; }
.decision-card { background:var(--card); border:1px solid var(--border); border-radius:14px; padding:22px; margin-bottom:16px; }
.decision-card h3 { font-size:.75rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#6b7280; margin-bottom:14px; }
.decision-status { font-size:.85rem; color:var(--muted2); margin-bottom:18px; display:flex; align-items:center; gap:10px; }
.decision-btns { display:flex; flex-direction:column; gap:10px; }
.decision-btn { width:100%; padding:12px; border:none; border-radius:10px; font-family:'Poppins',sans-serif; font-size:.88rem; font-weight:700; cursor:pointer; transition:all .2s; }
.decision-btn--green { background:rgba(0,135,81,.15); color:#4ade80; }
.decision-btn--green:hover { background:#008751; color:#fff; }
.decision-btn--red { background:rgba(232,17,45,.12); color:#f87171; }
.decision-btn--red:hover { background:#E8112D; color:#fff; }
.decision-btn--yellow { background:rgba(255,214,0,.12); color:#FFD600; }
.decision-btn--yellow:hover { background:rgba(255,214,0,.25); }
@media (max-width:1100px) { .show-layout { grid-template-columns:1fr; } }
</style>

<script>
function switchPhoto(url, card) {
    const img = document.getElementById('main-photo');
    if (img) {
        img.style.opacity = '0';
        setTimeout(() => { img.src = url; img.style.opacity = '1'; }, 200);
    }
    document.querySelectorAll('.autre-photo-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
}
</script>

</body>
</html>