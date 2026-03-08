<?php
$conversations = $conversations ?? [];
$total         = $total         ?? 0;
$total_pages   = $total_pages   ?? 1;
$page          = $page          ?? 1;
$search        = $search        ?? '';
$badges        = $badges        ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversations Chatbot — Admin BeninExplore</title>
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
                <p class="label-tag">Chatbot</p>
                <h1 class="page-title">Conversations</h1>
                <p class="page-sub"><?= $total ?> message<?= $total > 1 ? 's' : '' ?> au total</p>
            </div>
            <a href="/admin/chatbot" class="btn-ghost">← Tableau de bord</a>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success">✅ <?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <!-- Filtre -->
        <form method="GET" class="filters-bar">
            <input type="text" name="search" placeholder="Rechercher dans les messages…"
                   value="<?= htmlspecialchars($search) ?>" class="filter-input">
            <button type="submit" class="btn-filter">Filtrer</button>
            <a href="/admin/chatbot/conversations" class="btn-reset">Réinitialiser</a>
        </form>

        <!-- Liste conversations -->
        <?php if (!empty($conversations)): ?>
        <div class="conv-full-list">
            <?php foreach ($conversations as $c): ?>
            <div class="conv-full-item">
                <div class="conv-full-meta">
                    <div class="conv-avatar-lg">
                        <?= $c->utilisateur_id ? strtoupper(substr($c->user_prenom ?? 'U', 0, 1)) : '?' ?>
                    </div>
                    <div>
                        <div class="conv-full-name">
                            <a href="/admin/chatbot/conversations/<?= urlencode($c->session_id) ?>"
                               style="color:#60a5fa;text-decoration:none;font-weight:600">
                                <?= $c->utilisateur_id
                                    ? htmlspecialchars(($c->user_prenom ?? '') . ' ' . ($c->user_nom ?? ''))
                                    : '<span class="anon">Visiteur anonyme</span>' ?>
                            </a>
                        </div>
                        <?php if ($c->utilisateur_id && !empty($c->user_email)): ?>
                        <div style="font-size:.7rem;color:#6b7280"><?= htmlspecialchars($c->user_email) ?></div>
                        <?php endif; ?>
                        <div class="conv-full-date">
                            Session: <code><?= htmlspecialchars(substr($c->session_id, 0, 16)) ?>…</code>
                            · <?= date('d/m/Y à H:i', strtotime($c->date_envoi)) ?>
                        </div>
                    </div>
                    <div style="margin-left:auto">
                        <form method="POST" action="/admin/chatbot/conversations/<?= $c->id ?>/supprimer"
                              onsubmit="return confirm('Supprimer ce message ?')">
                            <button type="submit" class="btn-icon btn-icon--red" title="Supprimer">🗑</button>
                        </form>
                    </div>
                </div>
                <div class="conv-full-messages">
                    <div class="msg msg--user">
                        <span class="msg-label">👤 Utilisateur</span>
                        <p><?= nl2br(htmlspecialchars($c->message_utilisateur)) ?></p>
                    </div>
                    <div class="msg msg--bot">
                        <span class="msg-label">🤖 Bot</span>
                        <p><?= nl2br(htmlspecialchars($c->reponse_bot)) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination" style="margin-top:20px">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
               class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="empty-state">
            <span>💬</span>
            <h3>Aucune conversation trouvée</h3>
            <p>Modifiez votre recherche ou attendez que des utilisateurs utilisent le chatbot.</p>
        </div>
        <?php endif; ?>

    </div>
</div>

<style>
.conv-full-list { display:flex; flex-direction:column; gap:14px; }
.conv-full-item {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
}
.conv-full-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid rgba(255,255,255,.05);
    background: rgba(255,255,255,.02);
}
.conv-avatar-lg {
    width:38px; height:38px; border-radius:50%;
    background:#008751;
    display:flex; align-items:center; justify-content:center;
    font-size:.85rem; font-weight:700; color:#fff; flex-shrink:0;
}
.conv-full-name { font-size:.85rem; font-weight:600; color:#fff; }
.anon { color:#6b7280; }
.conv-full-date { font-size:.7rem; color:#6b7280; margin-top:3px; }
.conv-full-date code { background:rgba(255,255,255,.06); padding:1px 6px; border-radius:4px; font-size:.68rem; }
.conv-full-messages { padding:14px 20px; display:flex; flex-direction:column; gap:10px; }
.msg { padding:10px 14px; border-radius:10px; }
.msg--user { background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.06); }
.msg--bot  { background:rgba(0,135,81,.07); border:1px solid rgba(0,135,81,.15); }
.msg-label { font-size:.65rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#6b7280; display:block; margin-bottom:5px; }
.msg p { font-size:.84rem; color:#d1d5db; line-height:1.65; margin:0; }
</style>

</body>
</html>