<?php
session_start();
include 'connexion.php';


$search = $_POST['search'];
$date_re = $_POST['date_re'];
if ($search == "") {
    $reponse = $db->prepare("SELECT  id, CONCAT(DATE_FORMAT(`date_rdv`, '%d'), '/', DATE_FORMAT(`date_rdv`, '%m'),'/', DATE_FORMAT(`date_rdv`, '%Y')), `heure_rdv`, `personne`, `motif`, `etat`, date_rdv 
    FROM `rdv` 
    WHERE date_rdv=? AND etat=1
    ORDER BY date_rdv, heure_rdv DESC");
    $reponse->execute(array($date_re));
} else {
    $reponse = $db->prepare("SELECT  id, CONCAT(DATE_FORMAT(`date_rdv`, '%d'), '/', DATE_FORMAT(`date_rdv`, '%m'),'/', DATE_FORMAT(`date_rdv`, '%Y')), `heure_rdv`, `personne`, `motif`, `etat`, date_rdv 
    FROM `rdv` 
    WHERE date_rdv=? AND CONCAT(personne, ' ', motif) like CONCAT('%', ?, '%') AND etat=1
    ORDER BY date_rdv, heure_rdv DESC");
    $reponse->execute(array($date_re, $search));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun rendez-vous</h3></td></tr>";
}
$i = 1;
$total = 0;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_rdv = $donnees['1'];
    $heure_rdv = $donnees['2'];
    $personne = $donnees['3'];
    $motif = $donnees['4'];
    $etat = $donnees['5'];
    $date_rdv1 = $donnees['6'];
    
    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_rdv . "</td>";
    echo "<td class='text-center'>" . $heure_rdv . "</td>";
    echo "<td class='text-center'>" . $personne . "</td>";
    echo "<td class='text-center'>" . $motif . "</td>";
    echo "<td class='text-center'>";
    
        
        
        echo '
            <td>
                
                <a href="" data-toggle="modal" data-target="#modalModifRDV' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
                &nbsp&nbsp&nbsp
                <a href="s_rdv.php?s=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer ce RDV ?\'))"><i class="fas fa-times"></i></a>
                &nbsp&nbsp&nbsp
                
            </td>';

    

    $i++;

?>
<td>
    <!-- Modal: modif site -->
    <div class="modal fade" id="modalModifRDV<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!-- Content -->
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header light-blue darken-3 white-text">
                    <h4 class=""><i class="fas fa-calendar"></i> Modification RDV</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="m_rdv_trmnt.php">
                        <input type="number" name="id" hidden="" value="<?= $id ?>">
                        <div class="row">
                            <div class="col-md-5  col-sm-8">
                                <div class="md-form">
                                    <input type="date" id="date_rdv" value="<?=$date_rdv1 ?>" name="date_rdv" class="form-control " required>
                                    <label for="date_rdv" class="active">Date rendez-vous</label>
                                </div>
                            </div>
                            <div class="col-md-5  col-sm-8">
                                <div class="md-form">
                                    <input type="time" value="<?=$heure_rdv ?>" id="heure_rdv" name="heure_rdv" class="form-control " required>
                                    <label for="heure_rdv" class="active">Heure rendez-vous</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-8">
                                <div class="md-form">
                                    <input type="text" id="personne" value="<?=$personne ?>" name="personne" class="form-control" required>
                                    <label for="personne" class="active">Personne </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group shadow-textarea col-12">
                                <label for="motif"></label>
                                <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3"
                                    placeholder="Motif du RDV..."><?=$motif ?></textarea>
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
//$('.mdb-select').materialSelect();
</script>