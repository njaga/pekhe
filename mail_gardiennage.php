<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'connexion.php';
//Nbr recrut
$reponse_recrues = $db->query("SELECT COUNT(*) 
FROM `employe` 
WHERE employe.date_debut BETWEEN '2023-08-26' AND '2023-09-26'");
$nbr_recrues = $reponse_recrues->rowCount();

//Nbr démission
$reponse_demission = $db->query("SELECT COUNT(*) 
FROM `employe` 
WHERE employe.date_debut BETWEEN '2023-08-26' AND '2023-09-26'");
$nbr_demission = $reponse_demission->rowCount();

//Nbr contrat
$reponse_contrat = $db->query("SELECT COUNT(contrat_employe.id)
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
INNER JOIN contrat_employe ON employe.id=contrat_employe.id_employe
WHERE employe.etat=1 AND contrat_employe.etat=1 AND MONTH(contrat_employe.date_prevu_fin)=9 AND YEAR(contrat_employe.date_prevu_fin)=2023");
$nbr_contrat = $reponse_contrat->rowCount();

//Nbr new site
$reponse_site_debut = $db->query("SELECT COUNT(id) FROM `site` WHERE date_debut BETWEEN '2023-08-26' AND '2023-09-26'");
$nbr_site_debut = $reponse_site_debut->rowCount();

//Nbr fin site
$reponse_site_fin = $db->query("SELECT COUNT(id) FROM `site` WHERE date_fin BETWEEN '2023-08-26' AND '2023-09-26'");
$nbr_site_fin = $reponse_site_fin->rowCount();

$message = "";
$message = '<br>
Bonjour Team,
<br>
<br>
Ci dessous, le tableau récapitulatif du départemnt gardiennage.
<br>
<br>
Bonne réception !
<br>
<br>
<table >
<thead class="black ">
    <tr style="border:1px solid black; text-align: center">
        <td style="border:1px solid black; text-align: center">Elément</td>
        <td style="border:1px solid black; text-align: center">Nombre</td>
    </tr>
</thead>
<tbody class="tbody">';
?>

<?php
$message = $message . "<tr style='border:1px solid black; text-align: center'>";
$message = $message . "<td style='border:1px solid black; text-align: center'>Nombre de nouveaux sites : </td>";
$message = $message . "<td style='border:1px solid black; text-align: center'>" . $nbr_site_debut . "</td>";
$message = $message . "<tr style='border:1px solid black; text-align: center'>";
$message = $message . "<td style='border:1px solid black; text-align: center'>Nombre de  sites perdu : </td>";
$message = $message . "<td style='border:1px solid black; text-align: center'>" . $nbr_site_fin . "</td>";
$message = $message . "</tr>";
$message = $message . "<tr style='border:1px solid black; text-align: center'>";
$message = $message . "<td style='border:1px solid black; text-align: center'>Nombre de nouvelles recrues : </td>";
$message = $message . "<td style='border:1px solid black; text-align: center'>" . $nbr_recrues . "</td>";
$message = $message . "</tr>";
$message = $message . "<tr style='border:1px solid black; text-align: center'>";
$message = $message . "<td style='border:1px solid black; text-align: center'>Nombre des démissions : </td>";
$message = $message . "<td style='border:1px solid black; text-align: center'>" . $nbr_demission . "</td>";
$message = $message . "</tr>";
$message = $message . "<tr style='border:1px solid black; text-align: center'>";
$message = $message . "<td style='border:1px solid black; text-align: center'>Nombre de contrat à échance le mois prochain : </td>";
$message = $message . "<td style='border:1px solid black; text-align: center'>" . $nbr_demission . "</td>";
$message = $message . "</tr>";

$message = $message . "</tbody></table>";
echo $message;
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

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
    $mail->setFrom('bassene@groupevigilus.com', 'Team IT');
    $mail->addAddress('teamcommercial@groupevigilus.com', 'TEAM COMMERCIAL');     //Add a recipient
    $mail->addAddress('maury.kandji@groupevigilus.com', 'Maury KANDJI');               //Name is optional
    $mail->addReplyTo('teamcommercial@groupevigilus.com', 'Team Commercial');
    $mail->addCC('a.mbaye@groupevigilus.com', 'Alassane MBAYE - DG Vigilus');
    $mail->addCC('juridique@groupevigilus.com', 'Samba S. MBAYE - DAG VIGILUS');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Rappel TBO';
    $mail->Body    = $message;
    $mail->AltBody = 'Ceci est un second <b>test</b>';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
