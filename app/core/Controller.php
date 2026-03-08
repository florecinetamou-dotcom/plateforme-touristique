<?php
namespace Core;

abstract class Controller {

    /**
     * Vérifie que l'utilisateur est connecté avec le bon rôle.
     * Redirige sinon.
     */
    protected function requireAuth(string $role = null): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Pas connecté du tout
        if (empty($_SESSION['user_id'])) {
            if ($role === 'admin') {
                $this->redirect('/admin/login');
            } else {
                $this->redirect('/login');
            }
            exit;
        }

        // Rôle requis non respecté
        if ($role !== null && ($_SESSION['user_role'] ?? '') !== $role) {
            if ($role === 'admin') {
                $this->redirect('/admin/login');
            } else {
                $this->redirect('/');
            }
            exit;
        }
    }

    /**
     * Charge une vue en lui injectant les données
     */
    protected function view(string $path, array $data = []): void {
        extract($data);

        $file = dirname(__DIR__) . "/views/{$path}.php";

        if (file_exists($file)) {
            require $file;
        } else {
            die("Vue introuvable : {$path}");
        }
    }

    /**
     * Redirige vers une URL
     */
    protected function redirect(string $url): void {
        header("Location: {$url}");
        exit;
    }

    /**
     * Retourne une réponse JSON
     */
    protected function json($data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Retourne l'utilisateur connecté depuis la session
     */
    protected function authUser(): ?object {
        if (empty($_SESSION['user_id'])) {
            return null;
        }
        return (object) [
            'id'     => $_SESSION['user_id'],
            'nom'    => $_SESSION['user_nom']    ?? '',
            'prenom' => $_SESSION['user_prenom'] ?? '',
            'email'  => $_SESSION['user_email']  ?? '',
            'role'   => $_SESSION['user_role']   ?? '',
        ];
    }

    /**
     * Vérifie si un utilisateur est connecté
     */
    protected function isLoggedIn(): bool {
        return !empty($_SESSION['user_id']);
    }
}