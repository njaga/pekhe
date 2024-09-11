<?php
session_start();
include 'connexion.php';


$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
if ($search == "") {
    $reponse = $db->prepare("SELECT  id, CONCAT(DATE_FORMAT(`date_visite`, '%d'), '/', DATE_FORMAT(`date_visite`, '%m'),'/', DATE_FORMAT(`date_visite`, '%Y')), `heure_visite`, `personne_demandee`, `motif_visit`, `etat`, date_visite, visiteur 
    FROM `visiteur` 
    WHERE etat=1 AND MONTH(date_visite)=? AND YEAR(date_visite)=?
    ORDER BY date_visite, heure_visite DESC");
    $reponse->execute(array($mois, $annee));
} else {
    $reponse = $db->prepare("SELECT  id, CONCAT(DATE_FORMAT(`date_visite`, '%d'), '/', DATE_FORMAT(`date_visite`, '%m'),'/', DATE_FORMAT(`date_visite`, '%Y')), `heure_visite`, `personne_demandee`, `motif_visit`, `etat`, date_visite, visiteur 
    FROM `visiteur` 
    WHERE etat=1 AND MONTH(date_visite)=? AND YEAR(date_visite)=? AND CONCAT(personne_demandee, ' ', motif_visit) like CONCAT('%', ?, '%')
    ORDER BY date_visite, heure_visite DESC");
    $reponse->execute(array($mois, $annee, $search));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucune visite</h3></td></tr>";
}
$i = 1;
$total = 0;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_visite = $donnees['1'];
    $heure_visite = $donnees['2'];
    $personne_demandee = $donnees['3'];
    $motif_visit = $donnees['4'];
    $etat = $donnees['5'];
    $date_visite1 = $donnees['6'];
    $visiteur = $donnees['7'];
    
    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_visite . " à ".$heure_visite."</td>";
    echo "<td class='text-center'>" . $visiteur . "</td>";
    echo "<td class='text-center'>" . $personne_demandee . "</td>";
    echo "<td class='text-center'>" . $motif_visit . "</td>";
    echo "<td class='text-center'>";
    
        
        
        echo '
            <td>
                
                <a href="" data-toggle="modal" data-target="#modalModifRDV' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
                &nbsp&nbsp&nbsp
                <a href="s_visiteur.php?s=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cette visite ?\'))"><i class="fas fa-times"></i></a>
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
                    <h4 class=""> Modification visite</h4>
                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="modal-body mb-0">
                    <form method="POST" action="m_visiteur_trmnt.php">
                        <input type="number" name="id" value="<?= $id ?>" hidden>
                        <div class="row">
                            <div class="col-md-5  col-sm-8">
                                <div class="md-form">
                                    <input type="date" id="date_visite" value="<?= $date_visite1 ?>" name="date_visite"
                                        class="form-control " required>
                                    <label for="date_visite" class="active">Date visite</label>
                                </div>
                            </div>
                            <div class="col-md-5  col-sm-8">
                                <div class="md-form">
                                    <input type="time" id="heure_visite" value="<?= $heure_visite ?>"
                                        name="heure_visite" class="form-control " required>
                                    <label for="heure_visite" class="active">Heure visite</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-8">
                                <div class="md-form">
                                    <input type="text" id="visiteur" value="<?= $visiteur ?>" name="visiteur"
                                        class="form-control" required>
                                    <label for="visiteur" class="active">Visiteur</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <div class="md-form">
                                    <input type="text" id="personne_demandee" name="personne_demandee"
                                        class="form-control" value="<?= $personne_demandee ?>" required>
                                    <label for="personne_demandee" class="active">Personne demandée</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group shadow-textarea col-12">
                                <label for="motif"></label>
                                <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3"
                                    placeholder="Motif de la visite..."><?= $motif_visit ?></textarea>
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