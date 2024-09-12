<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
if ($search=="") 
{
	$reponse=$db->query("SELECT `id`, `nom`, `localisation`, `montant_paiement`, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')), date_debut
    FROM `site` 
    WHERE etat=1
    ORDER BY nom DESC");
}
else
{
	$reponse=$db->prepare("SELECT `id`, `nom`, `localisation`, `montant_paiement`, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')), date_debut
    FROM `site` 
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
	$montant_paiement=$donnees['3'];
	$date_debut=$donnees['4'];
	$date_debut_n=$donnees['5'];
	//Agents travaillents sur site
	$req_emp=$db->prepare("SELECT employe.prenom, employe.nom, employe.id 
	FROM `affectation_site` 
	INNER JOIN employe ON affectation_site.id_employe=employe.id
	WHERE id_site=? AND affectation_site.etat=1");
	$req_emp->execute(array($id));
	$nbr_emp=0;
	$employes="";
	$j=0;
	$nbr_emp = $nbr_emp + 1; 
	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$nom."</td>";
		echo "<td class='text-center'>".$localisation."</td>";
		echo "<td class='text-center'>".$date_debut."</td>";
		echo "<td class='text-center'>".number_format($montant_paiement,0,'.',' ')."</td>";
		echo'<td class="text-center"><a href="" data-toggle="modal" data-target="#modalNbrAgent'.$id.'" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier">'.str_pad($nbr_emp, 2, "0", STR_PAD_LEFT).'</a></td>';
		echo'
		<td>
			
			<a href="" data-toggle="modal" data-target="#modalModifSite'.$id.'" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
			&nbsp&nbsp&nbsp
			
			
		</td>
		';
		
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
							<h4 class=""><i class="fas fa-user"></i> Modification succursale</h4>
							<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<!-- Body -->
						<div class="modal-body mb-0">
							<form method="POST" action="m_site_trmnt.php" >
								<input type="number" name="id" value="<?=$id ?>" hidden>
								<div class="row">
                                    <div class="col-md-10">
                                        <div class="md-form">
                                            <input type="text" value="<?=$nom ?>" required name="nom" id="nom" class="form-control">
                                            <label for="nom" class="active">Nom</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 mb-0">
                                        <div class="md-form">
                                            <input type="text" value="<?=$localisation ?>" required id="localisation" name="localisation" class="form-control">
                                            <label for="localisation" class="active">Localisation</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="md-form">
                                            <input type="date" id="date_debut" value="<?=$date_debut_n ?>" name="date_debut" class="form-control ">
                                            <label for="date_debut" class="active">Date déut</label>
                                    </div>
                                </div>
                                <div class="col-md-5 ">
                                    <div class="md-form">
                                        <input type="number" id="montant" value="<?=$montant_paiement ?>" name="montant" class="form-control ">
                                        <label for="montant" class="active">Montant paiement</label>
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
	<td>
		<!-- Modal: list employe -->
		<div class="modal fade" id="modalNbrAgent<?=$id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
				aria-hidden="true">
				<div class="modal-dialog cascading-modal" role="document">
					<!-- Content -->
					<div class="modal-content">

						<!-- Header -->
						<div class="modal-header light-blue darken-3 white-text">
							<h4 class=""><i class="fas fa-user"></i> Agent(s) sur le site</h4>
							<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<!-- Body -->
						<div class="modal-body mb-0 text-left">
							<?php
								while($donnees_emp= $req_emp->fetch())
								{
									$j++;
									echo'<a href="m_employe.php?id='.$id.'" data-toggle="modal" " class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier">'.$j.' '.$donnees_emp["0"].' '.$donnees_emp["1"].'<br></a>';
									$nbr_emp = $nbr_emp + 1; 
								}
							?>
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
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>