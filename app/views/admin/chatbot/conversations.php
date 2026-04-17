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

        <!-- En-tête -->
        <div class="page-head">
            <div>
                <p class="label-tag">Chatbot</p>
                <h1 class="page-title">Conversations</h1>
                <p class="page-sub"><?= $total ?> message<?= $total > 1 ? 's' : '' ?> au total</p>
            </div>
            <div style="display:flex;gap:10px;align-items:center">
                <a href="/admin/chatbot" class="btn-ghost">← Dashboard</a>
                <form method="POST" action="/admin/chatbot/vider"
                      onsubmit="return confirm('Supprimer TOUTES les conversations ? Cette action est irréversible.')">
                    <button type="submit" class="btn-danger-sm">🗑 Tout vider</button>
                </form>
            </div>
        </div>

        <!-- Alertes -->
        <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert--success"><?= htmlspecialchars($_SESSION['success']) ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert--error"><?= htmlspecialchars($_SESSION['error']) ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Recherche -->
        <form method="GET" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
            <input type="text" name="search" placeholder="Rechercher dans les messages…"
                   value="<?= htmlspecialchars($search) ?>" class="filter-input" style="flex:1;min-width:200px">
            <button type="submit" class="btn-filter">Rechercher</button>
            <?php if ($search): ?>
            <a href="/admin/chatbot/conversations" class="btn-reset">Réinitialiser</a>
            <?php endif; ?>
        </form>

        <!-- Table -->
        <div class="table-card">
            <?php if (!empty($conversations)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>Message</th>
                        <th>Réponse bot</th>
                        <th>Session</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($conversations as $c): ?>
                    <tr>
                        <td style="white-space:nowrap;font-size:.75rem;color:#6b7280">
                            <?= date('d/m/Y', strtotime($c->date_envoi)) ?><br>
                            <span style="color:#9ca3af"><?= date('H:i', strtotime($c->date_envoi)) ?></span>
                        </td>
                        <td>
                            <?php if ($c->utilisateur_id): ?>
                            <div style="font-size:.82rem;font-weight:600;color:#e5e7eb">
                                <?= htmlspecialchars($c->user_prenom . ' ' . $c->user_nom) ?>
                            </div>
                            <div style="font-size:.7rem;color:#6b7280"><?= htmlspecialchars($c->user_email ?? '') ?></div>
                            <?php else: ?>
                            <span style="font-size:.75rem;color:#6b7280">👤 Anonyme</span>
                            <?php endif; ?>
                        </td>
                        <td style="max-width:220px">
                            <div class="msg-bubble msg-user">
                                <?= htmlspecialchars(mb_substr($c->message_utilisateur, 0, 100)) ?>
                                <?= mb_strlen($c->message_utilisateur) > 100 ? '…' : '' ?>
                            </div>
                        </td>
                        <td style="max-width:260px">
                            <div class="msg-bubble msg-bot">
                                <?= htmlspecialchars(mb_substr($c->reponse_bot, 0, 120)) ?>
                                <?= mb_strlen($c->reponse_bot) > 120 ? '…' : '' ?>
                            </div>
                        </td>
                        <td>
                            <a href="/admin/chatbot/conversations/<?= urlencode($c->session_id) ?>"
                               class="session-link" title="<?= htmlspecialchars($c->session_id) ?>">
                                <?= htmlspecialchars(substr($c->session_id, 0, 12)) ?>…
                            </a>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="/admin/chatbot/conversations/<?= urlencode($c->session_id) ?>"
                                   class="btn-icon" title="Voir la session">👁</a>
                                <form method="POST" action="/admin/chatbot/conversations/<?= $c->id ?>/supprimer"
                                      style="display:inline"
                                      onsubmit="return confirm('Supprimer ce message ?')">
                                    <button type="submit" class="btn-icon btn-icon--red" title="Supprimer">🗑</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
                   class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="empty-state">
                <span>💬</span>
                <h3>Aucune conversation</h3>
                <p><?= $search ? 'Aucun résultat pour "' . htmlspecialchars($search) . '".' : 'Le chatbot n\'a pas encore reçu de messages.' ?></p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
.btn-danger-sm {
    background: rgba(232,17,45,.15); color: #f87171;
    border: 1px solid rgba(232,17,45,.3); border-radius: 8px;
    padding: 8px 16px; font-size: .82rem; font-weight: 600;
    cursor: pointer; font-family: 'Poppins', sans-serif; transition: all .2s;
}
.btn-danger-sm:hover { background: #E8112D; color: #fff; }

.msg-bubble {
    font-size: .78rem; line-height: 1.5; padding: 7px 10px;
    border-radius: 10px; display: inline-block; max-width: 100%;
    word-break: break-word;
}
.msg-user { background: rgba(59,158,255,.1); color: #93c5fd; border: 1px solid rgba(59,158,255,.2); }
.msg-bot  { background: rgba(0,135,81,.1);  color: #4ade80; border: 1px solid rgba(0,135,81,.2);  }

.session-link {
    font-family: monospace; font-size: .72rem; color: #6b7280;
    background: rgba(255,255,255,.05); padding: 3px 8px; border-radius: 6px;
    text-decoration: none; border: 1px solid rgba(255,255,255,.08); transition: color .2s;
}
.session-link:hover { color: #4ade80; border-color: rgba(0,135,81,.3); }
</style>

</body>
</html> 