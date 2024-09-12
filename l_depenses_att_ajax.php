<?php
session_start();
include 'connexion.php';
$search = $_POST['search'];
if ($search != "") {
    $search = " AND CONCAT(depense_projet.description, ' ', depense_projet.fournisseur) like CONCAT('%', " . $search . ", '%')";
} else {
    $search = "";
}
$reponse = $db->query("SELECT id, CONCAT(DATE_FORMAT(`date_ajout`, '%d'), '/', DATE_FORMAT(`date_ajout`, '%m'),'/', DATE_FORMAT(`date_ajout`, '%Y')) AS date_depense, description, qt, montant, fournisseur, depense_projet.etat, departement, priorite, etat, date_ajout, id_projet
FROM `depense_projet` 
WHERE depense_projet.etat=0 ORDER BY date_ajout DESC");

$resultat = $reponse->rowCount();
if ($resultat < 1) {
    echo "<tr><td colspan='7'><h3 class='text-center'>Aucun résultat</h3></td></tr>";
}

//Liste projets;
$req_projet = $db->query("SELECT id, nom_projet FROM `projet` WHERE etat=1");

$i = 1;
$total_retire = 0;
$total_hs = 0;
while ($donnees = $reponse->fetch()) {
    $list = "";
    $id = $donnees['0'];
    $date_depense = $donnees['1'];
    $description = $donnees['2'];
    $qt = $donnees['3'];
    $montant = $donnees['4'];
    $fournisseur = $donnees['5'];
    $etat = $donnees['6'];
    $departement = $donnees['7'];
    $priorite = $donnees['8'];
    $date_ajout = $donnees['9'];
    $id_projet = $donnees['10'];
    if ($etat == 0) {
        $etat1 = "En attente validation comptabilité";
    } elseif ($etat == 1) {
        $etat1 = "Validée par la comptabilité";
    }


    echo "<tr>";
    echo "<td class='text-center'>" . $date_depense . "</td>";
    echo "<td class='text-center'>" . $departement . "</td>";
    echo "<td class='text-center'>" . $description . "</td>";
    echo "<td class='text-center'>" . $priorite . "</td>";
    echo "<td class='text-center'>" . $qt . "</td>";
    echo "<td class='text-center'>" . $montant . "</td>";
    echo "<td class='text-center'>" . $fournisseur . "</td>";
    echo "<td class='text-center'>" . $etat1 . "</td>";
    if ($etat == "0" and $_SESSION['profil_vigilus_user'] == "comptabilite") {
        echo '
		<td>
        <a href="valider_depense.php?id=' . $id . '" class="btn btn-success btn-sm"><i class="fas fa-check mr-2"></i>Valide</a>
        </td>';
    }
    if ($etat == "0" and $_SESSION['profil_vigilus_user'] == "r_achat") {
        echo '<td>
                
                <a href="" data-toggle="modal" data-target="#modalModifSite' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
                &nbsp&nbsp&nbsp
                <a href="s_depense_projet.php?id=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cet dépense ?\'))"><i class="fas fa-times"></i></a>
                &nbsp&nbsp&nbsp
                
            </td>';
    }
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
                        <h4 class=""><i class="fas fa-user"></i> Modification accompte</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="m_depense_trmnt.php">
                            <input type="number" class="id" name="id" value="<?= $id ?>" hidden>
                            <div class="row">
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="text" id="date_depense" value="<?= date('Y-m-d') ?>" name="date_depense" class="form-control datepicker" required>
                                        <label for="date_depense" class="active">Date dépense</label>
                                    </div>
                                </div>
                                <div class="col-md-5 ">
                                    <div class="md-form">
                                        <select class="browser-default custom-select" name="projet" id="projet">
                                            <option value='' selected>Projet</option>
                                            <?php
                                            while ($donnee_projet = $req_projet->fetch()) {
                                                echo "<option value='" . $donnee_projet['0'];
                                                if ($id_projet == $donnee_projet['0']) {
                                                    echo 'selected';
                                                }
                                                echo "'>" . $donnee_projet['1'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 ">
                                    <div class="">
                                        <select class="browser-default custom-select" name="priorite" id="priorite" required>
                                            <option value='' disabled selected>Priorité</option>
                                            <option value="Eleve" <?php if ($priorite == "Eleve") {
                                                                        echo "selected";
                                                                    } ?>>Eleve</option>
                                            <option value="Moyen" <?php if ($priorite == "Moyen") {
                                                                        echo "selected";
                                                                    } ?>>Moyen</option>
                                            <option value="Faible" <?php if ($priorite == "Faible") {
                                                                        echo "selected";
                                                                    } ?>>Faible</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5 ">
                                    <div class="">
                                        <select class="browser-default custom-select" name="departement" id="departement" required>
                                            <option value='' disabled selected>Département</option>
                                            <option value="Incendie" <?php if ($departement == "Incendie") {
                                                                            echo "selected";
                                                                        } ?>>Incendie</option>
                                            <option value="Informatique" <?php if ($departement == "Informatique") {
                                                                                echo "selected";
                                                                            } ?>>Informatique</option>
                                            <option value="Gardiennage" <?php if ($departement == "Gardiennage") {
                                                                            echo "selected";
                                                                        } ?>>Gardiennage</option>
                                            <option value="Electronique" <?php if ($departement == "Electronique") {
                                                                                echo "selected";
                                                                            } ?>>Electronique</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="md-form">
                                        <input type="text" id="description" name="description" class="form-control" value="<?= $description ?>" required>
                                        <label for="description" class="active">Motif dépense</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="md-form">
                                        <input type="text" id="fournisseur" value="<?= $fournisseur ?>" name="fournisseur" class="form-control">
                                        <label for="fournisseur" class="active">Fournisseur</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" id="qt" value="<?= $qt ?>" name="qt" class="form-control" required>
                                        <label for="qt" class="active">Quantité</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" value="<?= $montant ?>" id="montant" name="montant" class="form-control" required>
                                        <label for="montant" class="active">Montant</label>
                                    </div>
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