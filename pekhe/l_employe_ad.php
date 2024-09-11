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
        <!-- Card -->
        <div class="card card-cascade narrower col-md-12">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Liste des employées administratifs</h1>
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
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Prénom</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Nom</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Département</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Solde congès</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field=""></th>
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
                url: 'l_employe_ad_ajax.php',
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