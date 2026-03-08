<?php
$total_conv       = $total_conv       ?? 0;
$conv_today       = $conv_today       ?? 0;
$total_intentions = $total_intentions ?? 0;
$conv_connectes   = $conv_connectes   ?? 0;
$conversations    = $conversations    ?? [];
$intentions       = $intentions       ?? [];
$badges           = $badges           ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot — Admin BeninExplore</title>
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
                <p class="label-tag">Outils</p>
                <h1 class="page-title">Chatbot</h1>
                <p class="page-sub">Gestion des intentions et suivi des conversations</p>
            </div>
            <div style="display:flex;gap:10px">
                <a href="/admin/chatbot/conversations" class="btn-ghost">💬 Conversations</a>
                <a href="/admin/chatbot/intentions" class="btn-primary">🧠 Gérer les intentions</a>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error">❌ <?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="bot-stats">
            <div class="bot-stat">
                <div class="bot-stat__icon">💬</div>
                <div class="bot-stat__val"><?= $total_conv ?></div>
                <div class="bot-stat__label">Conversations totales</div>
            </div>
            <div class="bot-stat">
                <div class="bot-stat__icon">📅</div>
                <div class="bot-stat__val" style="color:#4ade80"><?= $conv_today ?></div>
                <div class="bot-stat__label">Aujourd'hui</div>
            </div>
            <div class="bot-stat">
                <div class="bot-stat__icon">🧠</div>
                <div class="bot-stat__val" style="color:#FFD600"><?= $total_intentions ?></div>
                <div class="bot-stat__label">Intentions configurées</div>
            </div>
            <div class="bot-stat">
                <div class="bot-stat__icon">👤</div>
                <div class="bot-stat__val" style="color:#60a5fa"><?= $conv_connectes ?></div>
                <div class="bot-stat__label">Utilisateurs connectés</div>
            </div>
        </div>

        <div class="bot-layout">

            <!-- Dernières conversations -->
            <div class="table-card">
                <div class="panel-head">
                    <h3>💬 Dernières conversations</h3>
                    <a href="/admin/chatbot/conversations" class="link-more">Voir tout →</a>
                </div>

                <?php if (!empty($conversations)): ?>
                <div class="conv-list">
                    <?php foreach ($conversations as $c): ?>
                    <div class="conv-item">
                        <div class="conv-item__user">
                            <div class="conv-avatar">
                                <?= $c->utilisateur_id
                                    ? strtoupper(substr($c->user_prenom ?? 'U', 0, 1))
                                    : '?' ?>
                            </div>
                            <div>
                                <div class="conv-item__name">
                                    <?= $c->utilisateur_id
                                        ? htmlspecialchars(($c->user_prenom ?? '') . ' ' . ($c->user_nom ?? ''))
                                        : '<span style="color:#6b7280">Visiteur anonyme</span>' ?>
                                </div>
                                <div class="conv-item__date">
                                    <?= date('d/m/Y H:i', strtotime($c->date_envoi)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="conv-item__messages">
                            <div class="conv-bubble conv-bubble--user">
                                👤 <?= htmlspecialchars(mb_substr($c->message_utilisateur, 0, 80)) ?>
                                <?= mb_strlen($c->message_utilisateur) > 80 ? '…' : '' ?>
                            </div>
                            <div class="conv-bubble conv-bubble--bot">
                                🤖 <?= htmlspecialchars(mb_substr($c->reponse_bot, 0, 100)) ?>
                                <?= mb_strlen($c->reponse_bot) > 100 ? '…' : '' ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Vider les conversations -->
                <div style="padding:16px 20px;border-top:1px solid var(--border)">
                    <form method="POST" action="/admin/chatbot/vider"
                          onsubmit="return confirm('Supprimer TOUTES les conversations ? Cette action est irréversible.')">
                        <button type="submit" class="btn-danger-sm">🗑 Vider toutes les conversations</button>
                    </form>
                </div>

                <?php else: ?>
                <div class="empty-state" style="padding:40px">
                    <span>💬</span>
                    <h3>Aucune conversation</h3>
                    <p>Le chatbot n'a pas encore été utilisé.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Intentions -->
            <div class="table-card">
                <div class="panel-head">
                    <h3>🧠 Intentions actives</h3>
                    <a href="/admin/chatbot/intentions" class="link-more">Gérer →</a>
                </div>

                <?php if (!empty($intentions)): ?>
                <div style="padding:8px 0">
                    <?php foreach ($intentions as $i): ?>
                    <div class="intention-row">
                        <div class="intention-kw">
                            <span class="kw-badge"><?= htmlspecialchars($i->mot_cle) ?></span>
                            <?php if ($i->nb_declenchements > 0): ?>
                            <span class="kw-count"><?= $i->nb_declenchements ?>x</span>
                            <?php endif; ?>
                        </div>
                        <div class="intention-rep">
                            <?= htmlspecialchars(mb_substr($i->reponse_texte ?? '—', 0, 70)) ?>
                            <?= mb_strlen($i->reponse_texte ?? '') > 70 ? '…' : '' ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="empty-state" style="padding:40px">
                    <span>🧠</span>
                    <h3>Aucune intention</h3>
                    <p>Ajoutez des intentions pour que le bot puisse répondre.</p>
                </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>

<style>
/* Stats */
.bot-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.bot-stat {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}
.bot-stat__icon  { font-size: 1.6rem; margin-bottom: 8px; }
.bot-stat__val   { font-size: 2rem; font-weight: 800; color: #fff; line-height: 1; }
.bot-stat__label { font-size: .72rem; color: #6b7280; margin-top: 5px; }

/* Layout */
.bot-layout { display: grid; grid-template-columns: 1fr 380px; gap: 20px; }

/* Panel head */
.panel-head { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid var(--border); }
.panel-head h3 { font-size:.85rem; font-weight:700; color:#fff; }
.link-more { font-size:.75rem; color:#60a5fa; text-decoration:none; font-weight:600; }
.link-more:hover { color:#93c5fd; }

/* Conversations */
.conv-list { max-height: 460px; overflow-y: auto; }
.conv-item {
    padding: 14px 20px;
    border-bottom: 1px solid rgba(255,255,255,.04);
}
.conv-item:last-child { border-bottom: none; }
.conv-item__user { display:flex; align-items:center; gap:10px; margin-bottom:10px; }
.conv-avatar {
    width:32px; height:32px; border-radius:50%;
    background: #008751;
    display:flex; align-items:center; justify-content:center;
    font-size:.75rem; font-weight:700; color:#fff; flex-shrink:0;
}
.conv-item__name { font-size:.82rem; font-weight:600; color:#fff; }
.conv-item__date { font-size:.7rem; color:#6b7280; margin-top:1px; }
.conv-item__messages { display:flex; flex-direction:column; gap:6px; padding-left:42px; }
.conv-bubble {
    padding: 7px 12px;
    border-radius: 10px;
    font-size: .78rem;
    line-height: 1.5;
}
.conv-bubble--user { background:rgba(255,255,255,.05); color:#9ca3af; }
.conv-bubble--bot  { background:rgba(0,135,81,.08); color:#6ee7b7; border:1px solid rgba(0,135,81,.15); }

/* Intentions */
.intention-row { padding:12px 20px; border-bottom:1px solid rgba(255,255,255,.04); }
.intention-row:last-child { border-bottom:none; }
.intention-kw { display:flex; align-items:center; gap:8px; margin-bottom:5px; }
.kw-badge { background:rgba(139,92,246,.15); color:#a78bfa; font-size:.72rem; font-weight:700; padding:3px 10px; border-radius:20px; font-family:monospace; }
.kw-count { font-size:.68rem; color:#6b7280; }
.intention-rep { font-size:.78rem; color:#6b7280; line-height:1.5; }

.btn-danger-sm {
    background: rgba(232,17,45,.1);
    border: 1px solid rgba(232,17,45,.2);
    border-radius: 8px;
    color: #f87171;
    font-family: 'Poppins', sans-serif;
    font-size: .78rem;
    font-weight: 600;
    padding: 7px 16px;
    cursor: pointer;
    transition: all .2s;
}
.btn-danger-sm:hover { background:#E8112D; color:#fff; border-color:#E8112D; }

@media (max-width:1100px) { .bot-layout { grid-template-columns:1fr; } }
@media (max-width:768px)  { .bot-stats  { grid-template-columns:repeat(2,1fr); } }
</style>

</body>
</html>