<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
$id_fournisseur=$_POST['id_fournisseur'];
if ($search=="") 
{
	$reponse=$db->prepare("SELECT `id`, `designation`, `pu`
    FROM `article_four` 
    WHERE etat=1 AND id_fournisseur=?
    ORDER BY designation DESC");
    $reponse->execute(array($_POST['id_fournisseur']));
}
else
{
	$reponse=$db->prepare("SELECT `id`, `designation`, `pu`
    FROM `article_four`
    WHERE etat=1 AND id_fournisseur=? AND CONCAT (designation,' ',pu) like CONCAT('%', ?, '%')
    ORDER BY designation DESC");
	$reponse->execute(array($_POST['id_fournisseur'], $search));
}
$resultat=$reponse->rowCount();
if ($resultat<1)
{
	echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i=1;
while ($donnees= $reponse->fetch())
{
	$id=$donnees['0'];
	$article=$donnees['1'];
	$pu=$donnees['2'];
	
	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$article."</td>";
		echo "<td class='text-center'>".number_format($pu,0,'.',' ')."</td>";
		echo'
		<td>
			
			<a href="m_article_four.php?id='.$id.'" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
			&nbsp&nbsp&nbsp
			<a class="red-text"  data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="return(confirm(\'Voulez-vous supprimer ce site ?\'))"><i class="fas fa-times"></i></a>
			&nbsp&nbsp&nbsp
			
		</td>
		';
		
	$i++;
	
	?>

	
	<?php
	echo "</tr>";

}

?>
<script type="text/javascript">
    // Tooltips Initialization
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>