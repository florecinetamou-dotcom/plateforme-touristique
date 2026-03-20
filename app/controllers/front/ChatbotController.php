<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\Hebergement;

class ChatbotController extends Controller {

    private $model;
    private string $lang = 'fr';

    private array $i18n = [
        'fr' => [
            'welcome'       => "Bonjour ! 👋 Je suis votre assistant BeninExplore.\n\nJe peux vous aider à trouver des **hébergements**, des **sites touristiques** et des informations sur les **villes du Bénin**. 🇧🇯\n\nComment puis-je vous aider ?",
            'welcome_name'  => "Bonjour %s ! 👋 Ravi de vous retrouver. Comment puis-je vous aider aujourd'hui ?",
            'not_found'     => "Je ne suis pas sûr de comprendre. 🤔\n\nEssayez de me demander :\n• Des **hébergements**\n• Des **sites touristiques**\n• Les **villes** du Bénin\n• Des renseignements sur les **prix**\n\nOu tapez **\"aide\"** pour voir tout ce que je peux faire.",
            'thanks'        => "Avec plaisir ! 😊 N'hésitez pas si vous avez d'autres questions. Bonne découverte du Bénin ! 🇧🇯",
            'bye'           => "Au revoir ! 👋 Bonne visite au Bénin et à bientôt sur BeninExplore ! 🇧🇯",
            'help'          => "Je peux vous aider avec :\n\n🏨 **Hébergements** — trouver un logement, voir les prix\n🏛️ **Sites touristiques** — découvrir les monuments\n🌍 **Villes** — explorer les destinations\n📅 **Réservations** — comment réserver\n💰 **Prix** — informations sur les tarifs\n⭐ **Recommandations** — nos meilleurs conseils\n\nQue souhaitez-vous savoir ?",
            'reservation'   => "Pour réserver, rendez-vous sur la page de l'hébergement et cliquez sur **\"Réserver maintenant\"**. 📅\n\n👉 [Voir les hébergements](/hebergements)",
            'no_heb'        => "Aucun hébergement disponible%s pour le moment.\n\n👉 [Voir tous les hébergements](/hebergements)",
            'no_site'       => "Aucun site touristique trouvé%s.\n\n👉 [Voir tous les sites](/sites)",
            'heb_title'     => "Hébergements populaires%s :\n\n",
            'site_title'    => "Sites touristiques%s :\n\n",
            'ville_title'   => "🌍 Principales destinations du Bénin :\n\n",
            'price_title'   => "💰 **Fourchette de prix :**\n\n",
            'reco_title'    => "⭐ **Nos recommandations :**\n\n",
            'see_all_heb'   => "👉 [Voir tous les hébergements](/hebergements)",
            'see_all_sites' => "👉 [Voir tous les sites touristiques](/sites)",
            'see_all_villes'=> "👉 [Explorer toutes les villes](/villes)",
            'free'          => 'Gratuit',
            'per_night'     => '/nuit',
            'entrance'      => 'Entrée',
            'lang_changed'  => "Langue changée en français 🇫🇷\n\n",
        ],
        'en' => [
            'welcome'       => "Hello! 👋 I'm your BeninExplore assistant.\n\nI can help you find **accommodations**, **tourist sites** and information about **cities in Benin**. 🇧🇯\n\nHow can I help you?",
            'welcome_name'  => "Hello %s! 👋 Great to see you again. How can I help you today?",
            'not_found'     => "I'm not sure I understand. 🤔\n\nTry asking me about:\n• **Accommodations**\n• **Tourist sites**\n• **Cities** in Benin\n• **Prices**\n\nOr type **\"help\"** to see what I can do.",
            'thanks'        => "You're welcome! 😊 Feel free to ask more questions. Enjoy discovering Benin! 🇧🇯",
            'bye'           => "Goodbye! 👋 Enjoy your visit to Benin and see you soon! 🇧🇯",
            'help'          => "I can help you with:\n\n🏨 **Accommodations** — find lodging, view prices\n🏛️ **Tourist sites** — discover monuments\n🌍 **Cities** — explore Benin destinations\n📅 **Bookings** — how to book\n💰 **Prices** — pricing information\n⭐ **Recommendations** — our best picks\n\nWhat would you like to know?",
            'reservation'   => "To book, go to the accommodation page and click **\"Book now\"**. 📅\n\n👉 [View accommodations](/hebergements)",
            'no_heb'        => "No accommodations available%s at the moment.\n\n👉 [View all accommodations](/hebergements)",
            'no_site'       => "No tourist sites found%s.\n\n👉 [View all sites](/sites)",
            'heb_title'     => "Popular accommodations%s:\n\n",
            'site_title'    => "Tourist sites%s:\n\n",
            'ville_title'   => "🌍 Main destinations in Benin:\n\n",
            'price_title'   => "💰 **Price range:**\n\n",
            'reco_title'    => "⭐ **Our recommendations:**\n\n",
            'see_all_heb'   => "👉 [View all accommodations](/hebergements)",
            'see_all_sites' => "👉 [View all tourist sites](/sites)",
            'see_all_villes'=> "👉 [Explore all cities](/villes)",
            'free'          => 'Free',
            'per_night'     => '/night',
            'entrance'      => 'Entrance',
            'lang_changed'  => "Language changed to English 🇬🇧\n\n",
        ],
    ];

    // Carte géographique avec les vraies villes du Bénin
    private array $regions = [
        'nord'   => ['Parakou', 'Natitingou'],
        'north'  => ['Parakou', 'Natitingou'],
        'sud'    => ['Cotonou', 'Ouidah', 'Porto-Novo', 'Grand-Popo', 'Ganvié'],
        'south'  => ['Cotonou', 'Ouidah', 'Porto-Novo', 'Grand-Popo'],
        'centre' => ['Abomey', 'Bohicon'],
        'center' => ['Abomey', 'Bohicon'],
        'est'    => ['Porto-Novo', 'Lokossa'],
        'east'   => ['Porto-Novo', 'Lokossa'],
        'ouest'  => ['Grand-Popo', 'Ouidah'],
        'west'   => ['Grand-Popo', 'Ouidah'],
        'côte'   => ['Cotonou', 'Ouidah', 'Grand-Popo', 'Ganvié'],
        'littoral'=> ['Cotonou', 'Ouidah', 'Grand-Popo'],
        'coast'  => ['Cotonou', 'Ouidah', 'Grand-Popo'],
        'lac'    => ['Ganvié', 'Cotonou'],
        'lake'   => ['Ganvié'],
        'montagne'=> ['Natitingou'],
        'mountain'=> ['Natitingou'],
    ];

    private array $regionLabels = [
        'nord' => 'Nord Bénin', 'north' => 'Northern Benin',
        'sud'  => 'Sud Bénin',  'south' => 'Southern Benin',
        'centre'=> 'Centre Bénin', 'center'=> 'Central Benin',
        'est'  => 'Est Bénin',  'east'  => 'Eastern Benin',
        'ouest'=> 'Ouest Bénin','west'  => 'Western Benin',
        'côte' => 'Côte Béninoise', 'littoral' => 'Littoral',
        'coast'=> 'Beninese Coast',
        'lac'  => 'Zone lacustre', 'lake' => 'Lake Zone',
        'montagne' => 'Région montagneuse', 'mountain' => 'Mountain Region',
    ];

    public function __construct() {
        $this->model = new Hebergement();
    }

    // ════════════════════════════════════════════════
    // POINT D'ENTRÉE
    // ════════════════════════════════════════════════
    public function message() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Method not allowed']); exit;
        }

        $input   = json_decode(file_get_contents('php://input'), true);
        $message = trim($input['message'] ?? '');
        $lang    = $input['lang'] ?? ($_SESSION['chatbot_lang'] ?? 'fr');
        if (!in_array($lang, ['fr', 'en'])) $lang = 'fr';
        $this->lang = $lang;
        $_SESSION['chatbot_lang'] = $lang;

        if (empty($message)) {
            echo json_encode(['reponse' => 'Veuillez saisir un message.']); exit;
        }

        $sessionId = session_id();

        if (!isset($_SESSION['chatbot_history'])) $_SESSION['chatbot_history'] = [];
        $_SESSION['chatbot_history'][] = ['role' => 'user', 'text' => $message];
        if (count($_SESSION['chatbot_history']) > 20) {
            $_SESSION['chatbot_history'] = array_slice($_SESSION['chatbot_history'], -20);
        }

        $reponse = $this->trouverReponse($message);
        $_SESSION['chatbot_history'][] = ['role' => 'bot', 'text' => $reponse];

        $this->model->query(
            "INSERT INTO chatbot_conversations
             (session_id, utilisateur_id, message_utilisateur, reponse_bot, date_envoi)
             VALUES (?, ?, ?, ?, NOW())",
            [$sessionId, $_SESSION['user_id'] ?? null, $message, $reponse]
        );

        echo json_encode(['reponse' => $reponse, 'lang' => $this->lang]);
        exit;
    }

    public function history() {
        header('Content-Type: application/json');
        echo json_encode([
            'history' => $_SESSION['chatbot_history'] ?? [],
            'lang'    => $_SESSION['chatbot_lang'] ?? 'fr',
        ]);
        exit;
    }

    // ════════════════════════════════════════════════
    // LOGIQUE PRINCIPALE
    // ════════════════════════════════════════════════
    private function trouverReponse(string $message): string {
        $msg = mb_strtolower($message, 'UTF-8');

        // ── Changement de langue ──
        if ($this->contient($msg, ['english', 'in english', 'speak english', 'switch to english'])) {
            $this->lang = 'en'; $_SESSION['chatbot_lang'] = 'en';
            return $this->t('lang_changed') . $this->t('help');
        }
        if ($this->contient($msg, ['français', 'en français', 'parler français', 'passer au français'])) {
            $this->lang = 'fr'; $_SESSION['chatbot_lang'] = 'fr';
            return $this->t('lang_changed') . $this->t('help');
        }

        // ── Intentions BDD ──
        $intentions = $this->model->query(
            "SELECT i.mot_cle, r.reponse_texte
             FROM chatbot_intentions i
             JOIN chatbot_reponses r ON r.intention_id = i.id
             ORDER BY i.id ASC"
        );
        foreach ($intentions as $i) {
            if (strpos($msg, mb_strtolower($i->mot_cle, 'UTF-8')) !== false)
                return $i->reponse_texte;
        }

        // ── Salutations ──
        if ($this->contient($msg, ['bonjour', 'bonsoir', 'salut', 'hello', 'hi', 'hey', 'coucou', 'good morning', 'good evening'])) {
            $prenom = !empty($_SESSION['user_name']) ? explode(' ', $_SESSION['user_name'])[0] : null;
            return $prenom ? sprintf($this->t('welcome_name'), $prenom) : $this->t('welcome');
        }

        // ── Aide ──
        if ($this->contient($msg, ['aide', 'help', 'que peux', 'what can', 'quoi faire'])) {
            return $this->t('help');
        }

        // ── Recommandations ──
        if ($this->contient($msg, ['recommande', 'recommandation', 'meilleur', 'top', 'suggest', 'recommend', 'best', 'conseil'])) {
            return $this->reponseRecommandations();
        }

        // ── Hébergements ──
        if ($this->contient($msg, ['hébergement', 'hotel', 'hôtel', 'logement', 'chambre', 'dormir', 'nuit', 'séjour', 'accommodation', 'room', 'sleep', 'lodge', 'loger', 'coucher'])) {
            $_SESSION['chatbot_contexte'] = 'hebergement';
            return $this->reponseHebergements($msg);
        }

        // ── Sites touristiques ──
        if ($this->contient($msg, ['site', 'touristique', 'visiter', 'visite', 'patrimoine', 'monument', 'musée', 'parc', 'historique', 'tourist', 'visit', 'museum', 'park', 'attraction', 'voir', 'découvrir'])) {
            $_SESSION['chatbot_contexte'] = 'site';
            return $this->reponseSites($msg);
        }

        // ── Prix ──
        if ($this->contient($msg, ['prix', 'tarif', 'coût', 'combien', 'fcfa', 'budget', 'price', 'cost', 'how much', 'économique'])) {
            return $this->reponsePrix();
        }

        // ── Réservation ──
        if ($this->contient($msg, ['réserver', 'réservation', 'booking', 'disponible', 'disponibilité', 'book', 'reserve'])) {
            return $this->t('reservation');
        }

        // ── Remerciements ──
        if ($this->contient($msg, ['merci', 'thanks', 'thank you', 'super', 'parfait', 'excellent', 'génial', 'great', 'bravo','ok'])) {
            return $this->t('thanks');
        }

        // ── Au revoir ──
        if ($this->contient($msg, ['au revoir', 'bye', 'goodbye', 'à bientôt', 'adieu', 'tchao'])) {
            return $this->t('bye');
        }

        // ── Villes (mot-clé explicite) ──
        if ($this->contient($msg, ['ville', 'destination', 'city', 'where', 'où aller', 'endroit', 'place'])) {
            $_SESSION['chatbot_contexte'] = 'ville';
            return $this->reponseVilles($msg);
        }

        // ── Recherche géographique (nord, sud, côte...) ──
        $reponseGeo = $this->reponseGeo($msg);
        if ($reponseGeo) return $reponseGeo;

        // ── Détection directe d'une ville ──
        $villeDetectee = $this->detecterVille($msg);
        if ($villeDetectee) {
            $_SESSION['chatbot_contexte'] = 'ville';
            return $this->reponseVilles($msg);
        }

        // ── Réponse contextuelle ──
        return $this->reponseContextuelle($msg);
    }

    // ════════════════════════════════════════════════
    // RÉPONSE CONTEXTUELLE
    // ════════════════════════════════════════════════
    private function reponseContextuelle(string $msg): string {
        $contexte = $_SESSION['chatbot_contexte'] ?? null;

        $estSuite = $this->contient($msg, [
            'autre', 'autres', 'plus', 'encore', 'suite', 'suivant',
            'more', 'other', 'next', 'différent', 'different', 'sinon'
        ]);

        if ($contexte && $estSuite) {
            switch ($contexte) {
                case 'hebergement':
                    $intro = $this->lang === 'fr' ? "Voici d'autres hébergements :\n\n" : "Here are more accommodations:\n\n";
                    return $intro . $this->reponseHebergements($msg);
                case 'site':
                    $intro = $this->lang === 'fr' ? "Voici d'autres sites touristiques :\n\n" : "Here are more tourist sites:\n\n";
                    return $intro . $this->reponseSites($msg);
                case 'ville':
                    return $this->reponseVilles($msg);
            }
        }

        // Message court → utiliser le contexte
        if (mb_strlen($msg, 'UTF-8') < 15 && $contexte) {
            switch ($contexte) {
                case 'hebergement': return $this->reponseHebergements($msg);
                case 'site':        return $this->reponseSites($msg);
                case 'ville':       return $this->reponseVilles($msg);
            }
        }

        // Vraiment incompris
        return $this->lang === 'fr'
            ? "Je n'ai pas bien compris votre demande. 🤔\n\nVoici ce que je peux faire :\n\n• **\"hébergements\"** — voir les logements disponibles\n• **\"sites\"** — les attractions touristiques\n• Nom d'une ville : **Cotonou**, **Ouidah**, **Parakou**...\n• **\"nord\"**, **\"sud\"**, **\"côte\"** — chercher par région\n• **\"prix\"** — voir les tarifs\n• **\"aide\"** — toutes les options"
            : "I didn't quite understand. 🤔\n\nHere's what I can do:\n\n• **\"accommodations\"** — see available lodging\n• **\"sites\"** — tourist attractions\n• City name: **Cotonou**, **Ouidah**, **Parakou**...\n• **\"north\"**, **\"south\"**, **\"coast\"** — search by region\n• **\"prices\"** — see pricing\n• **\"help\"** — all options";
    }

    // ════════════════════════════════════════════════
    // RÉPONSE GÉOGRAPHIQUE
    // ════════════════════════════════════════════════
    private function reponseGeo(string $msg): ?string {
        foreach ($this->regions as $region => $villes) {
            if (strpos($msg, $region) === false) continue;

            $placeholders = implode(',', array_fill(0, count($villes), '?'));
            $result = $this->model->query(
                "SELECT v.id, v.nom,
                        (SELECT COUNT(*) FROM hebergement h WHERE h.ville_id = v.id AND h.statut = 'approuve') as nb_heb,
                        (SELECT COUNT(*) FROM site_touristique s WHERE s.ville_id = v.id AND s.est_valide = 1) as nb_sites
                 FROM ville v
                 WHERE v.nom IN ($placeholders) AND v.est_active = 1",
                $villes
            );

            if (empty($result)) {
                return $this->lang === 'fr'
                    ? "Pas encore de destinations référencées pour cette région.\n\n" . $this->t('see_all_villes')
                    : "No destinations listed for this region yet.\n\n" . $this->t('see_all_villes');
            }

            $label = $this->regionLabels[$region] ?? ucfirst($region);
            $rep   = "🌍 Destinations — **{$label}** :\n\n";
            foreach ($result as $v) {
                $rep .= "📍 **{$v->nom}** — {$v->nb_heb} heb. · {$v->nb_sites} site(s)\n";
            }
            $rep .= "\n" . $this->t('see_all_villes');
            $_SESSION['chatbot_contexte'] = 'ville';
            return $rep;
        }
        return null;
    }

    // ════════════════════════════════════════════════
    // RECOMMANDATIONS
    // ════════════════════════════════════════════════
    private function reponseRecommandations(): string {
        $topHeb  = $this->model->query(
            "SELECT h.nom, h.prix_nuit_base, v.nom as ville_nom, h.note_moyenne
             FROM hebergement h JOIN ville v ON h.ville_id = v.id
             WHERE h.statut = 'approuve' AND h.note_moyenne > 0
             ORDER BY h.note_moyenne DESC LIMIT 2"
        );
        $topSite = $this->model->query(
            "SELECT s.nom, s.categorie, v.nom as ville_nom
             FROM site_touristique s JOIN ville v ON s.ville_id = v.id
             WHERE s.est_valide = 1 ORDER BY s.id DESC LIMIT 2"
        );

        $rep = $this->t('reco_title');
        if (!empty($topHeb)) {
            $rep .= $this->lang === 'fr' ? "🏨 **Meilleurs hébergements :**\n" : "🏨 **Best accommodations:**\n";
            foreach ($topHeb as $h) {
                $prix = number_format($h->prix_nuit_base, 0, ',', ' ');
                $note = $h->note_moyenne > 0 ? " ⭐ {$h->note_moyenne}" : '';
                $rep .= "• **{$h->nom}** — {$h->ville_nom}{$note} · {$prix} FCFA" . $this->t('per_night') . "\n";
            }
            $rep .= "\n";
        }
        if (!empty($topSite)) {
            $rep .= $this->lang === 'fr' ? "🏛️ **Sites à ne pas manquer :**\n" : "🏛️ **Must-see sites:**\n";
            foreach ($topSite as $s) $rep .= "• **{$s->nom}** — {$s->ville_nom}\n";
            $rep .= "\n";
        }
        return $rep . $this->t('see_all_heb') . "\n" . $this->t('see_all_sites');
    }

    // ════════════════════════════════════════════════
    // HÉBERGEMENTS
    // ════════════════════════════════════════════════
    private function reponseHebergements(string $msg): string {
        $villeNom = $this->detecterVille($msg);
        $villeId  = $villeNom ? $this->getVilleId($villeNom) : null;

        $sql    = "SELECT h.nom, h.prix_nuit_base, h.note_moyenne, h.capacite, v.nom as ville_nom
                   FROM hebergement h JOIN ville v ON h.ville_id = v.id
                   WHERE h.statut = 'approuve'";
        $params = [];

        if ($this->contient($msg, ['pas cher', 'économique', 'budget', 'cheap', 'affordable', 'abordable'])) {
            $sql .= " AND h.prix_nuit_base < 30000";
        } elseif ($this->contient($msg, ['luxe', 'luxury', 'premium', 'haut de gamme'])) {
            $sql .= " AND h.prix_nuit_base > 80000";
        }

        if ($villeId) { $sql .= " AND h.ville_id = ?"; $params[] = $villeId; }
        $sql .= " ORDER BY h.note_moyenne DESC LIMIT 4";

        $list = $this->model->query($sql, $params);
        if (empty($list)) return sprintf($this->t('no_heb'), $villeNom ? " à $villeNom" : '');

        $rep = sprintf($this->t('heb_title'), $villeNom ? " à **$villeNom**" : '');
        foreach ($list as $h) {
            $prix = number_format($h->prix_nuit_base, 0, ',', ' ');
            $note = $h->note_moyenne > 0 ? " ⭐ {$h->note_moyenne}" : '';
            $rep .= "🏨 **{$h->nom}**{$note}\n   📍 {$h->ville_nom} · 💰 {$prix} FCFA" . $this->t('per_night') . "\n\n";
        }
        return $rep . $this->t('see_all_heb');
    }

    // ════════════════════════════════════════════════
    // SITES TOURISTIQUES
    // ════════════════════════════════════════════════
    private function reponseSites(string $msg): string {
        $villeNom = $this->detecterVille($msg);
        $villeId  = $villeNom ? $this->getVilleId($villeNom) : null;

        $sql    = "SELECT s.nom, s.categorie, s.prix_entree, v.nom as ville_nom
                   FROM site_touristique s JOIN ville v ON s.ville_id = v.id
                   WHERE s.est_valide = 1";
        $params = [];

        foreach ([
            'historique' => ['historique', 'histoire', 'history', 'palais', 'royal'],
            'nature'     => ['nature', 'parc', 'park', 'faune', 'wildlife', 'animaux'],
            'culturel'   => ['culturel', 'culture', 'musée', 'museum', 'art'],
            'religieux'  => ['religieux', 'religion', 'temple', 'église', 'vodoun'],
        ] as $cat => $mots) {
            if ($this->contient($msg, $mots)) { $sql .= " AND s.categorie = ?"; $params[] = $cat; break; }
        }

        if ($this->contient($msg, ['gratuit', 'free', 'sans frais'])) $sql .= " AND s.prix_entree = 0";
        if ($villeId) { $sql .= " AND s.ville_id = ?"; $params[] = $villeId; }
        $sql .= " ORDER BY s.id DESC LIMIT 4";

        $list = $this->model->query($sql, $params);
        if (empty($list)) return sprintf($this->t('no_site'), $villeNom ? " à $villeNom" : '');

        $rep = sprintf($this->t('site_title'), $villeNom ? " à **$villeNom**" : '');
        foreach ($list as $s) {
            $prix = $s->prix_entree > 0 ? number_format($s->prix_entree, 0, ',', ' ') . ' FCFA' : $this->t('free');
            $rep .= "🏛️ **{$s->nom}**\n   📍 {$s->ville_nom} · " . ucfirst($s->categorie) . " · 🎫 {$prix}\n\n";
        }
        return $rep . $this->t('see_all_sites');
    }

    // ════════════════════════════════════════════════
    // VILLES
    // ════════════════════════════════════════════════
    private function reponseVilles(string $msg): string {
        $villeNom = $this->detecterVille($msg);
        if ($villeNom) {
            $villeId = $this->getVilleId($villeNom);
            if ($villeId) {
                $infos = $this->model->query(
                    "SELECT v.*,
                            (SELECT COUNT(*) FROM hebergement h WHERE h.ville_id = v.id AND h.statut = 'approuve') as nb_heb,
                            (SELECT COUNT(*) FROM site_touristique s WHERE s.ville_id = v.id AND s.est_valide = 1) as nb_sites
                     FROM ville v WHERE v.id = ? LIMIT 1",
                    [$villeId]
                );
                if (!empty($infos)) {
                    $v   = $infos[0];
                    $rep = "📍 **{$v->nom}**\n\n";
                    $rep .= "• 🏨 {$v->nb_heb} hébergement(s) disponible(s)\n";
                    $rep .= "• 🏛️ {$v->nb_sites} site(s) touristique(s)\n\n";
                    if (!empty($v->description)) $rep .= "_" . mb_substr($v->description, 0, 120, 'UTF-8') . "..._\n\n";
                    $rep .= "👉 [Explorer {$v->nom}](/ville/{$v->id})";
                    return $rep;
                }
            }
        }

        $villes = $this->model->query(
            "SELECT v.id, v.nom,
                    (SELECT COUNT(*) FROM hebergement h WHERE h.ville_id = v.id AND h.statut = 'approuve') as nb_heb,
                    (SELECT COUNT(*) FROM site_touristique s WHERE s.ville_id = v.id AND s.est_valide = 1) as nb_sites
             FROM ville v WHERE v.est_active = 1
             ORDER BY nb_heb DESC LIMIT 6"
        );
        if (empty($villes)) return $this->t('see_all_villes');

        $rep = $this->t('ville_title');
        foreach ($villes as $v) {
            $rep .= "📍 **{$v->nom}** — {$v->nb_heb} heb. · {$v->nb_sites} site(s)\n";
        }
        return $rep . "\n" . $this->t('see_all_villes');
    }

    // ════════════════════════════════════════════════
    // PRIX
    // ════════════════════════════════════════════════
    private function reponsePrix(): string {
        $r = $this->model->query(
            "SELECT MIN(prix_nuit_base) as min_prix,
                    MAX(prix_nuit_base) as max_prix,
                    ROUND(AVG(prix_nuit_base)) as moy_prix
             FROM hebergement WHERE statut = 'approuve'"
        );
        $r = $r[0] ?? null;
        if (!$r || !$r->min_prix) return $this->t('see_all_heb');

        $rep  = $this->t('price_title');
        $rep .= "• " . ($this->lang === 'fr' ? 'Min' : 'Min') . " : **" . number_format($r->min_prix, 0, ',', ' ') . " FCFA**" . $this->t('per_night') . "\n";
        $rep .= "• " . ($this->lang === 'fr' ? 'Moy' : 'Avg') . " : **" . number_format($r->moy_prix, 0, ',', ' ') . " FCFA**" . $this->t('per_night') . "\n";
        $rep .= "• " . ($this->lang === 'fr' ? 'Max' : 'Max') . " : **" . number_format($r->max_prix, 0, ',', ' ') . " FCFA**" . $this->t('per_night') . "\n\n";
        return $rep . $this->t('see_all_heb');
    }

    // ════════════════════════════════════════════════
    // UTILITAIRES
    // ════════════════════════════════════════════════
    private function t(string $key): string {
        return $this->i18n[$this->lang][$key] ?? $this->i18n['fr'][$key] ?? $key;
    }

    private function contient(string $message, array $mots): bool {
        foreach ($mots as $m) {
            if (strpos($message, mb_strtolower($m, 'UTF-8')) !== false) return true;
        }
        return false;
    }

    private function detecterVille(string $msg): ?string {
        $villes = $this->model->query("SELECT nom FROM ville WHERE est_active = 1");
        foreach ($villes as $v) {
            if (strpos($msg, mb_strtolower($v->nom, 'UTF-8')) !== false) return $v->nom;
        }
        return null;
    }

    private function getVilleId(string $nom): ?int {
        $r = $this->model->query("SELECT id FROM ville WHERE nom = ? LIMIT 1", [$nom]);
        return $r[0]->id ?? null;
    }
}