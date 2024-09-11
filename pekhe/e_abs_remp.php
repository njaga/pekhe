<?php

include 'connexion.php';
$req_site = $db->query("SELECT id, `nom`, `localisation` FROM `site` WHERE etat=1");
$req_employe_remplacer = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
WHERE departement.id=3 AND employe.etat=1
ORDER BY employe.prenom, employe.nom  DESC");
$req_employe_remplacant = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
WHERE departement.id=3 AND employe.etat=1
ORDER BY employe.prenom, employe.nom  DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Absence remplacement d'un agent</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>color-2174065_1280.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="container">

        <!-- Card -->
        <div class="card card-cascade narrower col-md-8 offset-md-2">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h4 class="mb-0 col-sm-12">Absence / Remplacement d'un agent</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="e_abs_remp_trmnt.php" method="POST">

                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="text" id="date_remplacement" name="date_remplacement" class="form-control datepicker" required>
                                <label for="date_remplacement" class="active">Date absence</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 ">
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
                    </div>
                    <h5 class="text-center"><b>Agent Absent</b></h5>
                    <div class="row">
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form" name="employe_remplace" id="employe_remplace" searchable="Recherhce du site ..">
                                <option value='' disabled selected>Agent absent</option>
                                <?php
                                while ($donnees_employe_remplacer = $req_employe_remplacer->fetch()) {
                                    echo "<option value='" . $donnees_employe_remplacer['0'] . "'  >" . $donnees_employe_remplacer['2'] . " " . $donnees_employe_remplacer['3']  . "</option>";
                                }
                                ?>
                            </select>
                            <label for="employe_remplace">Agent absent</label>
                        </div>
                        <div class="col-md-4 ">
                            <select class="mdb-select md-form" name="motif_absence" id="motif_absence">
                                <option value='' disabled selected>Motif absence</option>
                                <option value="Absence non justifiée">Absence non justifiée</option>
                                <option value="Baptême">Baptême</option>
                                <option value="Congès">Congès</option>
                                <option value="Décès">Décès</option>
                                <option value="Indisponibilite">Indisponibilite</option>
                                <option value="Mariage">Mariage</option>
                                <option value="Maladie">Maladie</option>
                                <option value="Mise à pied">Mise à pied</option>
                                <option value="Permission">Permission</option>
                                <option value="Repos médical">Repos médical</option>
                            </select>
                            <label for="motif_absence">Motif absence</label>
                        </div>
                        <div class="col-md-3 ">
                            <div class="md-form">
                                <input type="number" id="montant_retirer" value="0" required name="montant_retirer" class="form-control ">
                                <label for="montant_retirer" class="active">Montant retenu</label>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center"><b>Agent remplaçant</b></h5>

                    <div class="row">
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form" name="employe_remplacant" id="employe_remplacant" searchable="Recherhce agent ..">
                                <option value='' disabled selected>Agent remplaçant</option>
                                <?php
                                while ($donnees_employe_remplacant = $req_employe_remplacant->fetch()) {
                                    echo "<option value='" . $donnees_employe_remplacant['0'] . "'  >" . $donnees_employe_remplacant['2'] . " " . $donnees_employe_remplacant['3'] .  "</option>";
                                }
                                ?>
                            </select>
                            <label for="employe_remplacant">Agent supplémentare</label>
                        </div>
                        <div class="col-md-4 ">
                            <select class="mdb-select md-form" name="motif_hs" id="motif_hs">
                                <option value='' disabled selected>Motif heure sup</option>
                                <option value="Complément">Complément</option>
                                <option value="Supplémentaire">Supplémentaire</option>
                                <option value="Renfort">Renfort</option>
                            </select>
                            <label for="motif_hs">Observation</label>
                        </div>
                        <div class="col-md-3 ">
                            <div class="md-form">
                                <input type="number" id="montant_heure_sup" value="0" required name="montant_heure_sup" class="form-control ">
                                <label for="montant_heure_sup" class="active">Montant heure sup</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group shadow-textarea col-12">
                            <label for="motif"></label>
                            <textarea class="form-control z-depth-1" id="motif" name="motif" rows="3" placeholder="Motif de l'absence..."></textarea>
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



            });
        </script>
</body>
<style type="text/css">

</style>

</html>