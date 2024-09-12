<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];

$reponse = $db->query("SELECT demande_conges.`id`,  CONCAT(DATE_FORMAT(
    demande_conges.`date_debut`, '%d'), '/', DATE_FORMAT(demande_conges.`date_debut`, '%m'),'/', DATE_FORMAT(demande_conges.`date_debut`, '%Y')),  CONCAT(DATE_FORMAT(demande_conges.`date_fin`, '%d'), '/', DATE_FORMAT(demande_conges.`date_fin`, '%m'),'/', DATE_FORMAT(demande_conges.`date_fin`, '%Y')), `nbr_jour`, demande_conges.`motif`, demande_conges.`statut`, type_conges.type_conges, CONCAT(DATE_FORMAT(demande_conges.`date_enregistrement`, '%d'), '/', DATE_FORMAT(demande_conges.`date_enregistrement`, '%m'),'/', DATE_FORMAT(demande_conges.`date_enregistrement`, '%Y')), demande_conges.etat, employe.prenom, employe.nom
    FROM `demande_conges` 
    INNER JOIN employe ON employe.id=demande_conges.id_employe
    INNER JOIN type_conges ON type_conges.id=demande_conges.id_type_conges
    INNER JOIN departement ON departement.id=employe.id_departement
    WHERE demande_conges.etat=1 AND departement.id=".$_SESSION['id_departement']."
    ORDER BY demande_conges.date_enregistrement DESC;");
$resultat = $reponse->rowCount();
 
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_debut = $donnees['1'];
    $date_fin = $donnees['2'];
    $nbr_jour = $donnees['3'];
    $motif = $donnees['4'];
    $statut = $donnees['5'];
    $type_conges = $donnees['6'];
    $date_enregistrement = $donnees['7'];
    $etat = $donnees['8'];
    $prenom = $donnees['9'];
    $nom = $donnees['10'];


    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_enregistrement . "</td>";
    echo "<td class='text-center'>" . $prenom . " ".$nom."</td>";
    echo "<td class='text-center'>" . $type_conges . "</td>";
    echo "<td class='text-center'>Du " . $date_debut . " au " . $date_fin . " : <b>" . $nbr_jour . " jours</b></td>";
    echo "<td class='text-center'>" . $motif . "</td>";
    echo "<td class='text-center'>" . $statut . "</td>";
    echo '
		<td>
			
        <a href="validation_demande_conges.php?s=' . $id . '" onclick="return(confirm(\'Voulez-vous vraiment accepter cette demande ?\'))" class="btn btn-success btn-sm" data-mdb-ripple-init>Accepter</a>
        <br>
        <br>
        <a  onclick="return(confirm(\'Voulez-vous vraiment refuser cette demande ?\'))" class="btn btn-danger btn-sm" data-mdb-ripple-init data-toggle="modal" data-target="#modalRefus' . $id . '">Refuser</a>
			&nbsp&nbsp&nbsp
			
		</td>';
    echo '<td>';
?>
    <div class="modal fade" id="modalRefus<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <div class="modal-content">
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class="">Commentaire</h4><button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body mb-0">
                    <form method="POST" action="validation_demande_conges.php?idi=1">
                        <input type="number" value="<?= $id ?>" name="id_demande" hidden>
                        <div class="row">
                            <div class="form-group shadow-textarea col-12"><label for="commentaire"></label><textarea class="form-control z-depth-1" id="commentaire" name="commentaire" rows="3" placeholder="Ajouter un commentaire"></textarea></div>
                        </div>
                        <div class="text-center mt-4"><button type="submit" class="btn blue-gradient">Enregistrer</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo '</td>';

    $i++;

    ?>

<?php
    echo "</tr>";
}

?>
<script type="text/javascript">

</script>