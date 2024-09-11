<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';

$date_sortie=htmlspecialchars($_POST['date_sortie']);
$heure_sortie=htmlspecialchars($_POST['heure_sortie']);
$id_vehicule=htmlspecialchars($_POST['vehicule']);
$id_chauffeur=htmlspecialchars($_POST['chauffeur']);
$id_departement=htmlspecialchars($_POST['departement']);
$demandeur=htmlspecialchars($_POST['demandeur']);
$destination=htmlspecialchars($_POST['destination']);
$motif=htmlspecialchars($_POST['motif']);
$carburant=htmlspecialchars($_POST['carburant']);
$peage=htmlspecialchars($_POST['peage']);


$reponse=$db->prepare("INSERT INTO `sortie_vehicule`(`date_sortie`, `heure_sortie`, `destination`, `motif`,  `id_vehicule`,`id_chauffeur`, `carburant`, `demandeur`, `id_user`, id_departement) VALUES (?,?,?,?,?,?,?,?,?,?)");
$reponse->execute(array($date_sortie, $heure_sortie, $destination, $motif, $id_vehicule, $id_chauffeur,$carburant, $demandeur,  $_SESSION['id_vigilus_user'], $id_departement)) or die(print_r($reponse->errorInfo()));
$nbr=$reponse->rowCount();
$id_sortie=$db->lastInsertId();

if($carburant>0)
{
    $date_depense = $date_sortie;
    $vehicule = $id_vehicule;
    $cout = $carburant;
    $commentaire = "";
    $type_depense = "Carburant";

    $reponse = $db->prepare("INSERT INTO `depense_vehicule`(`date_depense`, `commentaire`, `type_depense`, `cout`, `id_vehicule`, `id_user`, id_sortie) VALUES (?,?,?,?,?,?,?)");
    $reponse->execute(array($date_depense, $commentaire, $type_depense, $cout, $vehicule,  $_SESSION['id_vigilus_user'], $id_sortie)) or die(print_r($reponse->errorInfo()));
}

if($peage>0)
{
    $date_depense = $date_sortie;
    $vehicule = $id_vehicule;
    $cout = $peage;
    $commentaire = "";
    $type_depense = "Frais Péage";

    $reponse = $db->prepare("INSERT INTO `depense_vehicule`(`date_depense`, `commentaire`, `type_depense`, `cout`, `id_vehicule`, `id_user`, id_sortie) VALUES (?,?,?,?,?,?,?)");
    $reponse->execute(array($date_depense, $commentaire, $type_depense, $cout, $vehicule,  $_SESSION['id_vigilus_user'], $id_sortie)) or die(print_r($reponse->errorInfo()));
}
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
		alert("Erreur : sortie non enregistré");
        window.history.go(-1);
    </script>
    <?php
}
?>