<?php
<<<<<<< HEAD

namespace App\Middleware;

class HebergeurMiddleware
{
    public static function handle()
    {
        if (
            !isset($_SESSION['user_id']) ||
            ($_SESSION['user_type'] ?? null) !== 'hebergeur'
        ) {
            $_SESSION['error'] = "Accès réservé aux hébergeurs";
            header('Location: /');
            exit;
        }
=======
namespace App\Middleware;

use App\Models\User;

class HebergeurMiddleware
{
    public static function check()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $userModel = new User();
        $userId = $_SESSION['user_id'];
        
        // Vérifier si l'utilisateur est un hébergeur ACTIF
        if ($userModel->isHebergeurActif($userId)) {
            return true;
        }
        
        // Vérifier s'il est en attente
        if ($userModel->isHebergeurEnAttente($userId)) {
            $_SESSION['error'] = "⏳ Votre compte hébergeur est en attente de validation par l'administrateur.";
            header('Location: /profil');
            exit;
        }
        
        // Vérifier s'il est bloqué
        if ($userModel->isHebergeurBloque($userId)) {
            $_SESSION['error'] = "🔒 Votre compte hébergeur a été bloqué. Veuillez contacter l'administrateur.";
            header('Location: /profil');
            exit;
        }
        
        // Sinon, accès refusé
        $_SESSION['error'] = "Vous n'avez pas accès à l'espace hébergeur.";
        header('Location: /profil');
        exit;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    }
}