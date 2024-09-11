<?php
session_start();
include 'connexion.php';

$req_annee = $db->query("SELECT DISTINCT YEAR(date_operation) 
FROM `caisse` WHERE 1");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Etat Banque</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>dfk.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalDepense">Nouvelle
                    opération +
                </a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Etat banque</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-4 sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" enctype="multipart/form-data">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75" name="search" type="text" placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                            <div class="col-md-2 ">
                                <select class="browser-default custom-select" name="anne_academique" required="">
                                    <option selected disabled>Année </option>
                                    <?php
                                    while ($donnees_annee = $req_annee->fetch()) {
                                        echo "<option value='" . $donnees_annee['0'] . "'";
                                        if ($donnees_annee['0'] == $annee_actuelle) {
                                            echo "selected";
                                        }
                                        echo ">" . $donnees_annee['0'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-2 ">
                                <select class="browser-default custom-select" name="mois" required="">
                                    <option disabled>Sélectionnez le mois </option>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo "<option value='$i'";
                                        if ($mois[$i] == $mois_actuel) {
                                            echo "selected";
                                        }
                                        echo ">$mois[$i]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover " id="l_employe">
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">Date </td>
                                    <td class="white-text">Bon / Carnet</td>
                                    <td class="white-text">Libellé Dépense</td>
                                    <td class="white-text">Entrée</td>
                                    <td class="white-text">Sortie</td>
                                    <td class="white-text">Solde</td>
                                    <td class="white-text" width="50px"></td>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                            </tbody>
                        </table>
                    </div>
                    <!-- Card content -->

                </div>
            </div>
            <!-- Card -->

        </section>
        <!-- Section -->
        <!-- Modal: Succursale form -->
        <div class="modal fade" id="modalDepense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouvelle opération</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_banque_trmnt.php" enctype="multipart/form-data">
                            <input type="number" class="id" name="id" value="" hidden>
                            <div class="row">
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="text" id="date_operation" value="<?= date('Y-m-d') ?>" name="date_operation" class="form-control datepicker" required>
                                        <label for="date_operation" class="active">Date opération</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <select class="browser-default custom-select" name="type_operation" id="type_opération" required>
                                            <option value='' selected disabled>Opération</option>
                                            <option value="entree">Entrée</option>
                                            <option value="sortie">Sortie</option>
                                            <option value="solde">Solde</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-10">
                                    <div class="md-form">
                                        <select class="browser-default custom-select" name="section" id="section" required>
                                            <option value='' disabled selected>Section</option>
                                            <option value="Approvisionnement">Approvisionnement</option>
                                            <option value="Eau">Eau</option>
                                            <option value="Electricité">Electricité</option>
                                            <option value="Divers">Divers</option>
                                            <option value="Telephonie">Téléphonie</option>
                                            <option value="Transport">Transport</option>
                                            <option value="Carburant">Carburant</option>
                                            <option value="Retrait chèque">Retrait chèque</option>
                                            <option value="Réglèment facture">Réglèment facture</option>
                                            <option value="Remise chèque">Remise chèque</option>
                                            <option value="Versement banque">Versement banque</option>
                                            <option value="Solde">Solde</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-10">
                                    <div class="md-form">
                                        <input type="text" id="description" name="description" class="form-control" required>
                                        <label for="description" class="active">Motif dépense</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" value="0" id="bon" name="bon" class="form-control">
                                        <label for="bon" class="active">N° Bon</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" value="0" id="carnet" name="carnet" class="form-control">
                                        <label for="carnet" class="active">N° Carnet</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" value="0" id="num_cheque" name="num_cheque" class="form-control">
                                        <label for="num_cheque" class="active">N° Chèque</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" id="montant" name="montant" class="form-control" value="0" required>
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
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>

</body>
<style type="text/css">
    body {
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #999;
    }

    table {
        font-family: "times new roman";
        font-size: "28px";
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        function dotation(search) {
            var mois = $('select:eq(1)').val();
            var annee = $('select:eq(0)').val();
            var search = $('input:first').val();
            $.ajax({
                type: 'POST',
                url: 'etat_banque_ajax.php',
                data: 'mois=' + mois + '&annee=' + annee + '&search=' + search,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        dotation();
        $('select').change(function() {
            dotation();
        });
        $('input:first').keyup(function() {
            dotation()
        });
    })
</script>

</html>