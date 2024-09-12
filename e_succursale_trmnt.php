<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$nom=htmlspecialchars(suppr_accents($_POST['nom']));
$localisation=htmlspecialchars(suppr_accents($_POST['localisation']));

$reponse=$db->prepare("INSERT INTO `succursale`(`nom`, `localisation`, `id_user`) VALUES (?,?,?)");
$reponse->execute(array($nom, $localisation, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
		alert("Succursale enregistrée");
        window.history.go(-1);
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : Succursale non enregistrée");
        window.history.go(-1);
    </script>
    <?php
}
?>