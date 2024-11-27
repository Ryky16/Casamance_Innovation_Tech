<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les informations du formulaire
    $name = $_POST['contact_name'];
    $email = $_POST['contact_email'];
    $subject = $_POST['contact_subject'];
    $message = $_POST['contact_message'];

    // Vérifiez si les champs sont remplis correctement
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo 'Veuillez remplir tous les champs.';
        exit;
    }

    // Configurer PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur
        $mail->isSMTP();                                            // Envoyer en utilisant SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Configurez votre serveur SMTP
        $mail->SMTPAuth   = true;                                   // Authentification SMTP activée
        $mail->Username   = 'n.henripierre@gmail.com';                // Votre adresse email SMTP
        $mail->Password   = 'qlbi gvkc fyki ljup';                   // Votre mot de passe SMTP
        $mail->SMTPSecure = 'tls';                                  // Active le chiffrement TLS0
        $mail->Port       = 587;                                    // Port SMTP (TLS)

        // Destinataires
        $mail->setFrom($email, $name);                              // Adresse de l'expéditeur
        $mail->addAddress('n.henripierre@gmail.com');           // Ajouter l'adresse de l'entreprise

        // Contenu de l'email
        $mail->isHTML(true);                                        // Email au format HTML
        $mail->Subject = $subject;
        $mail->Body    = nl2br($message);                           // Convertit les retours à la ligne en HTML

        // Envoyer l'email
        $mail->send();
        echo 'Votre message a été envoyé. Merci!';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
    }
}
?>
<?
