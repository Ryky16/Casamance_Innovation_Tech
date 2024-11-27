<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure les fichiers PHPMailer
require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/Exception.php';
require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/htdocs/Casamance_Innovation_tech/PHPMailer-master/PHPMailer-master/src/SMTP.php';

// Récupération des informations du formulaire de réservation
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : null;
    $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $profession = isset($_POST['profession']) ? $_POST['profession'] : null;
    $nombre_tickets = isset($_POST['nombre_tickets']) ? $_POST['nombre_tickets'] : null;

    // Vérification si tous les champs sont remplis
    if (!$prenom || !$nom || !$email || !$profession || !$nombre_tickets) {
        echo "Veuillez remplir tous les champs du formulaire.";
        return;
    }

    // Appel à l'API Eventbrite pour récupérer les informations de l'événement
    $token = "C5C2NYB6ERZFM6NNP2KN"; // Ton vrai token API
    $event_id = "1044291041617"; // ID de l'événement, extrait de l'URL Eventbrite
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.eventbriteapi.com/v3/events/" . $event_id . "/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . $token
        ),
        CURLOPT_VERBOSE => true  // Active le mode débogage pour cURL
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "Erreur cURL: " . $err;
        return;
    } 

    // Vérifions si la réponse est vide ou incorrecte
    if (empty($response)) {
        echo "Erreur : la réponse de l'API est vide.";
        return;
    }

    // Décodage de la réponse JSON
    $response_data = json_decode($response, true);

    // Vérification d'erreur de décodage JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Erreur lors du décodage JSON : " . json_last_error_msg();
        return;
    }

    // Vérification si les informations de l'événement sont présentes
    if (!isset($response_data['name']['text']) || !isset($response_data['start']['local'])) {
        echo "Les informations de l'événement n'ont pas été récupérées correctement.";
        return;
    }

    // Initialisation de PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Remplace par ton serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'n.henripierre@gmail.com'; // Ton adresse e-mail SMTP
        $mail->Password = 'oilt obxr zqlm dkbe'; // Ton mot de passe SMTP
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom('n.henripierre@gmail.com', 'Casamance Innovation Tech');
        $mail->addAddress($email); // L'adresse e-mail de l'utilisateur

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Votre reservation pour Casamance Innovation Tech';
        $mail->Body    = "
        <h1>Merci $prenom $nom d'avoir réservé votre place pour l'événement Casamance Innovation Tech !</h1>
        <p><b>Titre de l'événement :</b> {$response_data['name']['text']}</p>
        <p><b>Description :</b> {$response_data['description']['text']}</p>
        <p><b>Date de début :</b> {$response_data['start']['local']}</p>
        <p><b>Date de fin :</b> {$response_data['end']['local']}</p>
        <p><b>URL de l'événement :</b> <a href='{$response_data['url']}'>{$response_data['url']}</a></p>
        <p><b>Nombre de tickets réservés :</b> $nombre_tickets</p>
        ";

        // Envoi de l'e-mail
        $mail->send();
        echo 'L\'e-mail de réservation a été envoyé avec succès.';
    } catch (Exception $e) {
        echo "L'e-mail n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
    }
} else {
    echo "Veuillez soumettre le formulaire de réservation.";
}
?>

<?