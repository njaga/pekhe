<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id=htmlspecialchars($_POST['id']);
$montant=htmlspecialchars($_POST['montant']);
$date_demande=htmlspecialchars($_POST['date_demande']);
$mois=htmlspecialchars($_POST['mois_demande']);

$reponse=$db->prepare("UPDATE `accompte` SET `date_demande`=?, `montant`=?, mois=? WHERE id=?");
$reponse->execute(array($date_demande, $montant, $mois, $id)) or die(print_r($reponse->errorInfo()));
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
		alert("Erreur : accompte non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>