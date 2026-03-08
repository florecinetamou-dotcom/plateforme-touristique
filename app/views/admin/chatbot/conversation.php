<?php
$messages   = $messages   ?? [];
$session_id = $session_id ?? '';
$badges     = $badges     ?? [];

$first     = $messages[0] ?? null;
$userName  = $first && $first->utilisateur_id
    ? htmlspecialchars(($first->user_prenom ?? '') . ' ' . ($first->user_nom ?? ''))
    : 'Visiteur anonyme';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation — Admin BeninExplore</title>
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
                <h1 class="page-title">Conversation</h1>
                <p class="page-sub">
                    <?= $userName ?> ·
                    Session <code style="background:rgba(255,255,255,.07);padding:2px 8px;border-radius:5px;font-size:.75rem">
                        <?= htmlspecialchars(substr($session_id, 0, 16)) ?>…
                    </code>
                </p>
            </div>
            <a href="/admin/chatbot/conversations" class="btn-ghost">← Retour</a>
        </div>

        <!-- Chat -->
        <div class="chat-wrap">
            <div class="chat-header">
                <div class="chat-avatar">
                    <?= $first && $first->utilisateur_id
                        ? strtoupper(substr($first->user_prenom ?? 'U', 0, 1))
                        : '?' ?>
                </div>
                <div>
                    <div class="chat-header__name"><?= $userName ?></div>
                    <div class="chat-header__count"><?= count($messages) ?> échange<?= count($messages) > 1 ? 's' : '' ?></div>
                </div>
            </div>

            <div class="chat-body">
                <?php foreach ($messages as $m): ?>

                <!-- Message utilisateur -->
                <div class="chat-row chat-row--user">
                    <div class="bubble bubble--user">
                        <p><?= nl2br(htmlspecialchars($m->message_utilisateur)) ?></p>
                        <span class="bubble-time"><?= date('H:i', strtotime($m->date_envoi)) ?></span>
                    </div>
                </div>

                <!-- Réponse bot -->
                <div class="chat-row chat-row--bot">
                    <div class="bot-icon">🤖</div>
                    <div class="bubble bubble--bot">
                        <span class="bubble-author">BeninExplore Bot</span>
                        <p><?= nl2br(htmlspecialchars($m->reponse_bot)) ?></p>
                        <span class="bubble-time"><?= date('H:i', strtotime($m->date_envoi)) ?></span>
                    </div>
                </div>

                <?php endforeach; ?>
            </div>

            <div class="chat-footer">
                <span style="font-size:.72rem;color:#6b7280">
                    Début : <?= $first ? date('d/m/Y à H:i', strtotime($first->date_envoi)) : '—' ?>
                </span>
                <form method="POST" action="/admin/chatbot/conversations/<?= $first->id ?? 0 ?>/supprimer"
                      onsubmit="return confirm('Supprimer cette conversation ?')">
                    <button type="submit" class="btn-danger-sm">🗑 Supprimer</button>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
.chat-wrap {
    max-width: 720px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
}

/* Header */
.chat-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 24px;
    border-bottom: 1px solid var(--border);
    background: rgba(255,255,255,.02);
}
.chat-avatar {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: #008751;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 700; color: #fff;
}
.chat-header__name  { font-size: .9rem; font-weight: 700; color: #fff; }
.chat-header__count { font-size: .72rem; color: #6b7280; margin-top: 2px; }

/* Body */
.chat-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    max-height: 560px;
    overflow-y: auto;
}

/* Rows */
.chat-row { display: flex; align-items: flex-end; gap: 10px; }
.chat-row--user { flex-direction: row-reverse; }
.chat-row--bot  { flex-direction: row; }

.bot-icon { font-size: 1.4rem; flex-shrink: 0; margin-bottom: 4px; }

/* Bubbles */
.bubble {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 16px;
    position: relative;
}
.bubble p { font-size: .88rem; line-height: 1.65; margin: 0; }
.bubble-time {
    display: block;
    font-size: .65rem;
    margin-top: 6px;
    opacity: .5;
    text-align: right;
}
.bubble-author {
    display: block;
    font-size: .68rem;
    font-weight: 700;
    color: #4ade80;
    margin-bottom: 5px;
    letter-spacing: .04em;
}

.bubble--user {
    background: #008751;
    color: #fff;
    border-bottom-right-radius: 4px;
}
.bubble--bot {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.08);
    color: #d1d5db;
    border-bottom-left-radius: 4px;
}

/* Footer */
.chat-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 24px;
    border-top: 1px solid var(--border);
    background: rgba(255,255,255,.01);
}
.btn-danger-sm {
    background: rgba(232,17,45,.1);
    border: 1px solid rgba(232,17,45,.2);
    border-radius: 8px;
    color: #f87171;
    font-family: 'Poppins', sans-serif;
    font-size: .75rem;
    font-weight: 600;
    padding: 6px 14px;
    cursor: pointer;
    transition: all .2s;
}
.btn-danger-sm:hover { background: #E8112D; color: #fff; border-color: #E8112D; }
</style>

</body>
</html>