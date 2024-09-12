<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$marque=htmlspecialchars($_POST['marque']);
$modele=htmlspecialchars($_POST['modele']);
$matriculation=htmlspecialchars($_POST['matriculation']);
$energie=htmlspecialchars($_POST['energie']);
$nbr_place=htmlspecialchars($_POST['nbr_place']);
$date_acquisition=htmlspecialchars($_POST['date_acquisition']);

$reponse=$db->prepare("INSERT INTO `vehicule`(`marque`, `modele`, `energie`, `nbr_place`,  `matricule`, `date_acquisition`, `id_user`) VALUES (?,?,?,?,?,?,?)");
$reponse->execute(array($marque, $modele, $energie, $nbr_place, $matriculation, $date_acquisition, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
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
		alert("Erreur : client non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>