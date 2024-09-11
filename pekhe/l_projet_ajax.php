<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
if ($search == "") {
	$reponse = $db->query("SELECT projet.id, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')), nom_projet, localisation, user.prenom, user.nom, projet.etat 
    FROM `projet`
    INNER JOIN user ON user.id=projet.id_commercial
    WHERE projet.etat>0
    ORDER BY projet.date_debut ASC");
} else {
	$reponse = $db->prepare("SELECT projet.id, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')), nom_projet, localisation, user.prenom, user.nom, projet.etat 
    FROM `projet`
    INNER JOIN user ON user.id=projet.id_commercial
    WHERE projet.etat>0 AND nom_projet like CONCAT('%', ?, '%')
    ORDER BY projet.date_debut ASC");
	$reponse->execute(array($search));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
	echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
while ($donnees = $reponse->fetch()) {
	$id = $donnees['0'];
	$date_debut = $donnees['1'];
	$nom_projet = $donnees['2'];
	$localisation = $donnees['3'];
	$prenon = $donnees['4'];
	$nom = $donnees['5'];
	$etat = $donnees['6'];

	if ($etat == "1") {
		$etat = "En cours...";
	} elseif ($etat == "2") {
		$etat = "Terminer";
	}
	//Dépenses sur ce projet
	$req_dep = $db->prepare("SELECT COALESCE(SUM(montant), '0')
    FROM `depense_projet` 
    WHERE id_projet=? AND etat=1");
	$req_dep->execute(array($id));
	$donnees_dep = $req_dep->fetch();
	$mnt_dep = $donnees_dep['0'];
	echo "<tr>";
	echo "<td class='text-center'><b>" . $i . "</b></td>";
	echo "<td class='text-center'>" . $nom_projet . "</td>";
	echo "<td class='text-center'>" . $localisation . "</td>";
	echo "<td class='text-center'>" . $date_debut . "</td>";
	echo "<td class='text-center'>" . number_format($mnt_dep, 0, '.', ' ') . "</td>";
	echo "<td class='text-center'>" . $prenon . " " . $nom . "</td>";
	echo '
		<td>
			<a href="l_depense_projet.php?s=' . $id . '"  class="btn btn-primary">Dépenses</a>
		</td>
		';
	echo '
		<td>
			
			<a href="m_projet.php?m=' . $id . '"  class="teal-text"><i class="fas fa-pencil-alt"></i></a>
			&nbsp&nbsp&nbsp
			<a href="s_projet.php?s=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer ce projet ?\'))"><i class="fas fa-times"></i></a>
			&nbsp&nbsp&nbsp
			
		</td>';

	$i++;

?>

<?php
	echo "</tr>";
}

?>
<script type="text/javascript">

</script>