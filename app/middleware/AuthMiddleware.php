<?php
namespace App\Middleware;

class AuthMiddleware {
    public static function user() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Veuillez vous connecter";
            header('Location: /login');
            exit();
        }
    }
    
    public static function admin() {
        if (!isset($_SESSION['admin'])) {
            $_SESSION['admin_error'] = "Veuillez vous connecter";
            header('Location: /admin/login');
            exit();
        }
    }
    
    public static function hebergeur() {
        self::user();
        if ($_SESSION['user']['role'] !== 'hebergeur') {
            $_SESSION['error'] = "Accès réservé aux hébergeurs";
            header('Location: /profile');
            exit();
        }
    }
}