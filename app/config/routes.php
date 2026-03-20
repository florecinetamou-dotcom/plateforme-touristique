<?php
return [
    // ─── PAGES PUBLIQUES ──────────────────────────────────────
    '/' => ['App\\Controllers\\Front\\HomeController', 'index'],
    '/about' => ['App\\Controllers\\Front\\HomeController', 'about'],
    '/contact' => ['App\\Controllers\\Front\\HomeController', 'contact'],

    // ─── AUTHENTIFICATION FRONT ───────────────────────────────
    '/login' => ['App\\Controllers\\Front\\AuthController', 'login'],
    '/register' => ['App\\Controllers\\Front\\AuthController', 'register'],
    '/logout' => ['App\\Controllers\\Front\\AuthController', 'logout'],

    // ─── PROFIL ───────────────────────────────────────────────
    '/profile' => ['App\\Controllers\\Front\\ProfileController', 'index'],
    '/profile/edit' => ['App\\Controllers\\Front\\ProfileController', 'edit'],
    '/profile/password' => ['App\\Controllers\\Front\\ProfileController', 'password'],

    // ─── HÉBERGEMENTS ─────────────────────────────────────────
    '/hebergements' => ['App\\Controllers\\Front\\HebergementController', 'index'],
    '/hebergement/{id}' => ['App\\Controllers\\Front\\HebergementController', 'show'],

    // ─── VILLES ───────────────────────────────────────────────
    '/villes' => ['App\\Controllers\\Front\\VilleController', 'index'],
    '/ville/{id}' => ['App\\Controllers\\Front\\VilleController', 'show'],

    // ─── SITES TOURISTIQUES ───────────────────────────────────
    '/sites' => ['App\\Controllers\\Front\\SiteController', 'index'],
    '/site/{id}' => ['App\\Controllers\\Front\\SiteController', 'show'],

    // ─── RÉSERVATIONS FRONT ───────────────────────────────────
    '/hebergement/{id}/reserver' => ['App\\Controllers\\Front\\ReservationController', 'create'],
    '/reservation/create' => ['App\\Controllers\\Front\\ReservationController', 'store'],
    '/reservation/confirmation/{id}' => ['App\\Controllers\\Front\\ReservationController', 'confirmation'],
    '/reservations' => ['App\\Controllers\\Front\\ReservationController', 'index'],
    '/reservation/{id}' => ['App\\Controllers\\Front\\ReservationController', 'show'],
    '/reservation/{id}/annuler' => ['App\\Controllers\\Front\\ReservationController', 'cancel'],

    // ─── ESPACE HÉBERGEUR ─────────────────────────────────────
    '/hebergeur/dashboard' => ['App\\Controllers\\Hebergeur\\DashboardController', 'index'],
    '/hebergeur/hebergements' => ['App\\Controllers\\Hebergeur\\HebergementController', 'index'],
    '/hebergeur/hebergements/create' => ['App\\Controllers\\Hebergeur\\HebergementController', 'create'],
    '/hebergeur/hebergements/store' => ['App\\Controllers\\Hebergeur\\HebergementController', 'store'],
    '/hebergeur/hebergements/edit/{id}' => ['App\\Controllers\\Hebergeur\\HebergementController', 'edit'],
    '/hebergeur/hebergements/update/{id}' => ['App\\Controllers\\Hebergeur\\HebergementController', 'update'],
    '/hebergeur/hebergements/delete/{id}' => ['App\\Controllers\\Hebergeur\\HebergementController', 'delete'],
    '/hebergeur/reservations' => ['App\\Controllers\\Hebergeur\\ReservationController', 'index'],
    '/hebergeur/reservations/confirmer/{id}' => ['App\\Controllers\\Hebergeur\\ReservationController', 'confirmer'],
    '/hebergeur/reservations/annuler/{id}' => ['App\\Controllers\\Hebergeur\\ReservationController', 'annuler'],
    '/hebergeur/profil' => ['App\\Controllers\\Hebergeur\\ProfilController', 'index'],
    '/hebergeur/profil/edit' => ['App\\Controllers\\Hebergeur\\ProfilController', 'edit'],
    '/hebergeur/profil/update' => ['App\\Controllers\\Hebergeur\\ProfilController', 'update'],
    '/hebergeur/photos/delete/{id}' => ['App\\Controllers\\Hebergeur\\PhotoController', 'delete'],
    '/hebergeur/photos/set-principale/{id}' => ['App\\Controllers\\Hebergeur\\PhotoController', 'setPrincipale'],

    // ─── ESPACE ADMIN — AUTHENTIFICATION ──────────────────────
    '/admin/login' => ['App\\Controllers\\Admin\\AdminAuthController', 'loginPage'],
    '/admin/login/post' => ['App\\Controllers\\Admin\\AdminAuthController', 'login'],
    '/admin/logout' => ['App\\Controllers\\Admin\\AdminAuthController', 'logout'],

    // ─── ESPACE ADMIN — DASHBOARD ─────────────────────────────
    '/admin/dashboard' => ['App\\Controllers\\Admin\\DashboardController', 'index'],

    // ─── ESPACE ADMIN — UTILISATEURS ──────────────────────────
    '/admin/utilisateurs' => ['App\\Controllers\\Admin\\UserAdminController', 'index'],
    '/admin/utilisateurs/{id}' => ['App\\Controllers\\Admin\\UserAdminController', 'show'],
    '/admin/utilisateurs/{id}/bloquer' => ['App\\Controllers\\Admin\\UserAdminController', 'bloquer'],
    '/admin/utilisateurs/{id}/debloquer' => ['App\\Controllers\\Admin\\UserAdminController', 'debloquer'],
    '/admin/utilisateurs/{id}/supprimer' => ['App\\Controllers\\Admin\\UserAdminController', 'supprimer'],
    '/admin/utilisateurs/{id}/changerRole' => ['App\\Controllers\\Admin\\UserAdminController', 'changerRole'],

    // ─── ESPACE ADMIN — HÉBERGEMENTS ──────────────────────────
    '/admin/hebergements' => ['App\\Controllers\\Admin\\HebergementAdminController', 'index'],
    '/admin/hebergements/{id}' => ['App\\Controllers\\Admin\\HebergementAdminController', 'show'],
    '/admin/hebergements/{id}/valider' => ['App\\Controllers\\Admin\\HebergementAdminController', 'valider'],
    '/admin/hebergements/{id}/rejeter' => ['App\\Controllers\\Admin\\HebergementAdminController', 'rejeter'],

    // ─── ESPACE ADMIN — VILLES ────────────────────────────────
    '/admin/villes' => ['App\\Controllers\\Admin\\VilleAdminController', 'index'],
    '/admin/villes/create' => ['App\\Controllers\\Admin\\VilleAdminController', 'create'],
    '/admin/villes/store' => ['App\\Controllers\\Admin\\VilleAdminController', 'store'],
    '/admin/villes/edit/{id}' => ['App\\Controllers\\Admin\\VilleAdminController', 'edit'],
    '/admin/villes/update/{id}' => ['App\\Controllers\\Admin\\VilleAdminController', 'update'],
    '/admin/villes/toggle/{id}' => ['App\\Controllers\\Admin\\VilleAdminController', 'toggleActive'],
    '/admin/villes/delete/{id}' => ['App\\Controllers\\Admin\\VilleAdminController', 'delete'],
    '/admin/villes/{id}' => ['App\\Controllers\\Admin\\VilleAdminController', 'show'],

    // ─── ESPACE ADMIN — AVIS ──────────────────────────────────
    '/admin/avis' => ['App\\Controllers\\Admin\\AvisAdminController', 'index'],
    '/admin/avis/{id}' => ['App\\Controllers\\Admin\\AvisAdminController', 'show'],
    '/admin/avis/{id}/verifier' => ['App\\Controllers\\Admin\\AvisAdminController', 'verifier'],
    '/admin/avis/{id}/supprimer' => ['App\\Controllers\\Admin\\AvisAdminController', 'supprimer'],
    '/admin/avis/{id}/rejeterSignalement' => ['App\\Controllers\\Admin\\AvisAdminController', 'rejeterSignalement'],

    // ─── ESPACE ADMIN — FAVORIS ───────────────────────────────
    '/admin/favoris' => ['App\\Controllers\\Admin\\FavoriAdminController', 'index'],

    // ─── ESPACE ADMIN — CHATBOT ───────────────────────────────
    '/admin/chatbot' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'index'],

    '/admin/chatbot/conversations' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'conversations'],
    '/admin/chatbot/conversations/{session}' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'conversation'],
    '/admin/chatbot/conversations/{id}/supprimer' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'supprimerConversation'],
    '/admin/chatbot/vider' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'viderConversations'],
    '/admin/chatbot/intentions' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'intentions'],
    '/admin/chatbot/intentions/creer' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'creerIntention'],
    '/admin/chatbot/intentions/{id}/modifier' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'modifierIntention'],
    '/admin/chatbot/intentions/{id}/supprimer' => ['App\\Controllers\\Admin\\ChatbotAdminController', 'supprimerIntention'],

    //  ESPACE ADMIN — SITES TOURISTIQUES
    '/admin/sites' => ['App\\Controllers\\Admin\\SiteAdminController', 'index'],
    '/admin/sites/create' => ['App\\Controllers\\Admin\\SiteAdminController', 'create'],
    '/admin/sites/store' => ['App\\Controllers\\Admin\\SiteAdminController', 'store'],
    '/admin/sites/{id}' => ['App\\Controllers\\Admin\\SiteAdminController', 'show'],
    '/admin/sites/{id}/edit' => ['App\\Controllers\\Admin\\SiteAdminController', 'edit'],
    '/admin/sites/{id}/update' => ['App\\Controllers\\Admin\\SiteAdminController', 'update'],
    '/admin/sites/{id}/toggle' => ['App\\Controllers\\Admin\\SiteAdminController', 'toggleValide'],
    '/admin/sites/{id}/supprimer' => ['App\\Controllers\\Admin\\SiteAdminController', 'supprimer'],

    // ESPACE ADMIN — RÉSERVATIONS
    '/admin/reservations' => ['App\\Controllers\\Admin\\ReservationAdminController', 'index'],
    '/admin/reservations/{id}' => ['App\\Controllers\\Admin\\ReservationAdminController', 'show'],
    '/admin/reservations/{id}/confirmer' => ['App\\Controllers\\Admin\\ReservationAdminController', 'confirmer'],
    '/admin/reservations/{id}/annuler' => ['App\\Controllers\\Admin\\ReservationAdminController', 'annuler'],

    // FAVORIS FRONT
    '/favoris' => ['App\\Controllers\\Front\\FavoriController', 'index'],
    '/favori/toggle/{id}' => ['App\\Controllers\\Front\\FavoriController', 'toggle'],

    // MOT DE PASSE OUBLIÉ

    '/forgot_password' => ['App\\Controllers\\Front\\AuthController', 'forgotPassword'],
    '/reset_password' => ['App\\Controllers\\Front\\AuthController', 'resetPassword'],

    // chatbot widget
    '/chatbot/message' => ['App\\Controllers\\Front\\ChatbotController', 'message'],

    // chatbot history
    '/chatbot/history' => ['App\\Controllers\\Front\\ChatbotController', 'history'],
];