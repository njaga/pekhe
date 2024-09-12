<?php

include 'connexion.php';
$req_site = $db->query("SELECT id, `nom`, `localisation` FROM `site` WHERE etat=1");
$req_employe_remplacer = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
WHERE departement.id=3 AND employe.etat=1 
ORDER BY employe.prenom, employe.nom  DESC");

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
    <div class="container">

        <!-- Card -->
        <div class="card card-cascade narrower col-md-8 offset-md-2">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h4 class="mb-0 col-sm-12">Nouveau Planning</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="e_planning_trmnt.php" method="POST">

                    <div class="row">


                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="text" id="date_planning" value="<?php echo date('Y') . "-" . date('m') . "-" . date('d') ?>" name="date_planning" class="form-control datepicker" required>
                                <label for="date_planning" class="active">Date planning</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            Multisite
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="0" checked />
                                <label class="form-check-label" for="inlineRadio1">Non</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="1" />
                                <label class="form-check-label" for="inlineRadio2">Oui</label>
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
                    <div class="row">
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form employe" name="employe" id="employe" searchable="Recherhce du agent ..">
                                <option value='' disabled selected>Employe</option>
                                <?php
                                while ($donnees_employe_remplacer = $req_employe_remplacer->fetch()) {
                                    echo "<option value='" . $donnees_employe_remplacer['0'] . "'  >" . $donnees_employe_remplacer['2'] . " " . $donnees_employe_remplacer['3'] . "==> " . $donnees_employe_remplacer['4'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="employe">Employe</label>
                        </div>
                        <div class="col-md-5 planning">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="md-form">
                                <input type="text" id="lundi" readonly value="Lundi" required name="lundi" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="mdb-select md-form" name="horaire_lundi" id="horaire_lundi">
                                <option value='' disabled selected>Horaire</option>
                                <option value='Jour'>Jour</option>
                                <option value='Jour/Perm'>Jour/Perm</option>
                                <option value='Nuit'>Nuit</option>
                                <option value='Nuit/Perm'>Nuit/Perm</option>
                                <option value='Repos'>Repos</option>
                            </select>
                            <label for="horaire_lundi">Horaire</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="md-form">
                                <input type="text" id="mardi" readonly value="Mardi" name="mardi" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="mdb-select md-form" name="horaire_mardi" id="horaire_mardi">
                                <option value='' disabled selected>Horaire</option>
                                <option value='Jour'>Jour</option>
                                <option value='Jour/Perm'>Jour/Perm</option>
                                <option value='Nuit'>Nuit</option>
                                <option value='Nuit/Perm'>Nuit/Perm</option>
                                <option value='Repos'>Repos</option>
                            </select>
                            <label for="horaire_mardi">Horaire</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="md-form">
                                <input type="text" id="mercredi" readonly value="Mercredi" name="mercredi" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="mdb-select md-form" name="horaire_mercredi" id="horaire_mercredi">
                                <option value='' disabled selected>Horaire</option>
                                <option value='Jour'>Jour</option>
                                <option value='Jour/Perm'>Jour/Perm</option>
                                <option value='Nuit'>Nuit</option>
                                <option value='Nuit/Perm'>Nuit/Perm</option>
                                <option value='Repos'>Repos</option>
                            </select>
                            <label for="horaire_mercredi">Horaire</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="md-form">
                                <input type="text" id="jeudi" readonly value="Jeudi" name="jeudi" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="mdb-select md-form" name="horaire_jeudi" id="horaire_jeudi">
                                <option value='' disabled selected>Horaire</option>
                                <option value='Jour'>Jour</option>
                                <option value='Jour/Perm'>Jour/Perm</option>
                                <option value='Nuit'>Nuit</option>
                                <option value='Nuit/Perm'>Nuit/Perm</option>
                                <option value='Repos'>Repos</option>
                            </select>
                            <label for="horaire_jeudi">Horaire</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="md-form">
                                <input type="text" id="vendredi" readonly value="Vendredi" name="vendredi" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="mdb-select md-form" name="horaire_vendredi" id="horaire_vendredi">
                                <option value='' disabled selected>Horaire</option>
                                <option value='Jour'>Jour</option>
                                <option value='Jour/Perm'>Jour/Perm</option>
                                <option value='Nuit'>Nuit</option>
                                <option value='Nuit/Perm'>Nuit/Perm</option>
                                <option value='Repos'>Repos</option>
                            </select>
                            <label for="horaire_vendredi">Horaire</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="md-form">
                                <input type="text" id="samedi" readonly value="samedi" name="samedi" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="mdb-select md-form" name="horaire_samedi" id="horaire_samedi">
                                <option value='' disabled selected>Horaire</option>
                                <option value='Jour'>Jour</option>
                                <option value='Jour/Perm'>Jour/Perm</option>
                                <option value='Nuit'>Nuit</option>
                                <option value='Nuit/Perm'>Nuit/Perm</option>
                                <option value='Repos'>Repos</option>
                            </select>
                            <label for="horaire_samedi">Horaire</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="md-form">
                                <input type="text" id="dimanche" readonly value="Dimanche" name="dimanche" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="mdb-select md-form" name="horaire_dimanche" id="horaire_dimanche">
                                <option value='' disabled selected>Horaire</option>
                                <option value='Jour'>Jour</option>
                                <option value='Jour/Perm'>Jour/Perm</option>
                                <option value='Nuit'>Nuit</option>
                                <option value='Nuit/Perm'>Nuit/Perm</option>
                                <option value='Repos'>Repos</option>
                            </select>
                            <label for="horaire_dimanche">Horaire</label>
                        </div>
                    </div>

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


        p

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

                function dotation(search) {
                    var employe = $('#employe').val();

                    $.ajax({
                        type: 'POST',
                        url: 'planning_agent_actuel_ajax.php',
                        data: 'employe=' + employe,
                        success: function(html) {
                            $('.planning').html(html);
                        }
                    });
                }

                dotation();
                $('select').change(function() {
                    dotation();
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