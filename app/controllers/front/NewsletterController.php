<?php
namespace App\Controllers\Front;

use Core\Controller;

class NewsletterController extends Controller {
    
    public function subscribe() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
            return;
        }
        
        $email = trim($_POST['email'] ?? '');
        $consent = isset($_POST['consent']) ? 1 : 0;
        
        // Validation
        if (empty($email)) {
            $_SESSION['error'] = "Veuillez entrer votre adresse email";
            $this->redirect('/');
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Adresse email invalide";
            $this->redirect('/');
            return;
        }
        
        if (!$consent) {
            $_SESSION['error'] = "Veuillez accepter de recevoir nos emails";
            $this->redirect('/');
            return;
        }
        
        try {
            $db = \Core\Database::getInstance();
            
            // ✅ Vérifier si l'utilisateur existe dans la table utilisateur
            $stmt = $db->prepare("SELECT id, newsletter FROM utilisateur WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user) {
                // ✅ L'utilisateur existe : mettre à jour la colonne newsletter
                if ($user->newsletter == 1) {
                    $_SESSION['warning'] = "Vous êtes déjà inscrit à notre newsletter";
                } else {
                    $stmt = $db->prepare("UPDATE utilisateur SET newsletter = 1 WHERE email = ?");
                    $stmt->execute([$email]);
                    $_SESSION['success'] = "✅ Inscription réussie ! Vous recevrez nos actualités.";
                }
            } else {
                // ❌ L'utilisateur n'existe pas
                $_SESSION['error'] = "Cet email n'est pas inscrit sur notre plateforme. <a href='/register' style='color:#008751;text-decoration:underline;'>Créez un compte</a> d'abord.";
            }
            
        } catch (\Exception $e) {
            error_log("Erreur newsletter: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de l'inscription. Veuillez réessayer.";
        }
        
        $this->redirect('/');
    }
}