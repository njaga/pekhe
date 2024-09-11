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



?>
<!DOCTYPE html>
<html>

<head>
    <title>Rendez-vous(s) journalier</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>514.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="container">

        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalSiteForm">Nouveau RDV
                <i class="far fa-calendar-plus"></i>
            </a>
        </div>
        <!-- Modal: Succursale form -->
        <div class="modal fade" id="modalSiteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-calendar "></i> Nouveau RDV</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_rdv_trmnt.php">
                            <div class="row">
                                <div class="col-md-5  col-sm-8">
                                    <div class="md-form">
                                        <input type="date" id="date_rdv" name="date_rdv" class="form-control " required>
                                        <label for="date_rdv" class="active">Date rendez-vous</label>
                                    </div>
                                </div>
                                <div class="col-md-5  col-sm-8">
                                    <div class="md-form">
                                        <input type="time" id="heure_rdv" name="heure_rdv" class="form-control "
                                            required>
                                        <label for="heure_rdv" class="active">Heure rendez-vous</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <div class="md-form">
                                        <input type="text" id="personne" name="personne" class="form-control" required>
                                        <label for="personne" class="active">Personne </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-12">
                                    <label for="motif"></label>
                                    <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3"
                                        placeholder="Motif du RDV..."></textarea>
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
        <div class="card card-cascade narrower col-10 offset-1 ">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Rendez-vous du mois <i class="fas fa-calendar"></i></h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade text-center table-responsive">
                <div class="row">
                    <div class="col-md-5  col-sm-8">
                        <div class="md-form">
                            <input type="date" value="<?= date('Y-m-d') ?>" id="date_rdv" name="date_rdv" class="form-control date_rdv" required>
                            <label for="date_rdv" class="active">Date rendez-vous</label>
                        </div>
                    </div>
                    <div class="col-md-5  col-sm-8">
                        <div class="md-form">
                            <input type="text"  id="search" placeholder="Recherche" name="search" class="form-control " required>
                            <label for="search" class="active">Recherche</label>
                        </div>
                    </div>
                    
                </div>

            </div>
            <div class="row table-responsive ">
                <table class="table  table-hover w-auto centered  card-body ml-3"
                    style="font-family:'Times new roman'; font-size:'150px'!important">
                    <thead class="">
                        <tr>
                            <th class="font-weight-bold text-center text-uppercase" data-field="">#</th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date RDV
                            </th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Heure
                            </th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Personne
                            </th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Motif RDV
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

        function accompte() {
            var search = $('#search').val();
            var date_re = $('.date_rdv').val();
            $.ajax({
                type: 'POST',
                url: 'rdv_j_ajax.php',
                data: 'search=' + search + '&date_re=' + date_re ,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        var search = "";
        accompte();
        $('#search').keyup(function() {
            accompte()
        });
        $('.date_rdv').change(function() {
            accompte()
        });

    });
    </script>
</body>
<style type="text/css">

</style>

</html>