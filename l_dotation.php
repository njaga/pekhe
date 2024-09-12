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


?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des dotations</title>
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
                <a href="e_dotation.php" class="btn col-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-12 ">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des dotations</h1>
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
                                    <option value="tous">Tous les mois </option>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover " id="l_employe">
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">#</td>
                                    <td class="white-text">Date </td>
                                    <td class="white-text">Agent </td>
                                    <td class="white-text">Chem</td>
                                    <td class="white-text">Lac</td>
                                    <td class="white-text">ChauV</td>
                                    <td class="white-text">ChauSec</td>
                                    <td class="white-text">VestN</td>
                                    <td class="white-text">VestP</td>
                                    <td class="white-text">Ceint</td>
                                    <td class="white-text">Epaul</td>
                                    <td class="white-text">Panta</td>
                                    <td class="white-text">Badge</td>
                                    <td class="white-text">Casquet</td>
                                    <td class="white-text">Crava</td>
                                    <td class="white-text">CombiChan</td>
                                    <td class="white-text">Tonfa</td>
                                    <td class="white-text">Képi</td>
                                    <td class="white-text">Blouson</td>
                                    <td class="white-text">Pantalon Parka</td>
                                    <td class="white-text"></td>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                            </tbody>
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">#</td>
                                    <td class="white-text">Date </td>
                                    <td class="white-text">Agent </td>
                                    <td class="white-text">Chem</td>
                                    <td class="white-text">Lac</td>
                                    <td class="white-text">ChauV</td>
                                    <td class="white-text">ChauSec</td>
                                    <td class="white-text">VestN</td>
                                    <td class="white-text">VestP</td>
                                    <td class="white-text">Ceint</td>
                                    <td class="white-text">Epaul</td>
                                    <td class="white-text">Panta</td>
                                    <td class="white-text">Badge</td>
                                    <td class="white-text">Casquet</td>
                                    <td class="white-text">Crava</td>
                                    <td class="white-text">CombiChan</td>
                                    <td class="white-text">Tonfa</td>
                                    <td class="white-text">Képi</td>
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
            var mois = $('select:eq(1)').val();
            var annee = $('select:eq(0)').val();
            var search = $('input:first').val();
            $.ajax({
                type: 'POST',
                url: 'l_dotation_ajax.php',
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