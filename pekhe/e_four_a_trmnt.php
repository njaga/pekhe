<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$nom_fournisseur=htmlspecialchars($_POST['nom_fournisseur']);
$adresse=htmlspecialchars($_POST['adresse']);
$contact=htmlspecialchars($_POST['contact']);
$categorie=htmlspecialchars($_POST['categorie']);

$reponse=$db->prepare("INSERT INTO `fournisseur_achat`(`nom`, adresse, `contact`, categorie, `id_user`) VALUES (?,?,?,?,?)");
$reponse->execute(array($nom_fournisseur, $adresse, $contact, $categorie, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();


if($nbr>0)
{ 
    ?>
    <script type="text/javascript">
        window.location="l_four.php";
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