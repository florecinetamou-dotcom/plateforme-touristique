<?php $title = 'Mon profil - BeninExplore'; ?>
<?php ob_start(); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap');

:root {
    --benin-green: #008751; --benin-yellow: #FCD116; --benin-red: #E8112D;
    --surface: #F4F6FA; --card-bg: #fff; --text-primary: #0f1923;
    --text-muted: #6b7585; --border: #E8EBF0;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.06); --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
    --radius: 18px; --radius-sm: 12px;
}
.voy-page * { font-family: 'DM Sans', sans-serif; }
.voy-page h1,.voy-page h2,.voy-page h3,.voy-page h4,.voy-page .syne { font-family: 'Syne', sans-serif; }

/* ─── Cards ─── */
.info-card {
    background: var(--card-bg); border-radius: var(--radius);
    border: 1px solid var(--border); box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.info-card-header {
    padding: 18px 24px; border-bottom: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
}
.info-card-header h5 {
    font-family: 'Syne', sans-serif; font-weight: 700;
    font-size: 0.95rem; color: var(--text-primary); margin: 0;
    display: flex; align-items: center; gap: 8px;
}
.info-card-header h5 i { color: var(--benin-green); font-size: 0.85rem; }
.info-card-body { padding: 22px 24px; }

/* Bouton éditer */
.btn-edit {
    font-size: 0.75rem; font-family: 'Syne', sans-serif; font-weight: 600;
    color: var(--benin-green); background: rgba(0,135,81,0.08);
    border: 1px solid rgba(0,135,81,0.2); border-radius: 50px;
    padding: 5px 14px; text-decoration: none; transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 5px;
}
.btn-edit:hover { background: rgba(0,135,81,0.15); color: var(--benin-green); }

/* ─── Info rows ─── */
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
.info-row {
    padding: 14px 0; border-bottom: 1px solid var(--border);
    display: flex; flex-direction: column; gap: 4px;
}
.info-row:nth-child(odd) { padding-right: 20px; }
.info-row:nth-child(even) { padding-left: 20px; border-left: 1px solid var(--border); }
.info-row:nth-last-child(-n+2) { border-bottom: none; }
.info-label {
    font-family: 'Syne', sans-serif; font-weight: 700;
    font-size: 0.68rem; color: var(--text-muted);
    letter-spacing: 0.06em; text-transform: uppercase;
}
.info-value {
    font-size: 0.88rem; color: var(--text-primary); font-weight: 500;
}

/* Role badge */
.role-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 50px; font-size: 0.68rem; font-family: 'Syne', sans-serif; font-weight: 700; text-transform: uppercase; }
.role-badge.voyageur  { background: rgba(0,135,81,0.1);    color: var(--benin-green); }
.role-badge.hebergeur { background: rgba(252,209,22,0.18); color: #b08900; }
.role-badge.admin     { background: rgba(232,17,45,0.1);   color: var(--benin-red); }

/* Verified */
.verified-ok  { color: var(--benin-green); font-size: 0.82rem; display: flex; align-items: center; gap: 5px; }
.verified-no  { color: var(--text-muted);  font-size: 0.82rem; display: flex; align-items: center; gap: 5px; }

/* ─── Stat cards ─── */
.stat-cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
.stat-card-mini {
    background: var(--surface); border-radius: var(--radius-sm);
    border: 1px solid var(--border); padding: 16px;
    text-align: center; transition: all 0.2s; text-decoration: none;
}
.stat-card-mini:hover { background: #fff; box-shadow: var(--shadow-md); transform: translateY(-2px); }
.stat-card-mini .val {
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 1.6rem; line-height: 1; margin-bottom: 4px;
}
.stat-card-mini .lbl { font-size: 0.72rem; color: var(--text-muted); font-weight: 500; }

/* ─── Réservation récente card ─── */
.recent-resa {
    display: flex; gap: 14px; align-items: center;
    padding: 13px 0; border-bottom: 1px solid var(--border);
}
.recent-resa:last-child { border-bottom: none; }
.resa-thumb {
    width: 54px; height: 44px; border-radius: 10px;
    object-fit: cover; flex-shrink: 0;
    background: var(--surface); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-muted); font-size: 0.9rem;
    overflow: hidden;
}
.resa-thumb img { width: 100%; height: 100%; object-fit: cover; }
.resa-name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.82rem; color: var(--text-primary); margin-bottom: 2px; }
.resa-meta { font-size: 0.72rem; color: var(--text-muted); }
.resa-badge { display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; border-radius: 50px; font-size: 0.65rem; font-family: 'Syne', sans-serif; font-weight: 700; text-transform: uppercase; margin-left: auto; flex-shrink: 0; }
.resa-badge.confirmee  { background: rgba(0,135,81,0.1);    color: var(--benin-green); }
.resa-badge.en_attente { background: rgba(252,209,22,0.18); color: #b08900; }
.resa-badge.annulee    { background: rgba(107,117,133,0.12); color: var(--text-muted); }
.resa-badge.terminee   { background: rgba(59,130,246,0.1);  color: #3b82f6; }

/* ─── Empty state ─── */
.empty-box {
    text-align: center; padding: 32px 20px;
    background: var(--surface); border-radius: var(--radius-sm);
}
.empty-box i { font-size: 1.8rem; color: var(--text-muted); margin-bottom: 10px; display: block; }
.empty-box p { font-size: 0.82rem; color: var(--text-muted); margin: 0; }

/* ─── Animations ─── */
@keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
.info-card { animation: fadeUp 0.4s ease both; }
.info-card:nth-child(2) { animation-delay: 0.08s; }
.info-card:nth-child(3) { animation-delay: 0.14s; }

@media(max-width:768px) { .info-grid { grid-template-columns: 1fr; } .stat-cards { grid-template-columns: repeat(3,1fr); } }
</style>

<div class="container-fluid py-4 voy-page" style="background:var(--surface);min-height:100vh">
    <div class="row g-4" style="max-width:1200px;margin:0 auto;padding:0 16px">

        <!-- Sidebar -->
        <div class="col-md-3">
            <?php include dirname(__DIR__, 2) . '/layout/sidebar-voyageur.php'; ?>
        </div>

        <!-- Contenu -->
        <div class="col-md-9">

            <!-- Topbar -->
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:10px">
                <div>
                    <h4 class="syne" style="font-weight:800;font-size:1.35rem;color:var(--text-primary);margin:0;letter-spacing:-0.02em">
                        Mon profil
                    </h4>
                    <p style="color:var(--text-muted);font-size:0.82rem;margin:3px 0 0">
                        Bonjour <?= htmlspecialchars($_SESSION['user_prenom'] ?? '') ?> 👋
                    </p>
                </div>
                <a href="/profile/edit" class="btn-edit">
                    <i class="fas fa-pen"></i> Modifier
                </a>
            </div>

            <!-- Flash success -->
            <?php if (isset($_SESSION['success'])): ?>
                <div style="background:#f0faf5;border:1px solid rgba(0,135,81,0.2);border-left:4px solid var(--benin-green);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:20px;font-size:0.83rem;color:#005c38;display:flex;align-items:center;gap:8px">
                    <i class="fas fa-check-circle"></i> <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <div class="row g-3">

                <!-- ── Infos personnelles ── -->
                <div class="col-12">
                    <div class="info-card">
                        <div class="info-card-header">
                            <h5><i class="fas fa-user"></i> Informations personnelles</h5>
                            <a href="/profile/edit" class="btn-edit"><i class="fas fa-pen"></i> Éditer</a>
                        </div>
                        <div class="info-card-body">
                            <div class="info-grid">
                                <div class="info-row">
                                    <span class="info-label">Prénom</span>
                                    <span class="info-value"><?= htmlspecialchars($user->prenom) ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Nom</span>
                                    <span class="info-value"><?= htmlspecialchars($user->nom) ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Adresse e-mail</span>
                                    <span class="info-value"><?= htmlspecialchars($user->email) ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Téléphone</span>
                                    <span class="info-value"><?= htmlspecialchars($user->telephone ?? '—') ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Rôle</span>
                                    <span class="info-value">
                                        <span class="role-badge <?= $user->role ?>">
                                            <?= ['voyageur'=>'Voyageur','hebergeur'=>'Hébergeur','admin'=>'Admin'][$user->role] ?? $user->role ?>
                                        </span>
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Compte vérifié</span>
                                    <span class="info-value">
                                        <?php if ($user->est_verifie): ?>
                                            <span class="verified-ok"><i class="fas fa-check-circle"></i> Vérifié</span>
                                        <?php else: ?>
                                            <span class="verified-no"><i class="fas fa-times-circle"></i> Non vérifié</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Membre depuis</span>
                                    <span class="info-value"><?= (new DateTime($user->date_inscription))->format('d F Y') ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Dernière connexion</span>
                                    <span class="info-value"><?= $user->derniere_connexion ? (new DateTime($user->derniere_connexion))->format('d/m/Y à H:i') : '—' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Statistiques ── -->
                <div class="col-12">
                    <div class="info-card">
                        <div class="info-card-header">
                            <h5><i class="fas fa-chart-bar"></i> Mes statistiques</h5>
                        </div>
                        <div class="info-card-body">
                            <div class="stat-cards">
                                <a href="/reservations" class="stat-card-mini" style="text-decoration:none">
                                    <div class="val" style="color:var(--benin-green)"><?= $voy_stats['reservations'] ?></div>
                                    <div class="lbl">Réservations</div>
                                </a>
                                <a href="/favoris" class="stat-card-mini" style="text-decoration:none">
                                    <div class="val" style="color:var(--benin-red)"><?= $voy_stats['favoris'] ?></div>
                                    <div class="lbl">Favoris</div>
                                </a>
                                <a href="/avis" class="stat-card-mini" style="text-decoration:none">
                                    <div class="val" style="color:#f59e0b"><?= $voy_stats['avis'] ?></div>
                                    <div class="lbl">Avis donnés</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Réservations récentes ── -->
                <div class="col-md-6">
                    <div class="info-card">
                        <div class="info-card-header">
                            <h5><i class="fas fa-calendar-check"></i> Séjours récents</h5>
                            <a href="/reservations" style="font-size:0.75rem;color:var(--benin-green);text-decoration:none;font-family:'Syne',sans-serif;font-weight:600">
                                Voir tout <i class="fas fa-arrow-right" style="font-size:0.65rem"></i>
                            </a>
                        </div>
                        <div class="info-card-body" style="padding-top:8px;padding-bottom:8px">
                            <?php if (!empty($dernieres_reservations)): ?>
                                <?php foreach ($dernieres_reservations as $r): ?>
                                <div class="recent-resa">
                                    <div class="resa-thumb">
                                        <?php if (!empty($r->photo)): ?>
                                            <img src="<?= htmlspecialchars($r->photo) ?>" alt="">
                                        <?php else: ?>
                                            <i class="fas fa-hotel"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div style="flex:1;min-width:0">
                                        <div class="resa-name"><?= htmlspecialchars($r->hebergement_nom) ?></div>
                                        <div class="resa-meta">
                                            <?= (new DateTime($r->date_arrivee))->format('d/m/Y') ?>
                                            → <?= (new DateTime($r->date_depart))->format('d/m/Y') ?>
                                        </div>
                                    </div>
                                    <span class="resa-badge <?= $r->statut ?>">
                                        <?= ['confirmee'=>'Confirmée','en_attente'=>'Attente','annulee'=>'Annulée','terminee'=>'Terminée'][$r->statut] ?? $r->statut ?>
                                    </span>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-box">
                                    <i class="fas fa-calendar-times"></i>
                                    <p>Aucune réservation pour le moment</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ── Favoris récents ── -->
                <div class="col-md-6">
                    <div class="info-card">
                        <div class="info-card-header">
                            <h5><i class="fas fa-heart"></i> Favoris récents</h5>
                            <a href="/favoris" style="font-size:0.75rem;color:var(--benin-green);text-decoration:none;font-family:'Syne',sans-serif;font-weight:600">
                                Voir tout <i class="fas fa-arrow-right" style="font-size:0.65rem"></i>
                            </a>
                        </div>
                        <div class="info-card-body" style="padding-top:8px;padding-bottom:8px">
                            <?php if (!empty($derniers_favoris)): ?>
                                <?php foreach ($derniers_favoris as $f): ?>
                                <div class="recent-resa">
                                    <div class="resa-thumb">
                                        <?php if (!empty($f->photo)): ?>
                                            <img src="<?= htmlspecialchars($f->photo) ?>" alt="">
                                        <?php else: ?>
                                            <i class="fas fa-hotel"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div style="flex:1;min-width:0">
                                        <div class="resa-name"><?= htmlspecialchars($f->nom) ?></div>
                                        <div class="resa-meta">
                                            <i class="fas fa-map-marker-alt" style="color:var(--benin-green);font-size:0.65rem"></i>
                                            <?= htmlspecialchars($f->ville_nom) ?>
                                            · <?= number_format($f->prix_nuit_base, 0, ',', ' ') ?> FCFA
                                        </div>
                                    </div>
                                    <a href="/hebergement/<?= $f->id ?>" style="flex-shrink:0;width:26px;height:26px;border-radius:7px;border:1px solid var(--border);background:transparent;display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:0.65rem;text-decoration:none;transition:all 0.2s">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-box">
                                    <i class="fas fa-heart"></i>
                                    <p>Aucun favori pour le moment</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>