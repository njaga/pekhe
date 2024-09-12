<?php
session_start();

$_SESSION['id_user_dasil']="1";
if(!isset($_SESSION['id_vigilus_user']))
{
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des jours fériers</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>background-616360_1280.jpg);">
    <?php
		include 'verif_menu.php';
        ?>
    <div class="container">

        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalClient">Nouveau
                jours
                </a>
        </div>
        <!-- Modal: Succursale form -->
        <div class="modal fade" id="modalClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouveau jour</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_ferier_trmnt.php">
                            <div class="row">
                            <div class="col-6 col-md-6">
                                    <div class="md-form">
                                        <input type="date" value="<?= date('Y-m-d') ?>" required id="date_ferier" name="date_ferier"
                                            class="form-control">
                                        <label for="date_ferier" class="">Date férier</label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="md-form">
                                        <input type="text" required name="description" id="description" class="form-control">
                                        <label for="description" class="">Description</label>
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
        <div class="card card-cascade narrower col-md-12">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Liste des jours féries</h1>
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
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Dénomination
                                    références</th>
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

        function l_vehicule(search) {
            $.ajax({
                type: 'POST',
                url: 'l_ferier_ajax.php',
                data: 'search=' + search,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        var search = "";
        l_vehicule(search);
        $('.search').keyup(function() {
            var search = $('.search').val();
            l_vehicule(search)
        });

    });
    </script>
</body>
<style type="text/css">

</style>

</html>