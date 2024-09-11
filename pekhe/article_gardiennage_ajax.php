<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
if ($search=="") 
{
	$reponse=$db->query("SELECT `id`, `article`, `qt`
    FROM `article_gardiennage` 
    WHERE etat=1
    ORDER BY societe DESC");
}
else
{
	$reponse=$db->prepare("SELECT `id`, `article`, `qt`
    FROM `article_gardiennage`
    WHERE article like CONCAT('%', ?, '%') AND etat=1
    ORDER BY societe DESC");
	$reponse->execute(array($search));
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
	$qt=$donnees['2'];
	
	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$article."</td>";
		echo "<td class='text-center'>".$qt."</td>";
		echo'
		<td>
			
			<a href="" data-toggle="modal" data-target="#modalModifClient'.$id.'" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
			&nbsp&nbsp&nbsp
			<a class="red-text" href="s_client.php?id='.$id.'" data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="return(confirm(\'Voulez-vous supprimer ce client ?\'))"><i class="fas fa-times"></i></a>&nbsp&nbsp&nbsp
            <a class="blue-text" href="d_client.php?id='.$id.'" data-toggle="tooltip" data-placement="top" title="Détails" ><i class="fas fa-id-card "></i></a>
			
			
		</td>
		';
		
	$i++;
	
	?>
<td>
    <!-- Modal: modif site -->
    <div class="modal fade" id="modalModifClient<?=$id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class=""><i class="fas fa-user"></i> Modification article</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="m_art_gard_trmnt.php">
                        <input type="number" name="id" value="<?= $id ?>" hidden>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="md-form">
                                    <input type="text" value="<?=$article ?>" required name="article" id="article"
                                        class="form-control">
                                    <label for="article" class="active">Article</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-light-blue">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Content -->
        </div>
    </div>
    <!-- Modal: client form -->
</td>

<?php
	echo "</tr>";

}

?>
<script type="text/javascript">
// Tooltips Initialization
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>