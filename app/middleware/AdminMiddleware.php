<?php

namespace App\Middleware;

class AdminMiddleware
{
    public static function handle()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? null) !== 'admin') {
            $_SESSION['error'] = "Accès refusé";
            header('Location: /login');
            exit;
        }
    }
}