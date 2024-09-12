<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_visite=htmlspecialchars($_POST['date_visite']);
$heure_visite=htmlspecialchars($_POST['heure_visite']);
$personne_demandee=htmlspecialchars($_POST['personne_demandee']);
$motif_visit=htmlspecialchars($_POST['motif']);
$visiteur=htmlspecialchars($_POST['visiteur']);
$id=htmlspecialchars($_POST['id']);


$reponse=$db->prepare("UPDATE  `visiteur` SET `date_visite`=?, `visiteur`=?, `heure_visite`=?, `personne_demandee`=?, `motif_visit`=? WHERE id=?");
$reponse->execute(array($date_visite, $visiteur, $heure_visite, $personne_demandee,$motif_visit, $id)) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();

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
		alert("Erreur : visiteur non enregistrée");
        window.history.go(-1);
    </script>
    <?php
}
?>