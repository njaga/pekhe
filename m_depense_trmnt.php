<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id = htmlspecialchars($_POST['id']);
$date_depense = htmlspecialchars($_POST['date_depense']);
$description = htmlspecialchars($_POST['description']);
$fournisseur = htmlspecialchars($_POST['fournisseur']);
$qt = htmlspecialchars($_POST['qt']);
$montant = htmlspecialchars($_POST['montant']);

$reponse = $db->prepare("UPDATE `depense_projet` SET `date_ajout`=?, description=?, `fournisseur`=?, qt=?, montant=?, `id_user`=? WHERE id=?");
$reponse->execute(array($date_depense, $description, $fournisseur, $qt, $montant, $_SESSION['id_vigilus_user'], $id)) or die(print_r($reponse->errorInfo()));
//$nbr=$reponse->rowCount();
$nbr = 1;

if ($nbr > 0) {
?>
    <script type="text/javascript">
        alert("Dépense modifiée");
        window.history.go(-1);
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : dépense non modifiée");
        window.history.go(-1);
    </script>
<?php
}
?>