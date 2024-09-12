<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id=htmlspecialchars($_POST['id']);
$nom_fournisseur=htmlspecialchars($_POST['nom']);
$adresse=htmlspecialchars($_POST['adresse']);
$contact=htmlspecialchars($_POST['contact']);
$categorie=htmlspecialchars($_POST['categorie']);

$reponse=$db->prepare("UPDATE `fournisseur_achat` SET `nom`=?, adresse=?, `contact`=?, categorie=? WHERE id=?");
$reponse->execute(array($nom_fournisseur, $adresse, $contact, $categorie, $id)) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
		alert("Fournisseur modifié");
        window.location="l_four.php";
    </script>
    <?php
}
else
{
    ?>
    <script type="text/javascript">
		alert("Erreur : fournisseur non modifié");
        window.history.go(-1);
    </script>
    <?php
}
?>