<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
if ($search=="") 
{
	$reponse=$db->query("SELECT `id`, `nom`, `localisation`, `etat`, `id_user`
    FROM `succursale`
    ORDER BY nom DESC");
}
else
{
	$reponse=$db->prepare("SELECT `id`, `nom`, `localisation`, `etat`, `id_user`
    FROM `succursale` 
    WHERE CONCAT (nom,' ',localisation) like CONCAT('%', ?, '%') AND etat=1
    ORDER BY nom DESC");
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
	$nom=$donnees['1'];
	$localisation=$donnees['2'];
	
	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$nom."</td>";
		echo "<td class='text-center'>".$localisation."</td>";
		echo'
		<td>
			
			<a href="" data-toggle="modal" data-target="#modalModifSuccursale'.$id.'" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
			&nbsp&nbsp&nbsp
			<a class="red-text"  data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="return(confirm(\'Voulez-vous supprimer cette succursale ?\'))"><i class="fas fa-times"></i></a>
			&nbsp&nbsp&nbsp
			
		</td>
		';
		
	$i++;
	
	?>
	<td>
		<!-- Modal: client form -->
		<div class="modal fade" id="modalModifSuccursale<?=$id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
				aria-hidden="true">
				<div class="modal-dialog cascading-modal" role="document">
					<!-- Content -->
					<div class="modal-content">

						<!-- Header -->
						<div class="modal-header light-blue darken-3 white-text">
							<h4 class=""><i class="fas fa-user"></i> Modification succursale</h4>
							<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<!-- Body -->
						<div class="modal-body mb-0">
							<form method="POST" action="m_client_trmnt.php" >
								<input type="number" name="id" value="<?=$id ?>" hidden>
								<div class="row">
									<div class="col-md-8 mb-4">
										<div class="md-form">
											<input type="text" value="<?=$nom ?>" required name="nom" id="nom" class="form-control">
											<label class="active" for="nom" >Prénom</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8 mb-4">
										<div class="md-form">
											<input type="text" id="localisation" value="<?=$localisation ?>" name="societe" class="form-control">
											<label for="localisation" class="active">Localisation</label>
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
	$('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>