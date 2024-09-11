<?php
session_start();
include 'connexion.php';
$id_site = $_POST['id_site'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$annee = " AND YEAR(planning_vertical.date_planning)=" . $annee;
$mois = " AND MONTH(planning_vertical.date_planning)=" . $mois;



$reponse = $db->query("SELECT planning_vertical.id, CONCAT(employe.prenom,' ',employe.nom), employe.telephone, site.nom, CONCAT(DATE_FORMAT(planning_vertical.date_planning, '%d')), planning_vertical.planning
    FROM `planning_vertical`
    INNER JOIN employe ON planning_vertical.id_agent=employe.id
    INNER JOIN site ON planning_vertical.id_site=site.id
    WHERE planning_vertical.etat=1 AND planning_vertical.id_site= " . $id_site . " " . $mois . " " . $annee . " ORDER BY date_planning, planning ASC");


$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;

while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $employe = $donnees['1'];
    $telephone = $donnees['2'];
    $site = $donnees['3'];
    $date_planning = $donnees['4'];
    $planning = $donnees['5'];


    if ($planning == "jour") {
        echo "<tr class='info-color white-text'>";
    } elseif ($planning == "nuit") {
        echo "<tr class='danger-color-dark'>";
    } else {
        echo "<tr class='special-color-dark'>";
    }
    echo "<td class='text-center white-text'>" . $date_planning . "</td>";
    echo "<td class='text-center white-text'>" . $employe . "</td>";
    echo "<td class='text-center white-text'>" . strtoupper($planning) . "</td>";
    echo '
		<td>
			<a href="s_planning_vertical.php?s=' . $id . '"  class="red-text" data-toggle="tooltip" data-placement="top" onclick="return(confirm(\'Voulez-vous supprimer ce planning ?\'))" title="Supprimer"><i class="fas fa-times white-text"></i></a>
		</td>
		';

    $i++;

?>


<?php
    echo "</tr>";
}

?>
<script type="text/javascript">
    $('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>