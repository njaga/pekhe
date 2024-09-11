<?php
session_start();
include 'connexion.php';
include 'supprim_accents.php';


$agent = htmlspecialchars($_POST['agent']);
$date_retour = htmlspecialchars($_POST['date_retour']);
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
$commentaire = htmlspecialchars($_POST['commentaire']);



$reponse = $db->prepare("INSERT INTO `retour_art_gard`(`date_retour`, `agent`, `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `cravate`, `combinaison`, blouson, pantalon_parka, `id_user`, commentaire) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$reponse->execute(array($date_retour, $agent, $lacoste, $veste_normale, $veste_parka, $chaussure_ville, $chaussure_securite, $tonfa, $ceinturon, $epaulettes, $chemise, $pantalon_simple, $badge, $kepi, $casquette, $cravate, $combinaison, $blouson, $pantalon_parka, $_SESSION['id_vigilus_user'], $commentaire)) or die(print_r($reponse->errorInfo()));
$nbr = $reponse->rowCount();



if ($nbr > 0) {
?>
    <script type="text/javascript">
        //alert("Opération enregistrée");
        window.location = "l_retour.php";
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