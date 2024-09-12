<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
if ($search == "") {
    $reponse = $db->query("SELECT id, categorie 
    FROM `categorie` 
    WHERE etat>0
    ORDER BY categorie ASC");
} else {
    $reponse = $db->prepare("SELECT id, categorie
    FROM `categorie` 
    WHERE etat>0 AND categorie like CONCAT('%', ?, '%')
    ORDER BY categorie ASC");
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
	$id = $donnees['0'];
    $categorie = $donnees['1'];
   
	
	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$categorie."</td>";
        echo'
		<td>
			
			<a href="" data-toggle="modal" data-target="#modalModifSite'.$id.'" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
			&nbsp&nbsp&nbsp
			<a href="s_categorie.php?s='.$id.'" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer ce categorie ?\'))"><i class="fas fa-times"></i></a>
			&nbsp&nbsp&nbsp
			
		</td>';
		
	$i++;
	
	?>
<td>
    <!-- Modal: modif site -->
    <div class="modal fade" id="modalModifSite<?=$id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class=""><i class="fas fa-user"></i> Modification categorie</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="m_categorie_trmnt.php">
					<input type="number" name="id" value="<?=$id ?>" hidden>
                        <div class="row">
                            <div class="col-md-8 col-sm-8">
                                <div class="md-form">
                                    <input type="text" value="<?=$categorie ?>" id="categorie" name="categorie" class="form-control" required>
                                    <label for="categorie" class="active">Nom de la catégorie</label>
                                </div>
                            </div>

                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn blue-gradient">Enregistrer</button>
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

</script>