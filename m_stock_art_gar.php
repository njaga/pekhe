<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';



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
$blouson = htmlspecialchars($_POST['blouson']);
$torche = htmlspecialchars($_POST['torche']);
$pantalon_parka = htmlspecialchars($_POST['pantalon_parka']);


$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Lacoste' ");
$reponse->execute(array($lacoste)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Veste Normale' ");
$reponse->execute(array($veste_normale)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Veste Parka' ");
$reponse->execute(array($veste_parka)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Chaussure de ville' ");
$reponse->execute(array($chaussure_ville)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Chaussure de sécurité' ");
$reponse->execute(array($chaussure_securite)) or die(print_r($reponse->errorInfo()));


$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Epaulettes' ");
$reponse->execute(array($epaulettes)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Chemise' ");
$reponse->execute(array($chemise)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Pantalon simple' ");
$reponse->execute(array($pantalon_simple)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Badge' ");
$reponse->execute(array($badge)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Kepi' ");
$reponse->execute(array($kepi)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Casquette' ");
$reponse->execute(array($casquette)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Cravate' ");
$reponse->execute(array($cravate)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`= ? WHERE designation='Combinaison tenue chantier' ");
$reponse->execute(array($combinaison)) or die(print_r($reponse->errorInfo()));

//SITE

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Tonfa' ");
$reponse->execute(array($tonfa)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Ceinturon' ");
$reponse->execute(array($ceinturon)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Registre' ");
$reponse->execute(array($registre)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Arme' ");
$reponse->execute(array($arme)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Chargeur arme' ");
$reponse->execute(array($chargeur_arme)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Casque' ");
$reponse->execute(array($casque)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Smartphone' ");
$reponse->execute(array($smartphone)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Telephone simple' ");
$reponse->execute(array($telephone_simple)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Miroir Telescopique' ");
$reponse->execute(array($miroir_telescopique)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Detecteur' ");
$reponse->execute(array($detecteur)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Chargeur Detecteur' ");
$reponse->execute(array($chargeur_detecteur)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Gilet Fluorescent' ");
$reponse->execute(array($gilet)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Blouson' ");
$reponse->execute(array($blouson)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Torche' ");
$reponse->execute(array($torche)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=? WHERE designation='Pantalon Parka' ");
$reponse->execute(array($pantalon_parka)) or die(print_r($reponse->errorInfo()));


$nbr = 1;

if ($nbr > 0) {
?>
    <script type="text/javascript">
        //alert("Opération enregistrée");
        window.location = "stock_art_gar.php";
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