<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];
$vehicule = $_POST['vehicule'];

$req_veh = $db->query("SELECT id, marque, modele, matricule FROM `vehicule` WHERE etat=1");

$reponse = $db->query("SELECT sortie_vehicule.id, CONCAT(DATE_FORMAT(`date_sortie`, '%d'), '/', DATE_FORMAT(`date_sortie`, '%m'),'/', DATE_FORMAT(`date_sortie`, '%Y')), sortie_vehicule.`heure_sortie`, sortie_vehicule.`destination`, sortie_vehicule.`motif`, CONCAT(vehicule.marque, ' ', vehicule.matricule), sortie_vehicule.`demandeur`, date_sortie, heure_sortie, CONCAT(DATE_FORMAT(`date_retour`, '%d'), '/', DATE_FORMAT(`date_retour`, '%m'),'/', DATE_FORMAT(`date_retour`, '%Y')), heure_retour, sortie_vehicule.commentaire, departement.nom, employe.prenom, employe.nom
FROM `sortie_vehicule`
INNER JOIN vehicule ON sortie_vehicule.id_vehicule= vehicule.id
INNER JOIN departement ON departement.id=sortie_vehicule.id_departement
INNER JOIN employe ON employe.id=sortie_vehicule.id_chauffeur
WHERE sortie_vehicule.etat=2 AND MONTH(sortie_vehicule.date_sortie)='".$mois."' AND YEAR(sortie_vehicule.date_sortie)='".$annee."'
ORDER BY sortie_vehicule.date_sortie, sortie_vehicule.heure_sortie DESC");

$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $date_sortie = $donnees['1'];
    $heure_sortie = $donnees['2'];
    $destination = $donnees['3'];
    $motif = $donnees['4'];
    $vehicule = $donnees['5'];
    $demandeur = $donnees['6'];
    $date_sortie1 = $donnees['7'];
    $heure_sortie1 = $donnees['8'];
    $date_retour = $donnees['9'];
    $heure_retour = $donnees['10'];
    $commentaire = $donnees['11'];
    $departement = $donnees['12'];
    $chauffeur = $donnees['13']." ".$donnees['14'];

    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $date_sortie . " " . $heure_sortie . "</td>";
    echo "<td class='text-center'>" . $vehicule . "</td>";
    echo "<td class='text-center'>" . $demandeur . "</td>";
    echo "<td class='text-center'>" . $destination . "</td>";
    echo "<td class='text-center'>" . $motif . "</td>";
    echo "<td class='text-center'>" . $chauffeur . "</td>";
    echo "<td class='text-center'>" . $departement . "</td>";
    echo "<td class='text-center'>" . $date_retour . " " . $heure_retour . "</td>";
    echo "<td class='text-center'>" . $commentaire . "</td>";

    if ($_SESSION['profil_vigilus_user'] == "r_achat") {
        echo '<td>
                    
                    <a href="" data-toggle="modal" data-target="#modalModifSortie' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
                    &nbsp&nbsp&nbsp
			<a class="red-text" href="s_sortie_veh.php?s=' . $id . '" data-toggle="tooltip" data-placement="top" title="Supprimer" onclick="return(confirm(\'Voulez-vous supprimer cette sortie ?\'))"><i class="fas fa-times"></i></a>&nbsp&nbsp&nbsp

                </td>';
    }
    $i++;
?>
    <td>
        <!-- Modal: modif site -->
        <div class="modal fade" id="modalModifSortie<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-user"></i> Modification sortie</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="m_sortie_veh_trmnt.php">
                            <input type="number" name="id" value="<?= $id ?>" hidden>
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="date" id="date_sortie" value="<?= $date_sortie1 ?>" required name="date_sortie" required class="form-control datepicker">
                                        <label for="date_sortie" class="active">Date sortie</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="heure_sortie" value="<?= $heure_sortie1 ?>" name="heure_sortie" class="form-control timepicker" required>
                                        <label for="heure_sortie" class="active">Heure
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-6">
                                    <select class="mdb-select md-form" name="vehicule" id="vehicule" searchable="Recherhce du vehicule .." required>
                                        <option value='' disabled selected>Véhicule</option>
                                        <?php
                                        while ($donnees_veh = $req_veh->fetch()) {
                                            echo "<option value='" . $donnees_veh['0'] . "'  >" . $donnees_veh['1'] . " " . $donnees_veh['2'] . " : " . $donnees_veh['3'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="vehicule" class='active'>Véhicule</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="demandeur" value="<?= $demandeur ?>" required name="demandeur" required class="form-control ">
                                        <label for="demandeur" class="active">Demandeur</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="destination" value="<?= $destination ?>" required name="destination" required class="form-control ">
                                        <label for="destination" class="active">destination</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-12">
                                    <label for="motif"></label>
                                    <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3" placeholder="Motif de la sorite.."><?= $motif ?></textarea>
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
    $('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>