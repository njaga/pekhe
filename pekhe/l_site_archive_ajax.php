<?php
session_start();
include 'connexion.php';
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
$search = $_POST['search'];
if ($search == "") {
    $reponse = $db->query("SELECT `id`, `nom`, `localisation`, `id_departement`, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')), date_debut, CONCAT(DATE_FORMAT(date_fin, '%d'), '/', DATE_FORMAT(date_fin, '%m'),'/', DATE_FORMAT(date_fin, '%Y'))
    FROM `site` 
    WHERE etat=0
    ORDER BY nom DESC");
} else {
    $reponse = $db->prepare("SELECT `id`, `nom`, `localisation`, `id_departement`, CONCAT(DATE_FORMAT(date_debut, '%d'), '/', DATE_FORMAT(date_debut, '%m'),'/', DATE_FORMAT(date_debut, '%Y')), date_debut, CONCAT(DATE_FORMAT(date_fin, '%d'), '/', DATE_FORMAT(date_fin, '%m'),'/', DATE_FORMAT(date_fin, '%Y'))
    FROM `site` 
    WHERE CONCAT (nom,' ',localisation) like CONCAT('%', ?, '%') AND etat=0
    ORDER BY nom DESC");
    $reponse->execute(array($search));
}
$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}
$i = 1;
while ($donnees = $reponse->fetch()) {
    $id = $donnees['0'];
    $nom = $donnees['1'];
    $localisation = $donnees['2'];
    $id_departement = $donnees['3'];
    $date_debut = $donnees['4'];
    $date_debut_n = $donnees['5'];
    $date_fin = $donnees['6'];
    //Agents travaillents sur site
    $req_emp = $db->prepare("SELECT employe.prenom, employe.nom 
	FROM `planning_agent` 
	INNER JOIN employe ON employe.id=planning_agent.id_agent
	WHERE planning_agent.id_site=? AND planning_agent.etat=1");
    $req_emp->execute(array($id));
    $nbr_emp = 0;
    $employes = "";

    echo "<tr>";
    echo "<td class='text-center'><b>" . $i . "</b></td>";
    echo "<td class='text-center'>" . $nom . "</td>";
    echo "<td class='text-center'>" . $localisation . "</td>";
    echo "<td class='text-center'>" . $date_debut . "</td>";
    echo "<td class='text-center'>" . $date_fin . "</td>";

    $i++;

?>
    <td>
        <!-- Modal: modif site -->
        <div class="modal fade" id="modalModifSite<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-user"></i> Modification site</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="m_site_trmnt.php">
                            <input type="number" name="id" value="<?= $id ?>" hidden>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="md-form">
                                        <input type="text" value="<?= $nom ?>" required name="nom" id="nom" class="form-control">
                                        <label for="nom" class="active">Nom</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 mb-0">
                                    <div class="md-form">
                                        <input type="text" value="<?= $localisation ?>" required id="localisation" name="localisation" class="form-control">
                                        <label for="localisation" class="active">Localisation</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="md-form">
                                        <input type="date" id="date_debut" value="<?= $date_debut_n ?>" name="date_debut" class="form-control ">
                                        <label for="date_debut" class="active">Date déut</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <select class="browser-default custom-select md-form" name="departement" searchable="Recherhce .." required>
                                        <option value='' disabled selected>Département</option>
                                        <?php
                                        while ($donnees_departement = $req_departement->fetch()) {
                                            echo "<option value='" . $donnees_departement['0'] . "'";
                                            if ($id_departement == $donnees_departement['0']) {
                                                echo "selected";
                                            }
                                            echo "  >" . $donnees_departement['1'] . "</option>";
                                        }
                                        ?>
                                    </select>
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
        <!-- Modal: modif site -->
        <div class="modal fade" id="modalSuppSite<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-user"></i> Fin de contrat</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="s_site.php">
                            <input type="number" name="id" value="<?= $id ?>" hidden>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="md-form">
                                        <input type="date" value="" required name="date_arret" id="nom" class="form-control">
                                        <label for="nom" class="active">Date fin de contrat</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-12">
                                    <label for="observation"></label>
                                    <textarea class="form-control z-depth-1" id="observation" name="observation" rows="3" placeholder="Commentaire..."></textarea>
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