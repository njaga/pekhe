<?php

include 'connexion.php';
$id_site = htmlspecialchars(intval($_GET['s']));
$req_site = $db->query("SELECT id, `nom`, `localisation` FROM `site` WHERE id=" . $id_site);
$donnees = $req_site->fetch();
$nom_site = $donnees['1'];
$req_employe_remplacer = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
WHERE departement.id=3 AND employe.etat=1 
ORDER BY employe.prenom, employe.nom  DESC");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_planning) 
FROM `planning_vertical` WHERE 1");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');

?>
<!DOCTYPE html>
<html>

<head>
    <title>Nouveau planning</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>color-2174065_1280.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="row">

        <!-- Pllaning du mois -->
        <div class="card card-cascade narrower col-md-5 offset-md-3">

            <div class="view view-cascade gradient-card-header blue-gradient">
                <h4 class="mb-0 col-sm-12">Planning <b><?= $nom_site ?></b></h4>
            </div>
            <div class="card-body card-body-cascade  table-responsive">
                <div class="row">
                    <input type="number" id="id_site" value="<?= $id_site ?>" hidden>
                    <div class="col-md-5 ">
                        <select class="browser-default custom-select" id="anne_academique" name="anne_academique" required="">
                            <option selected>Année </option>
                            <?php
                            while ($donnees_annee = $req_annee->fetch()) {
                                echo "<option value='" . $donnees_annee['0'] . "'";
                                if ($donnees_annee['0'] == $annee_actuelle) {
                                    echo "selected";
                                }
                                echo ">" . $donnees_annee['0'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 ">
                        <select class="browser-default custom-select" id="mois" name="mois" required="">
                            <option selected>Sélectionnez le mois </option>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                echo "<option value='$i'";
                                if ($mois[$i] == $mois_actuel) {
                                    echo "selected";
                                }
                                echo ">$mois[$i]</option>";
                            }
                            ?>
                            <option value="tous">Tous les mois </option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <table class="table table-hover " id="l_employe">
                        <thead class="black ">
                            <tr>
                                <td class="white-text text-center">Date </td>
                                <td class="white-text text-center">Agent</td>
                                <td class="white-text text-center">Planning</td>
                                <td class="white-text text-center"></td>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                        </tbody>
                    </table>
                </div>
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

                function planning() {
                    var mois = $('#mois').val();
                    var annee = $('#anne_academique').val();
                    var id_site = $('#id_site').val();
                    $.ajax({
                        type: 'POST',
                        url: 'planning_details_ajax.php',
                        data: 'mois=' + mois + '&annee=' + annee + '&id_site=' + id_site,
                        success: function(html) {
                            $('tbody').html(html);
                        }
                    });
                }

                planning();
                $('select').change(function() {
                    planning();
                });
                var input = $('.timepicker').pickatime({
                    autoclose: true,
                    'default': 'now'
                });

            });
        </script>
</body>
<style type="text/css">

</style>

</html>