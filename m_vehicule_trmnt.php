<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id=htmlspecialchars($_POST['id']);
$marque=htmlspecialchars($_POST['marque']);
$modele=htmlspecialchars($_POST['modele']);
$matriculation=htmlspecialchars($_POST['matriculation']);
$energie=htmlspecialchars($_POST['energie']);
$nbr_place=htmlspecialchars($_POST['nbr_place']);
$date_acquisition=htmlspecialchars($_POST['date_acquisition']);

$reponse=$db->prepare("UPDATE `vehicule` SET `marque`=?, `modele`=?, `energie`=?, `nbr_place`=?,  `matricule`=?, `date_acquisition`=? WHERE id=?");
$reponse->execute(array($marque, $modele, $energie, $nbr_place, $matriculation, $date_acquisition, $id)) or die(print_r($reponse->errorInfo()));
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
		alert("Erreur : client non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>