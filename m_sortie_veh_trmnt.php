<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

if (isset($_GET['f'])) {
    $date_retour = htmlspecialchars($_POST['date_retour']);
    $heure_retour = htmlspecialchars($_POST['heure_retour']);
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $id = htmlspecialchars($_POST['id']);

    $reponse = $db->prepare("UPDATE `sortie_vehicule` SET etat=2, `date_retour`=?, `heure_retour`=?, `commentaire`=? WHERE id=?");
    $reponse->execute(array($date_retour, $heure_retour, $commentaire,  $id)) or die(print_r($reponse->errorInfo()));
    $nbr = $reponse->rowCount();
    $nbr = 1;
} else {
    $date_sortie = htmlspecialchars($_POST['date_sortie']);
    $heure_sortie = htmlspecialchars($_POST['heure_sortie']);
    $id_vehicule = htmlspecialchars($_POST['vehicule']);
    $demandeur = htmlspecialchars($_POST['demandeur']);
    $destination = htmlspecialchars($_POST['destination']);
    $motif = htmlspecialchars($_POST['motif']);
    $id = htmlspecialchars($_POST['id']);
    $reponse = $db->prepare("UPDATE `sortie_vehicule` SET `date_sortie`=?, `heure_sortie`=?, `destination`=?, `motif`=?,  `id_vehicule`=?, `demandeur`=? WHERE id=?");
    $reponse->execute(array($date_sortie, $heure_sortie, $destination, $motif, $id_vehicule, $demandeur,  $id)) or die(print_r($reponse->errorInfo()));
    $nbr = $reponse->rowCount();
    $nbr = 1;
}


if ($nbr > 0) {
?>
    <script type="text/javascript">
        window.history.go(-1);
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : sortie non enregistré");
        window.history.go(-1);
    </script>
<?php
}
?>