<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
if ($search=="") 
{
	$reponse=$db->query("SELECT id, `marque`, `modele`, `energie`, `nbr_place`, `matricule`, CONCAT(DATE_FORMAT(`date_acquisition`, '%d'), '/', DATE_FORMAT(`date_acquisition`, '%m'),'/', DATE_FORMAT(`date_acquisition`, '%Y')), `etat`, date_acquisition 
    FROM `vehicule` WHERE etat=1
    ORDER BY marque, modele DESC");
}
else
{
	$reponse=$db->prepare("SELECT id, `marque`, `modele`, `energie`, `nbr_place`, `matricule`, CONCAT(DATE_FORMAT(`date_acquisition`, '%d'), '/', DATE_FORMAT(`date_acquisition`, '%m'),'/', DATE_FORMAT(`date_acquisition`, '%Y')), `etat`, date_acquisition 
    FROM `vehicule` WHERE CONCAT (marque,' ',modele,' ',matricule) like CONCAT('%', ?, '%') AND etat=1
    ORDER BY marque, modele DESC");
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
	$marque=$donnees['1'];
	$modele=$donnees['2'];
	$energie=$donnees['3'];
	$nbr_place=$donnees['4'];
	$matricule=$donnees['5'];
	$date_acquisition=$donnees['6'];
	$date_acquisition1=$donnees['8'];
	
	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$marque." ".$modele."</td>";
		echo "<td class='text-center'>".$matricule."</td>";
		echo "<td class='text-center'>".$energie."</td>";
		echo "<td class='text-center'>".$nbr_place."</td>";
		echo "<td class='text-center'>".$date_acquisition."</td>";
		echo'
		<td>
			
			<a href="" data-toggle="modal" data-target="#modalModifVehicule'.$id.'" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
			&nbsp&nbsp&nbsp
			<a class="red-text" href="s_vehicule.php?s='.$id.'" data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="return(confirm(\'Voulez-vous supprimer ce véhicule ?\'))"><i class="fas fa-times"></i></a>&nbsp&nbsp&nbsp
            
			
			
		</td>
		';
		
	$i++;
	
	?>
<td>
    <!-- Modal: modif site -->
    <div class="modal fade" id="modalModifVehicule<?=$id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class=""><i class="fas fa-user"></i> Modification véhicule</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="m_vehicule_trmnt.php">
                        <input type="number" name="id" value="<?= $id ?>" hidden>
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="md-form">
                                    <input type="text" value="<?= $marque ?>" required name="marque" id="marque" class="form-control">
                                    <label for="marque" class="active">Marque</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div class="md-form">
                                    <input type="text" value="<?= $marque ?>" required name="modele" id="modele" class="form-control">
                                    <label for="modele" class="active">Modèle</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-md-4">
                                <div class="md-form">
                                    <input type="text" required value="<?= $matricule ?>" id="matriculation" name="matriculation"
                                        class="form-control">
                                    <label for="matriculation" class="active">Matriculation</label>
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="md-form">
                                    <input type="text" required value="<?= $energie ?>" id="energie" name="energie" class="form-control">
                                    <label for="energie" class="active">Energie</label>
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="md-form">
                                    <input type="number" required value="<?= $nbr_place ?>" id="nbr_place" name="nbr_place" class="form-control">
                                    <label for="nbr_place" class="active">Nbr places</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="md-form">
                                    <input type="date" value="<?= $date_acquisition1 ?>" required id="date_acquisition"
                                        name="date_acquisition" class="form-control">
                                    <label for="date_acquisition" class="active">Date acquision</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn blue-gradient">Enregistrer modification</button>
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