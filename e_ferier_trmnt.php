<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_ferier=htmlspecialchars($_POST['date_ferier']);
$description=htmlspecialchars($_POST['description']);

$reponse=$db->prepare("INSERT INTO `jours_ferier`(`date_ferier`, `description`, id_user) VALUES (?,?,?)");
$reponse->execute(array($date_ferier, $description, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
        window.location="l_ferier.php";
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : fournisseur non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>