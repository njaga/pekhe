<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];

$reponse=$db->query("SELECT id, CONCAT(DATE_FORMAT(`date_ferier`, '%d'), '/', DATE_FORMAT(`date_ferier`, '%m'),'/', DATE_FORMAT(`date_ferier`, '%Y')), `description` FROM `jours_ferier` WHERE etat=1
ORDER BY date_ferier");

$resultat=$reponse->rowCount();
if ($resultat<1)
{
	echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i=1;
while ($donnees= $reponse->fetch())
{
	$id=$donnees['0'];
	$date_ferier=$donnees['1'];
	$description=$donnees['2'];
	
	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$date_ferier."</td>";
		echo "<td class='text-center'>".$description."</td>";
		/*
        echo'
		<td>
			
			<a href="" data-toggle="modal" data-target="#modalModifVehicule'.$id.'" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
			&nbsp&nbsp&nbsp
			<a class="red-text" href="s_vehicule.php?s='.$id.'" data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="return(confirm(\'Voulez-vous supprimer ce véhicule ?\'))"><i class="fas fa-times"></i></a>&nbsp&nbsp&nbsp
            
			
			
		</td>
		';
        */
		
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