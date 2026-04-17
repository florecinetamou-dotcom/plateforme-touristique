<!-- =============================================
     chatbot_view.php — Vue Chatbot Touristique Bénin
     À inclure dans votre layout principal
     ============================================= -->

<!-- Liens CSS -->
<link rel="stylesheet" href="public/css/chatbot.css">

<!-- Widget Chatbot -->
<div id="chatbot-widget">

    <!-- En-tête -->
    <div id="chatbot-header">
        <div class="chatbot-logo">🌍</div>
        <div class="chatbot-header-info">
            <div class="chatbot-header-nom">Guide Touristique Bénin</div>
            <div class="chatbot-header-sous">Votre assistant voyage</div>
        </div>
        <div class="chatbot-status">
            <div class="chatbot-status-dot"></div>
            En ligne
        </div>
    </div>

    <!-- Zone de messages -->
    <div id="chatbot-messages"></div>

    <!-- Zone de saisie -->
    <form id="chatbot-form">
        <div id="chatbot-footer">
            <textarea
                id="chatbot-input"
                placeholder="Posez votre question..."
                rows="1"
                oninput="this.style.height='auto'; this.style.height=Math.min(this.scrollHeight,80)+'px'"
            ></textarea>
            <button type="submit" id="chatbot-send" title="Envoyer">
                <svg viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </div>
    </form>

</div>

<!-- Script JS -->
<script src="public/js/chatbot.js"></script>

<!-- =============================================
     ROUTES À AJOUTER dans votre routeur PHP

     GET  /chatbot              → ChatbotController::afficher()
     POST /chatbot/initialiser  → ChatbotController::initialiser()
     POST /chatbot/message      → ChatbotController::envoyerMessage()

     Exemple avec index.php?action=... :

     case 'initialiser':
         $controller->initialiser();
         break;

     case 'envoyerMessage':
         $controller->envoyerMessage();
         break;

     SQL : table chatbot_conversations
     -----------------------------------
     CREATE TABLE IF NOT EXISTS chatbot_conversations (
         id               INT AUTO_INCREMENT PRIMARY KEY,
         message_utilisateur TEXT NOT NULL,
         reponse_bot         TEXT NOT NULL,
         date_envoi          DATETIME DEFAULT CURRENT_TIMESTAMP
     );

     SQL : table chatbot_intentions (optionnelle, fallback)
     -------------------------------------------------------
     CREATE TABLE IF NOT EXISTS chatbot_intentions (
         id            INT AUTO_INCREMENT PRIMARY KEY,
         mot_cle       VARCHAR(255) NOT NULL,
         reponse_texte TEXT NOT NULL
     );

     Exemple de données :
     INSERT INTO chatbot_intentions (mot_cle, reponse_texte) VALUES
     ('vaudou,vodou,culte', 'Le vaudou est au cœur de la culture béninoise 🌍 Ouidah est le centre spirituel.'),
     ('festival,evenement', 'Le Festival Vaudou se tient chaque 10 janvier à Ouidah. Une expérience unique !'),
     ('visa,entree,passeport', 'Les ressortissants de la CEDEAO entrent sans visa. Autres : visa disponible à l\'arrivée.');
     ============================================= -->