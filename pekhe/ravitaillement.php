<?php
session_start();

include 'connexion.php';

$req_annee = $db->query("SELECT DISTINCT YEAR(date_entree) FROM entrees 
ORDER BY date_entree");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois1 = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');

?>
<!DOCTYPE html>
<html>

<head>
    <title>Approvisionnements</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>login.jpg);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="">

        <div class="text-left">
            <a href="e_ravitaillement.php" class="btn btn-primary btn-rounded">Nouvel Approvisionnement
                <i class="fas fa-map-marker  ml-1"></i>
            </a>
        </div>
        <!-- Modal: Succursale form -->
        <div class="modal fade" id="modalSiteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouveau Ravitaiilement</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_accompte_trmnt.php">
                            <div class="row">
                                <div class="col-md-5  col-sm-8">
                                    <div class="md-form">
                                        <input type="date" id="date_demande" name="date_demande" class="form-control " required>
                                        <label for="date_demande" class="active">Date demande</label>
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
        <!-- Card -->
        <div class="card card-cascade narrower col-12 ">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Ravitaillement du mois</h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade text-center table-responsive">
                <div class="row">
                    <div class="col-5 col-md-2 ">
                        <select class="browser-default custom-select accompte" name="mois" required="">
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
                    <div class="col-3 col-md-2  ">
                        <select class="browser-default custom-select accompte" name="anne_ravitaillement" required="">
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

                </div>
            </div>

            <div class="row table-responsive ">
                <table class="table  table-hover w-auto centered  card-body ml-3" style="font-family:'Times new roman'; font-size:'150px'!important">
                    <thead class="" style="font-size: 9px;">
                        <tr>
                            <th class="font-weight-bold text-center text-uppercase" data-field="">#</th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date
                            </th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Article
                            </th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Qantité
                            </th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Stock
                            </th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">
                            </th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card content -->

    </div>
    <!-- Card -->
    </div>
    <br>
    <span id="fin"></span>
    <?php include 'js.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.mdb-select').materialSelect();
            $('.datepicker').pickadate({
                // Escape any “rule” characters with an exclamation mark (!).
                format: 'yyyy-mm-dd',
                formatSubmit: 'yyyy/mm/dd',
                hiddenPrefix: 'prefix__',
                hiddenSuffix: '__suffix'
            });

            function ravitaillement() {
                var mois = $('select:eq(0)').val();
                var annee = $('select:eq(1)').val();
                $.ajax({
                    type: 'POST',
                    url: 'ravitaillement_ajax.php',
                    data: 'mois=' + mois + '&annee=' + annee,
                    success: function(html) {
                        $('tbody').html(html);
                    }
                });
            }
            ravitaillement();
            $('select').change(function() {
                ravitaillement();
            });

        });
    </script>
</body>
<style type="text/css">

</style>

</html>