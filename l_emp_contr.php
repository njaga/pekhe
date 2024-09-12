<?php
session_start();
include 'connexion.php';

$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_prevu_fin) FROM `contrat_employe` WHERE 1");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des employes </title>
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
                <a href="l_employe_contrat.php" class="btn col-4 col-md-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des employes par date de fin contrat</h1>
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
                            <div class="col-3 col-md-2  ">
                                <select class="browser-default custom-select" searchable="Recherhce du site .." name="anne_academique" required="">
                                    <option disabled>Année </option>
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
                            <div class="col-5 col-md-2 ">
                                <select class="browser-default custom-select" name="mois" required="">
                                    <option selected disabled>Sélectionnez le mois </option>
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
                            <table class="table table-hover " id="l_employe">
                                <thead class="black ">
                                    <tr>
                                        <td class="white-text">#</td>
                                        <td class="white-text">Département</td>
                                        <td class="white-text">Prénom </td>
                                        <td class="white-text">Nom</td>
                                        <td class="white-text">Date naissance</td>
                                        <td class="white-text">Fonction</td>
                                        <td class="white-text">Date début contrat</td>
                                        <td class="white-text">Date prévue fin contrat</td>
                                        <td class="white-text">Montant</td>
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
        function l_emp_contr(search) {
            var annee = $('select:eq(0)').val();
            var mois = $('select:eq(1)').val();
            var search = $('input:first').val();
            $.ajax({
                type: 'POST',
                url: 'l_emp_contr_ajax.php',
                data: 'search=' + search + '&annee=' + annee + '&mois=' + mois,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        l_emp_contr();
        $('select').change(function() {
            l_emp_contr();
        });
        $('input:first').keyup(function() {
            l_emp_contr()
        });
    })
</script>

</html>