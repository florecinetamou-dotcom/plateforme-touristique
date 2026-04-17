<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailService {
    
    private $mail;
    private $config;
    
    public function __construct() {
        // Configuration pour Gmail (à adapter)
        $this->config = [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => 'votre-email@gmail.com', // Remplacez par votre email
            'password' => 'votre-mot-de-passe',     // Remplacez par votre mot de passe
            'encryption' => PHPMailer::ENCRYPTION_STARTTLS,
            'from_email' => 'newsletter@beninexplore.bj',
            'from_name' => 'BeninExplore'
        ];
        
        $this->initialize();
    }
    
    private function initialize() {
        $this->mail = new PHPMailer(true);
        
        // Configuration SMTP
        $this->mail->isSMTP();
        $this->mail->Host = $this->config['host'];
        $this->mail->Port = $this->config['port'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->config['username'];
        $this->mail->Password = $this->config['password'];
        $this->mail->SMTPSecure = $this->config['encryption'];
        
        // Désactiver le debug en production
        $this->mail->SMTPDebug = 0;
        
        // Encodage
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';
        
        // Expéditeur
        $this->mail->setFrom($this->config['from_email'], $this->config['from_name']);
    }
    
    /**
     * Envoi d'email simple
     */
    public function send($to, $subject, $body, $altBody = null) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->isHTML(true);
            $this->mail->Body = $this->getTemplate($subject, $body);
            $this->mail->AltBody = $altBody ?? strip_tags($body);
            
            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Erreur envoi email: " . $this->mail->ErrorInfo);
            return false;
        }
    }
    
    /**
     * Envoi de newsletter à plusieurs destinataires
     */
    public function sendNewsletter($recipients, $subject, $content) {
        $success = 0;
        $errors = 0;
        
        foreach ($recipients as $recipient) {
            $personalizedContent = str_replace(
                ['{prenom}', '{nom}'],
                [$recipient['prenom'] ?? '', $recipient['nom'] ?? ''],
                $content
            );
            
            if ($this->send($recipient['email'], $subject, $personalizedContent)) {
                $success++;
            } else {
                $errors++;
            }
            
            // Pause pour éviter la surcharge
            usleep(100000);
        }
        
        return ['success' => $success, 'errors' => $errors];
    }
    
    /**
     * Template HTML pour la newsletter
     */
    private function getTemplate($subject, $content) {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . htmlspecialchars($subject) . '</title>
            <style>
                body { margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #008751, #00a862); padding: 30px; text-align: center; }
                .header h1 { color: #fff; margin: 0; font-size: 28px; }
                .header p { color: #fcd116; margin: 10px 0 0 0; }
                .content { background: #fff; padding: 30px; }
                .content p { font-size: 16px; line-height: 1.6; color: #333; }
                .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #999; }
                .footer a { color: #008751; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>BeninExplore</h1>
                    <p>Votre guide du Bénin</p>
                </div>
                <div class="content">
                    ' . nl2br(htmlspecialchars($content)) . '
                </div>
                <div class="footer">
                    <p>© ' . date('Y') . ' BeninExplore - Tous droits réservés</p>
                    <p><a href="' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/newsletter/unsubscribe">Se désabonner</a></p>
                </div>
            </div>
        </body>
        </html>
        ';
    }
    
    /**
     * Envoi d'email de test
     */
    public function sendTest($to) {
        $subject = "Test - BeninExplore Newsletter";
        $body = "<h1>Test réussi !</h1><p>Votre configuration SMTP fonctionne correctement.</p>";
        
        return $this->send($to, $subject, $body);
    }
}