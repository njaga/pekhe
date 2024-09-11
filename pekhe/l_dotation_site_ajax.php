<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$annee = " AND YEAR(dotation_art_site.date_dotation)=" . $annee;
if ($mois != "tous") {
    $mois = " AND MONTH(dotation_art_site.date_dotation)=" . $mois;
}
if ($search != "") {
    $search = " AND CONCAT(site.nom) like CONCAT('%', '" . $search . "', '%')";
} else {
    $search = "";
}


if ($mois == "tous") {
    $reponse = $db->query("SELECT dotation_art_site.id, CONCAT(DATE_FORMAT(`date_dotation`, '%d'), '/', DATE_FORMAT(`date_dotation`, '%m'),'/', DATE_FORMAT(`date_dotation`, '%Y')), site.nom, `smartphone`, `casque`, `registre`, `arme`, `chargeur_arme`, `tonfa`, `ceinturon`, `telephone_simple`, `miroir_telescopique`, `detecteur`, `chargeur_detecteur`, `gilet`, torche 
    FROM `dotation_art_site` 
    INNER JOIN site ON site.id=dotation_art_site.site
    WHERE dotation_art_site.etat=1 " . $annee . " " . $search . " ORDER BY date_dotation DESC");
} else {
    $reponse = $db->query("SELECT dotation_art_site.id, CONCAT(DATE_FORMAT(`date_dotation`, '%d'), '/', DATE_FORMAT(`date_dotation`, '%m'),'/', DATE_FORMAT(`date_dotation`, '%Y')), site.nom, `smartphone`, `casque`, `registre`, `arme`, `chargeur_arme`, `tonfa`, `ceinturon`, `telephone_simple`, `miroir_telescopique`, `detecteur`, `chargeur_detecteur`, `gilet`, torche 
    FROM `dotation_art_site` 
    INNER JOIN site ON site.id=dotation_art_site.site
    WHERE dotation_art_site.etat=1 " . $mois . " " . $annee . " " . $search . " ORDER BY date_dotation DESC");
}

$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
$s_smartphone = 0;
$s_casque = 0;
$s_registre = 0;
$s_arme = 0;
$s_chargeur_arme = 0;
$s_tonfa = 0;
$s_ceinturon = 0;
$s_telephone_simple = 0;
$s_miroir_telescopique = 0;
$s_detecteur = 0;
$s_chargeur_detecteur = 0;
$s_gilet = 0;
$s_torche = 0;

while ($donnees = $reponse->fetch()) {
    $list = "";
    $id = $donnees['0'];
    $date_dotation = $donnees['1'];
    $site = $donnees['2'];

    $smartphone = $donnees['3'];
    $s_smartphone = $s_smartphone + $smartphone;

    $casque = $donnees['4'];
    $s_casque = $s_casque + $casque;

    $registre = $donnees['5'];
    $s_registre = $s_registre + $registre;

    $arme = $donnees['6'];
    $s_arme = $s_arme + $arme;

    $chargeur_arme = $donnees['7'];
    $s_chargeur_arme = $s_chargeur_arme + $chargeur_arme;

    $tonfa = $donnees['8'];
    $s_tonfa = $s_tonfa + $tonfa;

    $ceinturon = $donnees['9'];
    $s_ceinturon = $s_ceinturon + $ceinturon;

    $telephone_simple = $donnees['10'];
    $s_telephone_simple = $s_telephone_simple + $telephone_simple;

    $miroir_telescopique = $donnees['11'];
    $s_miroir_telescopique = $s_miroir_telescopique + $miroir_telescopique;

    $detecteur = $donnees['12'];
    $s_detecteur = $s_detecteur + $detecteur;

    $chargeur_detecteur = $donnees['13'];
    $s_chargeur_detecteur = $s_chargeur_detecteur + $chargeur_detecteur;

    $gilet = $donnees['14'];
    $s_gilet = $s_gilet + $gilet;

    $torche = $donnees['15'];
    $s_torche = $s_torche + $torche;

    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_dotation . "</td>";
    echo "<td class='text-center'>" . $site . "</td>";
    echo "<td class='text-center'>" . $ceinturon . "</td>";
    echo "<td class='text-center'>" . $miroir_telescopique . "</td>";
    echo "<td class='text-center'>" . $smartphone . "</td>";
    echo "<td class='text-center'>" . $arme . "</td>";
    echo "<td class='text-center'>" . $chargeur_arme . "</td>";
    echo "<td class='text-center'>" . $casque . "</td>";
    echo "<td class='text-center'>" . $registre . "</td>";
    echo "<td class='text-center'>" . $telephone_simple . "</td>";
    echo "<td class='text-center'>" . $detecteur . "</td>";
    echo "<td class='text-center'>" . $chargeur_detecteur . "</td>";
    echo "<td class='text-center'>" . $gilet . "</td>";
    echo "<td class='text-center'>" . $tonfa . "</td>";
    echo "<td class='text-center'>" . $torche . "</td>";
    echo '
		<td>
			
			<a href="s_dotation.php?id=' . $id . '"  class="red-text" data-toggle="tooltip" data-placement="top" onclick="return(confirm(\'Voulez-vous archiver cette dotation ?\'))" title="Supprimer"><i class="fas fa-times "></i></a>		
            <a href="m_dotation_site.php?id=' . $id . '"  class="" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
		</td>
		';

    $i++;

?>


<?php
    echo "</tr>";
}
echo "<tr>";
echo "<td colspan='3'><b>TOTAL</b></td>";
echo "<td class='text-center'><b>" . $s_ceinturon . "</b></td>";
echo "<td class='text-center'><b>" . $s_miroir_telescopique . "</b></td>";
echo "<td class='text-center'><b>" . $s_smartphone . "</b></td>";
echo "<td class='text-center'><b>" . $s_arme . "</b></td>";
echo "<td class='text-center'><b>" . $s_chargeur_arme . "</b></td>";
echo "<td class='text-center'><b>" . $s_casque . "</b></td>";
echo "<td class='text-center'><b>" . $s_registre . "</b></td>";
echo "<td class='text-center'><b>" . $s_telephone_simple . "</b></td>";
echo "<td class='text-center'><b>" . $s_detecteur . "</b></td>";
echo "<td class='text-center'><b>" . $s_chargeur_detecteur . "</b></td>";
echo "<td class='text-center'><b>" . $s_gilet . "</b></td>";
echo "<td class='text-center'><b>" . $s_tonfa . "</b></td>";
echo "<td class='text-center'><b>" . $s_torche . "</b></td>";
echo "</tr>";

?>
<script type="text/javascript">
    $('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>