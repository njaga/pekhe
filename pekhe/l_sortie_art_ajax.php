<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$categorie = $_POST['categorie'];
if ($search == "") {
	if ($categorie == "toutes") {
		$reponse = $db->prepare("SELECT sortie_art.id, CONCAT(DATE_FORMAT(date_sortie, '%d'), '/', DATE_FORMAT(date_sortie, '%m'),'/', DATE_FORMAT(date_sortie, '%Y')), article.ref, article.designation, article.marque, sortie_art.technicien, sortie_art.commentaire, sortie_art.qt
		FROM `sortie_art` 
		INNER JOIN article ON sortie_art.id_article = article.id
		INNER JOIN categorie ON article.id_categorie = categorie.id
		WHERE month(date_sortie)=? AND YEAR(date_sortie)=?
		ORDER BY date_sortie DESC");
		$reponse->execute(array($mois, $annee));
	} else {
		$reponse = $db->prepare("SELECT sortie_art.id, CONCAT(DATE_FORMAT(date_sortie, '%d'), '/', DATE_FORMAT(date_sortie, '%m'),'/', DATE_FORMAT(date_sortie, '%Y')), article.ref, article.designation, article.marque, sortie_art.technicien, sortie_art.commentaire, sortie_art.qt
		FROM `sortie_art` 
		INNER JOIN article ON sortie_art.id_article = article.id
		INNER JOIN categorie ON article.id_categorie = categorie.id
		WHERE month(date_sortie)=? AND YEAR(date_sortie)=? AND categorie.id=?
        ORDER BY date_sortie DESC");
		$reponse->execute(array($mois, $annee, $categorie));
	}
} else {
	if ($categorie == "toutes") {
		$reponse = $db->prepare("SELECT sortie_art.id, CONCAT(DATE_FORMAT(date_sortie, '%d'), '/', DATE_FORMAT(date_sortie, '%m'),'/', DATE_FORMAT(date_sortie, '%Y')), article.ref, article.designation, article.marque, sortie_art.technicien, sortie_art.commentaire, sortie_art.qt
		FROM `sortie_art` 
		INNER JOIN article ON sortie_art.id_article = article.id
		INNER JOIN categorie ON article.id_categorie = categorie.id
        WHERE month(date_sortie)=? AND YEAR(date_sortie)=? AND CONCAT (article.ref,' ',article.designation, ' ',article.marque) like CONCAT('%', ?, '%')
        ORDER BY date_sortie DESC");
		$reponse->execute(array($mois, $annee, $search));
	} else {
		$reponse = $db->prepare("SELECT sortie_art.id, CONCAT(DATE_FORMAT(date_sortie, '%d'), '/', DATE_FORMAT(date_sortie, '%m'),'/', DATE_FORMAT(date_sortie, '%Y')), article.ref, article.designation, article.marque, sortie_art.technicien, sortie_art.commentaire, sortie_art.qt
		FROM `sortie_art` 
		INNER JOIN article ON sortie_art.id_article = article.id
		INNER JOIN categorie ON article.id_categorie = categorie.id
        WHERE month(date_sortie)=? AND YEAR(date_sortie)=? AND CONCAT (article.ref,' ',article.designation, ' ',article.marque) like CONCAT('%', ?, '%') AND categorie.id=?
        ORDER BY date_sortie DESC");
		$reponse->execute(array($mois, $annee, $search, $categorie));
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
	$date_sortie = $donnees['1'];
	$ref = $donnees['2'];
	$designation = $donnees['3'];
	$marque = $donnees['4'];
	$technicien = $donnees['5'];
	$commentaire = $donnees['6'];
	$qt = $donnees['7'];

	echo "<tr>";
	echo "<td class='text-center'><b>" . $i . "</b></td>";
	echo "<td class='text-center'>" . $date_sortie . "</td>";
	echo "<td class='text-center'>" . $ref . " " . $designation . " " . $marque . "</td>";
	echo "<td class='text-center'>" . $qt . "</td>";
	echo "<td class='text-center'>" . $technicien . "</td>";
	echo "<td class='text-center'>" . $commentaire . "</td>";
	echo '<td>&nbsp&nbsp&nbsp
		<a href="s_sortie_art.php?id=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer ce sortie ?\'))"><i class="fas fa-times"></i></a></td>';


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