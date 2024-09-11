<?php
session_start();

$_SESSION['id_user_dasil'] = "1";
if (!isset($_SESSION['id_vigilus_user'])) {
?>
    <script type="text/javascript">
        alert("Veillez d'abord vous connectez !");
        window.location = 'index.php';
    </script>
<?php
}
include 'connexion.php';
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des sites de gardiennage</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>1.jpg);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="card-body card-body-cascade">

        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalSiteForm">Nouveau site <i class="fas fa-map-marker  ml-1"></i></a>
        </div>
        <!-- Modal: Succursale form -->
        <div class="modal fade" id="modalSiteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouveau site</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_site_trmnt.php">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="md-form">
                                        <input type="text" required name="nom" id="nom" class="form-control">
                                        <label for="nom" class="">Nom</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 mb-0">
                                    <div class="md-form">
                                        <input type="text" required id="localisation" name="localisation" class="form-control">
                                        <label for="localisation" class="">Localisation</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="md-form">
                                        <input type="date" id="date_debut" name="date_debut" class="form-control ">
                                        <label for="date_debut" class="active">Date déut</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <select class="browser-default custom-select md-form" name="departement" searchable="Recherhce .." required>
                                        <option value='' disabled selected>Département</option>
                                        <?php
                                        while ($donnees_departement = $req_departement->fetch()) {
                                            echo "<option value='" . $donnees_departement['0'] . "'  >" . $donnees_departement['1'] . "</option>";
                                        }
                                        ?>
                                    </select>
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
        <div class="card card-cascade narrower col-10 offset-1">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Liste des sites de gardiennage</h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade text-center table-responsive">
                <div class="row">
                    <div class="col-6 sm-4">
                        <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input class="form-control form-control-sm ml-3 w-75 search" name="search" type="text" placeholder="Recherche" aria-label="Search">
                        </form>
                    </div>
                </div>
                <div class="row table-responsive ">
                    <table class="table  table-hover w-auto centered  card-body ml-3">
                        <thead class="">
                            <tr>
                                <th class="font-weight-bold text-center text-uppercase" data-field="">#</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Nom du site</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Emplacement</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date début</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Nbr agents</th>
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
            $('.datepicker').pickadate({
                // Escape any “rule” characters with an exclamation mark (!).
                format: 'yyyy-mm-dd',
                formatSubmit: 'yyyy/mm/dd',
                hiddenPrefix: 'prefix__',
                hiddenSuffix: '__suffix'
            });

            function l_client(search) {
                $.ajax({
                    type: 'POST',
                    url: 'l_site_ajax.php',
                    data: 'search=' + search,
                    success: function(html) {
                        $('tbody').html(html);
                    }
                });
            }

            var search = "";
            l_client(search);
            $('.search').keyup(function() {
                var search = $('.search').val();
                l_client(search)
            });

        });
    </script>
</body>
<style type="text/css">

</style>

</html>