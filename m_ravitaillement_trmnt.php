<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$date_ravitailement = htmlspecialchars($_POST['date_ravitailement']);
$fournisseur = htmlspecialchars($_POST['fournisseur']);
$lacoste = htmlspecialchars($_POST['lacoste']);
$veste_normale = htmlspecialchars($_POST['veste_normale']);
$veste_parka = htmlspecialchars($_POST['veste_parka']);
$chaussure_ville = htmlspecialchars($_POST['chaussure_ville']);
$chaussure_securite = htmlspecialchars($_POST['chaussure_securite']);
$tonfa = htmlspecialchars($_POST['tonfa']);
$ceinturon = htmlspecialchars($_POST['ceinturon']);
$epaulettes = htmlspecialchars($_POST['epaulettes']);
$chemise = htmlspecialchars($_POST['chemise']);
$pantalon_simple = htmlspecialchars($_POST['pantalon_simple']);
$badge = htmlspecialchars($_POST['badge']);
$kepi = htmlspecialchars($_POST['kepi']);
$casquette = htmlspecialchars($_POST['casquette']);
$cravate = htmlspecialchars($_POST['cravate']);
$combinaison = htmlspecialchars($_POST['combinaison']);

$registre = htmlspecialchars($_POST['registre']);
$arme = htmlspecialchars($_POST['arme']);
$chargeur_arme = htmlspecialchars($_POST['chargeur_arme']);
$casque = htmlspecialchars($_POST['casque']);
$smartphone = htmlspecialchars($_POST['smartphone']);
$telephone_simple = htmlspecialchars($_POST['telephone_simple']);
$miroir_telescopique = htmlspecialchars($_POST['miroir_telescopique']);
$detecteur = htmlspecialchars($_POST['detecteur']);
$chargeur_detecteur = htmlspecialchars($_POST['chargeur_detecteur']);
$gilet = htmlspecialchars($_POST['gilet']);
$id = htmlspecialchars($_POST['id']);



$reponse = $db->prepare("UPDATE `ravitaillement_art_gard` SET `date_ravitailement`=?, `fournisseur`=?, `lacoste`=?, `veste_normale`=?, `veste_parka`=?, `chaussure_ville`=?, `chaussure_securite`=?, `tonfa`=?, `ceinturon`=?, `epaulettes`=?, `chemise`=?, `pantalon_simple`=?, `badge`=?, `kepi`=?, `casquette`=?, `registre`=?, `arme`=?, `chargeur_arme`=?, `casque`=?, `smartphone`=?, `telephone_simple`=?, `miroir_telescopique`=?, `detecteur`=?, `chargeur_detecteur`=?, gilet=?, cravate=?, combinaison=? WHERE id= ?");
$reponse->execute(array($date_ravitailement, $fournisseur, $lacoste, $veste_normale, $veste_parka, $chaussure_ville, $chaussure_securite, $tonfa, $ceinturon, $epaulettes, $chemise, $pantalon_simple, $badge, $kepi, $casquette, $registre, $arme, $chargeur_arme, $casque, $smartphone, $telephone_simple, $miroir_telescopique, $detecteur, $chargeur_detecteur, $gilet, $cravate, $combinaison, $id)) or die(print_r($reponse->errorInfo()));
$nbr = 1;

if ($nbr > 0) {
?>
    <script type="text/javascript">
        //alert("Opération enregistrée");
        window.location = "ravitaillement.php";
    </script>
<?php
} else {
?>
    <script type="text/javascript">
        alert("Erreur : opération non enregistrée");
        window.history.go(-1);
    </script>
<?php
}
?>