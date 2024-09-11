<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'connexion.php';
include 'supprim_accents.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$message = "";
$nbr_jour = htmlspecialchars($_POST['nbr_jour']);
$id_type_conges = htmlspecialchars($_POST['type_conges']);
$date_debut = htmlspecialchars($_POST['date_debut']);
$date_fin = htmlspecialchars($_POST['date_fin']);
$motif = htmlspecialchars($_POST['motif']);
$statut = "En attente du responsable de service";


$reponse = $db->prepare("INSERT INTO `demande_conges`(`date_debut`, `date_fin`, `nbr_jour`, `motif`, `statut`, `id_employe`, `id_type_conges`) VALUES (?,?,?,?,?,?,?)");
$reponse->execute(array($date_debut, $date_fin, $nbr_jour, $motif, $statut, $_SESSION['id_employe'], $id_type_conges)) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();


if ($nbr > 0) {
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

    $message="Bonjour Responsable <b>".$_SESSION['nom_departement']."</b><br><br><b>".$_SESSION['prenon_vigilus_user']." ".$_SESSION['nom_vigilus_user']."</b>, vient d'enregistrer une nouvelle demande congés.<br>";
    $message=$message."Date début : <b>". $date_debut."</b> <br>";
    $message=$message."Date fin : <b>". $date_fin."</b> <br>";
    $message=$message."Durée : <b>". $nbr_jour." jours</b> <br>";
    $message=$message."Type : <b>". $id_type_conges."</b> <br>";
    $message=$message."Motif : <b>". nl2br($motif)."</b> <br>";
    $message=$message."Satut : <b>". $statut."</b> <br>";
    $message=$message."<br>Veuillez vous connecter à l'application pékhé afin de donner suite à sa demande.<br><a href='https://pekhe.vigilus-securite.com/'>pekhe.vigilus-securite.com</a>";
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
        $employe=$_SESSION['prenon_vigilus_user']." ".$_SESSION['nom_vigilus_user'];
        //Recipients
        $mail->setFrom('no-reply@groupevigilus.com', 'Pékhé');
        $mail->addAddress($email_res_service, $res_service);     
        $mail->addCC($_SESSION['user_email'], $employe);     
        $mail->addCC('rh@groupevigilus.com', 'Service RH'); 
        $mail->addBCC('a.mbaye@groupevigilus.com', 'Alassane MBAYE - DG'); 

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $_SESSION['prenon_vigilus_user']." ". $_SESSION['nom_vigilus_user']." Nouvelle demande de congés/permissions";
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : demande non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>