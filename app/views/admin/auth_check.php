<?php
// On vérifie si une session est déjà démarrée, sinon on la lance
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Sécurité : Vérifie si l'utilisateur est connecté et possède le rôle admin.
 * Si ce n'est pas le cas, redirection immédiate vers la page de connexion.
 */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // On utilise un chemin relatif intelligent ou absolu
    // Si tes fichiers sont dans admin/villes/ ou admin/chatbot/, 
    // il faut remonter suffisamment de dossiers pour trouver login.php
    header("Location: /login.php"); 
    exit();
}
?>