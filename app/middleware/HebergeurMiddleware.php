<?php
namespace App\Middleware;

class HebergeurMiddleware {
    
    public static function check() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter";
            header('Location: /login');
            exit;
        }
        
        if ($_SESSION['user_role'] !== 'hebergeur') {
            $_SESSION['error'] = "Accès non autorisé. Espace réservé aux hébergeurs.";
            header('Location: /');
            exit;
        }
        
        return true;
    }
}