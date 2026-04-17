================================================================================
  TODO_Strait.txt — Fonctionnalités restantes pour atteindre la ligne d'arrivée
  Objectif MVP : Plateforme web touristique avec recommandation intelligente
================================================================================

  Légende :
  [ ] = À faire    [~] = Partiellement fait    [x] = Terminé (de référence)

────────────────────────────────────────────────────────────────────────────────
AXE 1 — AUTHENTIFICATION & GESTION DES UTILISATEURS
────────────────────────────────────────────────────────────────────────────────

[~] 1.1 — Inscription utilisateur (voyageur)
          → Vérifier que le rôle "voyageur" est bien assigné par défaut
          → Envoyer un email de bienvenue (EmailService à implémenter)

[~] 1.2 — Connexion / déconnexion front
          → S'assurer que la session stocke : user_id, role, nom, email

[ ] 1.3 — Réinitialisation de mot de passe (forgot_password / reset_password)
          → EmailService doit envoyer le lien de reset
          → Implémenter la logique token dans AuthController

[ ] 1.4 — Édition du profil utilisateur (ProfileController::edit / update)
          → Upload de photo de profil
          → Changement de mot de passe sécurisé

[ ] 1.5 — Implémenter App\Services\AuthService
          → hashPassword(), verifyPassword(), generateToken(), sendResetEmail()


────────────────────────────────────────────────────────────────────────────────
AXE 2 — HÉBERGEMENTS (Cœur du MVP)
────────────────────────────────────────────────────────────────────────────────

[~] 2.1 — Page listing hébergements (/hebergements)
          → Filtres : ville, budget min/max, type de séjour, durée
          → Pagination des résultats

[~] 2.2 — Page détail hébergement (/hebergement/{id})
          → Galerie photos (photo principale + secondaires)
          → Note moyenne et avis
          → Bouton "Réserver" visible si connecté

[ ] 2.3 — Système de recommandation intelligent (scoring)
          → Algorithme de scoring basé sur :
             - Adéquation ville (correspondance exacte = score max)
             - Compatibilité budget (prix/nuit dans la fourchette)
             - Type de séjour (loisirs, affaires, détente, culturel)
             - Durée du séjour
          → Exposer via une méthode Hebergement::getRecommandations($prefs)
          → Afficher les recommandations sur la page d'accueil et le profil

[ ] 2.4 — Calculateur de budget automatique
          → Sur la page de réservation : prix/nuit × nb_nuits = coût total
          → Afficher si dans le budget défini par l'utilisateur
          → Proposer des alternatives si hors budget


────────────────────────────────────────────────────────────────────────────────
AXE 3 — SYSTÈME DE RÉSERVATION
────────────────────────────────────────────────────────────────────────────────

[~] 3.1 — Formulaire de réservation (/hebergement/{id}/reserver)
          → Sélection date arrivée / date départ
          → Vérification des disponibilités (modèle Disponibilite à implémenter)
          → Calcul automatique du prix total

[ ] 3.2 — Confirmer / Annuler une réservation (côté voyageur)
          → Page "Mes réservations" (/reservations)
          → Annulation possible si statut = "en_attente" ou "confirmée"
          → Email de confirmation automatique (EmailService)

[ ] 3.3 — Implémenter App\Services\ReservationService
          → calculerPrix($hebergement, $dateArrivee, $dateDepart)
          → verifierDisponibilite($hebergementId, $dateArrivee, $dateDepart)
          → envoyerConfirmation($reservation)

[ ] 3.4 — Implémenter le modèle Disponibilite.php
          → isDisponible($hebergementId, $debut, $fin)
          → bloquer($hebergementId, $debut, $fin)


────────────────────────────────────────────────────────────────────────────────
AXE 4 — ESPACE HÉBERGEUR
────────────────────────────────────────────────────────────────────────────────

[~] 4.1 — Tableau de bord hébergeur
          → Statistiques : nb réservations, revenus, note moyenne
          → Hébergements listés avec statut (approuvé / en attente / rejeté)

[~] 4.2 — Créer / Modifier / Supprimer un hébergement
          → Upload de photos (photo principale + galerie)
          → Champs : nom, ville, prix/nuit, type séjour, description, capacité

[ ] 4.3 — Gérer les photos d'un hébergement (PhotoController manquant)
          → Créer app/controllers/hebergeur/PhotoController.php
          → Méthodes : delete($id), setPrincipale($id)

[~] 4.4 — Gérer les réservations reçues
          → Confirmer ou refuser une réservation
          → Notification automatique au voyageur (email)

[ ] 4.5 — Profil hébergeur (ProfilHebergeur)
          → Implémenter le modèle ProfilHebergeur.php
          → Page de profil public visible par les voyageurs


────────────────────────────────────────────────────────────────────────────────
AXE 5 — ESPACE ADMIN
────────────────────────────────────────────────────────────────────────────────

[~] 5.1 — Dashboard admin avec statistiques globales

[~] 5.2 — Validation / rejet des comptes hébergeur
          → Email de notification (hébergement validé / rejeté)

[~] 5.3 — Gestion des villes (CRUD)
          → Activer / désactiver une ville

[~] 5.4 — Supervision des hébergements et réservations

[ ] 5.5 — Gestion des utilisateurs (bloquer / débloquer un compte)

[ ] 5.6 — Supervision des avis (modération, suppression)


────────────────────────────────────────────────────────────────────────────────
AXE 6 — VILLES & SITES TOURISTIQUES
────────────────────────────────────────────────────────────────────────────────

[~] 6.1 — Page listing des villes (/villes)
          → Corriger l'erreur getAll() (voir TODO_Corrections BLOC 1)
          → Afficher : nom, photo, nb hébergements, nb sites

[~] 6.2 — Page détail d'une ville (/ville/{id})
          → Hébergements disponibles dans la ville
          → Sites touristiques associés

[~] 6.3 — Page listing des sites touristiques (/sites)
          → Filtres : catégorie, ville, recherche textuelle

[~] 6.4 — Page détail d'un site (/site/{id})
          → Hébergements à proximité
          → Ajouter méthode getWithVille() (voir TODO_Corrections 8.1)


────────────────────────────────────────────────────────────────────────────────
AXE 7 — PRÉFÉRENCES & PERSONNALISATION UTILISATEUR
────────────────────────────────────────────────────────────────────────────────

[ ] 7.1 — Formulaire de préférences utilisateur
          → Champs : budget max, ville préférée, type de séjour, durée typique
          → Sauvegarder en base (table utilisateur ou table dédiée)

[ ] 7.2 — Afficher les recommandations personnalisées sur la home
          → Si connecté : "Pour vous" avec le scoring intelligent
          → Si non connecté : afficher les hébergements populaires

[ ] 7.3 — Implémenter App\Services\SearchService
          → search($keyword, $filters) avec scoring
          → Retourner résultats triés par score décroissant


────────────────────────────────────────────────────────────────────────────────
AXE 8 — FAVORIS
────────────────────────────────────────────────────────────────────────────────

[ ] 8.1 — Implémenter le modèle Favori.php
          → addFavori($userId, $hebergementId)
          → removeFavori($userId, $hebergementId)
          → getFavoris($userId)
          → isFavori($userId, $hebergementId)

[ ] 8.2 — FavoriController front
          → Page "Mes favoris" (/favoris)
          → Bouton toggle favoris sur les cards hébergement (AJAX ou reload)


────────────────────────────────────────────────────────────────────────────────
AXE 9 — AVIS & NOTATIONS
────────────────────────────────────────────────────────────────────────────────

[ ] 9.1 — Permettre à un voyageur de laisser un avis après séjour
          → Formulaire : note (1-5), commentaire
          → Vérifier que la réservation est bien "terminée" avant de noter

[ ] 9.2 — Afficher les avis sur la page hébergement
          → Calculer et mettre à jour note_moyenne dans la table hebergement

[ ] 9.3 — Modération admin des avis (déjà prévu dans les vues admin)


────────────────────────────────────────────────────────────────────────────────
AXE 10 — EMAILS TRANSACTIONNELS
────────────────────────────────────────────────────────────────────────────────

[ ] 10.1 — Implémenter App\Services\EmailService
           → Utiliser PHPMailer ou SwiftMailer (via Composer)
           → Configurer SMTP dans .env (MAIL_HOST, MAIL_USER, MAIL_PASS)

[ ] 10.2 — Envoyer email de bienvenue à l'inscription (vue : bienvenue.php)
[ ] 10.3 — Envoyer email de confirmation de réservation (vue : reservation-confirmation.php)
[ ] 10.4 — Envoyer email d'annulation de réservation (vue : reservation-annulation.php)
[ ] 10.5 — Envoyer email hébergement validé/rejeté par l'admin


────────────────────────────────────────────────────────────────────────────────
AXE 11 — PAGES STATIQUES FRONT
────────────────────────────────────────────────────────────────────────────────

[~] 11.1 — Page d'accueil (/) avec :
           → Barre de recherche rapide (ville + dates + type)
           → Section hébergements populaires
           → Section villes à explorer
           → Section sites touristiques mis en avant

[ ] 11.2 — Page À propos (/about)
[ ] 11.3 — Page Contact (/contact) avec formulaire
           → EmailService doit envoyer le message à l'admin


────────────────────────────────────────────────────────────────────────────────
AXE 12 — QUALITÉ & MISE EN PRODUCTION
────────────────────────────────────────────────────────────────────────────────

[ ] 12.1 — Remplir le fichier .env.example avec toutes les variables nécessaires
           (DB_HOST, DB_NAME, DB_USER, DB_PASS, MAIL_*, APP_URL, APP_ENV)

[ ] 12.2 — Vérifier le fichier .htaccess pour le routage front controller
           → Toutes les URLs doivent passer par public/index.php

[ ] 12.3 — Tester l'ensemble des routes déclarées dans routes.php
           et vérifier qu'aucune n'est orpheline (controller ou méthode manquant)

[ ] 12.4 — Ajouter un fichier 404.php et 500.php attrayants (déjà dans views/errors)
           → Les câbler dans le Router en cas d'erreur / route introuvable

[ ] 12.5 — Sécurité minimale :
           → CSRF token sur tous les formulaires (CsrfMiddleware existe, à câbler)
           → Vérifier que htmlspecialchars() est utilisé sur toutes les sorties
           → Vérifier les validations d'entrée dans les Controllers


================================================================================
  ORDRE SUGGÉRÉ POUR LES SPRINTS
================================================================================

  Sprint 1 (stabilisation) → Tout le fichier TODO_Corrections.txt en premier

  Sprint 2 (noyau fonctionnel)
  → AXE 1 complet (Auth)
  → AXE 2.1 / 2.2 (listing + détail hébergements)
  → AXE 3.1 / 3.2 (réservation de base)

  Sprint 3 (différenciation MVP)
  → AXE 2.3 + 2.4 (recommandation + calculateur budget)
  → AXE 7 (préférences utilisateur)
  → AXE 4 complet (espace hébergeur)

  Sprint 4 (finitions)
  → AXE 8 (favoris), AXE 9 (avis), AXE 10 (emails)
  → AXE 5 complet (admin), AXE 11 (pages statiques)
  → AXE 12 (qualité & mise en production)

================================================================================