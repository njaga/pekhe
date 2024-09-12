<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id=htmlspecialchars($_GET['s']);

$reponse=$db->prepare("UPDATE `vehicule` SET `etat`=0 WHERE id=?");
$reponse->execute(array($id)) or die(print_r($reponse->errorInfo()));
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