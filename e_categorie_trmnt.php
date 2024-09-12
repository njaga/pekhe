<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$categorie=htmlspecialchars($_POST['categorie']);

$reponse=$db->prepare("INSERT INTO `categorie`(`categorie`, `id_user`) VALUES (?,?)");
$reponse->execute(array($categorie, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
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