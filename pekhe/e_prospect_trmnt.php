<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$societe=htmlspecialchars($_POST['societe']);
$personne=htmlspecialchars($_POST['personne']);
$telephone=htmlspecialchars($_POST['telephone']);
$email=htmlspecialchars($_POST['email']);
$adresse=htmlspecialchars($_POST['adresse']);

$reponse=$db->prepare("INSERT INTO `prospect`(`societe`, `personne`, telephone, `email`, `adresse`, `id_user`) VALUES (?,?,?,?,?,?)");
$reponse->execute(array($societe, $personne, $telephone, $email, $adresse, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
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
		alert("Erreur : prospect non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>