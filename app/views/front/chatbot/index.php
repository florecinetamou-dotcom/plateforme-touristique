<?php 
$title = 'Assistant virtuel - Tourisme Bénin';
$meta_description = 'Posez toutes vos questions sur le tourisme au Bénin à notre assistant virtuel.';
?>

<?php ob_start(); ?>

<!-- Hero Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center text-center" data-aos="fade-up">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Assistant virtuel</h1>
                <p class="lead text-muted mb-0">
                    Posez vos questions sur les hébergements, sites touristiques, transports et plus encore.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Interface Chatbot -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" data-aos="fade-up">
                    <!-- En-tête du chat -->
                    <div class="card-header bg-benin text-white py-3 px-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-white p-2 me-3">
                                <i class="fas fa-robot fa-2x text-benin"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Assistant Tourisme Bénin</h5>
                                <small class="text-white-50">
                                    <i class="fas fa-circle text-success me-1" style="font-size: 10px;"></i>
                                    En ligne
                                </small>
                            </div>
                            <button class="btn btn-sm btn-outline-light ms-auto" id="newChatBtn">
                                <i class="fas fa-plus-circle me-1"></i>Nouvelle conversation
                            </button>
                        </div>
                    </div>
                    
                    <!-- Zone des messages -->
                    <div class="card-body bg-light" style="height: 400px; overflow-y: auto;" id="chatMessages">
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-benin p-2 me-3">
                                    <i class="fas fa-robot text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="bg-white p-3 rounded-3 shadow-sm" style="max-width: 80%;">
                                    <p class="mb-0">
                                        Bonjour ! Je suis votre assistant virtuel pour le Bénin. 
                                        Comment puis-je vous aider ?<br><br>
                                        <strong>Exemples de questions :</strong><br>
                                        • Quels sont les meilleurs hôtels à Cotonou ?<br>
                                        • Que visiter à Ouidah ?<br>
                                        • Quel est le prix moyen d'une nuit ?<br>
                                        • Comment se déplacer au Bénin ?
                                    </p>
                                    <small class="text-muted d-block mt-2">À l'instant</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Les messages dynamiques s'inséreront ici -->
                        <div id="messageContainer"></div>
                    </div>
                    
                    <!-- Zone de saisie -->
                    <div class="card-footer bg-white p-3">
                        <form id="chatForm" class="d-flex gap-2">
                            <input type="text" 
                                   id="userMessage" 
                                   class="form-control form-control-lg" 
                                   placeholder="Tapez votre message ici..."
                                   autocomplete="off">
                            <button type="submit" class="btn btn-benin px-4">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Suggestions : 
                                <a href="#" class="text-decoration-none suggestion">hébergement Cotonou</a>,
                                <a href="#" class="text-decoration-none suggestion">prix hôtel</a>,
                                <a href="#" class="text-decoration-none suggestion">sites Ouidah</a>,
                                <a href="#" class="text-decoration-none suggestion">transport</a>
                            </small>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Rapide -->
                <div class="row g-4 mt-5">
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="card border-0 shadow-sm text-center h-100">
                            <div class="card-body p-4">
                                <div class="bg-benin-light rounded-circle p-3 d-inline-block mb-3">
                                    <i class="fas fa-bed fa-2x text-benin"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Hébergements</h5>
                                <p class="text-muted small">
                                    Prix, disponibilités, types de logements...
                                </p>
                                <button class="btn btn-sm btn-outline-benin quick-question" data-question="Quels sont les types d'hébergement disponibles ?">
                                    Demander
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card border-0 shadow-sm text-center h-100">
                            <div class="card-body p-4">
                                <div class="bg-benin-light rounded-circle p-3 d-inline-block mb-3">
                                    <i class="fas fa-landmark fa-2x text-benin"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Sites touristiques</h5>
                                <p class="text-muted small">
                                    Incontournables, horaires, tarifs...
                                </p>
                                <button class="btn btn-sm btn-outline-benin quick-question" data-question="Quels sont les sites incontournables du Bénin ?">
                                    Demander
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card border-0 shadow-sm text-center h-100">
                            <div class="card-body p-4">
                                <div class="bg-benin-light rounded-circle p-3 d-inline-block mb-3">
                                    <i class="fas fa-car fa-2x text-benin"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Transport</h5>
                                <p class="text-muted small">
                                    Taxis, bus, location de voitures...
                                </p>
                                <button class="btn btn-sm btn-outline-benin quick-question" data-question="Comment se déplacer au Bénin ?">
                                    Demander
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.chat-message-user {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 1rem;
}
.chat-message-bot {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 1rem;
}
.chat-bubble-user {
    background: #008751;
    color: white;
    padding: 1rem;
    border-radius: 20px 20px 5px 20px;
    max-width: 70%;
}
.chat-bubble-bot {
    background: white;
    padding: 1rem;
    border-radius: 20px 20px 20px 5px;
    max-width: 70%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.typing-indicator {
    display: flex;
    gap: 5px;
    padding: 1rem;
    background: white;
    border-radius: 20px;
    width: fit-content;
}
.typing-indicator span {
    width: 8px;
    height: 8px;
    background: #008751;
    border-radius: 50%;
    animation: typing 1s infinite ease-in-out;
}
.typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
.typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
@keyframes typing {
    0%, 100% { transform: translateY(0); opacity: 0.5; }
    50% { transform: translateY(-10px); opacity: 1; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    const messageContainer = document.getElementById('messageContainer');
    const chatForm = document.getElementById('chatForm');
    const userMessage = document.getElementById('userMessage');
    const sessionId = localStorage.getItem('chatSessionId') || 'session_' + Date.now();
    
    localStorage.setItem('chatSessionId', sessionId);
    
    // Charger l'historique
    function loadHistory() {
        fetch('/api/chatbot/history?session_id=' + sessionId)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.messages) {
                    messageContainer.innerHTML = '';
                    data.data.messages.forEach(msg => {
                        if (msg.expediteur === 'user') {
                            addUserMessage(msg.contenu, msg.date);
                        } else {
                            addBotMessage(msg.contenu, msg.date);
                        }
                    });
                    scrollToBottom();
                }
            });
    }
    
    loadHistory();
    
    // Envoyer un message
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = userMessage.value.trim();
        
        if (message.length === 0) return;
        
        // Afficher le message utilisateur
        addUserMessage(message);
        
        // Effacer l'input
        userMessage.value = '';
        
        // Afficher l'indicateur de frappe
        showTypingIndicator();
        
        // Envoyer au serveur
        fetch('/api/chatbot/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                message: message,
                session_id: sessionId
            })
        })
        .then(response => response.json())
        .then(data => {
            removeTypingIndicator();
            
            if (data.success) {
                addBotMessage(data.data.message);
                
                // Suggestions
                if (data.data.suggestions && data.data.suggestions.length > 0) {
                    addSuggestions(data.data.suggestions);
                }
            } else {
                addBotMessage('Désolé, une erreur est survenue. Veuillez réessayer.');
            }
            scrollToBottom();
        })
        .catch(error => {
            removeTypingIndicator();
            addBotMessage('Erreur de connexion. Veuillez réessayer.');
        });
    });
    
    // Ajouter message utilisateur
    function addUserMessage(message, timestamp = null) {
        const time = timestamp ? new Date(timestamp).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'}) : 'À l\'instant';
        
        const html = `
            <div class="chat-message-user">
                <div class="chat-bubble-user">
                    <p class="mb-0">${escapeHtml(message)}</p>
                    <small class="text-white-50 d-block mt-1">${time}</small>
                </div>
                <div class="flex-shrink-0 ms-2">
                    <div class="rounded-circle bg-secondary p-2">
                        <i class="fas fa-user text-white"></i>
                    </div>
                </div>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', html);
    }
    
    // Ajouter message bot
    function addBotMessage(message, timestamp = null) {
        const time = timestamp ? new Date(timestamp).toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'}) : 'À l\'instant';
        
        // Convertir les URLs en liens
        message = message.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>');
        
        const html = `
            <div class="chat-message-bot">
                <div class="flex-shrink-0 me-2">
                    <div class="rounded-circle bg-benin p-2">
                        <i class="fas fa-robot text-white"></i>
                    </div>
                </div>
                <div class="chat-bubble-bot">
                    <p class="mb-0">${nl2br(message)}</p>
                    <small class="text-muted d-block mt-1">${time}</small>
                </div>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', html);
    }
    
    // Ajouter des suggestions
    function addSuggestions(suggestions) {
        let html = '<div class="chat-message-bot"><div class="flex-shrink-0 me-2"><div class="rounded-circle bg-benin p-2"><i class="fas fa-robot text-white"></i></div></div><div class="chat-bubble-bot"><p class="mb-2"><small>Suggestions :</small></p><div class="d-flex flex-wrap gap-2">';
        
        suggestions.forEach(suggestion => {
            html += `<button class="btn btn-sm btn-outline-benin suggestion-btn" data-text="${escapeHtml(suggestion)}">${escapeHtml(suggestion)}</button>`;
        });
        
        html += '</div></div></div>';
        messageContainer.insertAdjacentHTML('beforeend', html);
        
        // Ajouter les événements aux suggestions
        document.querySelectorAll('.suggestion-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                userMessage.value = this.dataset.text;
                chatForm.dispatchEvent(new Event('submit'));
            });
        });
    }
    
    // Indicateur de frappe
    function showTypingIndicator() {
        const html = `
            <div class="chat-message-bot" id="typingIndicator">
                <div class="flex-shrink-0 me-2">
                    <div class="rounded-circle bg-benin p-2">
                        <i class="fas fa-robot text-white"></i>
                    </div>
                </div>
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        messageContainer.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }
    
    function removeTypingIndicator() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) indicator.remove();
    }
    
    // Scroll en bas
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Questions rapides
    document.querySelectorAll('.quick-question').forEach(btn => {
        btn.addEventListener('click', function() {
            userMessage.value = this.dataset.question;
            chatForm.dispatchEvent(new Event('submit'));
        });
    });
    
    // Suggestions cliquables
    document.querySelectorAll('.suggestion').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            userMessage.value = this.textContent;
            chatForm.dispatchEvent(new Event('submit'));
        });
    });
    
    // Nouvelle conversation
    document.getElementById('newChatBtn').addEventListener('click', function() {
        fetch('/api/chatbot/new', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                session_id: localStorage.getItem('chatSessionId')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.setItem('chatSessionId', 'session_' + Date.now());
                messageContainer.innerHTML = '';
                addBotMessage('Bonjour ! Je suis votre assistant virtuel pour le Bénin. Comment puis-je vous aider ?');
            }
        });
    });
    
    // Utilitaires
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function nl2br(text) {
        return text.replace(/\n/g, '<br>');
    }
});
</script>

<?php 
$content = ob_get_clean();
require dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
require dirname(__DIR__, 2) . '/layout/footer.php';
?>