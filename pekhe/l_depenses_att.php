<?php
session_start();
include 'connexion.php';

$req_site = $db->query("SELECT DISTINCT site.id, site.nom, site.localisation FROM `site` WHERE 1
");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_dotation) 
FROM `dotation_art_gard` WHERE 1");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');

//Liste projets;
$req_projet = $db->query("SELECT id, nom_projet FROM `projet` WHERE etat=1");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des dépenses en attente</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>wood-1108307_1280.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalDepense">Nouvelle
                    dépense +
                </a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des dépenses en attente</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-4 sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75" name="search" type="text" placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>

                        </div>
                        <table class="table table-hover " id="l_employe">
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">Date dépense</td>
                                    <td class="white-text">Departement</td>
                                    <td class="white-text">Description</td>
                                    <td class="white-text">Priorité</td>
                                    <td class="white-text">Quantité</td>
                                    <td class="white-text">Montant</td>
                                    <td class="white-text">Fournisseur</td>
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
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouvelle dépense</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_depense_trmnt.php">
                            <input type="number" class="id" name="id" value="" hidden>
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
                                                echo "<option value='" . $donnee_projet['0'] . "'>" . $donnee_projet['1'] . "</option>";
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
                                            <option value="Eleve">Eleve</option>
                                            <option value="Moyen">Moyen</option>
                                            <option value="Faible">Faible</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5 ">
                                    <div class="">
                                        <select class="browser-default custom-select" name="departement" id="departement" required>
                                            <option value='' disabled selected>Département</option>
                                            <option value="Incendie">Incendie</option>
                                            <option value="Informatique">Informatique</option>
                                            <option value="Gardiennage">Gardiennage</option>
                                            <option value="Electronique">Electronique</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="md-form">
                                        <input type="text" id="description" name="description" class="form-control" required>
                                        <label for="description" class="active">Motif dépense</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="md-form">
                                        <input type="text" id="fournisseur" name="fournisseur" class="form-control">
                                        <label for="fournisseur" class="active">Fournisseur</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" id="qt" name="qt" class="form-control" required>
                                        <label for="qt" class="active">Quantité</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="number" id="montant" name="montant" class="form-control" required>
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
            var search = $('input:first').val();
            $.ajax({
                type: 'POST',
                url: 'l_depenses_att_ajax.php',
                data: 'search=' + search,
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