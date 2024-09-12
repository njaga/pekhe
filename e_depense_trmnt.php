<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$id_projet = htmlspecialchars($_POST['id']);
$date_depense = htmlspecialchars($_POST['date_depense']);
$description = htmlspecialchars($_POST['description']);
$fournisseur = htmlspecialchars($_POST['fournisseur']);
$qt = htmlspecialchars($_POST['qt']);
$montant = htmlspecialchars($_POST['montant']);
if ($_POST['projet'] == '') {
    $projet = NULL;
} else {
    $projet = htmlspecialchars($_POST['projet']);
}
$priorite = htmlspecialchars($_POST['priorite']);
$departement = htmlspecialchars($_POST['departement']);

$reponse = $db->prepare("INSERT INTO `depense_projet`(`date_ajout`, description, `fournisseur`, qt, montant, id_projet, `id_user`, departement, priorite) VALUES (?,?,?,?,?,?,?,?,?)");
$reponse->execute(array($date_depense, $description, $fournisseur, $qt, $montant, $projet, $_SESSION['id_vigilus_user'], $departement, $priorite)) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();


if ($nbr > 0) {
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : dépense non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>