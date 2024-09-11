<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];

$reponse=$db->query("SELECT employe.id, employe.prenom, employe.nom, departement.nom 
FROM `user` 
INNER JOIN employe ON employe.id=user.id_employe
INNER JOIN departement on departement.id=employe.id_departement
WHERE user.etat=1");

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
	$departement=$donnees['3'];
	//Nbr jours conges
    $req_nbr_jou_conges = $db->query("SELECT nbr_conges-(SELECT COALESCE(SUM(nbr_jour),0) FROM `demande_conges` WHERE etat=3 AND id_employe=".$id.") FROM `employe` WHERE id=".$id);
    $donnees_nbr_jou_conges= $req_nbr_jou_conges->fetch();
    $nbr_jour=$donnees_nbr_jou_conges['0'];

	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$date_ferier."</td>";
		echo "<td class='text-center'>".$description."</td>";
		echo "<td class='text-center'>".$departement."</td>";
		echo "<td class='text-center'><b>".$nbr_jour." Jours</b></td>";
		
        echo'
		<td>
			<a class="btn " href="demande_conges_indiv.php?xr='.$id.'" data-toggle="tooltip" data-placement="top" title="détails" >Détails</a>
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