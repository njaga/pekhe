<?php
session_start();
include 'connexion.php';

if(!isset($_SESSION['id_vigilus_user']))
{
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
$req_veh = $db->query("SELECT id, marque, modele, matricule FROM `vehicule` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des véhicules</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>background-616360_1280.jpg);">
    <?php
		include 'verif_menu.php';
        ?>
    <div class="container">

        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalClient">Nouvelle sortie
                <i class="fas fa-car"></i></a>
        </div>
        <!-- Modal: Succursale form -->
        <div class="modal fade" id="modalClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouvelle sortie</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_sortie_veh_trmnt.php">
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="date" id="date_sortie" value="<?=date('Y-m-d') ?>" required
                                            name="date_sortie" required class="form-control ">
                                        <label for="date_sortie" class="active">Date sortie</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="time" id="heure_sortie" name="heure_sortie"
                                            class="form-control " required>
                                        <label for="heure_sortie" class="active">Heure
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-6 modal-body">
                                    <select class="mdb-select md-form" name="vehicule" id="vehicule"
                                        searchable="Recherhce du vehicule .." required>
                                        <option value='' disabled selected>Véhicule</option>
                                        <?php
                                    while ($donnees_veh =$req_veh->fetch()) {
                                        echo"<option value='".$donnees_veh['0']."'  >".$donnees_veh['1']." ".$donnees_veh['2']." : ".$donnees_veh['3']."</option>";
                                    }
                                ?>
                                    </select>
                                    <label for="vehicule" class='active'>Véhicu1le</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="demandeur" required name="demandeur" required
                                            class="form-control ">
                                        <label for="demandeur" class="active">Demandeur</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="md-form">
                                        <input type="text" id="destination" required name="destination" required
                                            class="form-control ">
                                        <label for="destination" class="active">destination</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-12">
                                    <label for="motif"></label>
                                    <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3"
                                        placeholder="Motif de la sorite.."></textarea>
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
        <div class="card card-cascade narrower col-md-12">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Liste des véhicules</h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade text-center table-responsive">
                <div class="row">
                    <div class="col-6 sm-4">
                        <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input class="form-control form-control-sm ml-3 w-75 search" name="search" type="text"
                                placeholder="Recherche" aria-label="Search">
                        </form>
                    </div>
                </div>
                <div class="row table-responsive ">
                    <table class="table  table-hover w-auto centered  card-body ml-3">
                        <thead class="">
                        <tr>
                                <th class="font-weight-bold text-center text-uppercase" data-field="">#</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Véhicule
                                    références</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Demandeur
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Destination
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Motif
                                    acquisition</th>
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
        var input = $('#heure_sortie').pickatime({
            autoclose: true,
            'default': 'now'
        });


        // Manually toggle to the minutes view
        $('#check-minutes').click(function(e) {
            e.stopPropagation();
            input.pickatime('show').pickatime('toggleView', 'minutes');
        });

        function l_sorite_veh(search) {
            $.ajax({
                type: 'POST',
                url: 'essai_ajax.php',
                data: 'search=' + search,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        var search = "";
        l_sorite_veh(search);
        $('.search').keyup(function() {
            var search = $('.search').val();
            l_sorite_veh(search)
        });

    });
    </script>
</body>
<style type="text/css">

</style>

</html>