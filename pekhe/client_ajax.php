<?php
session_start();
include 'connexion.php';
$search=$_POST['search'];
if ($search=="") 
{
	$reponse=$db->query("SELECT `id`, `societe`, `personne`, `telephone`, `email`, `adresse`, activite
    FROM `client` 
    WHERE etat=1
    ORDER BY societe DESC");
}
else
{
	$reponse=$db->prepare("SELECT `id`, `societe`, `personne`, `telephone`, `email`, `adresse`, activite
    FROM `client`
    WHERE CONCAT (societe,' ',personne) like CONCAT('%', ?, '%') AND etat=1
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
	$societe=$donnees['1'];
	$personne=$donnees['2'];
	$telephone=$donnees['3'];
	$email=$donnees['4'];
	$adresse=$donnees['5'];
	$activite=$donnees['6'];
	
	echo "<tr>";
		echo "<td class='text-center'><b>".$i. "</b></td>";
		echo "<td class='text-center'>".$societe."</td>";
		echo "<td class='text-center'>".$personne."</td>";
		echo "<td class='text-center'>".$telephone."</td>";
		echo "<td class='text-center'>".$email."</td>";
		echo "<td class='text-center'>".$adresse."</td>";
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
                    <h4 class=""><i class="fas fa-user"></i> Modification client</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="m_client_trmnt.php">
                        <input type="number" name="id" value="<?= $id ?>" hidden>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="md-form">
                                    <input type="text" value="<?=$societe ?>" required name="societe" id="societe"
                                        class="form-control">
                                    <label for="societe" class="active">Société</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <div class="md-form">
                                    <input type="text" value="<?=$personne ?>" required id="personne" name="personne"
                                        class="form-control">
                                    <label for="personne" class="active">Personnes références</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-0">
                                <div class="md-form">
                                    <input type="text" value="<?=$telephone ?>" required id="telephone" name="telephone"
                                        class="form-control">
                                    <label for="telephone" class="active">Telephone</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-0">
                                <div class="md-form">
                                    <input type="text" value="<?=$email ?>" required id="email" name="email"
                                        class="form-control">
                                    <label for="email" class="active">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mb-0">
                                <div class="md-form">
                                    <input type="text" value="<?=$adresse ?>" required id="adresse" name="adresse"
                                        class="form-control">
                                    <label for="adresse" class="active">Adresse</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-10 mb-0">
                                <div class="md-form">
                                    <input type="text" value="<?=$activite ?>" required id="activite" name="activite"
                                        class="form-control">
                                    <label for="activite" class="active">Secteur d'activité</label>
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