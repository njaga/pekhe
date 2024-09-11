<?php
session_start();
include 'connexion.php';

$req_type_conges = $db->query("SELECT id, type_conges FROM `type_conges` WHERE etat=1;");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_enregistrement) FROM `demande_conges` WHERE etat=1");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des demandes </title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>dfk.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">
            <div class="row">

                <div class="card card-cascade narrower col-md-12 ">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des demandes</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-3 sm-3">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75" name="search" type="text" placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                            <div class="col-md-2 ">
                                <select class="browser-default custom-select" name="anne_demande" required="">
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
                                <select class="browser-default custom-select" name="mois" required="">
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
                                    <option value="tous">Tous les mois </option>
                                </select>
                            </div>
                            <div class="col-md-2 ">
                                <select class="browser-default custom-select" name="type_demande" required="">
                                    <option value="tous" selected >Types demandes </option>
                                    <option value="tous">Toutes </option>
                                    <?php
                                    while ($donnees_type_conges = $req_type_conges->fetch()) {
                                        echo "<option value='" . $donnees_type_conges['0'] . "'";
                                        echo ">" . $donnees_type_conges['1'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2 col-md-2 ">
                                <select class="browser-default custom-select" name="etat" required="">
                                    <option selected>Etat </option>
                                    <option value="tous">Tous </option>
                                    <option value="3">Validées </option>
                                    <option value="-1">Refusées </option>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover " >
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">#</td>
                                    <td class="white-text">Date Demande </td>
                                    <td class="white-text">Employé </td>
                                    <td class="white-text">Département</td>
                                    <td class="white-text">Type demandes</td>
                                    <td class="white-text">Période</td>
                                    <td class="white-text">Motif</td>
                                    <td class="white-text">Etat</td>
                                    <td class="white-text">Commentaire</td>
                                    <td class="white-text"></td>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                            </tbody>
                            <thead class="black ">
                                <tr>
                                <td class="white-text">#</td>
                                    <td class="white-text">Date Demande </td>
                                    <td class="white-text">Employé </td>
                                    <td class="white-text">Département</td>
                                    <td class="white-text">Type demandes</td>
                                    <td class="white-text">Période</td>
                                    <td class="white-text">Motif</td>
                                    <td class="white-text">Etat</td>
                                    <td class="white-text">Commentaire</td>
                                    <td class="white-text"></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Card content -->

                </div>
            </div>
            <!-- Card -->

        </section>
        <!-- Section -->
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
            var annee = $('select:eq(0)').val();
            var mois = $('select:eq(1)').val();
            var type_demande = $('select:eq(2)').val();
            var etat = $('select:eq(3)').val();
            var search = $('input:first').val();
            $.ajax({
                type: 'POST',
                url: 'l_demande_conges_rh_ajax.php',
                data: 'mois=' + mois + '&annee=' + annee + '&search=' + search+ '&type_demande=' + type_demande+ '&etat=' + etat,
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
        $('.mdb-select').materialSelect();
    })
</script>

</html>