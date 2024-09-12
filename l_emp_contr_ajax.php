<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
$annee = $_POST['annee'];
$mois = $_POST['mois'];
if ($search == "") {
	$reponse = $db->prepare("SELECT contrat_employe.id, `matricule`, `prenom`, employe.nom, CONCAT(DATE_FORMAT(`date_naissance`, '%d'), '/', DATE_FORMAT(`date_naissance`, '%m'),'/', DATE_FORMAT(`date_naissance`, '%Y')), `lieu_naissance`, `adresse`, `situation_matrimoniale`, `niveau_experience`, CONCAT(DATE_FORMAT(employe.date_debut, '%d'), '/', DATE_FORMAT(employe.date_debut, '%m'),'/', DATE_FORMAT(employe.date_debut, '%Y')), `note`, `nbr_enfants`, departement.nom , `fonction`, contrat_employe.type_contrat, CONCAT(DATE_FORMAT(contrat_employe.date_debut, '%d'), '/', DATE_FORMAT(contrat_employe.date_debut, '%m'),'/', DATE_FORMAT(contrat_employe.date_debut, '%Y')), CONCAT(DATE_FORMAT(contrat_employe.date_prevu_fin, '%d'), '/', DATE_FORMAT(contrat_employe.date_prevu_fin, '%m'),'/', DATE_FORMAT(contrat_employe.date_prevu_fin, '%Y')), contrat_employe.montant, contrat_employe.document
		FROM `employe` 
		INNER JOIN departement ON employe.id_departement = departement.id
		INNER JOIN contrat_employe ON employe.id=contrat_employe.id_employe
		WHERE employe.etat=1 AND contrat_employe.etat=1 AND MONTH(contrat_employe.date_prevu_fin)=? AND YEAR(contrat_employe.date_prevu_fin)=?
		ORDER BY employe.nom DESC");
	$reponse->execute(array($mois, $annee));
} else {
	$reponse = $db->prepare("SELECT contrat_employe.id, `matricule`, `prenom`, employe.nom, CONCAT(DATE_FORMAT(`date_naissance`, '%d'), '/', DATE_FORMAT(`date_naissance`, '%m'),'/', DATE_FORMAT(`date_naissance`, '%Y')), `lieu_naissance`, `adresse`, `situation_matrimoniale`, `niveau_experience`, CONCAT(DATE_FORMAT(employe.date_debut, '%d'), '/', DATE_FORMAT(employe.date_debut, '%m'),'/', DATE_FORMAT(employe.date_debut, '%Y')), `note`, `nbr_enfants`, departement.nom , `fonction`, contrat_employe.type_contrat, CONCAT(DATE_FORMAT(contrat_employe.date_debut, '%d'), '/', DATE_FORMAT(contrat_employe.date_debut, '%m'),'/', DATE_FORMAT(contrat_employe.date_debut, '%Y')), CONCAT(DATE_FORMAT(contrat_employe.date_prevu_fin, '%d'), '/', DATE_FORMAT(contrat_employe.date_prevu_fin, '%m'),'/', DATE_FORMAT(contrat_employe.date_prevu_fin, '%Y')), contrat_employe.montant, contrat_employe.document
		FROM `employe` 
		INNER JOIN departement ON employe.id_departement = departement.id
		INNER JOIN contrat_employe ON employe.id=contrat_employe.id_employe
		WHERE employe.etat=1 AND CONCAT (employe.prenom,' ',employe.nom) like CONCAT('%', ?, '%') AND MONTH(contrat_employe.date_prevu_fin)=? AND YEAR(contrat_employe.date_prevu_fin)=?
		ORDER BY employe.nom DESC ");
	$reponse->execute(array($search, $mois, $annee));
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
	$matricule = $donnees['1'];
	$prenom = $donnees['2'];
	$nom = $donnees['3'];
	$date_naissance = $donnees['4'];
	$lieu_naissance = $donnees['5'];
	$adresse = $donnees['6'];
	$situation_matrimoniale = $donnees['7'];
	$niveau_experience = $donnees['8'];
	$employe_date_debut = $donnees['9'];
	$note = $donnees['10'];
	$nbr_enfants = $donnees['11'];
	$departement = $donnees['12'];
	$fonction = $donnees['13'];
	$type_contrat = $donnees['14'];
	$date_debut = $donnees['15'];
	$date_prevu_fin = $donnees['16'];
	$montant = $donnees['17'];
	$document = $donnees['18'];

	echo "<tr>";
	echo "<td class='text-center'><b>" . $i . "</b></td>";
	echo "<td class='text-center'>" . $departement . "</td>";
	echo "<td class='text-center'>" . $prenom . "</td>";
	echo "<td class='text-center'>" . $nom . "</td>";
	echo "<td class='text-center'>" . $date_naissance . "</td>";
	echo "<td class='text-center'>" . $type_contrat . "</td>";
	echo "<td class='text-center'>" . $date_debut . "</td>";
	echo "<td class='text-center'>" . $date_prevu_fin . "</td>";
	echo "<td class='text-center'>" . $montant . "</td>";
	echo '
		<td>
			<a href="' . $document . '"  class="teal-text" data-toggle="tooltip" data-placement="top" title="Afficher"><i class="fas fa-award"></i></a>
			&nbsp&nbsp
			<a href="m_contrat_employe.php?id=' . $id . '"  class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>		
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