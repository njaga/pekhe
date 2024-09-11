<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id = htmlspecialchars($_POST['id']);
$date_debut = htmlspecialchars($_POST['date_debut']);
$nom_projet = htmlspecialchars($_POST['nom_projet']);
$localisation = htmlspecialchars($_POST['localisation']);
$commercial = htmlspecialchars($_POST['commercial']);
$departement = htmlspecialchars($_POST['departement']);

$reponse = $db->prepare("UPDATE `projet` SET `date_debut`=?, nom_projet=?, `localisation`=?, id_commercial=?, id_departement=?, `id_user`=? WHERE id=?");
$reponse->execute(array($date_debut, $nom_projet, $localisation, $commercial, $departement, $_SESSION['id_vigilus_user'], $id)) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();
$nb = 1;

if ($nbr > 0) {
?>
    <script type="text/javascript">
        alert("Projet modifié");
        window.location = "l_projet.php";
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : projet non modifié");
        window.history.go(-1);
    </script>
<?php
}
?>