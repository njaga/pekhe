<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_rdv=htmlspecialchars($_POST['date_rdv']);
$heure_rdv=htmlspecialchars($_POST['heure_rdv']);
$personne=htmlspecialchars($_POST['personne']);
$motif=htmlspecialchars($_POST['motif']);


$reponse=$db->prepare("INSERT INTO `rdv` (`date_rdv`, `heure_rdv`, `personne`, `motif`, `id_user`) VALUES (?,?,?,?,?)");
$reponse->execute(array($date_rdv, $heure_rdv, $personne, $motif, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : rdv non enregistrée");
        window.history.go(-1);
    </script>
    <?php
}
?>