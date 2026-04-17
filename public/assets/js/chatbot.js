/**
 * chatbot.js — Frontend Chatbot Touristique Bénin
 * Consomme les réponses JSON du ChatbotController PHP
 * Aucune dépendance externe requise (Vanilla JS pur)
 */

const Chatbot = (() => {

    // ------------------------------------------------
    // CONFIGURATION — adaptez selon votre projet
    // ------------------------------------------------

    const CONFIG = {
        urlEnvoyer:     'index.php?action=envoyerMessage',  // URL POST messages
        urlInitialiser: 'index.php?action=initialiser',     // URL init conversation
        delaiTyping:    600,   // ms de délai "en train d'écrire..."
        delaiCartes:    300,   // ms entre chaque bloc de résultats
    };

    // ------------------------------------------------
    // ÉTAT INTERNE
    // ------------------------------------------------

    let _enCours = false;  // Empêche les doubles envois

    // ------------------------------------------------
    // INITIALISATION
    // ------------------------------------------------

    function init() {
        _bindEvents();
        _initialiserConversation();
    }

    function _bindEvents() {
        const form  = document.getElementById('chatbot-form');
        const input = document.getElementById('chatbot-input');

        if (form) {
            form.addEventListener('submit', e => {
                e.preventDefault();
                const msg = input.value.trim();
                if (msg) envoyerMessage(msg);
            });
        }

        if (input) {
            input.addEventListener('keydown', e => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    const msg = input.value.trim();
                    if (msg) envoyerMessage(msg);
                }
            });
        }
    }

    function _initialiserConversation() {
        fetch(CONFIG.urlInitialiser, { method: 'POST' })
            .then(r => r.json())
            .then(data => _afficherReponse(data))
            .catch(() => _afficherErreur());
    }

    // ------------------------------------------------
    // ENVOI D'UN MESSAGE (saisie libre)
    // ------------------------------------------------

    function envoyerMessage(texte) {
        if (_enCours || !texte) return;
        _enCours = true;

        _ajouterBubbleUser(texte);
        _viderInput();
        _afficherTyping();

        const body = new FormData();
        body.append('message', texte);

        setTimeout(() => {
            fetch(CONFIG.urlEnvoyer, { method: 'POST', body })
                .then(r => r.json())
                .then(data => {
                    _retirerTyping();
                    _afficherReponse(data);
                    _enCours = false;
                })
                .catch(() => {
                    _retirerTyping();
                    _afficherErreur();
                    _enCours = false;
                });
        }, CONFIG.delaiTyping);
    }

    // ------------------------------------------------
    // ENVOI D'UNE ACTION (bouton cliqué)
    // ------------------------------------------------

    function envoyerAction(valeur) {
        if (_enCours) return;
        _enCours = true;

        _ajouterBubbleUser(valeur);
        _desactiverBoutons();
        _afficherTyping();

        const body = new FormData();
        body.append('action', valeur);

        setTimeout(() => {
            fetch(CONFIG.urlEnvoyer, { method: 'POST', body })
                .then(r => r.json())
                .then(data => {
                    _retirerTyping();
                    _afficherReponse(data);
                    _enCours = false;
                })
                .catch(() => {
                    _retirerTyping();
                    _afficherErreur();
                    _enCours = false;
                });
        }, CONFIG.delaiTyping);
    }

    // ------------------------------------------------
    // AFFICHAGE DES RÉPONSES SELON LE TYPE
    // ------------------------------------------------

    function _afficherReponse(data) {
        if (!data) return;

        const type = data.type || 'texte';

        switch (type) {

            case 'boutons':
                _ajouterBubbleBot(data.reponse);
                if (data.options?.length) {
                    _ajouterBoutons(data.options);
                }
                break;

            case 'resultats':
                _ajouterBubbleBot(data.reponse);
                setTimeout(() => {
                    if (data.resume)         _ajouterResume(data.resume);
                }, CONFIG.delaiCartes);
                setTimeout(() => {
                    if (data.hotels?.length) _ajouterCartesHotels(data.hotels);
                }, CONFIG.delaiCartes * 2);
                setTimeout(() => {
                    if (data.sites?.length)  _ajouterCartesSites(data.sites);
                }, CONFIG.delaiCartes * 3);
                setTimeout(() => {
                    if (data.options?.length) _ajouterBoutons(data.options);
                }, CONFIG.delaiCartes * 4);
                break;

            case 'hotels':
                _ajouterBubbleBot(data.reponse);
                setTimeout(() => {
                    if (data.hotels?.length) _ajouterCartesHotels(data.hotels);
                    if (data.options?.length) setTimeout(() => _ajouterBoutons(data.options), CONFIG.delaiCartes);
                }, CONFIG.delaiCartes);
                break;

            case 'sites':
                _ajouterBubbleBot(data.reponse);
                setTimeout(() => {
                    if (data.sites?.length)  _ajouterCartesSites(data.sites);
                    if (data.options?.length) setTimeout(() => _ajouterBoutons(data.options), CONFIG.delaiCartes);
                }, CONFIG.delaiCartes);
                break;

            case 'texte':
            default:
                _ajouterBubbleBot(data.reponse);
                if (data.options?.length) {
                    _ajouterBoutons(data.options);
                }
                break;
        }

        _scrollBas();
    }

    // ------------------------------------------------
    // CONSTRUCTION DES ÉLÉMENTS DOM
    // ------------------------------------------------

    function _ajouterBubbleUser(texte) {
        const msgs = _getMsgs();
        const div = document.createElement('div');
        div.className = 'chatbot-msg chatbot-msg--user';
        div.innerHTML = `<div class="chatbot-bubble chatbot-bubble--user">${_esc(texte)}</div>`;
        msgs.appendChild(div);
        _scrollBas();
    }

    function _ajouterBubbleBot(texte) {
        const msgs = _getMsgs();
        const div = document.createElement('div');
        div.className = 'chatbot-msg chatbot-msg--bot';
        // Supporte le gras **texte** et les sauts de ligne \n
        const html = _esc(texte)
            .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');
        div.innerHTML = `
            <div class="chatbot-avatar">🧭</div>
            <div class="chatbot-bubble chatbot-bubble--bot">${html}</div>`;
        msgs.appendChild(div);
        _scrollBas();
        return div;
    }

    function _ajouterBoutons(options) {
        const msgs = _getMsgs();
        const div = document.createElement('div');
        div.className = 'chatbot-msg chatbot-msg--bot chatbot-msg--boutons';
        const btns = options.map(opt => `
            <button class="chatbot-chip" onclick="Chatbot.envoyerAction('${_esc(opt)}')">
                ${_esc(opt)}
            </button>`).join('');
        div.innerHTML = `<div class="chatbot-chips">${btns}</div>`;
        msgs.appendChild(div);
        _scrollBas();
    }

    function _ajouterResume(resume) {
        const msgs = _getMsgs();
        const budgetIcon = {Économique:'💰', Moyen:'💳', Luxe:'💎'}[resume.budget] || '💳';
        const activiteIcon = {culture:'🏛️', nature:'🌿', gastronomie:'🍽️', detente:'🛁'}[resume.activite] || '📍';
        const div = document.createElement('div');
        div.className = 'chatbot-msg chatbot-msg--bot';
        div.innerHTML = `
            <div class="chatbot-avatar">🧭</div>
            <div class="chatbot-resume">
                <div class="chatbot-resume__row"><span>📍 Destination</span><strong>${_esc(resume.ville)}</strong></div>
                <div class="chatbot-resume__row"><span>🗓️ Durée</span><strong>${_esc(resume.duree)}</strong></div>
                <div class="chatbot-resume__row"><span>${budgetIcon} Budget</span><strong>${_esc(resume.budget)}</strong></div>
                <div class="chatbot-resume__row"><span>${activiteIcon} Activités</span><strong>${_esc(resume.activite)}</strong></div>
            </div>`;
        msgs.appendChild(div);
        _scrollBas();
    }

    function _ajouterCartesHotels(hotels) {
        const msgs = _getMsgs();
        const div = document.createElement('div');
        div.className = 'chatbot-msg chatbot-msg--bot';
        const cartes = hotels.map(h => {
            const etoiles = '⭐'.repeat(h.etoiles || 0);
            return `
            <div class="chatbot-card">
                <div class="chatbot-card__stars">${etoiles}</div>
                <div class="chatbot-card__nom">${_esc(h.nom)}</div>
                <div class="chatbot-card__desc">${_esc(h.desc)}</div>
                <div class="chatbot-card__prix">${_esc(h.prix)}</div>
            </div>`;
        }).join('');
        div.innerHTML = `
            <div class="chatbot-avatar">🧭</div>
            <div class="chatbot-bubble chatbot-bubble--bot">
                <strong>🏨 Hébergements recommandés</strong>
                <div class="chatbot-cards">${cartes}</div>
            </div>`;
        msgs.appendChild(div);
        _scrollBas();
    }

    function _ajouterCartesSites(sites) {
        const msgs = _getMsgs();
        const div = document.createElement('div');
        div.className = 'chatbot-msg chatbot-msg--bot';
        const cartes = sites.map(s => `
            <div class="chatbot-card">
                <div class="chatbot-card__nom">${_esc(s.nom)}</div>
                <div class="chatbot-card__desc">${_esc(s.desc)}</div>
                <div class="chatbot-card__meta">
                    🕐 ${_esc(s.horaires)} &nbsp;·&nbsp; 🎟️ ${_esc(s.tarif)}
                </div>
            </div>`).join('');
        div.innerHTML = `
            <div class="chatbot-avatar">🧭</div>
            <div class="chatbot-bubble chatbot-bubble--bot">
                <strong>📍 Sites touristiques</strong>
                <div class="chatbot-cards">${cartes}</div>
            </div>`;
        msgs.appendChild(div);
        _scrollBas();
    }

    // ------------------------------------------------
    // TYPING INDICATOR
    // ------------------------------------------------

    function _afficherTyping() {
        const msgs = _getMsgs();
        const div = document.createElement('div');
        div.className = 'chatbot-msg chatbot-msg--bot';
        div.id = 'chatbot-typing';
        div.innerHTML = `
            <div class="chatbot-avatar">🧭</div>
            <div class="chatbot-typing">
                <span></span><span></span><span></span>
            </div>`;
        msgs.appendChild(div);
        _scrollBas();
    }

    function _retirerTyping() {
        document.getElementById('chatbot-typing')?.remove();
    }

    // ------------------------------------------------
    // UTILITAIRES DOM
    // ------------------------------------------------

    function _getMsgs() {
        return document.getElementById('chatbot-messages');
    }

    function _viderInput() {
        const input = document.getElementById('chatbot-input');
        if (input) { input.value = ''; input.style.height = 'auto'; }
    }

    function _desactiverBoutons() {
        document.querySelectorAll('.chatbot-chip').forEach(b => {
            b.disabled = true;
            b.style.opacity = '0.5';
            b.style.cursor = 'not-allowed';
        });
    }

    function _scrollBas() {
        const msgs = _getMsgs();
        if (msgs) setTimeout(() => msgs.scrollTop = msgs.scrollHeight, 50);
    }

    function _afficherErreur() {
        _ajouterBubbleBot("Une erreur est survenue 😕 Veuillez réessayer.");
    }

    function _esc(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // ------------------------------------------------
    // API PUBLIQUE
    // ------------------------------------------------

    return { init, envoyerMessage, envoyerAction };

})();

// Lancement automatique au chargement de la page
document.addEventListener('DOMContentLoaded', () => Chatbot.init());