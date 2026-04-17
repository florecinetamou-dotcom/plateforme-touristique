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

<script src="/public/assets/js/chatbot.js"></script>
<?php 
$content = ob_get_clean();
require dirname(__DIR__, 2) . '/layout/header.php';
echo $content;
require dirname(__DIR__, 2) . '/layout/footer.php';
?>