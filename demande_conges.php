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
$req_types_conges = $db->query("SELECT id, type_conges FROM `type_conges` WHERE etat=1 ORDER BY type_conges ASC");
$req_jours_feriers = $db->query("SELECT YEAR(date_ferier), MONTH(date_ferier), DAY(date_ferier) 
FROM `jours_ferier`");
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
$req_nbr_jou_conges = $db->query("SELECT nbr_conges-COALESCE((SELECT SUM(nbr_jour) FROM `demande_conges` WHERE a_deduire=1 AND etat=3 AND id_employe=".$_SESSION['id_employe']."),0) FROM `employe` WHERE id=".$_SESSION['id_employe']);
$donnees_nbr = $req_nbr_jou_conges->fetch();
$nbr_jour_conges_restant=$donnees_nbr['0'];

$jours_feriers="";
while($donnee_jours_feriers = $req_jours_feriers->fetch()){
$jours_feriers =$jours_feriers."new Date (".$donnee_jours_feriers['0'].", ".($donnee_jours_feriers['1']-1).", ".$donnee_jours_feriers['2']."), ";
}
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
        <div class="text-left">
            <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalSiteForm">Nouvelle demande
                <i class="fas fa-map-marker  ml-1"></i></a>
        </div>
        <!-- Modal: demande form -->
        <div class="modal fade" id="modalSiteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header light-blue darken-3 white-text">
                        <h4 class=""><i class="fas fa-map-marker "></i> Nouvelle demande</h4>
                        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body mb-0">
                        <form method="POST" action="demande_conges_trmnt.php" >
                            <input type="number" name="nbr_jour" id="nbr_jour" value="0" hidden >
                            <div class="row">
                                <div class="col-md-6 ">
                                    <select class="browser-default custom-select md-form" name="type_conges" id="type_conges" required>
                                        <option value='' disabled selected>Types congès</option>
                                        <?php
                                        while ($donnee_commercial = $req_types_conges->fetch()) {
                                            echo "<option value='" . $donnee_commercial['0'] . "'  >" . $donnee_commercial['1'] .  "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="date" id="date_debut" value="<?= date('Y-m-d') ?>" name="date_debut" class="form-control " required onchange="calculerNombreJours()">
                                        <label for="date_debut" class="active">Date de début</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-8">
                                    <div class="md-form">
                                        <input type="date" id="date_fin" value="" name="date_fin" class="form-control " required onchange="calculerNombreJours()">
                                        <label for="date_fin" class="active">Date de fin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group shadow-textarea col-12">
                                    <label for="motif"></label>
                                    <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3" placeholder="Motif..."></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label id="jours_feries_entre_dates"></label>
                                <label id="nombre_dimanches"></label>
                                <label id="nombre_jours_pris"></label>
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
        <!-- Modal: demande form -->
        <!-- Card -->
        <div class="card card-cascade narrower col-12 ">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Liste des demandes de congés/permissions</h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade text-center table-responsive">
                <div class="row">
                    <h4><u>Nombre de jours restant : <b><?= $nbr_jour_conges_restant?></b> Jours </u></h4>
                </div>
                <div class="row table-responsive ">
                    <table class="table  table-hover w-auto centered  card-body ml-3">
                        <thead class="">
                            <tr>
                                <th class="font-weight-bold text-center text-uppercase" data-field="">#</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date demande</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Type demande
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Période
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">motif
                                </th>
                                <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Etat
                                    d'avancement</th>
                                <th class="font-weight-bold text-center text-uppercase th-lg">Commentaire(s)</th>
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
                    url: 'demande_conges_ajax.php',
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
    <script>
        function estJourFerie(date) {
            // Liste des jours fériés (exemple)
            var joursFeries = [
                <?= $jours_feriers; ?>
                
                //new Date(2023, 0, 1), // Jour de l'An
                //new Date(2024, 0, 1), // Jour de l'An
                //new Date(2023, 4, 1), // Fête du Travail
                // Ajoutez d'autres jours fériés selon votre besoin
            ];

            // Vérifier si la date est un jour férié
            for (var i = 0; i < joursFeries.length; i++) {
                if (date.toDateString() === joursFeries[i].toDateString()) {
                    return true;
                }
            }

            return false;
        }

        function calculerNombreJours() {
            // Récupérer les dates de début et de fin
            var dateDebut = new Date(document.getElementById('date_debut').value);
            var dateFin = new Date(document.getElementById('date_fin').value);

            // Initialiser les compteurs
            var differenceEnJours = 0;
            var nbr_dimanche = 0;
            var nbr_jour_feries = 0;

            // Tableau pour stocker les jours fériés entre les dates
            var joursFeriesEntreDates = [];

            // Boucle pour chaque jour entre la date de début et la date de fin
            for (var date = dateDebut; date <= dateFin; date.setDate(date.getDate() + 1)) {
                // Vérifier si le jour est un dimanche
                if (date.getDay() === 0) {
                    nbr_dimanche++;
                } else {
                    // Vérifier si le jour est un jour férié
                    if (estJourFerie(date)) {
                        joursFeriesEntreDates.push(date.toDateString());
                        nbr_jour_feries++;
                    } else {
                        differenceEnJours++;
                    }
                }
            }

            // Afficher le résultat dans le label
            document.getElementById('nombre_jours_pris').innerText = "Nombre de jours pris (sans dimanches ni jours fériés) : " + differenceEnJours;
            document.getElementById('nombre_dimanches').innerText = "Nombre de dimanches inclus : " + nbr_dimanche;

            // Afficher les jours fériés entre les dates
            document.getElementById('jours_feries_entre_dates').innerText = "Jours fériés entre les dates : " + nbr_jour_feries +" : " + joursFeriesEntreDates.join(", ");
            $("#nbr_jour").val(differenceEnJours);
        }
    </script>
</body>
<style type="text/css">

</style>

</html>