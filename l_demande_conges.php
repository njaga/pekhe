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
                <h1 class="mb-0">Liste des demandes de congés du département </h1>
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
                    url: 'l_demande_conges_ajax.php',
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
                new Date(2023, 0, 1), // Jour de l'An
                new Date(2024, 0, 1), // Jour de l'An
                new Date(2023, 4, 1), // Fête du Travail
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