<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_rdv=htmlspecialchars($_POST['date_rdv']);
$heure_rdv=htmlspecialchars($_POST['heure_rdv']);
$personne=htmlspecialchars($_POST['personne']);
$motif=htmlspecialchars($_POST['motif']);
$id=htmlspecialchars($_POST['id']);


$reponse=$db->prepare("UPDATE `rdv` SET `date_rdv`=?, `heure_rdv`=?, `personne`=?, `motif`=? WHERE id=?");
$reponse->execute(array($date_rdv, $heure_rdv, $personne, $motif, $id)) or die(print_r($reponse->errorInfo()));
$nbr=1;


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