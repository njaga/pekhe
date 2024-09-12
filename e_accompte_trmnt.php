<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$employe=htmlspecialchars($_POST['employe']);
$montant=htmlspecialchars($_POST['montant']);
$date_demande=htmlspecialchars($_POST['date_demande']);
$mois=htmlspecialchars($_POST['mois_demande']);

$reponse=$db->prepare("INSERT INTO `accompte`(`date_demande`, `montant`, mois, `id_employe`, `id_user`) VALUES (?,?,?,?,?)");
$reponse->execute(array($date_demande, $montant, $mois, $employe, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
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
		alert("Erreur : accompte non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>