<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$annee = " AND YEAR(dotation_art_gard.date_dotation)=" . $annee;
if ($mois != "tous") {
    $mois = " AND MONTH(dotation_art_gard.date_dotation)=" . $mois;
}
if ($search != "") {
    $search = " AND CONCAT(employe.prenom, ' ', employe.nom) like CONCAT('%', '" . $search . "', '%')";
} else {
    $search = "";
}


if ($mois == "tous") {
    $reponse = $db->query("SELECT dotation_art_gard.id, CONCAT(DATE_FORMAT(`date_dotation`, '%d'), '/', DATE_FORMAT(`date_dotation`, '%m'),'/', DATE_FORMAT(`date_dotation`, '%Y')), CONCAT(employe.prenom,' ', employe.nom), `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `cravate`, `combinaison`, blouson, pantalon_parka 
    FROM `dotation_art_gard` 
    INNER JOIN employe ON employe.id = dotation_art_gard.agent
    WHERE dotation_art_gard.etat=1 " . $annee . " " . $search . " ORDER BY date_dotation DESC");
} else {
    $reponse = $db->query("SELECT dotation_art_gard.id, CONCAT(DATE_FORMAT(`date_dotation`, '%d'), '/', DATE_FORMAT(`date_dotation`, '%m'),'/', DATE_FORMAT(`date_dotation`, '%Y')), CONCAT(employe.prenom,' ', employe.nom), `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `cravate`, `combinaison`, blouson , pantalon_parka
FROM `dotation_art_gard` 
INNER JOIN employe ON employe.id = dotation_art_gard.agent
WHERE dotation_art_gard.etat=1 " . $mois . " " . $annee . " " . $search . " ORDER BY date_dotation DESC");
}

$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
$s_lacoste = 0;
$s_veste_normale = 0;
$s_veste_parka = 0;
$s_chaussure_ville = 0;
$s_chaussure_securite = 0;
$s_tonfa = 0;
$s_ceinturon = 0;
$s_epaulettes = 0;
$s_chemise = 0;
$s_pantalon_simple = 0;
$s_badge = 0;
$s_kepi = 0;
$s_casquette = 0;
$s_cravate = 0;
$s_combinaison = 0;
$s_blouson = 0;
$s_pantalon_parka = 0;

while ($donnees = $reponse->fetch()) {
    $list = "";
    $id = $donnees['0'];
    $date_dotation = $donnees['1'];
    $agent = $donnees['2'];

    $lacoste = $donnees['3'];
    $s_lacoste = $s_lacoste + $lacoste;

    $veste_normale = $donnees['4'];
    $s_veste_normale = $s_veste_normale + $veste_normale;

    $veste_parka = $donnees['5'];
    $s_veste_parka = $s_veste_parka + $veste_parka;

    $chaussure_ville = $donnees['6'];
    $s_chaussure_ville = $s_chaussure_ville + $chaussure_ville;

    $chaussure_securite = $donnees['7'];
    $s_chaussure_securite = $s_chaussure_securite + $chaussure_securite;

    $tonfa = $donnees['8'];
    $s_tonfa = $s_tonfa + $tonfa;

    $ceinturon = $donnees['9'];
    $s_ceinturon = $s_ceinturon + $ceinturon;

    $epaulettes = $donnees['10'];
    $s_epaulettes = $s_epaulettes + $epaulettes;

    $chemise = $donnees['11'];
    $s_chemise = $s_chemise + $chemise;

    $pantalon_simple = $donnees['12'];
    $s_pantalon_simple = $s_pantalon_simple + $pantalon_simple;

    $badge = $donnees['13'];
    $s_badge = $s_badge + $badge;

    $kepi = $donnees['14'];
    $s_kepi = $s_kepi + $kepi;

    $casquette = $donnees['15'];
    $s_casquette = $s_casquette + $casquette;

    $cravate = $donnees['16'];
    $s_cravate = $s_cravate + $cravate;

    $combinaison = $donnees['17'];
    $s_combinaison = $s_combinaison + $combinaison;

    $blouson = $donnees['18'];
    $s_blouson = $s_blouson + $blouson;

    $pantalon_parka = $donnees['19'];
    $s_pantalon_parka = $s_pantalon_parka + $pantalon_parka;


    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_dotation . "</td>";
    echo "<td class='text-center'>" . $agent . "</td>";
    echo "<td class='text-center'>" . $chemise . "</td>";
    echo "<td class='text-center'>" . $lacoste . "</td>";
    echo "<td class='text-center'>" . $chaussure_ville . "</td>";
    echo "<td class='text-center'>" . $chaussure_securite . "</td>";
    echo "<td class='text-center'>" . $veste_normale . "</td>";
    echo "<td class='text-center'>" . $veste_parka . "</td>";
    echo "<td class='text-center'>" . $ceinturon . "</td>";
    echo "<td class='text-center'>" . $epaulettes . "</td>";
    echo "<td class='text-center'>" . $pantalon_simple . "</td>";
    echo "<td class='text-center'>" . $badge . "</td>";
    echo "<td class='text-center'>" . $casquette . "</td>";
    echo "<td class='text-center'>" . $cravate . "</td>";
    echo "<td class='text-center'>" . $combinaison . "</td>";
    echo "<td class='text-center'>" . $tonfa . "</td>";
    echo "<td class='text-center'>" . $kepi . "</td>";
    echo "<td class='text-center'>" . $blouson . "</td>";
    echo "<td class='text-center'>" . $pantalon_parka . "</td>";
    echo '
		<td>
			
			<a href="s_dotation.php?id=' . $id . '"  class="red-text" data-toggle="tooltip" data-placement="top" onclick="return(confirm(\'Voulez-vous archiver cette dotation ?\'))" title="Supprimer"><i class="fas fa-times "></i></a>		
            <a href="m_dotation.php?id=' . $id . '"  class="" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
		</td>
		';

    $i++;

?>


<?php
    echo "</tr>";
}
echo "<tr>";
echo "<td colspan='3'><b>TOTAL</b></td>";
echo "<td class='text-center'><b>" . $s_chemise . "</b></td>";
echo "<td class='text-center'><b>" . $s_lacoste . "</b></td>";
echo "<td class='text-center'><b>" . $s_chaussure_ville . "</b></td>";
echo "<td class='text-center'><b>" . $s_chaussure_securite . "</b></td>";
echo "<td class='text-center'><b>" . $s_veste_normale . "</b></td>";
echo "<td class='text-center'><b>" . $s_veste_parka . "</b></td>";
echo "<td class='text-center'><b>" . $s_ceinturon . "</b></td>";
echo "<td class='text-center'><b>" . $s_epaulettes . "</b></td>";
echo "<td class='text-center'><b>" . $s_pantalon_simple . "</b></td>";
echo "<td class='text-center'><b>" . $s_badge . "</b></td>";
echo "<td class='text-center'><b>" . $s_casquette . "</b></td>";
echo "<td class='text-center'><b>" . $s_cravate . "</b></td>";
echo "<td class='text-center'><b>" . $s_combinaison . "</b></td>";
echo "<td class='text-center'><b>" . $s_tonfa . "</b></td>";
echo "<td class='text-center'><b>" . $s_kepi . "</b></td>";
echo "<td class='text-center'><b>" . $s_blouson . "</b></td>";
echo "<td class='text-center'><b>" . $s_pantalon_parka . "</b></td>";
echo "</tr>";

?>
<script type="text/javascript">
    $('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>