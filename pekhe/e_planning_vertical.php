<?php

include 'connexion.php';
$req_site = $db->query("SELECT id, `nom`, `localisation` FROM `site` WHERE etat=1");
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

        <!-- Nouveau pllaning -->
        <div class="card card-cascade narrower col-md-8 offset-md-2">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h4 class="mb-0 col-sm-12">Nouveau Planning</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="e_planning_vertical_trmnt.php" method="POST">

                    <div class="row">
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form" name="site" id="site" searchable="Recherhce du site .." required>
                                <option value='' disabled selected>Site de gardiennage</option>
                                <?php
                                while ($donnees_site = $req_site->fetch()) {
                                    echo "<option value='" . $donnees_site['0'] . "'  >" . $donnees_site['1'] . " == " . $donnees_site['2'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="site">Site de gardiennage</label>
                        </div>
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form employe" name="employe" id="employe" searchable="Recherhce du agent ..">
                                <option value='' disabled selected>Employe</option>
                                <?php
                                while ($donnees_employe_remplacer = $req_employe_remplacer->fetch()) {
                                    echo "<option value='" . $donnees_employe_remplacer['0'] . "'  >" . $donnees_employe_remplacer['2'] . " " . $donnees_employe_remplacer['3']  . "</option>";
                                }
                                ?>
                            </select>
                            <label for="employe">Employe</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4  ">
                            <select class="mdb-select md-form" name="mois" required="">
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
                            </select>
                        </div>
                        <div class="col-3 ">
                            <select class="mdb-select md-form" name="annee" required="">
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

                    </div>
                    <?php
                    // Boucle pour générer les checkboxes pour les 30 jours du mois
                    for ($jour = 1; $jour <= 31; $jour++) {

                    ?>
                        <div class="row">
                            <div class="col s1">
                                <div class="form-check">
                                    <?php
                                    echo "<input class='form-check-input' type='checkbox' name='jours[]' id='day{$jour}' value='{$jour}'>";
                                    echo "<label class='form-check-label' for='day{$jour}'>" . str_pad($jour, 2, "0", STR_PAD_LEFT) . "</label>";
                                    ?>
                                </div>
                            </div>
                            <div class="col s1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="<?php echo "periode" . $jour; ?>" id="<?php echo "jour" . $jour; ?>" value="jour" />
                                    <label class="form-check-label" for="<?php echo "jour" . $jour; ?>">Jour</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="<?php echo "periode" . $jour; ?>" id="<?php echo "nuit" . $jour; ?>" value="nuit" />
                                    <label class="form-check-label" for="<?php echo "nuit" . $jour; ?>">Nuit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="<?php echo "periode" . $jour; ?>" id="<?php echo "repos" . $jour; ?>" value="repos" />
                                    <label class="form-check-label" for="<?php echo "repos" . $jour; ?>">Repos</label>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                    <div class="row">
                        <div class="form-group shadow-textarea col-12">
                            <label for="observation"></label>
                            <textarea class="form-control z-depth-1" id="observation" name="observation" rows="3" placeholder="Observation"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center mt-4">
                            <button type="submit" class="btn blue-gradient">Enregistrer</button>
                        </div>
                    </div>

                    <br>
                </form>
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