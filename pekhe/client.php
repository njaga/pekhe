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
    <title>Liste des clients</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>background-616360_1280.jpg);">
    <?php
		include 'verif_menu.php';
        ?>
    <div class="container">

        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalClient">Nouveau client
            <i class="fas fa-user-plus"></i></a>
        </div>
        <!-- Modal: Succursale form -->
        <div class="modal fade" id="modalClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouveau client</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_client_trmnt.php">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="md-form">
                                        <input type="text" required name="societe" id="societe" class="form-control">
                                        <label for="societe" class="">Société</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-0">
                                    <div class="md-form">
                                        <input type="text" required id="personne" name="personne" class="form-control">
                                        <label for="personne" class="">Personnes références</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-0">
                                    <div class="md-form">
                                        <input type="text" required id="telephone" name="telephone"
                                            class="form-control">
                                        <label for="telephone" class="">Telephone</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-0">
                                    <div class="md-form">
                                        <input type="text" required id="email" name="email" class="form-control">
                                        <label for="email" class="">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 mb-0">
                                    <div class="md-form">
                                        <input type="text" required id="adresse" name="adresse" class="form-control">
                                        <label for="adresse" class="">Adresse</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 mb-0">
                                    <div class="md-form">
                                        <input type="text" required id="activite" name="activite" class="form-control">
                                        <label for="activite" class="">Secteur(s) d'activité</label>
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
                <h1 class="mb-0">Liste des clients</h1>
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
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Société</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Personnes
                                    références</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Téléphone
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Email</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Adresse</th>
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
                url: 'client_ajax.php',
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