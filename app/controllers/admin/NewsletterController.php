<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__, 3) . '/vendor/phpmailer/src/Exception.php';
require_once dirname(__DIR__, 3) . '/vendor/phpmailer/src/PHPMailer.php';
require_once dirname(__DIR__, 3) . '/vendor/phpmailer/src/SMTP.php';
class NewsletterController extends Controller
{

    private $mailConfig;

    public function __construct()
    {
        $this->requireAuth('admin');

        $this->mailConfig = [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => 'beninexplore33@gmail.com',
            'password' => 'bvlq ecxf mvpw dkww',
            'encryption' => PHPMailer::ENCRYPTION_STARTTLS,
            'from_email' => 'beninexplore33@gmail.com',
            'from_name' => 'BeninExplore'
        ];
    }

    public function index()
    {
        $userModel = new User();

        // ✅ Récupérer TOUS les utilisateurs (pas seulement newsletter)
        $utilisateurs = $userModel->query(
            "SELECT id, email, prenom, nom, newsletter FROM utilisateur ORDER BY id DESC"
        );

        $total_utilisateurs = count($utilisateurs);
        $newsletter_inscrits = $userModel->query("SELECT COUNT(*) as nb FROM utilisateur WHERE newsletter = 1")[0]->nb ?? 0;

        $this->view('admin/newsletter/index', [
            'title' => 'Newsletter - Administration',
            'utilisateurs' => $utilisateurs,
            'total_utilisateurs' => $total_utilisateurs,
            'newsletter_inscrits' => $newsletter_inscrits
        ]);
    }


    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/newsletter');
            return;
        }

        $sujet = trim($_POST['sujet'] ?? '');
        $contenu = trim($_POST['contenu'] ?? '');
        $testEmail = trim($_POST['test_email'] ?? '');
        $cible = $_POST['cible'] ?? 'tous'; // 'tous', 'newsletter', 'voyageurs', 'hebergeurs'

        if (empty($sujet) || empty($contenu)) {
            $_SESSION['error'] = "Le sujet et le contenu sont obligatoires";
            $this->redirect('/admin/newsletter');
            return;
        }

        // Test email
        if (!empty($testEmail) && filter_var($testEmail, FILTER_VALIDATE_EMAIL)) {
            if ($this->sendEmail($testEmail, $sujet, $contenu)) {
                $_SESSION['success'] = "Email de test envoyé à $testEmail";
            } else {
                $_SESSION['error'] = "Erreur d'envoi du test";
            }
            $this->redirect('/admin/newsletter');
            return;
        }

        // ✅ Construire la requête selon la cible
        $userModel = new User();

        switch ($cible) {
            case 'newsletter':
                $query = "SELECT id, email, prenom, nom FROM utilisateur WHERE newsletter = 1";
                $label = "abonnés à la newsletter";
                break;
            case 'voyageurs':
                $query = "SELECT id, email, prenom, nom FROM utilisateur WHERE role = 'voyageur'";
                $label = "voyageurs";
                break;
            case 'hebergeurs':
                $query = "SELECT id, email, prenom, nom FROM utilisateur WHERE role = 'hebergeur'";
                $label = "hébergeurs";
                break;
            default:
                $query = "SELECT id, email, prenom, nom FROM utilisateur";
                $label = "tous les utilisateurs";
                break;
        }

        $destinataires = $userModel->query($query);

        if (empty($destinataires)) {
            $_SESSION['error'] = "Aucun destinataire trouvé pour la cible '$cible'";
            $this->redirect('/admin/newsletter');
            return;
        }

        $success = 0;
        $errors = 0;

        foreach ($destinataires as $destinataire) {
            $personalizedContent = str_replace(
                ['{prenom}', '{nom}'],
                [$destinataire->prenom ?? '', $destinataire->nom ?? ''],
                $contenu
            );

            if ($this->sendEmail($destinataire->email, $sujet, $personalizedContent)) {
                $success++;
            } else {
                $errors++;
            }

            usleep(50000);
        }

        $_SESSION['success'] = "Email envoyé à $success $label. $errors échec(s).";
        $this->redirect('/admin/newsletter');
    }

    private function sendEmail($to, $subject, $message)
    {
        $mail = null;
        try {
            $mail = new PHPMailer(true);

            $mail->SMTPDebug = 2;
            ob_start(); // capturer l'output debug

            $mail->isSMTP();
            $mail->Host = $this->mailConfig['host'];
            $mail->Port = $this->mailConfig['port'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->mailConfig['username'];
            $mail->Password = $this->mailConfig['password'];
            $mail->SMTPSecure = $this->mailConfig['encryption'];

            // ← Ajouter ces lignes pour Laragon (développement)
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ]
            ];

            $mail->SMTPDebug = 0;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($this->mailConfig['from_email'], $this->mailConfig['from_name']);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $this->getEmailTemplate($subject, $message);
            $mail->AltBody = strip_tags($message);

            return $mail->send();
        } catch (Exception $e) {
            $debug = ob_get_clean();
            $errorMsg = $mail ? $mail->ErrorInfo : $e->getMessage();
            error_log("DEBUG SMTP: " . $debug);
            error_log("Erreur PHPMailer: " . $errorMsg);
            $_SESSION['error'] = $errorMsg . " | " . substr($debug, -300);
            return false;
        }
    }

    private function getEmailTemplate($subject, $content)
    {
        $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . htmlspecialchars($subject) . '</title>
            <style>
                body { margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4; }
                .container { max-width: 600px; margin: 0 auto; }
                .header { background: linear-gradient(135deg, #008751, #00a862); padding: 30px; text-align: center; }
                .header h1 { color: #fff; margin: 0; font-size: 28px; }
                .header p { color: #fcd116; margin: 10px 0 0 0; }
                .content { background: #ffffff; padding: 30px; }
                .content p { font-size: 16px; line-height: 1.6; color: #333; }
                .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #999; }
                .footer a { color: #008751; text-decoration: none; }
            </style>
        </head>
        <body>
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;padding:20px;">
                <tr>
                    <td align="center">
                        <div class="container">
                            <div class="header">
                                <h1>BeninExplore</h1>
                                <p>Votre guide du Bénin</p>
                            </div>
                            <div class="content">
                                ' . nl2br(htmlspecialchars($content)) . '
                            </div>
                            <div class="footer">
                                <p>© ' . date('Y') . ' BeninExplore</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ';
    }
}
