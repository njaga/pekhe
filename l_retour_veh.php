<?php
session_start();
include 'connexion.php';
$req_veh = $db->query("SELECT id, marque, modele, matricule FROM `vehicule` WHERE etat=1");

$req_site = $db->query("SELECT DISTINCT site.id, site.nom, site.localisation FROM `site` WHERE 1
");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_dotation) 
FROM `dotation_art_gard` WHERE 1");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');

//Liste projets;
$req_projet = $db->query("SELECT id, nom_projet FROM `projet` WHERE etat=1");
$req_fournisseur = $db->query("SELECT id, nom, categorie FROM `fournisseur_achat` WHERE etat=1");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Retours véhicules</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>1562743_1280.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalNewSortie">Nouvelle
                    sortie ++
                </a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-12 ">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Retours véhicules</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                    <div class="row">
                            <div class="col-4 sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75 search" name="search" type="text" placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                            <div class="col-md-2 ">
                                <select class="browser-default custom-select list" name="annee" required="">
                                    <option selected>Année </option>
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
                                <select class="browser-default custom-select list" name="mois" required="">
                                    <option selected>Sélectionnez le mois </option>
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

                            <div class="col-6 col-md-3 ">
                                <select class="browser-default custom-select list" name="categorie" required="">
                                    <option selected value="toutes">Tous  véhicules </option>
                                    <?php
                                    while ($donnees_veh = $req_veh->fetch()) {
                                        echo "<option value=" . $donnees_veh['0'] . ">" . $donnees_veh['1'] . " :". $donnees_veh['3'] ."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover " id="l_employe">
                            <thead class="black white-text ">
                                <tr>
                                    <th class="font-weight-bold text-center " data-field="">#</th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Date</th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Véhicule </th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Demandeur</th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Destination </th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Motif sortie</th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Chauffeur </th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Département </th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Date retour</th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Commentaire</th>
                                    <th class="font-weight-bold text-center  th-lg"></th>
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
        <div class="modal fade" id="modalNewSortie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouvelle sortie</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_sortie_veh_trmnt.php">
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="date" id="date_sortie" value="<?= date('Y-m-d') ?>" required name="date_sortie" required class="form-control ">
                                        <label for="date_sortie" class="active">Date sortie</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="time" id="heure_sortie" name="heure_sortie" class="form-control " required>
                                        <label for="heure_sortie" class="active">Heure
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-6">
                                    <select class="browser-default custom-select  md-form" name="vehicule" id="vehicule" searchable="Recherhce du vehicule .." required>
                                        <option value='' disabled selected>Véhicule</option>
                                        <?php
                                        while ($donnees_veh = $req_veh->fetch()) {
                                            echo "<option value='" . $donnees_veh['0'] . "'  >" . $donnees_veh['1'] . " " . $donnees_veh['2'] . " : " . $donnees_veh['3'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="demandeur" required name="demandeur" required class="form-control ">
                                        <label for="demandeur" class="active">Demandeur</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="destination" required name="destination" required class="form-control ">
                                        <label for="destination" class="active">destination</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-12">
                                    <label for="motif"></label>
                                    <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3" placeholder="Motif de la sorite.."></textarea>
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
            var vehicule = $('select:eq(2)').val();
            var mois = $('select:eq(1)').val();
            var annee = $('select:eq(0)').val();
            var search = $('.search').val();
            $.ajax({
                type: 'POST',
                url: 'l_retour_veh_ajax.php',
                data: 'mois=' + mois + '&annee=' + annee + '&search=' + search + '&vehicule=' + vehicule,
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