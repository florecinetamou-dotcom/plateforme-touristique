<?php
namespace App\Controllers\Front;

use Core\Controller;
use App\Models\Hebergement;
use App\Models\Ville;
use App\Models\SiteTouristique;
<<<<<<< HEAD
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Inclure PHPMailer
require_once ROOT_PATH . '/vendor/phpmailer/src/Exception.php';
require_once ROOT_PATH . '/vendor/phpmailer/src/PHPMailer.php';
require_once ROOT_PATH . '/vendor/phpmailer/src/SMTP.php';

class HomeController extends Controller {

    private $mailConfig;

    public function __construct() {
        // Configuration PHPMailer pour Gmail
        $this->mailConfig = [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => 'beninexplore33@gmail.com',
            'password' => 'bvlqecxfmvpwdkww', // Sans espaces
            'encryption' => PHPMailer::ENCRYPTION_STARTTLS,
            'from_email' => 'beninexplore33@gmail.com',
            'from_name' => 'BeninExplore'
        ];
    }

=======
use App\Models\Avis;

class HomeController extends Controller {

>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
    public function index() {
        $hebergementModel = new Hebergement();
        $villeModel       = new Ville();
        $siteModel        = new SiteTouristique();

        // ── Hébergements populaires (3) avec photo ──
        $hebergementsPopulaires = $hebergementModel->query(
            "SELECT h.*, v.nom as ville_nom,
                    (SELECT url FROM photo_hebergement
                     WHERE hebergement_id = h.id AND est_principale = 1
                     LIMIT 1) as photo
             FROM hebergement h
             JOIN ville v ON h.ville_id = v.id
             WHERE h.statut = 'approuve'
             ORDER BY h.note_moyenne DESC, h.date_creation DESC
             LIMIT 3"
        );

<<<<<<< HEAD
        // ── Villes actives avec nb hébergements + nb sites ──
=======
        // ── Villes actives avec nb hébergements + photo ──
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $villes = $villeModel->query(
            "SELECT v.*,
                    (SELECT COUNT(*) FROM hebergement h
                     WHERE h.ville_id = v.id AND h.statut = 'approuve') as nb_hebergements,
                    (SELECT COUNT(*) FROM site_touristique s
                     WHERE s.ville_id = v.id AND s.est_valide = 1) as nb_sites
             FROM ville v
             WHERE v.est_active = 1
             ORDER BY nb_hebergements DESC
             LIMIT 3"
        );

        // ── Sites touristiques populaires (4) avec photo ──
        $sitesPopulaires = $siteModel->query(
            "SELECT s.*, v.nom as ville_nom,
                    (SELECT url FROM photo_site_touristique
                     WHERE site_id = s.id AND est_principale = 1
                     LIMIT 1) as photo_url
             FROM site_touristique s
             JOIN ville v ON s.ville_id = v.id
             WHERE s.est_valide = 1
             ORDER BY s.id DESC
             LIMIT 4"
        );

        // ── Stats réelles ──
        $stats = $hebergementModel->query(
            "SELECT
<<<<<<< HEAD
                (SELECT COUNT(*) FROM hebergement      WHERE statut = 'approuve') as nb_hebergements,
                (SELECT COUNT(*) FROM site_touristique WHERE est_valide = 1)      as nb_sites,
                (SELECT COUNT(*) FROM ville            WHERE est_active = 1)      as nb_villes,
                (SELECT COUNT(*) FROM utilisateur      WHERE role = 'voyageur')   as nb_voyageurs"
        );
        $stats = $stats[0] ?? null;

=======
                (SELECT COUNT(*) FROM hebergement     WHERE statut = 'approuve')  as nb_hebergements,
                (SELECT COUNT(*) FROM site_touristique WHERE est_valide = 1)       as nb_sites,
                (SELECT COUNT(*) FROM ville            WHERE est_active = 1)       as nb_villes,
                (SELECT COUNT(*) FROM utilisateur      WHERE role = 'voyageur')    as nb_voyageurs"
        );
        $stats = $stats[0] ?? null;

        // ── Derniers avis (témoignages) ──
        $avisModel   = new Avis();
        $temoignages = $avisModel->query(
            "SELECT a.*, u.prenom, u.nom, u.avatar_url, v.nom as ville_nom
             FROM avis a
             JOIN utilisateur u ON a.voyageur_id = u.id
             JOIN hebergement h ON a.hebergement_id = h.id
             JOIN ville v ON h.ville_id = v.id
             WHERE a.est_verifie = 1 AND a.note_globale >= 4
             ORDER BY a.date_creation DESC
             LIMIT 3"
        );

>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        $this->view('front/home/index', [
            'title'                   => 'Accueil - BeninExplore',
            'hebergements_populaires' => $hebergementsPopulaires,
            'villes'                  => $villes,
            'sites_populaires'        => $sitesPopulaires,
            'stats'                   => $stats,
<<<<<<< HEAD
=======
            'temoignages'             => $temoignages,
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        ]);
    }

    public function about() {
        $this->view('front/home/about', ['title' => 'À propos - BeninExplore']);
    }

    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleContact();
<<<<<<< HEAD
            return;
=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        }
        $this->view('front/home/contact', ['title' => 'Contact - BeninExplore']);
    }

    private function handleContact(): void {
<<<<<<< HEAD
        $name    = trim($_POST['nom']    ?? '');
        $email   = trim($_POST['email']   ?? '');
        $sujet   = trim($_POST['sujet']   ?? 'autre');
        $message = trim($_POST['message'] ?? '');
        $rgpd    = isset($_POST['rgpd']) ? true : false;

        $errors = [];

        if (empty($name)) {
            $errors[] = "Le nom est requis";
        }
        if (empty($email)) {
            $errors[] = "L'email est requis";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide";
        }
        if (empty($sujet)) {
            $errors[] = "Veuillez sélectionner un sujet";
        }
        if (empty($message)) {
            $errors[] = "Le message est requis";
        } elseif (strlen($message) < 10) {
            $errors[] = "Le message doit contenir au moins 10 caractères";
        }
        if (!$rgpd) {
            $errors[] = "Vous devez accepter la politique de confidentialité";
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old']   = $_POST;
            $this->redirect('/contact');
            return;
        }

        // Envoi avec PHPMailer
        if ($this->sendContactEmail($name, $email, $sujet, $message)) {
            $_SESSION['success'] = "Message envoyé avec succès ! Nous vous répondrons sous 24h.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'envoi du message. Veuillez réessayer.";
=======
        $name    = trim($_POST['name']    ?? '');
        $email   = trim($_POST['email']   ?? '');
        $message = trim($_POST['message'] ?? '');

        $errors = [];
        if (empty($name))                                 $errors[] = "Le nom est requis";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))   $errors[] = "Email invalide";
        if (strlen($message) < 10)                        $errors[] = "Message trop court";

        if (empty($errors)) {
            $_SESSION['success'] = "Message envoyé avec succès !";
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old']   = $_POST;
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
        }

        $this->redirect('/contact');
    }
<<<<<<< HEAD

    private function sendContactEmail($name, $email, $sujet, $message): bool {
        try {
            $mail = new PHPMailer(true);
            
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host = $this->mailConfig['host'];
            $mail->Port = $this->mailConfig['port'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->mailConfig['username'];
            $mail->Password = $this->mailConfig['password'];
            $mail->SMTPSecure = $this->mailConfig['encryption'];

            //  ← Ajouter ces lignes pour Laragon (développement)
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ]
            ];
            
            $mail->SMTPDebug = 0;
            $mail->CharSet = 'UTF-8';
            
            // Expéditeur et destinataire
            $mail->setFrom($this->mailConfig['from_email'], $this->mailConfig['from_name']);
            $mail->addAddress('contact@beninexplore.bj', 'BeninExplore');
            $mail->addReplyTo($email, $name);
            
            // Contenu
            $mail->isHTML(true);
            $mail->Subject = "[Contact BeninExplore] " . $this->getSujetLabel($sujet);
            $mail->Body = $this->getAdminEmailTemplate($name, $email, $sujet, $message);
            $mail->AltBody = "Nom: $name\nEmail: $email\nMessage: $message";
            
            $mail->send();
            
            // Envoi de l'accusé de réception
            $this->sendAckEmail($email, $name, $sujet, $message);
            
            return true;
            
        } catch (Exception $e) {
            error_log("Erreur PHPMailer contact: " . $mail->ErrorInfo);
            return false;
        }
    }

    private function sendAckEmail($to, $name, $sujet, $message): void {
        try {
            $mail = new PHPMailer(true);
            
            $mail->isSMTP();
            $mail->Host = $this->mailConfig['host'];
            $mail->Port = $this->mailConfig['port'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->mailConfig['username'];
            $mail->Password = $this->mailConfig['password'];
            $mail->SMTPSecure = $this->mailConfig['encryption'];
            
            $mail->SMTPDebug = 0;
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom($this->mailConfig['from_email'], $this->mailConfig['from_name']);
            $mail->addAddress($to, $name);
            
            $mail->isHTML(true);
            $mail->Subject = "BeninExplore - Accusé de réception";
            $mail->Body = $this->getUserEmailTemplate($name, $sujet, $message);
            
            $mail->send();
            
        } catch (Exception $e) {
            error_log("Erreur envoi accusé: " . $mail->ErrorInfo);
        }
    }

    private function getSujetLabel($sujet): string {
        $sujets = [
            'reservation' => 'Réservation',
            'hebergement' => 'Hébergement',
            'site' => 'Site touristique',
            'partenariat' => 'Partenariat',
            'autre' => 'Autre'
        ];
        return $sujets[$sujet] ?? 'Demande générale';
    }

    private function getAdminEmailTemplate($name, $email, $sujet, $message): string {
        return '
        <!DOCTYPE html>
        <html>
        <head><meta charset="UTF-8"></head>
        <body style="font-family: Arial, sans-serif;">
            <h2 style="color: #008751;">📩 Nouveau message de contact</h2>
            <table style="border-collapse: collapse; width: 100%;">
                <tr style="background: #f5f5f5;"><td style="padding: 10px; font-weight: bold;">Nom :</td><td style="padding: 10px;">' . htmlspecialchars($name) . '</td></tr>
                <tr><td style="padding: 10px; font-weight: bold;">Email :</td><td style="padding: 10px;">' . htmlspecialchars($email) . '</td></tr>
                <tr style="background: #f5f5f5;"><td style="padding: 10px; font-weight: bold;">Sujet :</td><td style="padding: 10px;">' . $this->getSujetLabel($sujet) . '</td></tr>
                <tr><td style="padding: 10px; font-weight: bold;">Message :</td><td style="padding: 10px;">' . nl2br(htmlspecialchars($message)) . '</td></tr>
            </table>
            <hr>
            <p style="font-size: 12px; color: #888;">Message envoyé depuis le formulaire de contact BeninExplore</p>
        </body>
        </html>
        ';
    }

    private function getUserEmailTemplate($name, $sujet, $message): string {
        return '
        <!DOCTYPE html>
        <html>
        <head><meta charset="UTF-8"></head>
        <body style="font-family: Arial, sans-serif;">
            <h2 style="color: #008751;">✅ Merci de nous avoir contactés !</h2>
            <p>Bonjour <strong>' . htmlspecialchars($name) . '</strong>,</p>
            <p>Nous avons bien reçu votre message et nous vous répondrons dans les plus brefs délais (généralement sous 24h).</p>
            <div style="background: #f5f5f5; padding: 15px; border-radius: 8px; margin: 15px 0;">
                <p><strong>Sujet :</strong> ' . $this->getSujetLabel($sujet) . '</p>
                <p><strong>Message :</strong><br>' . nl2br(htmlspecialchars($message)) . '</p>
            </div>
            <p>Cordialement,<br><strong>L\'équipe BeninExplore</strong></p>
            <hr>
            <p style="font-size: 12px; color: #888;">Ceci est un message automatique, merci de ne pas y répondre.</p>
        </body>
        </html>
        ';
    }
=======
>>>>>>> 74d49c7af9d9097dcfef12a3b22260a097f830cc
}