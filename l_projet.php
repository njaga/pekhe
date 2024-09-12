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
include "connexion.php";
$req_commercial = $db->query("SELECT id, prenom, nom FROM `user` WHERE etat=1");
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des projets en cours</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>dt.jpg);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="">

        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalSiteForm">Nouveau
                projet
                <i class="fas fa-map-marker  ml-1"></i></a>
        </div>
        <!-- Modal: Succursale form -->
        <div class="modal fade" id="modalSiteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouveau projet</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_projet_trmnt.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="date" id="date_debut" value="<?= date('Y-m-d') ?>" name="date_debut" class="form-control " required>
                                        <label for="date_debut" class="active">Date début</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-8">
                                    <div class="md-form">
                                        <input type="text" id="nom_projet" name="nom_projet" class="form-control" required>
                                        <label for="nom_projet" class="active">nom du projet</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="text" id="localisation" name="localisation" class="form-control">
                                        <label for="localisation" class="active">Localisation</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <select class="mdb-select md-form" name="commercial" id="commercial" searchable="Recherhce commercial ..">
                                        <option value='' disabled selected>Commercial</option>
                                        <?php
                                        while ($donnee_commercial = $req_commercial->fetch()) {
                                            echo "<option value='" . $donnee_commercial['0'] . "'  >" . $donnee_commercial['1'] . " " . $donnee_commercial['2']  . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="commercial">Commercial</label>
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
                            <div class="row ">
                                <div class="col-md-12 ">
                                    <div class="md-form">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="bc_client" accept="application/pdf" class="custom-file-input" id="bc_client" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="bc_client">Bon de commande client</label>
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
        <!-- Modal: client form -->
        <!-- Card -->
        <div class="card card-cascade narrower col-10 offset-1">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Liste des projets en cours</h1>
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
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Nom du
                                    projet</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Emplacement
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date début
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Montant dépenses
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
                    url: 'l_projet_ajax.php',
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