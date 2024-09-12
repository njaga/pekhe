<?php
session_start();
include 'connexion.php';
$db->query("SET lc_time_names = 'fr_FR';");

$search = $_POST['search'];
$mois = $_POST['mois'];
$annee = $_POST['annee'];

if ($mois == 1) {
    //Solde su mois précédent
    $date_dernier_jour = $annee . '-' . $mois . '-01';
    $reponse = $db->prepare("SELECT (SELECT COALESCE(SUM(montant),0) FROM caisse WHERE type='entree' AND date_operation<?)  - (SELECT COALESCE(SUM(montant),0) FROM caisse WHERE type='sortie' AND  date_operation<?)");
    $reponse->execute(array($date_dernier_jour, $date_dernier_jour));
    $donnees = $reponse->fetch();
    $solde = $donnees['0'];
    $solde_init = $donnees['0'];
    $mois_precedent = "Décembre " . ($annee - 1);
} else {
    //Solde su mois précédent
    $date_dernier_jour = $annee . '-' . $mois . '-01';
    $reponse = $db->prepare("SELECT (SELECT COALESCE(SUM(montant),0) FROM caisse WHERE type='entree' AND date_operation<?)  - (SELECT COALESCE(SUM(montant),0) FROM caisse WHERE type='sortie' AND  date_operation<?)");
    $reponse->execute(array($date_dernier_jour, $date_dernier_jour));
    $donnees = $reponse->fetch();
    $solde = $donnees['0'];
    $solde_init = $donnees['0'];
    //mois précédent
    $list_mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    $mois_precedent = $list_mois[($mois - 1)];
}





$reponse = $db->prepare("SELECT caisse.id, CONCAT(DATE_FORMAT(`date_operation`, '%d'), '/', DATE_FORMAT(`date_operation`, '%m'),'/', DATE_FORMAT(`date_operation`, '%Y')), `type`, `section`, `bon`, `motif`, `montant`, date_operation, carnet, document_caisse.nom_document, document_caisse.chemin
FROM `caisse`
LEFT JOIN document_caisse ON caisse.id=document_caisse.id_caisse
WHERE caisse.etat=1 AND MONTH(date_operation)=? AND YEAR(date_operation)=? AND motif like CONCAT('%', ?, '%') ORDER BY caisse.date_operation ASC");
$reponse->execute(array($mois, $annee, $search));


$resultat = $reponse->rowCount();
$som_entree = 0;
$som_sortie = 0;
$som_solde = 0;

echo "<tr>";
echo "<td colspan='3' class='center'><b>Solde du mois de " . ucfirst($mois_precedent) . "</b></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td class='right'>" . number_format($solde, 0, '.', ' ') . "</td>";
echo "</tr>";

$nbr = $reponse->rowCount();
if ($nbr > 0) {
    while ($donnees = $reponse->fetch()) {
        $id = $donnees['0'];
        $date_operation = $donnees['1'];
        $type = $donnees['2'];
        $section = $donnees['3'];
        $bon = $donnees['4'];
        $motif = $donnees['5'];
        $montant = $donnees['6'];
        $date_operation1 = $donnees['7'];
        $carnet = $donnees['8'];
        $nom_document = $donnees['9'];
        $chemin = $donnees['10'];
        if ($chemin == NULL) {
            $motif1 =  $motif;
        } else {
            $motif1 = "<a href='" . $chemin . "' class='blue-text'>" . $motif . "</a>";
        }

        if ($type == 'entree') {
            echo "<tr class=''>";
            $som_entree = $som_entree + $montant;
        } elseif ($type == 'sortie') {
            echo "<tr class=''>";
            $som_sortie = $som_sortie + $montant;
        } else {
            echo "<tr>";
        }
        echo "<td class='center'>" . $date_operation . "</td>";
        echo "<td>" . $bon . "/" . $carnet . "</td>";
        echo "<td>" . $motif1 . "</td>";
        if ($type == "entree") {
            $solde = $solde + $montant;
            echo "<td class='right-align'>" . number_format($montant, 0, '.', ' ') . "</td>";
            echo "<td></td>";
        } elseif ($type == 'sortie') {
            $solde = $solde - $montant;
            echo "<td></td>";
            echo "<td class='right-align'>" . number_format($montant, 0, '.', ' ') . "</td>";
        } else {
            $solde = $solde + $montant;
            echo "<td></td>";
            echo "<td></td>";
        }
        echo "<td class='right-align'>" . number_format($solde, 0, '.', ' ') . "</td>";
        echo '<td>
            <a href="" data-toggle="modal" data-target="#modalModifSite' . $id . '" class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a>
            <a href="s_ligne_caisse.php?id=' . $id . '" class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cet dépense ?\'))"><i class="fas fa-times"></i></a>
            &nbsp&nbsp&nbsp
            
        </td>';
?>
        <td>
            <!-- Modal: modif site -->
            <div class="modal fade" id="modalModifSite<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog cascading-modal" role="document">
                    <!-- Content -->
                    <div class="modal-content">

                        <!-- Header -->
                        <div class="modal-header light-blue darken-3 white-text">
                            <h4 class=""> Modification opération</h4>
                            <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body mb-0">
                            <form method="POST" action="m_caisse_trmnt.php" enctype="multipart/form-data">
                                <input type="number" class="id" name="id" value="<?= $id ?>" hidden>
                                <div class="row">
                                    <div class="col-md-5 col-sm-8">
                                        <div class="md-form">
                                            <input type="date" id="date_operation" value="<?= $date_operation1 ?>" name="date_operation" class="form-control datepicker" required>
                                            <label for="date_operation" class="active">Date opération</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="md-form">
                                            <select class="browser-default custom-select" name="type_operation" id="type_opération">
                                                <option value='' disabled>Opération</option>
                                                <option value="entree" <?php if ($type == "entree") {
                                                                            echo "selected";
                                                                        } ?>>Entrée</option>
                                                <option value="sortie" <?php if ($type == "sortie") {
                                                                            echo "selected";
                                                                        } ?>>Sortie</option>
                                                <option value="solde" <?php if ($type == "solde") {
                                                                            echo "selected";
                                                                        } ?>>Solde</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-10 col-sm-10 ">
                                        <div class="md-form">
                                            <select class="browser-default custom-select" name="section" id="section" required>
                                                <option value='' disabled>Section</option>
                                                <option value="Approvisionnement" <?php if ($type == "Approvisionnement") {
                                                                                        echo "selected";
                                                                                    } ?>>Approvisionnement</option>
                                                <option value="Eau" <?php if ($type == "Eau") {
                                                                        echo "selected";
                                                                    } ?>>Eau</option>
                                                <option value="Electricité" <?php if ($type == "Electricité") {
                                                                                echo "selected";
                                                                            } ?>>Electricité</option>
                                                <option value="Carburant" <?php if ($type == "Carburant") {
                                                                                echo "selected";
                                                                            } ?>>Carburant</option>
                                                <option value="Divers" <?php if ($type == "Divers") {
                                                                            echo "selected";
                                                                        } ?>>Divers</option>
                                                <option value="Telephonie" <?php if ($type == "Telephonie") {
                                                                                echo "selected";
                                                                            } ?>>Téléphonie</option>
                                                <option value="Transport" <?php if ($type == "Transport") {
                                                                                echo "selected";
                                                                            } ?>>Transport</option>
                                                <option value="Retrait chèque" <?php if ($type == "Retrait chèque") {
                                                                                    echo "selected";
                                                                                } ?>>Retrait chèque</option>
                                                <option value="Réglèment facture" <?php if ($type == "Réglèment facture") {
                                                                                        echo "selected";
                                                                                    } ?>>Réglèment facture</option>
                                                <option value="Versement banque" <?php if ($type == "Versement banque") {
                                                                                        echo "selected";
                                                                                    } ?>>Versement banque</option>
                                                <option value="Réglèment facture fournisseur" <?php if ($type == "Réglèment facture fournisseur") {
                                                                                                    echo "selected";
                                                                                                } ?>>Réglèment facture fournisseur</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-sm-10">
                                        <div class="md-form">
                                            <input type="text" id="description" value="<?= $motif ?>" name="description" class="form-control" required>
                                            <label for="description" class="active">Libellé dépense</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-8">
                                        <div class="md-form">
                                            <input type="number" value="<?= $bon ?>" id="bon" name="bon" class="form-control">
                                            <label for="bon" class="active">N° Bon</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-8">
                                        <div class="md-form">
                                            <input type="number" value="<?= $carnet ?>" id="carnet" name="carnet" class="form-control">
                                            <label for="carnet" class="active">N° Carnet</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-8">
                                        <div class="md-form">
                                            <input type="number" id="montant" value="<?= $montant ?>" name="montant" class="form-control" required>
                                            <label for="montant" class="active">Montant</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12 ">
                                        <div class="md-form">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="bc" accept="" class="custom-file-input" id="bc" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="bc">Pièce Jointe</label>
                                                </div>
                                            </div>
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
    }
    $reponse->closeCursor();
    //Total et solde
    echo "</tr>";

    echo "<tr class='white darken-3 '>";
    echo "<td colspan='3' class='center'><b>TOTAL</b></td>";
    echo "<td class='right-align'><b>" . number_format($som_entree, 0, '.', ' ') . " </b></td>";
    echo "<td class='right-align'><b>" . number_format($som_sortie, 0, '.', ' ') . " </b></td>";
    echo "<td class='right-align'><b>" . number_format(($solde_init + $som_entree - $som_sortie), 0, '.', ' ') . " </b></td>";
    echo "</tr>";
} else {
    echo "<tr><td class='trait center' colspan='5'><h3>Aucune ce mois ci </td></tr>";
}



?>


<?php

?>
<script type="text/javascript">
    $('.mdb-select').materialSelect();
    // Tooltips Initialization
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>