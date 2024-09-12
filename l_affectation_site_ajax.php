<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$site = $_POST['site'];
if ($search == "") {
	if ($site == "toutes") {
		$reponse = $db->prepare("SELECT planning_agent.id, employe.id as id_employe, employe.prenom, employe.nom, site.nom as site, CONCAT(DATE_FORMAT(planning_agent.date_debut, '%d'), '/', DATE_FORMAT(planning_agent.date_debut, '%m'),'/', DATE_FORMAT(planning_agent.date_debut, '%Y')) as date_debut,(SELECT site.nom FROM site INNER JOIN planning_agent ON planning_agent.id_site=site.id WHERE planning_agent.id_agent=id_employe AND planning_agent.etat=0 ORDER BY planning_agent.date_fin DESC LIMIT 1) AS ancien_site, planning_agent.observation
		FROM `planning_agent` 
		INNER JOIN employe ON employe.id=planning_agent.id_agent
		INNER JOIN site ON site.id=planning_agent.id_site
		WHERE MONTH(planning_agent.date_debut)=? AND YEAR(planning_agent.date_debut)=?
		ORDER BY planning_agent.date_debut, planning_agent.id, employe.nom");
		$reponse->execute(array($mois, $annee));
	} else {
		$reponse = $db->prepare("SELECT planning_agent.id, employe.id as id_employe, employe.prenom, employe.nom, site.nom as site, CONCAT(DATE_FORMAT(planning_agent.date_debut, '%d'), '/', DATE_FORMAT(planning_agent.date_debut, '%m'),'/', DATE_FORMAT(planning_agent.date_debut, '%Y')) as date_debut,(SELECT site.nom FROM site INNER JOIN planning_agent ON planning_agent.id_site=site.id WHERE planning_agent.id_agent=id_employe AND planning_agent.etat=0 ORDER BY planning_agent.date_fin DESC LIMIT 1) AS ancien_site, planning_agent.observation
		FROM `planning_agent` 
		INNER JOIN employe ON employe.id=planning_agent.id_agent
		INNER JOIN site ON site.id=planning_agent.id_site
		WHERE MONTH(planning_agent.date_debut)=? AND YEAR(planning_agent.date_debut)=? AND site.id=?
		ORDER BY planning_agent.date_debut, planning_agent.id, employe.nom");
		$reponse->execute(array($mois, $annee, $site));
	}
} else {
	if ($site == "toutes") {
		$reponse = $db->prepare("SELECT planning_agent.id, employe.id as id_employe, employe.prenom, employe.nom, site.nom as site, CONCAT(DATE_FORMAT(planning_agent.date_debut, '%d'), '/', DATE_FORMAT(planning_agent.date_debut, '%m'),'/', DATE_FORMAT(planning_agent.date_debut, '%Y')) as date_debut,(SELECT site.nom FROM site INNER JOIN planning_agent ON planning_agent.id_site=site.id WHERE planning_agent.id_agent=id_employe AND planning_agent.etat=0 ORDER BY planning_agent.date_fin DESC LIMIT 1) AS ancien_site, planning_agent.observation
		FROM `planning_agent` 
		INNER JOIN employe ON employe.id=planning_agent.id_agent
		INNER JOIN site ON site.id=planning_agent.id_site
		WHERE MONTH(planning_agent.date_debut)=? AND YEAR(planning_agent.date_debut)=? AND CONCAT (employe.prenom,' ',employe.nom) like CONCAT('%', ?, '%')
		ORDER BY planning_agent.date_debut, planning_agent.id, employe.nom");
		$reponse->execute(array($mois, $annee, $search));
	} else {
		$reponse = $db->prepare("SELECT planning_agent.id, employe.id as id_employe, employe.prenom, employe.nom, site.nom as site, CONCAT(DATE_FORMAT(planning_agent.date_debut, '%d'), '/', DATE_FORMAT(planning_agent.date_debut, '%m'),'/', DATE_FORMAT(planning_agent.date_debut, '%Y')) as date_debut,(SELECT site.nom FROM site INNER JOIN planning_agent ON planning_agent.id_site=site.id WHERE planning_agent.id_agent=id_employe AND planning_agent.etat=0 ORDER BY planning_agent.date_fin DESC LIMIT 1) AS ancien_site, planning_agent.observation
		FROM `planning_agent` 
		INNER JOIN employe ON employe.id=planning_agent.id_agent
		INNER JOIN site ON site.id=planning_agent.id_site
		WHERE MONTH(planning_agent.date_debut)=? AND YEAR(planning_agent.date_debut)=? AND site.id=? AND CONCAT (employe.prenom,' ',employe.nom) like CONCAT('%', ?, '%')
		ORDER BY planning_agent.date_debut, planning_agent.id, employe.nom");
		$reponse->execute(array($mois, $annee, $site, $search));
	}
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
	echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
$total_retire = 0;
$total_hs = 0;
while ($donnees = $reponse->fetch()) {
	$id = $donnees['0'];
	$id_employe = $donnees['1'];
	$prenom = $donnees['2'];
	$nom = $donnees['3'];
	$site = $donnees['4'];
	$date_affectation = $donnees['5'];
	$ancien_site = $donnees['6'];
	$motif = $donnees['7'];

	echo "<tr>";
	echo "<td class='text-center'><b>" . $i . "</b></td>";
	echo "<td class='text-center'>" . $date_affectation . "</td>";
	echo "<td class='text-center'>" . $prenom . " " . $nom . "</td>";
	echo "<td class='text-center'>" . $site . "</td>";
	echo "<td class='text-center'>" . $ancien_site . "</td>";
	echo "<td class='text-center'>" . nl2br($motif) . "</td>";
	echo '
		<td>
			
			<a href="m_affectation_site.php?id=' . $id . '"  class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>		
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