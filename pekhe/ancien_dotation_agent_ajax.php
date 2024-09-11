<?php
session_start();
include 'connexion.php';
$agent = $_POST['agent'];

$reponse = $db->prepare("SELECT dotation_art_gard.id, CONCAT(DATE_FORMAT(`date_dotation`, '%d'), '/', DATE_FORMAT(`date_dotation`, '%m'),'/', DATE_FORMAT(`date_dotation`, '%Y')), CONCAT(employe.prenom,' ', employe.nom), `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `cravate`, `combinaison` FROM `dotation_art_gard` INNER JOIN employe ON employe.id = dotation_art_gard.agent WHERE dotation_art_gard.agent=? ORDER BY dotation_art_gard.id DESC LIMIT 1");
$reponse->execute(array($agent));

$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<b>Pas de dotation antérieure</b>";
}

$list = "";
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_dotation = $donnees['1'];
    $agent = $donnees['2'];
    $list = $date_dotation;
    if ($donnees['3'] > 0) {
        $list = $list . "; Laco : " . $donnees['3'];
    }
    if ($donnees['4'] > 0) {
        $list = $list . "; Vest N : " . $donnees['4'];
    }
    if ($donnees['5'] > 0) {
        $list = $list . "; Vest P : " . $donnees['5'];
    }
    if ($donnees['6'] > 0) {
        $list = $list . "; Chau Vil : " . $donnees['6'];
    }
    if ($donnees['7'] > 0) {
        $list = $list . "; Chau Sec : " . $donnees['7'];
    }
    if ($donnees['8'] > 0) {
        $list = $list . "; Tonfa : " . $donnees['8'];
    }
    if ($donnees['9'] > 0) {
        $list = $list . "; Ceintu : " . $donnees['9'];
    }
    if ($donnees['10'] > 0) {
        $list = $list . "; Epaul : " . $donnees['10'];
    }
    if ($donnees['11'] > 0) {
        $list = $list . "; Chemi : " . $donnees['11'];
    }
    if ($donnees['12'] > 0) {
        $list = $list . "; Pan Sim : " . $donnees['12'];
    }
    if ($donnees['13'] > 0) {
        $list = $list . "; Badge : " . $donnees['13'];
    }
    if ($donnees['14'] > 0) {
        $list = $list . "; Kepi : " . $donnees['14'];
    }
    if ($donnees['15'] > 0) {
        $list = $list . "; Casqu : " . $donnees['15'];
    }
    if ($donnees['16'] > 0) {
        $list = $list . "; Crava : " . $donnees['16'];
    }
    if ($donnees['17'] > 0) {
        $list = $list . "; Combi : " . $donnees['17'];
    }
}
echo "<b>" . $list . "</b>";
