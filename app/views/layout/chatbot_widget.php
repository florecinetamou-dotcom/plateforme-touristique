<!-- ══════════════════════════════════════
     WIDGET CHATBOT v2 — BeninExplore
     Inclure juste avant </body> dans footer.php
══════════════════════════════════════ -->

<!-- Bouton flottant -->
<button class="chat-fab" id="chatFab" onclick="toggleChat()" aria-label="Assistant BeninExplore">
    <span class="chat-fab-icon" id="fabIconOpen"><i class="fas fa-comments"></i></span>
    <span class="chat-fab-icon" id="fabIconClose" style="display:none"><i class="fas fa-times"></i></span>
    <span class="chat-fab-notif" id="chatNotif"></span>
</button>

<!-- Label flottant -->
<div class="chat-fab-label" id="chatFabLabel">💬 Besoin d'aide ?</div>

<!-- Fenêtre -->
<div class="chat-window" id="chatWindow">

    <!-- Header -->
    <div class="chat-header">
        <div class="chat-header-info">
            <div class="chat-avatar-wrap">
                <div class="chat-avatar">🤖</div>
                <span class="chat-status-dot"></span>
            </div>
            <div>
                <div class="chat-bot-name">Assistant BeninExplore</div>
                <div class="chat-bot-sub" id="chatStatusText">En ligne · Répond instantanément</div>
            </div>
        </div>
        <div class="chat-header-actions">
            <!-- Sélecteur de langue -->
            <button class="chat-lang-btn" id="langBtn" onclick="toggleLang()" title="Changer de langue">
                <span id="langFlag">🇫🇷</span>
            </button>
            <button class="chat-action-btn" onclick="clearHistory()" title="Effacer la conversation">
                <i class="fas fa-trash-alt"></i>
            </button>
            <button class="chat-action-btn" onclick="toggleChat()" title="Fermer">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Messages -->
    <div class="chat-messages" id="chatMessages"></div>

    <!-- Suggestions -->
    <div class="chat-suggestions-wrap" id="suggestionsWrap">
        <div class="chat-suggestions" id="chatSuggestions"></div>
    </div>

    <!-- Input -->
    <div class="chat-input-area">
        <div class="chat-input-row">
            <input type="text" class="chat-input" id="chatInput"
                   placeholder="Écrivez votre message..."
                   onkeydown="if(event.key==='Enter'&&!event.shiftKey){sendMessage();event.preventDefault()}">
            <button class="chat-send-btn" id="chatSendBtn" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
        <div class="chat-input-footer">
            <span>BeninExplore Assistant</span>
            <span id="charCount" style="color:#b0b8c4">0/200</span>
        </div>
    </div>

</div>

<style>
/* ══════════════════════════════════
   FAB
══════════════════════════════════ */
.chat-fab {
    position: fixed; bottom: 28px; right: 28px; z-index: 1000;
    width: 60px; height: 60px; border-radius: 50%;
    background: linear-gradient(135deg, #008751, #00a862);
    color: #fff; border: none; cursor: pointer;
    box-shadow: 0 6px 28px rgba(0,135,81,.5);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem; transition: all .3s;
}
.chat-fab:hover { transform: scale(1.1) rotate(-5deg); box-shadow: 0 10px 36px rgba(0,135,81,.6); }
.chat-fab:active { transform: scale(.95); }

.chat-fab-notif {
    position: absolute; top: -3px; right: -3px;
    width: 16px; height: 16px; border-radius: 50%;
    background: #E8112D; border: 2px solid #fff;
    display: none;
    animation: notifPop .3s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes notifPop { from{transform:scale(0)} to{transform:scale(1)} }

.chat-fab-label {
    position: fixed; bottom: 36px; right: 98px; z-index: 999;
    background: #fff; color: #0f1923;
    border-radius: 50px; padding: 7px 16px;
    font-size: .8rem; font-weight: 600;
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
    white-space: nowrap;
    animation: labelSlide 3s ease forwards;
    pointer-events: none;
}
@keyframes labelSlide {
    0%   { opacity:0; transform:translateX(10px); }
    15%  { opacity:1; transform:translateX(0); }
    75%  { opacity:1; }
    100% { opacity:0; }
}

/* ══════════════════════════════════
   WINDOW
══════════════════════════════════ */
.chat-window {
    position: fixed; bottom: 100px; right: 28px; z-index: 999;
    width: 370px; height: 560px;
    background: #fff; border-radius: 22px;
    box-shadow: 0 24px 70px rgba(0,0,0,.18), 0 0 0 1px rgba(0,0,0,.06);
    display: flex; flex-direction: column; overflow: hidden;
    transform: scale(.85) translateY(16px);
    opacity: 0; pointer-events: none;
    transform-origin: bottom right;
    transition: all .35s cubic-bezier(.34,1.56,.64,1);
}
.chat-window.open {
    transform: scale(1) translateY(0);
    opacity: 1; pointer-events: all;
}

/* ── Header ── */
.chat-header {
    background: linear-gradient(135deg, #008751 0%, #005c37 100%);
    padding: 14px 16px;
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.chat-header-info { display: flex; align-items: center; gap: 10px; }
.chat-avatar-wrap { position: relative; flex-shrink: 0; }
.chat-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(255,255,255,.18);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; border: 2px solid rgba(255,255,255,.25);
}
.chat-status-dot {
    position: absolute; bottom: 1px; right: 1px;
    width: 10px; height: 10px; border-radius: 50%;
    background: #4ade80; border: 2px solid #008751;
    animation: statusPulse 2.5s ease infinite;
}
@keyframes statusPulse { 0%,100%{box-shadow:0 0 0 0 rgba(74,222,128,.4)} 50%{box-shadow:0 0 0 5px rgba(74,222,128,0)} }
.chat-bot-name { color: #fff; font-weight: 700; font-size: .88rem; letter-spacing: -.01em; }
.chat-bot-sub  { color: rgba(255,255,255,.6); font-size: .68rem; margin-top: 1px; }

.chat-header-actions { display: flex; gap: 6px; align-items: center; }
.chat-action-btn, .chat-lang-btn {
    background: rgba(255,255,255,.12); border: none;
    color: rgba(255,255,255,.8); width: 30px; height: 30px; border-radius: 50%;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    font-size: .78rem; transition: all .2s;
}
.chat-action-btn:hover, .chat-lang-btn:hover { background: rgba(255,255,255,.25); color: #fff; }
.chat-lang-btn { font-size: .95rem; }

/* ── Messages ── */
.chat-messages {
    flex: 1; overflow-y: auto; padding: 16px 14px;
    display: flex; flex-direction: column; gap: 10px;
    scroll-behavior: smooth;
}
.chat-messages::-webkit-scrollbar { width: 3px; }
.chat-messages::-webkit-scrollbar-thumb { background: #E8EBF0; border-radius: 2px; }

.chat-msg { display: flex; align-items: flex-end; gap: 7px; }
.chat-msg--bot { flex-direction: row; }
.chat-msg--user { flex-direction: row-reverse; }

.chat-msg-av {
    width: 26px; height: 26px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #008751, #00a862);
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; color: #fff; margin-bottom: 2px;
}

.chat-msg-bubble {
    max-width: 80%; padding: 9px 13px;
    border-radius: 18px; font-size: .83rem; line-height: 1.65;
    animation: bubbleIn .22s ease both;
    word-break: break-word;
}
@keyframes bubbleIn { from{opacity:0;transform:translateY(6px) scale(.97)} to{opacity:1;transform:none} }

.chat-msg--bot  .chat-msg-bubble { background: #F4F6F8; color: #0f1923; border-bottom-left-radius: 5px; border: 1px solid #EEF0F3; }
.chat-msg--user .chat-msg-bubble { background: linear-gradient(135deg, #008751, #00a862); color: #fff; border-bottom-right-radius: 5px; }
.chat-msg--user .chat-msg-bubble a { color: #FFD600; }
.chat-msg--bot  .chat-msg-bubble a { color: #008751; font-weight: 600; }

/* Heure */
.chat-msg-time { font-size: .6rem; color: #b0b8c4; margin-top: 2px; text-align: center; align-self: flex-end; padding-bottom: 2px; }
.chat-msg--user .chat-msg-time { margin-right: 4px; }
.chat-msg--bot  .chat-msg-time { margin-left: 4px; }

/* Typing */
.chat-typing .chat-msg-bubble { padding: 11px 14px; display: flex; gap: 5px; align-items: center; }
.t-dot { width: 7px; height: 7px; border-radius: 50%; background: #b0b8c4; animation: typDot 1.1s ease infinite; }
.t-dot:nth-child(2) { animation-delay: .18s; }
.t-dot:nth-child(3) { animation-delay: .36s; }
@keyframes typDot { 0%,60%,100%{transform:translateY(0);opacity:.5} 30%{transform:translateY(-5px);opacity:1} }

/* Séparateur de date */
.chat-date-sep {
    text-align: center; font-size: .65rem; color: #b0b8c4;
    margin: 6px 0; position: relative;
}
.chat-date-sep::before, .chat-date-sep::after {
    content: ''; position: absolute; top: 50%; height: 1px;
    background: #EEF0F3; width: 35%;
}
.chat-date-sep::before { left: 0; }
.chat-date-sep::after  { right: 0; }

/* ── Suggestions ── */
.chat-suggestions-wrap {
    padding: 6px 14px 8px; border-top: 1px solid #F4F6F8;
    flex-shrink: 0;
}
.chat-suggestions { display: flex; flex-wrap: wrap; gap: 6px; }
.chat-suggestion {
    background: #fff; border: 1.5px solid #E8EBF0;
    color: #008751; border-radius: 50px;
    padding: 5px 13px; font-size: .74rem; font-weight: 600;
    cursor: pointer; transition: all .2s; white-space: nowrap;
    font-family: inherit;
}
.chat-suggestion:hover { background: #008751; color: #fff; border-color: #008751; transform: translateY(-1px); }

/* ── Input ── */
.chat-input-area {
    padding: 10px 14px 12px;
    border-top: 1px solid #F4F6F8;
    flex-shrink: 0; background: #fff;
}
.chat-input-row { display: flex; gap: 8px; align-items: center; }
.chat-input {
    flex: 1; border: 1.5px solid #E8EBF0; border-radius: 50px;
    padding: 9px 16px; font-size: .85rem;
    outline: none; transition: all .2s;
    font-family: inherit; color: #0f1923; background: #F7F8FA;
}
.chat-input:focus { border-color: #008751; background: #fff; box-shadow: 0 0 0 3px rgba(0,135,81,.08); }
.chat-input::placeholder { color: #c4cbd4; }
.chat-send-btn {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #008751, #00a862);
    color: #fff; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem; transition: all .2s;
    box-shadow: 0 4px 12px rgba(0,135,81,.3);
}
.chat-send-btn:hover { transform: scale(1.08); }
.chat-send-btn:disabled { opacity: .4; cursor: not-allowed; transform: none; }
.chat-input-footer {
    display: flex; justify-content: space-between;
    font-size: .62rem; color: #c4cbd4; margin-top: 5px; padding: 0 4px;
}

/* ── Responsive ── */
@media (max-width: 480px) {
    .chat-window { width: calc(100vw - 24px); right: 12px; bottom: 86px; height: 78vh; border-radius: 18px; }
    .chat-fab { bottom: 16px; right: 16px; }
    .chat-fab-label { display: none; }
}
</style>

<script>
(function() {
    let chatOpen  = false;
    let chatLang  = '<?= $_SESSION['chatbot_lang'] ?? 'fr' ?>';
    let isTyping  = false;

    const suggestions = {
        fr: [
            { label: '🏨 Hébergements',    msg: 'Hébergements disponibles' },
            { label: '🏛️ Sites',           msg: 'Sites touristiques à visiter' },
            { label: '🌍 Villes',           msg: 'Villes du Bénin' },
            { label: '💰 Prix',             msg: 'Quels sont les prix ?' },
            { label: '⭐ Recommandations',  msg: 'Que recommandez-vous ?' },
        ],
        en: [
            { label: '🏨 Accommodations',  msg: 'Available accommodations' },
            { label: '🏛️ Sites',           msg: 'Tourist sites to visit' },
            { label: '🌍 Cities',           msg: 'Cities in Benin' },
            { label: '💰 Prices',           msg: 'What are the prices?' },
            { label: '⭐ Recommendations', msg: 'What do you recommend?' },
        ],
    };

    // ── Init ──
    window.addEventListener('load', () => {
        renderSuggestions();
        addWelcomeMessage();
        loadHistory();

        // Compteur caractères
        document.getElementById('chatInput').addEventListener('input', function() {
            const n = this.value.length;
            document.getElementById('charCount').textContent = n + '/200';
            if (n > 180) document.getElementById('charCount').style.color = '#E8112D';
            else document.getElementById('charCount').style.color = '#b0b8c4';
            if (n > 200) this.value = this.value.substring(0, 200);
        });
    });

    function addWelcomeMessage() {
        const msgs = document.getElementById('chatMessages');
        if (msgs.children.length > 0) return;
        const text = chatLang === 'fr'
            ? "Bonjour ! 👋 Je suis votre assistant BeninExplore. Comment puis-je vous aider ?"
            : "Hello! 👋 I'm your BeninExplore assistant. How can I help you?";
        appendBotMsg(text);
    }

    function renderSuggestions() {
        const wrap = document.getElementById('chatSuggestions');
        wrap.innerHTML = '';
        suggestions[chatLang].forEach(s => {
            const btn = document.createElement('button');
            btn.className = 'chat-suggestion';
            btn.textContent = s.label;
            btn.onclick = () => sendSuggestion(s.msg);
            wrap.appendChild(btn);
        });
    }

    async function loadHistory() {
        try {
            const res  = await fetch('/chatbot/history');
            const data = await res.json();
            if (data.history && data.history.length > 2) {
                chatLang = data.lang || 'fr';
                updateLangUI();
                document.getElementById('chatMessages').innerHTML = '';
                data.history.forEach(m => {
                    if (m.role === 'user') appendUserMsg(m.text);
                    else appendBotMsg(m.text);
                });
            }
        } catch(e) {}
    }

    // ── Toggle ──
    window.toggleChat = function() {
        chatOpen = !chatOpen;
        const win = document.getElementById('chatWindow');
        win.classList.toggle('open', chatOpen);
        document.getElementById('fabIconOpen').style.display  = chatOpen ? 'none' : 'flex';
        document.getElementById('fabIconClose').style.display = chatOpen ? 'flex' : 'none';
        document.getElementById('chatFabLabel').style.display = 'none';
        if (chatOpen) {
            document.getElementById('chatNotif').style.display = 'none';
            setTimeout(() => document.getElementById('chatInput').focus(), 300);
            scrollToBottom();
        }
    };

    // ── Langue ──
    window.toggleLang = function() {
        chatLang = chatLang === 'fr' ? 'en' : 'fr';
        updateLangUI();
        renderSuggestions();
        sendAuto(chatLang === 'fr' ? 'passer au français' : 'switch to english');
    };

    function updateLangUI() {
        document.getElementById('langFlag').textContent = chatLang === 'fr' ? '🇫🇷' : '🇬🇧';
        document.getElementById('chatInput').placeholder = chatLang === 'fr' ? 'Écrivez votre message...' : 'Write your message...';
        document.getElementById('chatStatusText').textContent = chatLang === 'fr' ? 'En ligne · Répond instantanément' : 'Online · Instant replies';
    }

    // ── Effacer ──
    window.clearHistory = function() {
        document.getElementById('chatMessages').innerHTML = '';
        fetch('/chatbot/history', { method: 'DELETE' }).catch(() => {});
        sessionStorage.removeItem('chatHistory');
        addWelcomeMessage();
    };

    // ── Envoyer ──
    window.sendMessage = async function() {
        const input = document.getElementById('chatInput');
        const msg   = input.value.trim();
        if (!msg || isTyping) return;
        input.value = '';
        document.getElementById('charCount').textContent = '0/200';
        await sendAuto(msg);
    };

    window.sendSuggestion = async function(text) {
        document.getElementById('suggestionsWrap').style.display = 'none';
        await sendAuto(text);
    };

    async function sendAuto(msg) {
        if (isTyping) return;
        isTyping = true;

        appendUserMsg(msg);
        const typingId = showTyping();
        document.getElementById('chatSendBtn').disabled = true;

        try {
            const res  = await fetch('/chatbot/message', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: msg, lang: chatLang })
            });
            const data = await res.json();

            await new Promise(r => setTimeout(r, 400)); // délai réaliste
            removeTyping(typingId);

            if (data.lang && data.lang !== chatLang) {
                chatLang = data.lang;
                updateLangUI();
                renderSuggestions();
            }

            appendBotMsg(data.reponse || (chatLang === 'fr' ? "Désolé, une erreur s'est produite." : "Sorry, an error occurred."));

            // Badge si fermé
            if (!chatOpen) showNotif();

        } catch(e) {
            removeTyping(typingId);
            appendBotMsg(chatLang === 'fr' ? "Je suis temporairement indisponible. Réessayez dans quelques instants." : "I'm temporarily unavailable. Please try again.");
        }

        document.getElementById('chatSendBtn').disabled = false;
        isTyping = false;
        document.getElementById('chatInput').focus();
    }

    function appendUserMsg(text) {
        const msgs = document.getElementById('chatMessages');
        const wrap = document.createElement('div');
        wrap.className = 'chat-msg chat-msg--user';
        const bubble = document.createElement('div');
        bubble.className = 'chat-msg-bubble';
        bubble.textContent = text;
        const time = document.createElement('div');
        time.className = 'chat-msg-time';
        time.textContent = getTime();
        wrap.appendChild(bubble);
        wrap.appendChild(time);
        msgs.appendChild(wrap);
        scrollToBottom();
    }

    function appendBotMsg(text) {
        const msgs = document.getElementById('chatMessages');
        const wrap = document.createElement('div');
        wrap.className = 'chat-msg chat-msg--bot';
        const av = document.createElement('div');
        av.className = 'chat-msg-av';
        av.innerHTML = '<i class="fas fa-robot" style="font-size:.6rem"></i>';
        const bubble = document.createElement('div');
        bubble.className = 'chat-msg-bubble';
        bubble.innerHTML = formatText(text);
        const time = document.createElement('div');
        time.className = 'chat-msg-time';
        time.textContent = getTime();
        wrap.appendChild(av);
        wrap.appendChild(bubble);
        wrap.appendChild(time);
        msgs.appendChild(wrap);
        scrollToBottom();
    }

    function formatText(text) {
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" style="color:#008751;font-weight:600">$1</a>')
            .replace(/\n/g, '<br>');
    }

    function showTyping() {
        const msgs = document.getElementById('chatMessages');
        const id   = 'typ-' + Date.now();
        const wrap = document.createElement('div');
        wrap.className = 'chat-msg chat-msg--bot chat-typing';
        wrap.id = id;
        const av = document.createElement('div');
        av.className = 'chat-msg-av';
        av.innerHTML = '<i class="fas fa-robot" style="font-size:.6rem"></i>';
        const b = document.createElement('div');
        b.className = 'chat-msg-bubble';
        b.innerHTML = '<div class="t-dot"></div><div class="t-dot"></div><div class="t-dot"></div>';
        wrap.appendChild(av); wrap.appendChild(b);
        msgs.appendChild(wrap);
        scrollToBottom();
        return id;
    }

    function removeTyping(id) { document.getElementById(id)?.remove(); }

    function scrollToBottom() {
        const msgs = document.getElementById('chatMessages');
        setTimeout(() => msgs.scrollTop = msgs.scrollHeight, 50);
    }

    function showNotif() {
        const n = document.getElementById('chatNotif');
        n.style.display = 'block';
    }

    function getTime() {
        const d = new Date();
        return d.getHours().toString().padStart(2,'0') + ':' + d.getMinutes().toString().padStart(2,'0');
    }

    // Auto-afficher le label après 2s
    setTimeout(() => {
        if (!chatOpen) document.getElementById('chatFabLabel').style.display = 'block';
    }, 2000);
    setTimeout(() => {
        if (!chatOpen) showNotif();
    }, 5000);

})();
</script>