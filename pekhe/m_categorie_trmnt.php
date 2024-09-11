<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$categorie=htmlspecialchars($_POST['categorie']);
$id=htmlspecialchars($_POST['id']);

$reponse=$db->prepare("UPDATE `categorie` SET `categorie`=? WHERE id=?");
$reponse->execute(array($categorie, $id)) or die(print_r($reponse->errorInfo()));
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
		alert("Erreur : catégorie non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>