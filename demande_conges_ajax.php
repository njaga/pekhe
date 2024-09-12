<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];

$reponse = $db->prepare("SELECT demande_conges.`id`,  CONCAT(DATE_FORMAT(
    demande_conges.`date_debut`, '%d'), '/', DATE_FORMAT(demande_conges.`date_debut`, '%m'),'/', DATE_FORMAT(demande_conges.`date_debut`, '%Y')),  CONCAT(DATE_FORMAT(demande_conges.`date_fin`, '%d'), '/', DATE_FORMAT(demande_conges.`date_fin`, '%m'),'/', DATE_FORMAT(demande_conges.`date_fin`, '%Y')), `nbr_jour`, demande_conges.`motif`, demande_conges.`statut`, type_conges.type_conges, CONCAT(DATE_FORMAT(demande_conges.`date_enregistrement`, '%d'), '/', DATE_FORMAT(demande_conges.`date_enregistrement`, '%m'),'/', DATE_FORMAT(demande_conges.`date_enregistrement`, '%Y')), demande_conges.etat, demande_conges.commentaire_sup, demande_conges.commentaire_rh
    FROM `demande_conges` 
    INNER JOIN type_conges ON type_conges.id=demande_conges.id_type_conges
    WHERE demande_conges.etat<>0 and demande_conges.id_employe=?
    ORDER BY demande_conges.date_enregistrement DESC");
    $reponse->execute(array($_SESSION['id_employe']));
$resultat = $reponse->rowCount();

if ($resultat < 1) {
    echo "<tr><td colspan='2'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$commentaire_rh="";
$commentaire_sup="";
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
    $commentaire_sup = $donnees['9'];
    $commentaire_rh = $donnees['10'];

   
    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_enregistrement . "</td>";
    echo "<td class='text-center'>" . $type_conges . "</td>";
    echo "<td class='text-center'>Du " . $date_debut . " au ".$date_fin." : <b>".$nbr_jour." jours</b></td>";
    echo "<td class='text-center'>" . $motif . "</td>";
    echo "<td class='text-center'>" . $statut . "</td>";
    echo '<td><a href="" data-toggle="modal" data-target="#modal' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="AFficher"><i class="far fa-eye"></i></a></td>';
    if($etat==1)
    {
        echo '
            <td>
                
                <a href="#' . $id . '"  class="teal-text"><i class="fas fa-pencil-alt"></i></a>
                &nbsp&nbsp&nbsp
                <a href="s_conges.php?s=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cette demande ?\'))"><i class="fas fa-times"></i></a>
                &nbsp&nbsp&nbsp
                
            </td>';
    }

    $i++;

?>
<td>
    <!-- Modal: modif site -->
    <div class="modal fade" id="modal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class=""> Commentaire</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="#">
                        <div class="row">
                            <div class="form-group shadow-textarea col-12">
                                <label for="commentaire_sup">Commentaire Chef Service</label>
                                <textarea class="form-control z-depth-1" id="commentaire_sup" name="commentaire_sup" rows="3"
                                    placeholder="Motif de la visite..."><?= $commentaire_sup ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group shadow-textarea col-12">
                                <label for="commentaire_rh">Commentaire Direction</label>
                                <textarea class="form-control z-depth-1" id="commentaire_rh" name="commentaire_rh" rows="3"
                                    placeholder="Motif de la visite..."><?= $commentaire_rh ?></textarea>
                            </div>
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