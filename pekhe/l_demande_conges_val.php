<?php
session_start();

if (!isset($_SESSION['id_vigilus_user'])) {
?>
    <script type="text/javascript">
        alert("Veillez d'abord vous connectez !");
        window.location = 'index.php';
    </script>
<?php
}
include "connexion.php";
$req_types_conges = $db->query("SELECT id, type_conges FROM `type_conges` WHERE etat=1");
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des demandes</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>dt.jpg);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="">
        <!-- Card -->
        <div class="card card-cascade narrower col-12">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Liste des demandes de congés validées</h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade text-center table-responsive">
                <div class="row">
                    <div class="col-6 sm-4">
                        <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input class="form-control form-control-sm ml-3 w-75 search" id="search" name="search" type="text" placeholder="Recherche" aria-label="Search">
                        </form>
                    </div>
                </div>
                <div class="row table-responsive ">
                    <table class="table  table-hover w-auto centered  card-body ml-3">
                        <thead class="">
                            <tr>
                                <th class="font-weight-bold text-center text-uppercase" data-field="">#</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date demande</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Employé</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Département</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Type demande
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Période
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">motif
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Etat
                                    d'avancement</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg"></th>
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

            function l_projet() {
                var search = $('#search').val();
                $.ajax({
                    type: 'POST',
                    url: 'l_demande_conges_val_ajax.php',
                    data: 'search=' + search,
                    success: function(html) {
                        $('tbody').html(html);
                    }
                });
            }

            l_projet();
            $('.search').keyup(function() {
                l_projet()
            });

        });
    </script>
</body>
<style type="text/css">

</style>

</html>