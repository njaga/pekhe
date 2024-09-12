<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id_fournisseur=htmlspecialchars($_POST['id']);
$designation=htmlspecialchars($_POST['designation']);
$pu=htmlspecialchars($_POST['pu']);

$reponse=$db->prepare("INSERT INTO `article_four`(`designation`, `pu`, id_fournisseur, `id_user`) VALUES (?,?,?,?)");
$reponse->execute(array($designation, $pu, $id_fournisseur, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
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