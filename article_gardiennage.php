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
$req_employe = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom, site.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
LEFT JOIN affectation_site ON affectation_site.id_employe=employe.id
INNER JOIN site ON affectation_site.id_site=site.id
WHERE departement.id=3 AND employe.etat=1 AND affectation_site.etat=1 
ORDER BY employe.prenom, employe.nom  DESC");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_demande) FROM `accompte` 
ORDER BY date_demande");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois1 = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');

?>
<!DOCTYPE html>
<html>

<head>
    <title>Accompte(s) du mois</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>514.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="">

        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalSiteForm">Nouvel
                accompte
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
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouvel article</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="e_art_gard_trmnt.php">
                            <div class="row">
                                <div class="col-md-5  col-sm-8">
                                    <div class="md-form">
                                        <input type="text" id="article" name="article" class="form-control " required>
                                        <label for="article" class="active">Article</label>
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
                <h1 class="mb-0">Liste des articles</h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="row">
                <div class="col-10 sm-10">
                    <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <input class="form-control form-control-sm ml-3 w-75 search" name="search" id="search" type="text" placeholder="Recherche" aria-label="Search">
                    </form>
                </div>
            </div>
            <div class="row table-responsive ">
                <table class="table  table-hover w-auto centered  card-body ml-3" style="font-family:'Times new roman'; font-size:'150px'!important">
                    <thead class="">
                        <tr>
                            <th class="font-weight-bold text-center text-uppercase" data-field="">#</th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Article
                            </th>
                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Qt restante
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

            function accompte() {
                var search = $('#search').val();
                var mois = $('select:eq(2)').val();
                var annee = $('select:eq(3)').val();
                $.ajax({
                    type: 'POST',
                    url: 'article_gardiennage_ajax.php',
                    data: 'search=' + search,
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
            $('select').keyup(function() {
                accompte()
            });

        });
    </script>
</body>
<style type="text/css">

</style>

</html>