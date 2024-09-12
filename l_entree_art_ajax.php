<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$categorie=$_POST['categorie'];
if ($search=="") 
{
	if($categorie=="toutes")
	{
		$reponse=$db->prepare("SELECT entree_art.id, CONCAT(DATE_FORMAT(date_entree, '%d'), '/', DATE_FORMAT(date_entree, '%m'),'/', DATE_FORMAT(date_entree, '%Y')), article.ref, article.designation, article.marque, entree_art.ancien_qt, new_qt, article.qt
        FROM `entree_art` 
        INNER JOIN article ON entree_art.id_article = article.id
        INNER JOIN categorie ON article.id_categorie = categorie.id
        WHERE month(date_entree)=? AND YEAR(date_entree)=? 
        ORDER BY date_entree DESC");
		$reponse->execute(array($mois, $annee));
	}
	else
	{
		$reponse=$db->prepare("SELECT entree_art.id, CONCAT(DATE_FORMAT(date_entree, '%d'), '/', DATE_FORMAT(date_entree, '%m'),'/', DATE_FORMAT(date_entree, '%Y')), article.ref, article.designation, article.marque, entree_art.ancien_qt, new_qt, article.qt
        FROM `entree_art` 
        INNER JOIN article ON entree_art.id_article = article.id
        INNER JOIN categorie ON article.id_categorie = categorie.id
        WHERE month(date_entree)=? AND YEAR(date_entree)=? AND categorie.id=?
        ORDER BY date_entree DESC");
		$reponse->execute(array($mois, $annee, $categorie));
	}
}
else
{
	if($categorie=="toutes")
	{
		$reponse=$db->prepare("SELECT entree_art.id, CONCAT(DATE_FORMAT(date_entree, '%d'), '/', DATE_FORMAT(date_entree, '%m'),'/', DATE_FORMAT(date_entree, '%Y')), article.ref, article.designation, article.marque, entree_art.ancien_qt, new_qt, article.qt
        FROM `entree_art` 
        INNER JOIN article ON entree_art.id_article = article.id
        INNER JOIN categorie ON article.id_categorie = categorie.id
        WHERE month(date_entree)=? AND YEAR(date_entree)=? AND CONCAT (article.ref,' ',article.designation, ' ',article.marque) like CONCAT('%', ?, '%')
        ORDER BY date_entree DESC");
		$reponse->execute(array($mois, $annee, $search));
	}
	else
	{
		$reponse=$db->prepare("SELECT entree_art.id, CONCAT(DATE_FORMAT(date_entree, '%d'), '/', DATE_FORMAT(date_entree, '%m'),'/', DATE_FORMAT(date_entree, '%Y')), article.ref, article.designation, article.marque, entree_art.ancien_qt, new_qt, article.qt
        FROM `entree_art` 
        INNER JOIN article ON entree_art.id_article = article.id
        INNER JOIN categorie ON article.id_categorie = categorie.id
        WHERE month(date_entree)=? AND YEAR(date_entree)=? AND CONCAT (article.ref,' ',article.designation, ' ',article.marque) like CONCAT('%', ?, '%') AND categorie.id=?
        ORDER BY date_entree DESC");
		$reponse->execute(array($mois, $annee, $search, $categorie));
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
	$date_entree=$donnees['1'];
	$ref=$donnees['2'];
	$designation=$donnees['3'];
	$marque=$donnees['4'];
	$ancien_qt=$donnees['5'];
	$new_qt=$donnees['6'];
	$qt_restante=$donnees['7'];
    $qt_entree=$new_qt-$ancien_qt;

	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$date_entree."</td>";
		echo "<td class='text-center'>".$ref." ".$designation." ".$marque."</td>";
		echo "<td class='text-center'>".$ancien_qt."</td>";
		echo "<td class='text-center'>".($new_qt - $ancien_qt)."</td>";
		echo "<td class='text-center'>".$new_qt."</td>";
        if($qt_restante>=$qt_entree)
        {
            echo'
            <td>
                <a href="s_entree_art.php?s='.$id.'" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cette entrée ?\'))"><i class="fas fa-times"></i></a>
            </td>
            ';
        }
		
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