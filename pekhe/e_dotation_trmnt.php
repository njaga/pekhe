<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


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
$pantalon_parka = htmlspecialchars($_POST['pantalon_parka']);



$reponse = $db->prepare("INSERT INTO `dotation_art_gard`(`date_dotation`, `agent`, `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `cravate`, `combinaison`, blouson, pantalon_parka, `id_user`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$reponse->execute(array($date_dotation, $agent, $lacoste, $veste_normale, $veste_parka, $chaussure_ville, $chaussure_securite, $tonfa, $ceinturon, $epaulettes, $chemise, $pantalon_simple, $badge, $kepi, $casquette, $cravate, $combinaison, $blouson, $pantalon_parka, $_SESSION['id_vigilus_user'])) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();

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

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Chemise' ");
$reponse->execute(array($chemise)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE id='Pantalon simple' ");
$reponse->execute(array($pantalon_simple)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE id='Badge' ");
$reponse->execute(array($badge)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Kepi' ");
$reponse->execute(array($kepi)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Casquette' ");
$reponse->execute(array($casquette)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Cravate' ");
$reponse->execute(array($cravate)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Combinaison tenue chantier' ");
$reponse->execute(array($combinaison)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Blouson' ");
$reponse->execute(array($blouson)) or die(print_r($reponse->errorInfo()));

$reponse = $db->prepare("UPDATE `article_gardiennage` SET `qt`=qt - ? WHERE designation='Pantalon Parka' ");
$reponse->execute(array($pantalon_parka)) or die(print_r($reponse->errorInfo()));



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