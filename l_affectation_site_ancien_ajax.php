<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$site=$_POST['site'];
if ($search=="") 
{
	if($site=="toutes")
	{
		$reponse=$db->prepare("SELECT affectation_site.id, employe.matricule, employe.prenom, employe.nom, site.nom, site.localisation, CONCAT(DATE_FORMAT(affectation_site.date_debut, '%d'), '/', DATE_FORMAT(affectation_site.date_debut, '%m'),'/', DATE_FORMAT(affectation_site.date_debut, '%Y')), affectation_site.montant,  employe.id, affectation_site.note, CONCAT(DATE_FORMAT(affectation_site.date_fin, '%d'), '/', DATE_FORMAT(affectation_site.date_fin, '%m'),'/', DATE_FORMAT(affectation_site.date_fin, '%Y'))
		FROM `affectation_site` 
		INNER JOIN employe ON affectation_site.id_employe=employe.id
		INNER JOIN site ON affectation_site.id_site=site.id
		WHERE affectation_site.etat=0 AND MONTH(affectation_site.date_debut)=? AND YEAR(affectation_site.date_debut)=?
		ORDER BY affectation_site.date_debut DESC");
		$reponse->execute(array($mois, $annee));
	}
	else
	{
		$reponse=$db->prepare("SELECT affectation_site.id, employe.matricule, employe.prenom, employe.nom, site.nom, site.localisation, CONCAT(DATE_FORMAT(affectation_site.date_debut, '%d'), '/', DATE_FORMAT(affectation_site.date_debut, '%m'),'/', DATE_FORMAT(affectation_site.date_debut, '%Y')), affectation_site.montant,  employe.id, affectation_site.note, CONCAT(DATE_FORMAT(affectation_site.date_fin, '%d'), '/', DATE_FORMAT(affectation_site.date_fin, '%m'),'/', DATE_FORMAT(affectation_site.date_fin, '%Y'))
		FROM `affectation_site` 
		INNER JOIN employe ON affectation_site.id_employe=employe.id
		INNER JOIN site ON affectation_site.id_site=site.id
		WHERE affectation_site.etat=0 AND MONTH(affectation_site.date_debut)=? AND YEAR(affectation_site.date_debut)=? AND site.id=?
		ORDER BY affectation_site.date_debut DESC");
		$reponse->execute(array($mois, $annee, $site));
	}
}
else
{
	if($site=="toutes")
	{
		$reponse=$db->prepare("SELECT affectation_site.id, employe.matricule, employe.prenom, employe.nom, site.nom, site.localisation, CONCAT(DATE_FORMAT(affectation_site.date_debut, '%d'), '/', DATE_FORMAT(affectation_site.date_debut, '%m'),'/', DATE_FORMAT(affectation_site.date_debut, '%Y')), affectation_site.montant,  employe.id, affectation_site.note, CONCAT(DATE_FORMAT(affectation_site.date_fin, '%d'), '/', DATE_FORMAT(affectation_site.date_fin, '%m'),'/', DATE_FORMAT(affectation_site.date_fin, '%Y'))
		FROM `affectation_site` 
		INNER JOIN employe ON affectation_site.id_employe=employe.id
		INNER JOIN site ON affectation_site.id_site=site.id
		WHERE affectation_site.etat=0 AND MONTH(affectation_site.date_debut)=? AND YEAR(affectation_site.date_debut)=? AND CONCAT (employe.prenom,' ',employe.nom) like CONCAT('%', ?, '%')
		ORDER BY affectation_site.date_debut DESC ");
		$reponse->execute(array($mois, $annee, $search));
	}
	else
	{
		$reponse=$db->prepare("SELECT affectation_site.id, employe.matricule, employe.prenom, employe.nom, site.nom, site.localisation, CONCAT(DATE_FORMAT(affectation_site.date_debut, '%d'), '/', DATE_FORMAT(affectation_site.date_debut, '%m'),'/', DATE_FORMAT(affectation_site.date_debut, '%Y')), affectation_site.montant,  employe.id, affectation_site.note, CONCAT(DATE_FORMAT(affectation_site.date_fin, '%d'), '/', DATE_FORMAT(affectation_site.date_fin, '%m'),'/', DATE_FORMAT(affectation_site.date_fin, '%Y'))
		FROM `affectation_site` 
		INNER JOIN employe ON affectation_site.id_employe=employe.id
		INNER JOIN site ON affectation_site.id_site=site.id
		WHERE affectation_site.etat=0 AND MONTH(affectation_site.date_debut)=? AND YEAR(affectation_site.date_debut)=? AND CONCAT (employe.prenom,' ',employe.nom) like CONCAT('%', ?, '%') AND site.id=?
		ORDER BY affectation_site.date_debut DESC ");
		$reponse->execute(array($mois, $annee, $search, $site));
	}
}
$resultat=$reponse->rowCount();
if ($resultat<1)
{
	echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i=1;
$total_retire=0;
$total_hs=0;
while ($donnees= $reponse->fetch())
{
	$id=$donnees['0'];
	$matricule=$donnees['1'];
	$prenom=$donnees['2'];
	$nom=$donnees['3'];
	$site=$donnees['4'];
	$localisation=$donnees['5'];
	$date_affectation=$donnees['6'];
	$montant=$donnees['7'];
	$id_employe=$donnees['8'];
	$motif=$donnees['9'];
	$date_fin=$donnees['10'];
    //infos sur le site
    $req_site = $db->prepare("SELECT site.nom, site.localisation
    FROM `affectation_site` 
    INNER JOIN site ON affectation_site.id_site=site.id
    INNER JOIN employe ON affectation_site.id_employe=employe.id
    WHERE affectation_site.id_employe=? AND affectation_site.etat=1");
    $req_site->execute(array($id_employe));
    $donnees_site = $req_site->fetch();


	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$date_affectation."</td>";
		echo "<td class='text-center'>".$date_fin."</td>";
		echo "<td class='text-center'>".$prenom." ".$nom."</td>";
		echo "<td class='text-center'>".$donnees_site['0']."</td>";
		echo "<td class='text-center'>".$montant."</td>";
		echo "<td class='text-center'>".$site."</td>";
		echo "<td class='text-center'>".nl2br($motif)."</td>";
		
		
	$i++;
	
	?>
	
	
	<?php
	echo "</tr>";

}

?>
<script type="text/javascript">
	$('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>