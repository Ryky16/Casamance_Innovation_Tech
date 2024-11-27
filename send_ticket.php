<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure les fichiers PHPMailer correctement
require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $structureName = $_POST['structureName'];
    $telephone = $_POST['Téléphone'];
    $email = $_POST['email'];
    $ticketType = $_POST['ticketType'];

    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Utilisez smtp.gmail.com si vous utilisez Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'n.henripierre@gmail.com'; // Remplacez par l'email de l'entreprise
        $mail->Password = 'zdeo ymmn emrt jtxp'; // Remplacez par un mot de passe d'application si vous utilisez Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // Pour TLS, sinon 465 pour SSL

        // Destinataire (email de l'entreprise)
        $mail->setFrom('n.henripierre@gmail.com', 'Erastus Group');
        $mail->addAddress('n.henripierre@gmail.com'); // Remplacez par l'email de l'entreprise

        // Contenu de l'email
        $mail->isHTML(isHtml: true);
        $mail->Subject = 'Formule Pour Partenaire';
        $mail->Body = "
            <h2>Informations du ticket</h2>
            <p><strong>Nom de la structure :</strong> $structureName</p>
            <p><strong>Téléphone :</strong> $telephone</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Type de ticket :</strong> $ticketType</p>
        ";

        $mail->send();
        echo "Le message a bien été envoyé.";
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
    }
}




?>
<?