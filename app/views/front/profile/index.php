<?php
// Récupération des données depuis le contrôleur
$user = $user ?? null;
$voy_stats = $voy_stats ?? ['reservations' => 0, 'favoris' => 0, 'avis' => 0];
$dernieres_reservations = $dernieres_reservations ?? [];
$derniers_favoris = $derniers_favoris ?? [];
$errors_pwd = $errors_pwd ?? [];

if (!$user) {
    header('Location: /login');
    exit;
}

// S'assurer que les données de session sont définies pour le sidebar
$_SESSION['user_prenom'] = $_SESSION['user_prenom'] ?? $user->prenom;
$_SESSION['user_nom'] = $_SESSION['user_nom'] ?? $user->nom;
$_SESSION['user_email'] = $_SESSION['user_email'] ?? $user->email;
$_SESSION['user_role'] = $_SESSION['user_role'] ?? $user->role;

$title = 'Mon profil - BeninExplore';
?>
<?php ob_start(); ?>

<div class="voy-layout">

    <!-- Sidebar -->
    <aside class="voy-sidebar-wrap">
        <?php include dirname(__DIR__, 2) . '/layout/sidebar-voyageur.php'; ?>
    </aside>

    <!-- Contenu principal -->
    <main class="voy-main">

        <!-- Page header -->
        <div class="voy-page-header">
            <div>
                <h1 class="voy-page-title">Mon profil</h1>
                <p class="voy-page-sub">
                    Bonjour <?= htmlspecialchars($user->prenom) ?>, voici un aperçu de votre compte et de votre activité sur BeninExplore.
                </p>
            </div>
            <a href="/profile/edit" class="btn-voy-primary">
                <i class="fas fa-pen me-2"></i>Modifier le profil
            </a>
        </div>

        <!-- Flash messages -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="voy-alert voy-alert-success">
                <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="voy-alert voy-alert-error">
                <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row g-4">

            <!-- ── Infos personnelles ── -->
            <div class="col-12">
                <div class="voy-card">
                    <div class="voy-card-header">
                        <div class="voy-card-header-left">
                            <div class="voy-card-icon" style="background:rgba(0,135,81,0.1);color:#008751;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h2 class="voy-card-title">Informations personnelles</h2>
                                <p class="voy-card-sub">Vos données de compte</p>
                            </div>
                        </div>
                        <a href="/profile/edit" class="btn-voy-outline btn-sm">
                            <i class="fas fa-pen me-1"></i>Éditer
                        </a>
                    </div>
                    <div class="voy-card-body">
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
                                    <?php
                                    $roleLabels = ['voyageur' => 'Voyageur', 'hebergeur' => 'Hébergeur', 'admin' => 'Admin'];
                                    $roleColors = ['voyageur' => 'role-green', 'hebergeur' => 'role-yellow', 'admin' => 'role-red'];
                                    ?>
                                    <span class="role-badge <?= $roleColors[$user->role] ?? 'role-green' ?>">
                                        <?= $roleLabels[$user->role] ?? $user->role ?>
                                    </span>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Compte vérifié</span>
                                <span class="info-value">
                                    <?php if ($user->est_verifie): ?>
                                        <span class="verified-ok"><i class="fas fa-check-circle me-1"></i>Vérifié</span>
                                    <?php else: ?>
                                        <span class="verified-no"><i class="fas fa-times-circle me-1"></i>Non vérifié</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Membre depuis</span>
                                <span class="info-value"><?= (new DateTime($user->date_inscription))->format('d F Y') ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Dernière connexion</span>
                                <span class="info-value">
                                    <?= $user->derniere_connexion
                                        ? (new DateTime($user->derniere_connexion))->format('d/m/Y à H:i')
                                        : '—' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Statistiques ── -->
            <div class="col-12">
                <div class="voy-card">
                    <div class="voy-card-header">
                        <div class="voy-card-header-left">
                            <div class="voy-card-icon" style="background:rgba(59,130,246,0.1);color:#3b82f6;">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div>
                                <h2 class="voy-card-title">Mes statistiques</h2>
                                <p class="voy-card-sub">Vue d'ensemble de votre activité</p>
                            </div>
                        </div>
                    </div>
                    <div class="voy-card-body">
                        <div class="row g-3">
                            <div class="col-4">
                                <a href="/reservations" class="mini-stat-card" style="text-decoration:none">
                                    <div class="mini-stat-icon" style="background:rgba(0,135,81,0.1);color:#008751;"><i class="fas fa-calendar-check"></i></div>
                                    <div class="mini-stat-num" style="color:#008751;"><?= $voy_stats['reservations'] ?></div>
                                    <div class="mini-stat-lbl">Réservations</div>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="/favoris" class="mini-stat-card" style="text-decoration:none">
                                    <div class="mini-stat-icon" style="background:rgba(239,68,68,0.1);color:#ef4444;"><i class="fas fa-heart"></i></div>
                                    <div class="mini-stat-num" style="color:#ef4444;"><?= $voy_stats['favoris'] ?></div>
                                    <div class="mini-stat-lbl">Favoris</div>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="/avis" class="mini-stat-card" style="text-decoration:none">
                                    <div class="mini-stat-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;"><i class="fas fa-star"></i></div>
                                    <div class="mini-stat-num" style="color:#f59e0b;"><?= $voy_stats['avis'] ?></div>
                                    <div class="mini-stat-lbl">Avis donnés</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Séjours récents ── -->
            <div class="col-md-6">
                <div class="voy-card h-100">
                    <div class="voy-card-header">
                        <div class="voy-card-header-left">
                            <div class="voy-card-icon" style="background:rgba(0,135,81,0.1);color:#008751;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h2 class="voy-card-title">Séjours récents</h2>
                                <p class="voy-card-sub">Vos dernières réservations</p>
                            </div>
                        </div>
                        <a href="/reservations" class="voy-see-all">Tout voir <i class="fas fa-arrow-right ms-1" style="font-size:.65rem"></i></a>
                    </div>
                    <div class="voy-card-body" style="padding-top:8px;padding-bottom:8px;">
                        <?php if (!empty($dernieres_reservations)): ?>
                            <?php foreach ($dernieres_reservations as $r): ?>
                            <div class="voy-list-item">
                                <div class="voy-thumb">
                                    <?php if (!empty($r->photo)): ?>
                                        <img src="<?= htmlspecialchars($r->photo) ?>" alt="">
                                    <?php else: ?>
                                        <i class="fas fa-hotel"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="voy-list-info">
                                    <div class="voy-list-name"><?= htmlspecialchars($r->hebergement_nom) ?></div>
                                    <div class="voy-list-meta">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?= (new DateTime($r->date_arrivee))->format('d/m/Y') ?>
                                        <span class="mx-1">→</span>
                                        <?= (new DateTime($r->date_depart))->format('d/m/Y') ?>
                                    </div>
                                </div>
                                <?php
                                $sc = [
                                    'confirmee'  => ['Confirmée',  'badge-green'],
                                    'en_attente' => ['En attente', 'badge-yellow'],
                                    'annulee'    => ['Annulée',    'badge-red'],
                                    'terminee'   => ['Terminée',   'badge-blue'],
                                ][$r->statut] ?? [ucfirst($r->statut), 'badge-gray'];
                                ?>
                                <span class="voy-badge <?= $sc[1] ?>"><?= $sc[0] ?></span>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="voy-empty">
                                <div class="voy-empty-icon"><i class="fas fa-calendar-times"></i></div>
                                <p class="voy-empty-text">Aucune réservation pour le moment</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- ── Favoris récents ── -->
            <div class="col-md-6">
                <div class="voy-card h-100">
                    <div class="voy-card-header">
                        <div class="voy-card-header-left">
                            <div class="voy-card-icon" style="background:rgba(239,68,68,0.1);color:#ef4444;">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <h2 class="voy-card-title">Favoris récents</h2>
                                <p class="voy-card-sub">Vos hébergements sauvegardés</p>
                            </div>
                        </div>
                        <a href="/favoris" class="voy-see-all">Tout voir <i class="fas fa-arrow-right ms-1" style="font-size:.65rem"></i></a>
                    </div>
                    <div class="voy-card-body" style="padding-top:8px;padding-bottom:8px;">
                        <?php if (!empty($derniers_favoris)): ?>
                            <?php foreach ($derniers_favoris as $f): ?>
                            <div class="voy-list-item">
                                <div class="voy-thumb">
                                    <?php if (!empty($f->photo)): ?>
                                        <img src="<?= htmlspecialchars($f->photo) ?>" alt="">
                                    <?php else: ?>
                                        <i class="fas fa-hotel"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="voy-list-info">
                                    <div class="voy-list-name"><?= htmlspecialchars($f->nom) ?></div>
                                    <div class="voy-list-meta">
                                        <i class="fas fa-map-marker-alt me-1" style="color:#008751;"></i>
                                        <?= htmlspecialchars($f->ville_nom) ?> ·
                                        <strong><?= number_format($f->prix_nuit_base, 0, ',', ' ') ?> FCFA</strong>
                                    </div>
                                </div>
                                <a href="/hebergement/<?= $f->id ?>" class="voy-fav-btn">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="voy-empty">
                                <div class="voy-empty-icon"><i class="fas fa-heart"></i></div>
                                <p class="voy-empty-text">Aucun favori pour le moment</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- ── Modifier le mot de passe ── -->
            <div class="col-12">
                <div class="voy-card">
                    <div class="voy-card-header">
                        <div class="voy-card-header-left">
                            <div class="voy-card-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6;">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div>
                                <h2 class="voy-card-title">Sécurité du compte</h2>
                                <p class="voy-card-sub">Modifiez votre mot de passe régulièrement pour protéger votre compte</p>
                            </div>
                        </div>
                        <!-- Toggle pour afficher/masquer le formulaire -->
                        <button class="btn-voy-outline btn-sm" id="togglePwdForm" onclick="togglePasswordForm()">
                            <i class="fas fa-key me-1"></i>Changer le mot de passe
                        </button>
                    </div>

                    <!-- Indicateur sécurité (état par défaut) -->
                    <div class="voy-card-body" id="pwdDefault">
                        <div class="pwd-security-status">
                            <div class="pwd-status-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="pwd-status-info">
                                <div class="pwd-status-title">Mot de passe défini</div>
                                <div class="pwd-status-sub">
                                    Dernière modification : 
                                    <strong><?= !empty($user->derniere_modif_mdp)
                                        ? (new DateTime($user->derniere_modif_mdp))->format('d/m/Y')
                                        : 'Non renseigné' ?></strong>
                                </div>
                            </div>
                            <div class="pwd-tips">
                                <span class="pwd-tip"><i class="fas fa-check me-1"></i>8 caractères min.</span>
                                <span class="pwd-tip"><i class="fas fa-check me-1"></i>Majuscules & chiffres</span>
                                <span class="pwd-tip"><i class="fas fa-check me-1"></i>Caractères spéciaux</span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire (masqué par défaut) -->
                    <div class="voy-card-body" id="pwdForm" style="display:none; border-top:1px solid #f5f5f5;">

                        <?php if (!empty($errors_pwd)): ?>
                            <div class="voy-alert voy-alert-error mb-4">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?= htmlspecialchars(array_values($errors_pwd)[0]) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/profile/password" id="passwordForm" novalidate>
                            <?php if (!empty($_SESSION['csrf_token'])): ?>
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <?php endif; ?>

                            <div class="row g-4">
                                <!-- Mot de passe actuel -->
                                <div class="col-12">
                                    <label class="pwd-label">Mot de passe actuel <span class="text-danger">*</span></label>
                                    <div class="pwd-input-wrap">
                                        <i class="fas fa-lock pwd-input-icon"></i>
                                        <input type="password"
                                               class="pwd-input <?= isset($errors_pwd['actuel']) ? 'is-invalid' : '' ?>"
                                               name="password_actuel"
                                               id="pwd_actuel"
                                               placeholder="Votre mot de passe actuel"
                                               autocomplete="current-password"
                                               required>
                                        <button type="button" class="pwd-toggle" onclick="togglePwd('pwd_actuel', this)" aria-label="Afficher/masquer">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <?php if (isset($errors_pwd['actuel'])): ?>
                                        <div class="pwd-field-error"><i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($errors_pwd['actuel']) ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Nouveau mot de passe -->
                                <div class="col-md-6">
                                    <label class="pwd-label">Nouveau mot de passe <span class="text-danger">*</span></label>
                                    <div class="pwd-input-wrap">
                                        <i class="fas fa-key pwd-input-icon"></i>
                                        <input type="password"
                                               class="pwd-input <?= isset($errors_pwd['nouveau']) ? 'is-invalid' : '' ?>"
                                               name="password_nouveau"
                                               id="pwd_nouveau"
                                               placeholder="Nouveau mot de passe"
                                               autocomplete="new-password"
                                               oninput="checkStrength(this.value)"
                                               required>
                                        <button type="button" class="pwd-toggle" onclick="togglePwd('pwd_nouveau', this)" aria-label="Afficher/masquer">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <?php if (isset($errors_pwd['nouveau'])): ?>
                                        <div class="pwd-field-error"><i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($errors_pwd['nouveau']) ?></div>
                                    <?php endif; ?>

                                    <!-- Barre de force -->
                                    <div class="strength-bar-wrap" id="strengthWrap" style="display:none;">
                                        <div class="strength-bar">
                                            <div class="strength-fill" id="strengthFill"></div>
                                        </div>
                                        <span class="strength-label" id="strengthLabel"></span>
                                    </div>

                                    <!-- Checklist règles -->
                                    <div class="pwd-rules" id="pwdRules" style="display:none;">
                                        <div class="pwd-rule" id="rule-length"><i class="fas fa-circle me-1"></i>8 caractères minimum</div>
                                        <div class="pwd-rule" id="rule-upper"><i class="fas fa-circle me-1"></i>Une majuscule</div>
                                        <div class="pwd-rule" id="rule-number"><i class="fas fa-circle me-1"></i>Un chiffre</div>
                                        <div class="pwd-rule" id="rule-special"><i class="fas fa-circle me-1"></i>Un caractère spécial</div>
                                    </div>
                                </div>

                                <!-- Confirmation -->
                                <div class="col-md-6">
                                    <label class="pwd-label">Confirmer le nouveau mot de passe <span class="text-danger">*</span></label>
                                    <div class="pwd-input-wrap">
                                        <i class="fas fa-check-circle pwd-input-icon"></i>
                                        <input type="password"
                                               class="pwd-input <?= isset($errors_pwd['confirmation']) ? 'is-invalid' : '' ?>"
                                               name="password_confirmation"
                                               id="pwd_confirm"
                                               placeholder="Confirmez le mot de passe"
                                               autocomplete="new-password"
                                               oninput="checkMatch()"
                                               required>
                                        <button type="button" class="pwd-toggle" onclick="togglePwd('pwd_confirm', this)" aria-label="Afficher/masquer">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <?php if (isset($errors_pwd['confirmation'])): ?>
                                        <div class="pwd-field-error"><i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($errors_pwd['confirmation']) ?></div>
                                    <?php endif; ?>
                                    <div class="pwd-match-msg" id="matchMsg" style="display:none;"></div>
                                </div>

                                <!-- Actions -->
                                <div class="col-12">
                                    <div class="pwd-actions">
                                        <button type="submit" class="btn-voy-primary">
                                            <i class="fas fa-save me-2"></i>Enregistrer le nouveau mot de passe
                                        </button>
                                        <button type="button" class="btn-voy-ghost" onclick="togglePasswordForm()">
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ── Fin mot de passe ── -->

        </div><!-- /row -->
    </main>
</div>

<!-- Styles CSS intégrés depuis le message précédent -->
<style>
.voy-layout, .voy-layout * { font-family: 'Poppins', sans-serif; }

.voy-layout {
    display: flex; gap: 28px; padding: 32px 24px;
    max-width: 1400px; margin: 0 auto;
    align-items: flex-start; background: #f7faf8; min-height: 100vh;
}
.voy-sidebar-wrap { width: 260px; flex-shrink: 0; }
.voy-main { flex: 1; min-width: 0; }

.voy-page-header {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 28px; flex-wrap: wrap; gap: 14px;
}
.voy-page-title { font-size: 1.5rem; font-weight: 700; color: #1a1a2e; margin: 0 0 4px; }
.voy-page-sub { font-size: 0.875rem; color: #888; margin: 0; }

.btn-voy-primary {
    background: linear-gradient(135deg, #008751, #00a862);
    color: white; border: none; border-radius: 50px;
    padding: 10px 22px; font-size: 0.875rem; font-weight: 600;
    transition: all 0.3s; box-shadow: 0 4px 14px rgba(0,135,81,0.25);
    white-space: nowrap; text-decoration: none; display: inline-flex; align-items: center; cursor: pointer;
}
.btn-voy-primary:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,135,81,0.35); }
.btn-voy-outline {
    border: 1.5px solid #008751; color: #008751; background: transparent;
    border-radius: 50px; padding: 6px 16px; font-size: 0.8rem; font-weight: 600;
    transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; cursor: pointer;
}
.btn-voy-outline:hover { background: #008751; color: white; }
.btn-voy-ghost {
    background: none; border: none; color: #aaa;
    font-size: 0.875rem; font-weight: 500; cursor: pointer;
    padding: 10px 16px; border-radius: 50px; transition: all 0.2s;
    font-family: 'Poppins', sans-serif;
}
.btn-voy-ghost:hover { background: #f5f5f5; color: #555; }
.btn-sm { padding: 5px 14px !important; font-size: 0.76rem !important; }
.voy-see-all { font-size: 0.75rem; font-weight: 600; color: #008751; text-decoration: none; display: inline-flex; align-items: center; }
.voy-see-all:hover { color: #005c37; }

.voy-alert {
    border-radius: 12px; padding: 13px 16px;
    font-size: 0.875rem; margin-bottom: 24px; display: flex; align-items: center;
}
.voy-alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #008751; }
.voy-alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }

.voy-card { background: white; border-radius: 18px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #f0f0f0; overflow: hidden; }
.voy-card-header { display: flex; justify-content: space-between; align-items: center; padding: 18px 22px; border-bottom: 1px solid #f5f5f5; }
.voy-card-header-left { display: flex; align-items: center; gap: 12px; }
.voy-card-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
.voy-card-title { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin: 0; }
.voy-card-sub { font-size: 0.75rem; color: #aaa; margin: 1px 0 0; }
.voy-card-body { padding: 22px; }

.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
.info-row { padding: 14px 0; border-bottom: 1px solid #f5f5f5; display: flex; flex-direction: column; gap: 4px; }
.info-row:nth-child(odd)  { padding-right: 24px; }
.info-row:nth-child(even) { padding-left: 24px; border-left: 1px solid #f5f5f5; }
.info-row:nth-last-child(-n+2) { border-bottom: none; }
.info-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #bbb; }
.info-value { font-size: 0.875rem; color: #1a1a2e; font-weight: 500; }

.role-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 50px; font-size: 0.72rem; font-weight: 700; }
.role-green  { background: rgba(0,135,81,0.1);  color: #008751; }
.role-yellow { background: rgba(245,158,11,0.1); color: #d97706; }
.role-red    { background: rgba(239,68,68,0.1);  color: #dc2626; }
.verified-ok { color: #008751; font-size: 0.85rem; display: inline-flex; align-items: center; }
.verified-no { color: #aaa;    font-size: 0.85rem; display: inline-flex; align-items: center; }

.mini-stat-card { background: #f7faf8; border-radius: 14px; border: 1px solid #f0f0f0; padding: 20px 16px; text-align: center; display: block; transition: all 0.2s; }
.mini-stat-card:hover { background: white; box-shadow: 0 6px 20px rgba(0,135,81,0.1); transform: translateY(-3px); }
.mini-stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; margin: 0 auto 10px; }
.mini-stat-num { font-size: 1.8rem; font-weight: 800; line-height: 1; margin-bottom: 4px; }
.mini-stat-lbl { font-size: 0.75rem; color: #888; font-weight: 500; }

.voy-list-item { display: flex; align-items: center; gap: 14px; padding: 13px 0; border-bottom: 1px solid #f5f5f5; }
.voy-list-item:last-child { border-bottom: none; }
.voy-thumb { width: 52px; height: 42px; border-radius: 10px; overflow: hidden; flex-shrink: 0; background: #f5f5f5; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 16px; }
.voy-thumb img { width: 100%; height: 100%; object-fit: cover; }
.voy-list-info { flex: 1; min-width: 0; }
.voy-list-name { font-size: 0.85rem; font-weight: 600; color: #1a1a2e; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.voy-list-meta { font-size: 0.75rem; color: #888; }
.voy-badge { display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 50px; font-size: 0.7rem; font-weight: 600; white-space: nowrap; flex-shrink: 0; }
.badge-green  { background: #d1fae5; color: #065f46; }
.badge-yellow { background: #fef3c7; color: #92400e; }
.badge-red    { background: #fee2e2; color: #991b1b; }
.badge-blue   { background: #dbeafe; color: #1e40af; }
.badge-gray   { background: #f3f4f6; color: #6b7280; }
.voy-fav-btn { width: 28px; height: 28px; border-radius: 8px; border: 1.5px solid #eee; background: transparent; display: flex; align-items: center; justify-content: center; color: #ccc; font-size: 11px; text-decoration: none; flex-shrink: 0; transition: all 0.2s; }
.voy-fav-btn:hover { background: #008751; border-color: #008751; color: white; }
.voy-empty { text-align: center; padding: 30px 16px; }
.voy-empty-icon { width: 52px; height: 52px; border-radius: 14px; background: #f5f5f5; color: #ccc; font-size: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
.voy-empty-text { font-size: 0.82rem; color: #aaa; margin: 0; }

/* ── Sécurité / Mot de passe ── */
.pwd-security-status {
    display: flex; align-items: center; gap: 20px;
    flex-wrap: wrap;
}
.pwd-status-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: rgba(139,92,246,0.1); color: #8b5cf6;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; flex-shrink: 0;
}
.pwd-status-title { font-size: 0.9rem; font-weight: 700; color: #1a1a2e; margin-bottom: 3px; }
.pwd-status-sub { font-size: 0.8rem; color: #888; }
.pwd-tips {
    display: flex; gap: 10px; flex-wrap: wrap; margin-left: auto;
}
.pwd-tip {
    display: inline-flex; align-items: center;
    background: #f5f5f5; color: #555;
    font-size: 0.72rem; font-weight: 500;
    padding: 4px 10px; border-radius: 50px;
}
.pwd-tip i { color: #008751; }

/* Champs mot de passe */
.pwd-label { font-size: 0.82rem; font-weight: 600; color: #444; margin-bottom: 6px; display: block; }
.pwd-input-wrap { position: relative; }
.pwd-input-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: #ccc; font-size: 13px; z-index: 1;
}
.pwd-input {
    width: 100%;
    border: 1.5px solid #e8e8e8; border-radius: 10px;
    padding: 11px 44px 11px 40px;
    font-size: 0.875rem; color: #1a1a2e;
    outline: none; transition: border-color 0.2s;
    font-family: 'Poppins', sans-serif;
    background: white;
}
.pwd-input:focus { border-color: #8b5cf6; box-shadow: 0 0 0 3px rgba(139,92,246,0.08); }
.pwd-input.is-invalid { border-color: #ef4444; }
.pwd-toggle {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: #bbb; cursor: pointer;
    font-size: 13px; padding: 4px; transition: color 0.2s;
}
.pwd-toggle:hover { color: #8b5cf6; }

.pwd-field-error { font-size: 0.75rem; color: #ef4444; margin-top: 5px; }

/* Barre de force */
.strength-bar-wrap { display: flex; align-items: center; gap: 10px; margin-top: 10px; }
.strength-bar { flex: 1; height: 5px; background: #f0f0f0; border-radius: 50px; overflow: hidden; }
.strength-fill { height: 100%; border-radius: 50px; transition: all 0.4s ease; width: 0%; }
.strength-label { font-size: 0.72rem; font-weight: 600; white-space: nowrap; }

/* Checklist règles */
.pwd-rules { display: grid; grid-template-columns: 1fr 1fr; gap: 5px; margin-top: 10px; }
.pwd-rule { font-size: 0.72rem; color: #bbb; transition: color 0.2s; }
.pwd-rule.ok { color: #008751; }
.pwd-rule.ok i { color: #008751; }

/* Message match */
.pwd-match-msg { font-size: 0.75rem; font-weight: 600; margin-top: 8px; }

/* Actions */
.pwd-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

@media (max-width: 991px) {
    .voy-layout { flex-direction: column; padding: 20px 16px; }
    .voy-sidebar-wrap { width: 100%; }
}
@media (max-width: 576px) {
    .info-grid { grid-template-columns: 1fr; }
    .info-row:nth-child(odd)  { padding-right: 0; }
    .info-row:nth-child(even) { padding-left: 0; border-left: none; }
    .voy-page-header { flex-direction: column; align-items: flex-start; }
    .pwd-rules { grid-template-columns: 1fr; }
    .pwd-tips { display: none; }
}
</style>

<script>
// ── Toggle affichage formulaire mot de passe ──
function togglePasswordForm() {
    const form    = document.getElementById('pwdForm');
    const def     = document.getElementById('pwdDefault');
    const btn     = document.getElementById('togglePwdForm');
    const visible = form.style.display !== 'none';

    if (visible) {
        form.style.display = 'none';
        def.style.display  = 'block';
        btn.innerHTML = '<i class="fas fa-key me-1"></i>Changer le mot de passe';
    } else {
        form.style.display = 'block';
        def.style.display  = 'none';
        btn.innerHTML = '<i class="fas fa-times me-1"></i>Annuler';
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

// ── Toggle affichage mot de passe (œil) ──
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// ── Vérification force du mot de passe ──
function checkStrength(val) {
    const wrap  = document.getElementById('strengthWrap');
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    const rules = document.getElementById('pwdRules');

    if (!val) {
        wrap.style.display = 'none';
        rules.style.display = 'none';
        return;
    }

    wrap.style.display = 'flex';
    rules.style.display = 'grid';

    const checks = {
        length:  val.length >= 8,
        upper:   /[A-Z]/.test(val),
        number:  /[0-9]/.test(val),
        special: /[^A-Za-z0-9]/.test(val),
    };

    // Mise à jour checklist
    Object.entries(checks).forEach(([key, ok]) => {
        const el = document.getElementById('rule-' + key);
        if (el) el.classList.toggle('ok', ok);
    });

    const score = Object.values(checks).filter(Boolean).length;
    const levels = [
        { pct: '25%', color: '#ef4444', text: 'Faible',     textColor: '#ef4444' },
        { pct: '50%', color: '#f59e0b', text: 'Moyen',      textColor: '#f59e0b' },
        { pct: '75%', color: '#3b82f6', text: 'Bon',        textColor: '#3b82f6' },
        { pct: '100%',color: '#008751', text: 'Excellent',  textColor: '#008751' },
    ];
    const lvl = levels[Math.max(0, score - 1)] ?? levels[0];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent     = lvl.text;
    label.style.color     = lvl.textColor;

    checkMatch();
}

// ── Vérification correspondance ──
function checkMatch() {
    const n = document.getElementById('pwd_nouveau')?.value || '';
    const c = document.getElementById('pwd_confirm')?.value || '';
    const msg = document.getElementById('matchMsg');

    if (!c) { 
        if (msg) msg.style.display = 'none'; 
        return; 
    }
    
    if (msg) {
        msg.style.display = 'block';
        if (n === c) {
            msg.textContent  = '✓ Les mots de passe correspondent';
            msg.style.color  = '#008751';
        } else {
            msg.textContent  = '✗ Les mots de passe ne correspondent pas';
            msg.style.color  = '#ef4444';
        }
    }
}

// ── Ouvrir automatiquement si erreurs de validation ──
<?php if (!empty($errors_pwd)): ?>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('pwdForm').style.display    = 'block';
    document.getElementById('pwdDefault').style.display = 'none';
    document.getElementById('togglePwdForm').innerHTML  = '<i class="fas fa-times me-1"></i>Annuler';
});
<?php endif; ?>
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
include dirname(__DIR__, 2) . '/layout/footer.php';
?>