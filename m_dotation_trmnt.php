<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$id = htmlspecialchars($_POST['id']);
$agent = htmlspecialchars($_POST['agent']);
$date_dotation = htmlspecialchars($_POST['date_dotation']);
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
$blouson = htmlspecialchars($_POST['blouson']);


$reponse = $db->prepare("UPDATE `dotation_art_gard` SET `date_dotation`=?, `agent`=?, `lacoste`=?, `veste_normale`=?, `veste_parka`=?, `chaussure_ville`=?, `chaussure_securite`=?, `tonfa`=?, `ceinturon`=?, `epaulettes`=?, `chemise`=?, `pantalon_simple`=?, `badge`=?, `kepi`=?, `casquette`=?, `cravate`=?, `combinaison`=?, `blouson`=?, `id_user`=? WHERE id=?");
$reponse->execute(array($date_dotation, $agent, $lacoste, $veste_normale, $veste_parka, $chaussure_ville, $chaussure_securite, $tonfa, $ceinturon, $epaulettes, $chemise, $pantalon_simple, $badge, $kepi, $casquette, $cravate, $combinaison, $blouson, $_SESSION['id_vigilus_user'], $id)) or die(print_r($reponse->errorInfo()));


$req_dotation = $db->query("SELECT dotation_art_gard.id, date_dotation, agent, `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `cravate`, `combinaison`, blouson 
FROM `dotation_art_gard` 
WHERE dotation_art_gard.id=" . $id);
$donnees = $req_dotation->fetch();
$lacoste = $lacoste - $donnees['3'];
$veste_normale = $veste_normale - $donnees['4'];
$veste_parka = $veste_parka - $donnees['5'];
$chaussure_ville = $chaussure_ville - $donnees['6'];
$chaussure_securite = $chaussure_securite - $donnees['7'];
$tonfa = $tonfa - $donnees['8'];
$ceinturon = $ceinturon - $donnees['9'];
$epaulettes = $epaulettes - $donnees['10'];
$chemise = $chemise - $donnees['11'];
$pantalon_simple = $pantalon_simple - $donnees['12'];
$badge = $badge - $donnees['13'];
$kepi = $kepi - $donnees['14'];
$casquette = $casquette - $donnees['15'];
$cravate = $cravate - $donnees['16'];
$combinaison = $combinaison - $donnees['17'];
$blouson = $combinaison - $donnees['18'];



$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Lacoste' ");
$reponse->execute(array($lacoste)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Veste Normale' ");
$reponse->execute(array($veste_normale)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Veste Parka' ");
$reponse->execute(array($veste_parka)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Chaussure de ville' ");
$reponse->execute(array($chaussure_ville)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Chaussure de sécurité' ");
$reponse->execute(array($chaussure_securite)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Tonfa' ");
$reponse->execute(array($tonfa)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Ceinturon' ");
$reponse->execute(array($ceinturon)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Epaulettes' ");
$reponse->execute(array($epaulettes)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Chemise simple' ");
$reponse->execute(array($chemise)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Pantalon simple' ");
$reponse->execute(array($pantalon_simple)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Badge' ");
$reponse->execute(array($badge)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Kepi' ");
$reponse->execute(array($kepi)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Casquette' ");
$reponse->execute(array($casquette)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Cravate' ");
$reponse->execute(array($cravate)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Combinaison' ");
$reponse->execute(array($combinaison)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Blouson' ");
$reponse->execute(array($blouson)) or die(print_r($reponse->errorInfo()));

$nbr = 1;

if ($nbr > 0) {
?>
    <script type="text/javascript">
        //alert("Opération enregistrée");
        window.location = "l_dotation.php";
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