<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'connexion.php';
include 'supprim_accents.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$message = "";

if (isset($_GET['idi'])) {
$id_demande=$_POST['id_demande'];
}
else{
    $id_demande = intval(htmlspecialchars($_GET['s']));
}
$reponse = $db->prepare("SELECT demande_conges.`id`,  CONCAT(DATE_FORMAT(
    demande_conges.`date_debut`, '%d'), '/', DATE_FORMAT(demande_conges.`date_debut`, '%m'),'/', DATE_FORMAT(demande_conges.`date_debut`, '%Y')),  CONCAT(DATE_FORMAT(demande_conges.`date_fin`, '%d'), '/', DATE_FORMAT(demande_conges.`date_fin`, '%m'),'/', DATE_FORMAT(demande_conges.`date_fin`, '%Y')), `nbr_jour`, demande_conges.`motif`, demande_conges.`statut`, type_conges.type_conges, CONCAT(DATE_FORMAT(demande_conges.`date_enregistrement`, '%d'), '/', DATE_FORMAT(demande_conges.`date_enregistrement`, '%m'),'/', DATE_FORMAT(demande_conges.`date_enregistrement`, '%Y')), demande_conges.etat, employe.prenom, employe.nom, type_conges.type_conges, user.email
    FROM `demande_conges` 
    INNER JOIN employe ON employe.id=demande_conges.id_employe
    INNER JOIN type_conges ON type_conges.id=demande_conges.id_type_conges
    INNER JOIN user ON user.id_employe=employe.id
    WHERE demande_conges.id=?
ORDER BY demande_conges.date_enregistrement DESC");
$reponse->execute(array($id_demande));
$donnees = $reponse->fetch();
$id = $donnees['0'];
$date_debut = $donnees['1'];
$date_fin = $donnees['2'];
$nbr_jour = $donnees['3'];
$motif = $donnees['4'];
$statut = $donnees['5'];
$type_conges = $donnees['6'];
$date_enregistrement = $donnees['7'];
$etat = $donnees['8'];
$prenom = $donnees['9'];
$nom = $donnees['10'];
$type_conges1 = $donnees['11'];
$email = $donnees['12'];
$employe=$prenom." ".$nom;
$message="";

if (isset($_GET['idi'])) {
    $id_demande = htmlspecialchars($_POST['id_demande']);
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $etat = -1;
    $statut = "Demande annulée";
    
    $message="Bonjour Team RH, <br><br>
    Le responsable <b>".$_SESSION['nom_departement']."</b> vient de <b>refuser</b> la demande de <b>".$prenom." ".$nom."</b>.<br>";
    $message=$message."Date début : <b>". $date_debut."</b> <br>";
    $message=$message."Date fin : <b>". $date_fin."</b> <br>";
    $message=$message."Durée : <b>". $nbr_jour." jours</b> <br>";
    $message=$message."Type : <b>". $type_conges1."</b> <br>";
    $message=$message."Motif : <b>". nl2br($motif)."</b> <br>";
    $message=$message."Satut : <b>". $statut."</b><br>";
    $message=$message."Commentaire Responsable service : <b>". nl2br($commentaire)."</b> <br>";
    $message=$message."<br>Veuillez vous connecter à l'application pékhé afin de donner suite à sa demande.<br>";
    $message=$message."<br>Cordialement.";
    try {
        //Server settings
        $mail->CharSet = 'UTF-8'; //Format d'encodage à utiliser pour les caractères
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.groupevigilus.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'no-reply@groupevigilus.com';                     //SMTP username
        $mail->Password   = 'No-Reply@';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('no-reply@groupevigilus.com', 'Pékhé');
        $mail->addAddress($email, $employe); 
        $mail->addCC($email_res_service, $res_service);     
        $mail->addCC('rh@groupevigilus.com', 'Service RH');    
        $mail->addBCC('a.mbaye@groupevigilus.com', 'Alassane MBAYE - DG');    
        //$mail->addAddress('rh@groupevigilus.com', 'RH');     //Add a recipient
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $_SESSION['prenon_vigilus_user']." ". $_SESSION['nom_vigilus_user']." Nouvelle demande de congés";
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    $id_demande = intval(htmlspecialchars($_GET['s']));
    $commentaire = "";
    $etat = 2;
    $statut = "En attente direction";
    
    $reponse = $db->prepare("SELECT  user.email, employe.prenom, employe.nom
    FROM `employe`
    INNER JOIN user ON user.id_employe=employe.id
    WHERE employe.id=?");
    $reponse->execute(array($_SESSION['id_manager_departement'])) or die(print_r($reponse->errorInfo()));
    $donnees=$reponse->fetch();
    $email_res_service = $donnees['0'];
    $prenom_res_service = $donnees['1'];
    $nom_res_service = $donnees['2'];
    $res_service=$prenom_res_service." ".$nom_res_service;


    $message="Bonjour Team RH, <br><br>
    Le responsable <b>".$_SESSION['nom_departement']."</b> vient de <b>valider</b> la demande de <b>".$prenom." ".$nom."</b>.<br>";
    $message=$message."Date début : <b>". $date_debut."</b> <br>";
    $message=$message."Date fin : <b>". $date_fin."</b> <br>";
    $message=$message."Durée : <b>". $nbr_jour." jours</b> <br>";
    $message=$message."Type : <b>". $type_conges1."</b> <br>";
    $message=$message."Motif : <b>". nl2br($motif)."</b> <br>";
    $message=$message."Satut : <b>". $statut."</b><br>";
    $message=$message."Commentaire Responsable service : <b>". nl2br($commentaire)."</b> <br>";
    $message=$message."<br>Veuillez vous connecter à l'application pékhé afin de donner suite à sa demande.<br><br><a href='https://pekhe.vigilus-securite.com/'>pekhe.vigilus-securite.com</a>";
    $message=$message."<br>Cordialement.";
    try {
        //Server settings
        $mail->CharSet = 'UTF-8'; //Format d'encodage à utiliser pour les caractères
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.groupevigilus.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'no-reply@groupevigilus.com';                     //SMTP username
        $mail->Password   = 'No-Reply@';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('no-reply@groupevigilus.com', 'Pékhé');
        $mail->addAddress('rh@groupevigilus.com', 'Service RH'); 
        $mail->addCC($email_res_service, $res_service);     
        $mail->addCC($email, $employe);     
        $mail->addBCC('a.mbaye@groupevigilus.com', 'Alassane MBAYE - DG');    

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject =  $employe." Nouvelle demande de congés";
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


$reponse = $db->prepare("UPDATE  `demande_conges` SET `id_superieur`=?, `etat`=?, commentaire_sup=?, statut=?, `date_val_chef`=NOW()  WHERE id=?");
$reponse->execute(array($_SESSION['id_employe'], $etat, $commentaire, $statut, $id_demande)) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();

$nbr = 1;
if ($nbr > 0) {
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : validation non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>