<?php
session_start();
include 'connexion.php';
$req_veh = $db->query("SELECT id, marque, modele, matricule FROM `vehicule` WHERE etat=1");
$req_chauf = $db->query("SELECT id, prenom, nom FROM `employe` WHERE fonction='Chauffeur' and etat=1");

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
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Sorite /Retours véhicules</title>
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
                <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalNewSortie">Nouvelle
                    sortie +
                </a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-12 ">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Sorite véhicule en cours</h1>
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
                            <thead class="black white-text ">
                                <tr>
                                    <th class="font-weight-bold text-center " data-field="">#</th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Date
                                    </th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Demandeur
                                    </th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Destination
                                    </th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Motif
                                        acquisition</th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Véhicule</th>
                                    <th class="font-weight-bold text-center  th-lg" data-field="">Chauffeur</th>
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
                                <div class="col-md-5 col-sm-5">
                                    <select class="browser-default custom-select  md-form" name="vehicule" id="vehicule" searchable="Recherhce du vehicule .." required>
                                        <option value='' disabled selected>Véhicule</option>
                                        <?php
                                        while ($donnees_veh = $req_veh->fetch()) {
                                            echo "<option value='" . $donnees_veh['0'] . "'  >" . $donnees_veh['1'] . " " . $donnees_veh['2'] . " : " . $donnees_veh['3'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <select class="browser-default custom-select  md-form" name="departement" id="departement"  required>
                                        <option value='' disabled selected>Département</option>
                                        <?php
                                        while ($donnees_departement = $req_departement->fetch()) {
                                            echo "<option value='" . $donnees_departement['0'] . "'  >" . $donnees_departement['1'] . " </option>";
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
                                    <select class="browser-default custom-select  md-form" name="chauffeur" id="chauffeur"  required>
                                        <option value='' disabled selected>Chauffeur</option>
                                        <?php
                                        while ($donnees_chauf = $req_chauf->fetch()) {
                                            echo "<option value='" . $donnees_chauf['0'] . "'  >" . $donnees_chauf['1'] . " " . $donnees_chauf['2'] . " </option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="md-form">
                                        <input type="text" id="destination" required name="destination" required class="form-control ">
                                        <label for="destination" class="active">Destination</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="md-form">
                                        <input type="number" id="carburant" required name="carburant" value="0" required class="form-control ">
                                        <label for="carburant" class="active">Carburant</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="md-form">
                                        <input type="number" id="peage" required name="peage" value="0" required class="form-control ">
                                        <label for="peage" class="active">Frais Péage</label>
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
            var search = $('input:first').val();
            $.ajax({
                type: 'POST',
                url: 'l_sortie_veh_ajax.php',
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