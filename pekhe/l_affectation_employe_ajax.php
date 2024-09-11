<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
if ($search == "") {
	$reponse = $db->query("SELECT DISTINCT employe.id, `matricule`, `prenom`, employe.nom, CONCAT(DATE_FORMAT(`date_naissance`, '%d'), '/', DATE_FORMAT(`date_naissance`, '%m'),'/', DATE_FORMAT(`date_naissance`, '%Y')), `lieu_naissance`, `adresse`, `situation_matrimoniale`, `niveau_experience`, CONCAT(DATE_FORMAT(employe.date_debut, '%d'), '/', DATE_FORMAT(employe.date_debut, '%m'),'/', DATE_FORMAT(employe.date_debut, '%Y')), employe.note, `nbr_enfants`, departement.nom , `fonction`, site.nom
	FROM `employe` 
	INNER JOIN departement ON employe.id_departement = departement.id
    RIGHT JOIN affectation_site ON affectation_site.id_employe=employe.id
    INNER JOIN site ON affectation_site.id_site=site.id
	WHERE departement.id=3 AND employe.etat=1 AND affectation_site.etat=1
ORDER BY `site`.`nom`  DESC");
} else {
	$reponse = $db->prepare("SELECT DISTINCT employe.id, `matricule`, `prenom`, employe.nom, CONCAT(DATE_FORMAT(`date_naissance`, '%d'), '/', DATE_FORMAT(`date_naissance`, '%m'),'/', DATE_FORMAT(`date_naissance`, '%Y')), `lieu_naissance`, `adresse`, `situation_matrimoniale`, `niveau_experience`, CONCAT(DATE_FORMAT(employe.date_debut, '%d'), '/', DATE_FORMAT(employe.date_debut, '%m'),'/', DATE_FORMAT(employe.date_debut, '%Y')), employe.note, `nbr_enfants`, departement.nom , `fonction`, site.nom
	FROM `employe` 
	INNER JOIN departement ON employe.id_departement = departement.id
    RIGHT JOIN affectation_site ON affectation_site.id_employe=employe.id
    INNER JOIN site ON affectation_site.id_site=site.id
	WHERE departement.id=3 AND employe.etat=1 AND affectation_site.etat=1 AND CONCAT (employe.prenom,' ',employe.nom) like CONCAT('%', ?, '%')
ORDER BY `site`.`nom`  DESC");
	$reponse->execute(array($search));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
	echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
while ($donnees = $reponse->fetch()) {
	$id = $donnees['0'];
	$matricule = $donnees['1'];
	$prenom = $donnees['2'];
	$nom = $donnees['3'];
	$date_naissance = $donnees['4'];
	$lieu_naissance = $donnees['5'];
	$adresse = $donnees['6'];
	$situation_matrimoniale = $donnees['7'];
	$niveau_experience = $donnees['8'];
	$date_debut = $donnees['9'];
	$note = $donnees['10'];
	$nbr_enfants = $donnees['11'];
	$departement = $donnees['12'];
	$site = $donnees['14'];

	echo "<tr>";
	echo "<td class='text-center'><b>" . $i . "</b></td>";
	echo "<td class='text-center'>" . $matricule . "</td>";
	echo "<td class='text-center'>" . $prenom . "</td>";
	echo "<td class='text-center'>" . $nom . "</td>";
	echo "<td class='text-center'>" . $date_naissance . " à " . $lieu_naissance . "</td>";
	echo "<td class='text-center'>" . $situation_matrimoniale . "</td>";
	echo "<td class='text-center'>" . $adresse . "</td>";
	echo "<td class='text-center'>" . $site . "</td>";
	echo "<td class='text-center'><a href='e_affectation_site.php?id=" . $id . "' class='btn blue white-text'>Selectionner</a></td>";


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