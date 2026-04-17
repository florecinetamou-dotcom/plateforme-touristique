<?php
/**
 * ChatbotController — Site Touristique Bénin
 * Moteur de règles + arbre de décision par session
 * Compatible avec votre architecture MVC existante
 */
class ChatbotController {

    private $model;

    // ------------------------------------------------
    // BASE DE CONNAISSANCES BÉNIN
    // ------------------------------------------------

    private $villes = [
        'cotonou'    => ['nom' => 'Cotonou',    'emoji' => '🌊'],
        'porto-novo' => ['nom' => 'Porto-Novo', 'emoji' => '🏛️'],
        'ouidah'     => ['nom' => 'Ouidah',     'emoji' => '🌍'],
        'parakou'    => ['nom' => 'Parakou',    'emoji' => '🏔️'],
        'ganvie'     => ['nom' => 'Ganvié',     'emoji' => '🚤'],
        'abomey'     => ['nom' => 'Abomey',     'emoji' => '👑'],
    ];

    private $hotels = [
        'cotonou' => [
            'economique' => [
                ['nom' => 'Hôtel Bel Azur',     'prix' => '15 000–25 000 FCFA/nuit', 'desc' => 'Bien situé, propre et accessible'],
                ['nom' => 'Résidence Comfort',   'prix' => '20 000–30 000 FCFA/nuit', 'desc' => 'Chambres simples, quartier calme'],
            ],
            'moyen' => [
                ['nom' => 'Hôtel de la Plage',   'prix' => '35 000–55 000 FCFA/nuit', 'desc' => 'Vue sur la mer, piscine, restaurant'],
                ['nom' => 'Golden Tulip Cotonou','prix' => '40 000–65 000 FCFA/nuit', 'desc' => 'Standing international, centre-ville'],
            ],
            'luxe' => [
                ['nom' => 'Novotel Cotonou',     'prix' => '80 000–130 000 FCFA/nuit','desc' => 'Luxe, spa, piscine, vue mer'],
                ['nom' => 'Azalaï Hôtel',        'prix' => '70 000–110 000 FCFA/nuit','desc' => 'Prestige, service 5 étoiles'],
            ],
        ],
        'porto-novo' => [
            'economique' => [
                ['nom' => 'Hôtel Beaurivage',    'prix' => '12 000–20 000 FCFA/nuit', 'desc' => 'Simple et central'],
                ['nom' => 'Auberge La Détente',  'prix' => '10 000–18 000 FCFA/nuit', 'desc' => 'Petite auberge familiale'],
            ],
            'moyen' => [
                ['nom' => 'Hôtel Songhaï',       'prix' => '25 000–45 000 FCFA/nuit', 'desc' => 'Centre d'agrotourisme unique'],
                ['nom' => 'Villa Karo',          'prix' => '30 000–50 000 FCFA/nuit', 'desc' => 'Charme colonial, jardin tropical'],
            ],
            'luxe' => [
                ['nom' => 'Hôtel de l\'Espérance','prix' => '60 000–90 000 FCFA/nuit', 'desc' => 'Meilleur standing de la capitale'],
            ],
        ],
        'ouidah' => [
            'economique' => [
                ['nom' => 'Auberge de Ouidah',   'prix' => '10 000–18 000 FCFA/nuit', 'desc' => 'Proche des sites historiques'],
            ],
            'moyen' => [
                ['nom' => 'Casa del Papa',       'prix' => '25 000–40 000 FCFA/nuit', 'desc' => 'Boutique-hôtel, ambiance coloniale'],
                ['nom' => 'Hôtel Aupiais',       'prix' => '20 000–35 000 FCFA/nuit', 'desc' => 'Confortable, proche de la plage'],
            ],
            'luxe' => [
                ['nom' => 'Escapade Ouidah',     'prix' => '55 000–80 000 FCFA/nuit', 'desc' => 'Piscine, jardin, standing premium'],
            ],
        ],
        'parakou' => [
            'economique' => [
                ['nom' => 'Hôtel Central',       'prix' => '10 000–20 000 FCFA/nuit', 'desc' => 'Centre-ville, accessible'],
            ],
            'moyen' => [
                ['nom' => 'Hôtel Tata',          'prix' => '25 000–40 000 FCFA/nuit', 'desc' => 'Confort, restaurant, parking'],
                ['nom' => 'Hôtel Canaris',       'prix' => '20 000–35 000 FCFA/nuit', 'desc' => 'Tranquille, bon rapport qualité-prix'],
            ],
            'luxe' => [
                ['nom' => 'Hôtel Paradise',      'prix' => '50 000–75 000 FCFA/nuit', 'desc' => 'Le meilleur de Parakou, piscine'],
            ],
        ],
    ];

    private $sites = [
        'cotonou' => [
            'culture'     => [
                ['nom' => 'Musée d\'Histoire de Cotonou', 'desc' => 'Patrimoine béninois', 'horaires' => '9h–17h', 'tarif' => '1 000 FCFA'],
                ['nom' => 'Marché Dantokpa',              'desc' => 'Plus grand marché d\'Afrique de l\'Ouest', 'horaires' => '6h–18h', 'tarif' => 'Gratuit'],
                ['nom' => 'Fondation Zinsou',             'desc' => 'Art contemporain africain', 'horaires' => '10h–18h (fermé lun.)', 'tarif' => '500 FCFA'],
            ],
            'nature'      => [
                ['nom' => 'Plage de Fidjrossè',           'desc' => 'Plage populaire, couchers de soleil', 'horaires' => 'Toute la journée', 'tarif' => 'Gratuit'],
                ['nom' => 'Lac Nokoué',                   'desc' => 'Lac et village lacustre de Ganvié', 'horaires' => '7h–18h', 'tarif' => '5 000 FCFA (pirogue)'],
            ],
            'gastronomie' => [
                ['nom' => 'Maquis du Bord de Mer',        'desc' => 'Poisson braisé, cuisine locale authentique', 'horaires' => '12h–23h', 'tarif' => '2 000–8 000 FCFA'],
                ['nom' => 'Restaurant Le Jardin Brésilien','desc' => 'Fusion afro-brésilienne', 'horaires' => '12h–22h', 'tarif' => '5 000–15 000 FCFA'],
            ],
            'detente'     => [
                ['nom' => 'Plage de la Sirène',           'desc' => 'Farniente, cocotiers, détente', 'horaires' => 'Toute la journée', 'tarif' => 'Gratuit'],
                ['nom' => 'Centre Culturel Français',      'desc' => 'Spectacles, expositions, cinéma', 'horaires' => '9h–20h', 'tarif' => 'Variable'],
            ],
        ],
        'ouidah' => [
            'culture'     => [
                ['nom' => 'Route des Esclaves',           'desc' => 'Site UNESCO, mémoire de la traite', 'horaires' => 'Toute la journée', 'tarif' => 'Gratuit'],
                ['nom' => 'Musée d\'Histoire de Ouidah',  'desc' => 'Fort portugais, histoire du royaume du Dahomey', 'horaires' => '9h–17h', 'tarif' => '2 000 FCFA'],
                ['nom' => 'Temple des Pythons',           'desc' => 'Temple vaudou sacré', 'horaires' => '8h–17h', 'tarif' => '1 000 FCFA'],
            ],
            'nature'      => [
                ['nom' => 'Plage de Ouidah',              'desc' => 'Plage sauvage et préservée', 'horaires' => 'Toute la journée', 'tarif' => 'Gratuit'],
                ['nom' => 'Forêt Sacrée de Kpasse',       'desc' => 'Forêt vaudou, statues mythologiques', 'horaires' => '8h–17h', 'tarif' => '1 500 FCFA'],
            ],
            'gastronomie' => [
                ['nom' => 'Maquis local de Ouidah',       'desc' => 'Cuisine béninoise traditionnelle', 'horaires' => '10h–21h', 'tarif' => '1 500–5 000 FCFA'],
            ],
            'detente'     => [
                ['nom' => 'Plage de la Porte du Non-Retour','desc' => 'Coucher de soleil émouvant', 'horaires' => 'Toute la journée', 'tarif' => 'Gratuit'],
            ],
        ],
        'porto-novo' => [
            'culture'     => [
                ['nom' => 'Musée Ethnographique',         'desc' => 'Masques, costumes, objets royaux', 'horaires' => '9h–17h', 'tarif' => '1 500 FCFA'],
                ['nom' => 'Grande Mosquée de Porto-Novo', 'desc' => 'Architecture afro-brésilienne unique', 'horaires' => 'Libre accès', 'tarif' => 'Gratuit'],
                ['nom' => 'Palais Royal de Porto-Novo',   'desc' => 'Histoire du royaume du Hogbonou', 'horaires' => '9h–17h', 'tarif' => '1 000 FCFA'],
            ],
            'nature'      => [
                ['nom' => 'Lac Nokoué (rive nord)',       'desc' => 'Pêcheurs, pirogues, coucher de soleil', 'horaires' => '6h–18h', 'tarif' => 'Gratuit'],
            ],
            'gastronomie' => [
                ['nom' => 'Marché de Porto-Novo',         'desc' => 'Épices, fruits, spécialités locales', 'horaires' => '7h–18h', 'tarif' => 'Gratuit'],
            ],
            'detente'     => [
                ['nom' => 'Jardins de la Présidence',     'desc' => 'Promenade paisible en capitale', 'horaires' => '8h–18h', 'tarif' => 'Gratuit'],
            ],
        ],
        'parakou' => [
            'culture'     => [
                ['nom' => 'Grande Mosquée de Parakou',    'desc' => 'Architecture islamique, centre nord', 'horaires' => 'Libre accès', 'tarif' => 'Gratuit'],
                ['nom' => 'Marché de Parakou',            'desc' => 'Artisanat du nord, textile', 'horaires' => '7h–18h', 'tarif' => 'Gratuit'],
            ],
            'nature'      => [
                ['nom' => 'Parc National du W',           'desc' => 'Faune sauvage, lions, éléphants', 'horaires' => 'Journée', 'tarif' => '5 000 FCFA + guide'],
                ['nom' => 'Cascades de Kota',             'desc' => 'Paysages de savane et cascades', 'horaires' => 'Journée', 'tarif' => '2 000 FCFA'],
            ],
            'gastronomie' => [
                ['nom' => 'Resto-Maquis du Nord',         'desc' => 'Viandes grillées, cuisine haoussa', 'horaires' => '10h–22h', 'tarif' => '2 000–6 000 FCFA'],
            ],
            'detente'     => [
                ['nom' => 'Centre artisanal de Parakou',  'desc' => 'Poterie, maroquinerie, détente culturelle', 'horaires' => '9h–17h', 'tarif' => 'Gratuit'],
            ],
        ],
    ];

    // ------------------------------------------------
    // ÉTAPES DE LA CONVERSATION
    // ------------------------------------------------

    private $etapes = [
        'accueil'    => 'Étape 1 : choix de la ville',
        'ville'      => 'Étape 2 : durée du séjour',
        'duree'      => 'Étape 3 : budget',
        'budget'     => 'Étape 4 : type d\'activités',
        'activite'   => 'Étape 5 : affichage des résultats',
        'resultats'  => 'Conversation libre',
    ];

    // ------------------------------------------------

    public function __construct($model) {
        $this->model = $model;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Initialiser la session si besoin
        if (!isset($_SESSION['chatbot'])) {
            $this->resetSession();
        }
    }

    // ------------------------------------------------
    // POINT D'ENTRÉE PRINCIPAL
    // ------------------------------------------------

    public function envoyerMessage() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["error" => "Requête invalide"]);
            return;
        }

        // Support boutons (action) et saisie libre (message)
        $action  = trim($_POST['action']  ?? '');
        $message = trim($_POST['message'] ?? '');
        $input   = $action ?: $message;

        if (empty($input)) {
            echo json_encode(["reponse" => "Veuillez écrire un message.", "type" => "texte"]);
            return;
        }

        $msg = $this->nettoyer($input);

        // Commande reset
        if ($this->contient($msg, ['recommencer', 'reset', 'restart', 'nouvelle conversation'])) {
            $this->resetSession();
            $reponse = $this->etapeAccueil();
            $this->sauvegarder($input, $reponse['reponse']);
            echo json_encode($reponse);
            return;
        }

        // Routeur selon l'étape courante
        $etape = $_SESSION['chatbot']['etape'];
        $reponse = match($etape) {
            'accueil'   => $this->etapeAccueil(),
            'ville'     => $this->etapeVille($msg, $input),
            'duree'     => $this->etapeDuree($msg, $input),
            'budget'    => $this->etapeBudget($msg, $input),
            'activite'  => $this->etapeActivite($msg, $input),
            'resultats' => $this->etapeResultats($msg, $input),
            default     => $this->etapeLibre($msg, $input),
        };

        $this->sauvegarder($input, $reponse['reponse']);
        echo json_encode($reponse);
    }

    // ------------------------------------------------
    // ÉTAPES DU PARCOURS GUIDÉ
    // ------------------------------------------------

    private function etapeAccueil() {
        $_SESSION['chatbot']['etape'] = 'ville';
        return [
            "reponse" => "Bienvenue sur votre guide touristique du Bénin ! 🇧🇯\n\nQuelle ville souhaitez-vous découvrir ?",
            "type"    => "boutons",
            "options" => ["Cotonou 🌊", "Ouidah 🌍", "Porto-Novo 🏛️", "Parakou 🏔️"],
        ];
    }

    private function etapeVille($msg, $raw) {
        $ville = null;
        foreach ($this->villes as $cle => $info) {
            if ($this->contient($msg, [$cle])) {
                $ville = $cle;
                break;
            }
        }

        if (!$ville) {
            return [
                "reponse" => "Je n'ai pas reconnu cette ville 🤔 Choisissez parmi :",
                "type"    => "boutons",
                "options" => ["Cotonou 🌊", "Ouidah 🌍", "Porto-Novo 🏛️", "Parakou 🏔️"],
            ];
        }

        $_SESSION['chatbot']['ville'] = $ville;
        $_SESSION['chatbot']['etape'] = 'duree';
        $info = $this->villes[$ville];

        return [
            "reponse" => "{$info['emoji']} Excellent choix ! **{$info['nom']}** vous attend.\n\nCombien de jours comptez-vous séjourner ?",
            "type"    => "boutons",
            "options" => ["1–2 jours (week-end)", "3–5 jours", "1 semaine", "Plus d'une semaine"],
        ];
    }

    private function etapeDuree($msg, $raw) {
        // Accepte bouton ou saisie libre contenant un chiffre
        if (preg_match('/\d/', $raw) || $this->contient($msg, ['jour','semaine','nuit','week','weekend'])) {
            $_SESSION['chatbot']['duree'] = $raw;
            $_SESSION['chatbot']['etape'] = 'budget';
            return [
                "reponse" => "Parfait ! 🗓️ Quel est votre budget pour l'hébergement par nuit ?",
                "type"    => "boutons",
                "options" => ["💰 Économique (< 25 000 FCFA)", "💳 Moyen (25 000–60 000 FCFA)", "💎 Luxe (60 000 FCFA+)"],
            ];
        }

        return [
            "reponse" => "Combien de jours prévoyez-vous ? Choisissez ou tapez librement :",
            "type"    => "boutons",
            "options" => ["1–2 jours (week-end)", "3–5 jours", "1 semaine", "Plus d'une semaine"],
        ];
    }

    private function etapeBudget($msg, $raw) {
        $budget = null;

        if ($this->contient($msg, ['economique','eco','petit budget','pas cher','moins'])) {
            $budget = 'economique';
        } elseif ($this->contient($msg, ['luxe','palace','prestige','premium','haut de gamme'])) {
            $budget = 'luxe';
        } elseif ($this->contient($msg, ['moyen','milieu','standard','confortable'])) {
            $budget = 'moyen';
        }

        // Détection par montant saisi librement
        if (!$budget && preg_match('/\d+/', $raw, $m)) {
            $montant = (int)$m[0];
            if ($montant < 25000)        $budget = 'economique';
            elseif ($montant < 60000)    $budget = 'moyen';
            else                         $budget = 'luxe';
        }

        if (!$budget) {
            return [
                "reponse" => "Quel budget par nuit vous convient ?",
                "type"    => "boutons",
                "options" => ["💰 Économique (< 25 000 FCFA)", "💳 Moyen (25 000–60 000 FCFA)", "💎 Luxe (60 000 FCFA+)"],
            ];
        }

        $_SESSION['chatbot']['budget'] = $budget;
        $_SESSION['chatbot']['etape']  = 'activite';

        return [
            "reponse" => "👌 Noté ! Quel type d'activités vous attire le plus ?",
            "type"    => "boutons",
            "options" => ["🏛️ Culture & Histoire", "🌿 Nature & Plein air", "🍽️ Gastronomie", "🛁 Détente & Bien-être"],
        ];
    }

    private function etapeActivite($msg, $raw) {
        $activite = null;

        if ($this->contient($msg, ['culture','histoire','musee','patrimoine','monument'])) {
            $activite = 'culture';
        } elseif ($this->contient($msg, ['nature','plein air','plage','foret','parc','lac'])) {
            $activite = 'nature';
        } elseif ($this->contient($msg, ['gastronomie','manger','restaurant','cuisine','food'])) {
            $activite = 'gastronomie';
        } elseif ($this->contient($msg, ['detente','relax','repos','spa','bien-etre','bien etre'])) {
            $activite = 'detente';
        }

        if (!$activite) {
            return [
                "reponse" => "Quel type d'activité vous intéresse ?",
                "type"    => "boutons",
                "options" => ["🏛️ Culture & Histoire", "🌿 Nature & Plein air", "🍽️ Gastronomie", "🛁 Détente & Bien-être"],
            ];
        }

        $_SESSION['chatbot']['activite'] = $activite;
        $_SESSION['chatbot']['etape']    = 'resultats';

        return $this->construireResultats();
    }

    private function etapeResultats($msg, $raw) {
        // Navigation après les résultats
        if ($this->contient($msg, ['hotel','hebergement','logement'])) {
            return $this->reponseHotels();
        }
        if ($this->contient($msg, ['site','touristique','visite','voir','activite'])) {
            return $this->reponseSites();
        }
        if ($this->contient($msg, ['changer ville','autre ville','nouvelle ville'])) {
            $this->resetSession();
            return $this->etapeAccueil();
        }
        if ($this->contient($msg, ['changer budget','autre budget'])) {
            $_SESSION['chatbot']['etape'] = 'budget';
            return [
                "reponse" => "Quel budget préférez-vous à la place ?",
                "type"    => "boutons",
                "options" => ["💰 Économique", "💳 Moyen", "💎 Luxe"],
            ];
        }
        if ($this->contient($msg, ['merci','super','parfait','top','genial','bravo'])) {
            return [
                "reponse" => "Avec plaisir ! 😊 Bon voyage au Bénin 🇧🇯\nN'hésitez pas si vous avez d'autres questions.",
                "type"    => "boutons",
                "options" => ["Recommencer", "Voir les hôtels", "Voir les sites"],
            ];
        }

        // Réponse libre sur des questions simples
        return $this->etapeLibre($msg, $raw);
    }

    // ------------------------------------------------
    // CONSTRUCTION DES RÉSULTATS
    // ------------------------------------------------

    private function construireResultats() {
        $ville   = $_SESSION['chatbot']['ville']   ?? 'cotonou';
        $budget  = $_SESSION['chatbot']['budget']  ?? 'moyen';
        $duree   = $_SESSION['chatbot']['duree']   ?? '';
        $activite= $_SESSION['chatbot']['activite']?? 'culture';

        $nomVille = $this->villes[$ville]['nom'] ?? ucfirst($ville);
        $budgetLabel = ['economique' => 'Économique', 'moyen' => 'Moyen', 'luxe' => 'Luxe'][$budget];

        $hotels = $this->hotels[$ville][$budget]   ?? [];
        $sites  = $this->sites[$ville][$activite]  ?? [];

        // Si pas de données pour cette ville, fallback Cotonou
        if (empty($hotels)) $hotels = $this->hotels['cotonou'][$budget] ?? [];
        if (empty($sites))  $sites  = $this->sites['cotonou'][$activite] ?? [];

        return [
            "reponse"  => "Voici vos recommandations pour **{$nomVille}** ({$duree}) 🎉",
            "type"     => "resultats",
            "resume"   => [
                "ville"   => $nomVille,
                "duree"   => $duree,
                "budget"  => $budgetLabel,
                "activite"=> $activite,
            ],
            "hotels"   => $hotels,
            "sites"    => $sites,
            "options"  => ["Voir d'autres activités", "Changer de budget", "Changer de ville", "🔄 Recommencer"],
        ];
    }

    private function reponseHotels() {
        $ville  = $_SESSION['chatbot']['ville']  ?? 'cotonou';
        $budget = $_SESSION['chatbot']['budget'] ?? 'moyen';
        $hotels = $this->hotels[$ville][$budget] ?? [];
        $nomVille = $this->villes[$ville]['nom'] ?? ucfirst($ville);

        return [
            "reponse" => "🏨 Hôtels à {$nomVille} ({$budget}) :",
            "type"    => "hotels",
            "hotels"  => $hotels,
            "options" => ["Voir les sites", "Changer de budget", "🔄 Recommencer"],
        ];
    }

    private function reponseSites() {
        $ville   = $_SESSION['chatbot']['ville']    ?? 'cotonou';
        $activite= $_SESSION['chatbot']['activite'] ?? 'culture';
        $sites   = $this->sites[$ville][$activite]  ?? [];
        $nomVille = $this->villes[$ville]['nom'] ?? ucfirst($ville);

        return [
            "reponse" => "📍 Sites à {$nomVille} :",
            "type"    => "sites",
            "sites"   => $sites,
            "options" => ["Voir les hôtels", "Voir d'autres activités", "🔄 Recommencer"],
        ];
    }

    // ------------------------------------------------
    // CONVERSATION LIBRE (fallback)
    // ------------------------------------------------

    private function etapeLibre($msg, $raw) {

        // Salutations
        if ($this->contient($msg, ['bonjour','salut','hello','bonsoir','salam','bonne journee'])) {
            return [
                "reponse" => $this->random([
                    "Bonjour ! 👋 Comment puis-je vous aider ?",
                    "Salut ! 😊 Besoin d'infos touristiques sur le Bénin ?",
                    "Bonsoir ! 🌙 Je suis votre guide touristique béninois.",
                ]),
                "type"    => "boutons",
                "options" => ["Planifier mon voyage", "Hôtels", "Sites touristiques"],
            ];
        }

        // Horaires
        if ($this->contient($msg, ['horaire','heure','ouverture','fermeture','quand'])) {
            return [
                "reponse" => "Les horaires varient selon les sites. En général :\n• Musées : 9h–17h (fermés lundi)\n• Marchés : 6h–18h\n• Sites naturels : lever–coucher du soleil\n\nQuel site vous intéresse ?",
                "type"    => "boutons",
                "options" => ["Sites à Cotonou", "Sites à Ouidah", "Sites à Porto-Novo"],
            ];
        }

        // Tarifs
        if ($this->contient($msg, ['prix','tarif','cout','combien','entree','ticket'])) {
            return [
                "reponse" => "Les tarifs d'entrée au Bénin sont très accessibles 💰 :\n• Sites gratuits : plages, marchés\n• Musées : 500–2 000 FCFA\n• Parcs naturels : 2 000–5 000 FCFA + guide\n\nPour quel site voulez-vous le tarif exact ?",
                "type"    => "texte",
            ];
        }

        // Accès / transport
        if ($this->contient($msg, ['acces','transport','comment aller','zem','taxi','bus'])) {
            return [
                "reponse" => "Transports au Bénin 🚗 :\n• Zemidjans (motos-taxis) : rapides et économiques\n• Taxis : confort, négociez le prix avant\n• Bus : liaisons inter-villes Cotonou–Parakou\n• Location de voiture : disponible à Cotonou",
                "type"    => "texte",
            ];
        }

        // Villes mentionnées sans contexte
        foreach ($this->villes as $cle => $info) {
            if ($this->contient($msg, [$cle])) {
                $_SESSION['chatbot']['ville'] = $cle;
                $_SESSION['chatbot']['etape'] = 'duree';
                return [
                    "reponse" => "{$info['emoji']} {$info['nom']} vous intéresse ! Combien de jours prévoyez-vous ?",
                    "type"    => "boutons",
                    "options" => ["1–2 jours", "3–5 jours", "1 semaine", "Plus d'une semaine"],
                ];
            }
        }

        // Intentions depuis la base de données
        $intentions = $this->model->query("SELECT * FROM chatbot_intentions");
        foreach ($intentions as $i) {
            if ($this->match($msg, $i->mot_cle)) {
                return ["reponse" => $i->reponse_texte, "type" => "texte"];
            }
        }

        // Fallback
        return [
            "reponse" => $this->random([
                "Je n'ai pas bien compris 🤔 Essayez 'hôtel Cotonou' ou 'sites à Ouidah'.",
                "Pouvez-vous reformuler ? 😊 Je peux vous aider sur les hôtels, sites et transports.",
                "Je suis encore en apprentissage 😅 Essayez de choisir parmi les options proposées.",
            ]),
            "type"    => "boutons",
            "options" => ["Planifier mon voyage", "Voir les hôtels", "Voir les sites"],
        ];
    }

    // ------------------------------------------------
    // UTILITAIRES
    // ------------------------------------------------

    private function nettoyer($msg) {
        $msg = mb_strtolower($msg, 'UTF-8');
        $msg = str_replace(
            ['é','è','ê','ë','à','â','î','ï','ô','ù','û','ç','œ','æ'],
            ['e','e','e','e','a','a','i','i','o','u','u','c','oe','ae'],
            $msg
        );
        $msg = preg_replace('/[^a-z0-9\s\-]/u', '', $msg);
        return trim($msg);
    }

    private function contient($msg, $mots) {
        foreach ($mots as $mot) {
            if (strpos($msg, $mot) !== false) return true;
        }
        return false;
    }

    private function match($msg, $motCle) {
        $mots = explode(',', $motCle);
        foreach ($mots as $mot) {
            $mot = trim($this->nettoyer($mot));
            if (empty($mot)) continue;
            if (strpos($msg, $mot) !== false) return true;
            similar_text($msg, $mot, $percent);
            if ($percent > 70) return true;
        }
        return false;
    }

    private function random($responses) {
        return $responses[array_rand($responses)];
    }

    private function resetSession() {
        $_SESSION['chatbot'] = [
            'etape'   => 'accueil',
            'ville'   => null,
            'duree'   => null,
            'budget'  => null,
            'activite'=> null,
        ];
    }

    private function sauvegarder($message, $reponse) {
        $this->model->query(
            "INSERT INTO chatbot_conversations (message_utilisateur, reponse_bot, date_envoi)
             VALUES (?, ?, NOW())",
            [$message, $reponse]
        );
    }

    // ------------------------------------------------
    // POINT D'ENTRÉE : initialiser la conversation
    // ------------------------------------------------

    public function initialiser() {
        $this->resetSession();
        echo json_encode($this->etapeAccueil());
    }
}