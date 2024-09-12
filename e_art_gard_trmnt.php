<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$ref=htmlspecialchars($_POST['reference']);
$designation=htmlspecialchars($_POST['designation']);
$pu=htmlspecialchars($_POST['pu']);
$marque=htmlspecialchars($_POST['marque']);
$modele=htmlspecialchars($_POST['modele']);
$pu=htmlspecialchars($_POST['pu']);
$categorie=htmlspecialchars($_POST['categorie']);

$reponse=$db->prepare("INSERT INTO `article`(`ref`, `designation`, `marque`, `modele`, `pu`, id_categorie, `id_user`) VALUES (?,?,?,?,?,?,?)");
$reponse->execute(array($ref, $designation, $marque, $modele, $pu, $categorie, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
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
		alert("Erreur : article non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>