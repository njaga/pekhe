<?php
$id = intval($_GET['s']);
include 'connexion.php';
$req_site = $db->query("SELECT id, `nom`, `localisation` FROM `site` WHERE etat=1");
$req_employe_remplacer = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
WHERE departement.id=3 AND employe.etat=1 
ORDER BY employe.prenom, employe.nom  DESC");

$req_planning = $db->prepare("SELECT `id`, `lundi`, `mardi`, `mercredi`, `jeudi`, `vendredi`, `samedi`, `dimanche`, `observation`, `date_debut`,  `id_site`, `id_agent` FROM `planning_agent` WHERE id=?");
$req_planning->execute(array($id));
$donnee_req_planning = $req_planning->fetch();
$id = $donnee_req_planning['0'];
$lundi = $donnee_req_planning['1'];
$mardi = $donnee_req_planning['2'];
$mercredi = $donnee_req_planning['3'];
$jeudi = $donnee_req_planning['4'];
$vendredi = $donnee_req_planning['5'];
$samedi = $donnee_req_planning['6'];
$dimanche = $donnee_req_planning['7'];
$observation = $donnee_req_planning['8'];
$date_debut = $donnee_req_planning['9'];
$id_site = $donnee_req_planning['10'];
$id_agent = $donnee_req_planning['11'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification planning</title>
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
                <h4 class="mb-0 col-sm-12">Modification Planning</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="m_planning_trmnt.php" method="POST">
                    <input type="number" hidden name="id" value="<?= $id ?>">
                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="text" value="<?php echo date('Y') . "-" . date('m') . "-" . date('d') ?>" id="date_planning" name="date_planning" class="form-control datepicker" required>
                                <label for="date_planning" class="active">Date planning</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 ">
                            <select class="mdb-select md-form" name="site" id="site" searchable="Recherhce du site .." required>
                                <option value='' disabled selected>Site de gardiennage</option>
                                <?php
                                while ($donnees_site = $req_site->fetch()) {
                                    echo "<option value='" . $donnees_site['0'] . "'";
                                    if ($id_site == $donnees_site['0']) {
                                        echo "Selected";
                                    }
                                    echo ">" . $donnees_site['1'] . " == " . $donnees_site['2'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="site">Site de gardiennage</label>
                        </div>
                    </div>
                    <div class="row">
                        <input type="number" name="employe" value="<?= $id_agent ?>" hidden>
                        <div class="col-md-5 ">
                            <select class="mdb-select md-form" name="" id="employe" disabled searchable="Recherhce du site ..">
                                <option value='' disabled selected>Employe</option>
                                <?php
                                while ($donnees_employe_remplacer = $req_employe_remplacer->fetch()) {
                                    echo "<option value='" . $donnees_employe_remplacer['0'] . "'";
                                    if ($id_agent == $donnees_employe_remplacer['0']) {
                                        echo "Selected";
                                    }
                                    echo ">" . $donnees_employe_remplacer['2'] . " " . $donnees_employe_remplacer['3'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="employe">Employe</label>
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
                                <option value='' disabled>Horaire</option>
                                <option value='Jour' <?php if ($lundi == "Jour") {
                                                            echo "Selected";
                                                        } ?>>Jour</option>
                                <option value='Jour/Perm' <?php if ($lundi == "Jour/Perm") {
                                                                echo "Selected";
                                                            } ?>>Jour/Perm</option>
                                <option value='Nuit' <?php if ($lundi == "Nuit") {
                                                            echo "Selected";
                                                        } ?>>Nuit</option>
                                <option value='Nuit/Perm' <?php if ($lundi == "Nuit/Perm") {
                                                                echo "Selected";
                                                            } ?>>Nuit/Perm</option>
                                <option value='Repos' <?php if ($lundi == "Repos") {
                                                            echo "Selected";
                                                        } ?>>Repos</option>
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
                                <option value='' disabled>Horaire</option>
                                <option value='Jour' <?php if ($mardi == "Jour") {
                                                            echo "Selected";
                                                        } ?>>Jour</option>
                                <option value='Jour/Perm' <?php if ($mardi == "Jour/Perm") {
                                                                echo "Selected";
                                                            } ?>>Jour/Perm</option>
                                <option value='Nuit' <?php if ($mardi == "Nuit") {
                                                            echo "Selected";
                                                        } ?>>Nuit</option>
                                <option value='Nuit/Perm' <?php if ($mardi == "Nuit/Perm") {
                                                                echo "Selected";
                                                            } ?>>Nuit/Perm</option>
                                <option value='Repos' <?php if ($mardi == "Repos") {
                                                            echo "Selected";
                                                        } ?>>Repos</option>
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
                                <option value='' disabled>Horaire</option>
                                <option value='Jour' <?php if ($mercredi == "Jour") {
                                                            echo "selected";
                                                        } ?>>Jour</option>
                                <option value='Jour/Perm' <?php if ($mercredi == "Jour/Perm") {
                                                                echo "selected";
                                                            } ?>>Jour/Perm</option>
                                <option value='Nuit' <?php if ($mercredi == "Nuit") {
                                                            echo "selected";
                                                        } ?>>Nuit</option>
                                <option value='Nuit/Perm' <?php if ($mercredi == "Nuit/Perm") {
                                                                echo "selected";
                                                            } ?>>Nuit/Perm</option>
                                <option value='Repos' <?php if ($mercredi == "Repos") {
                                                            echo "selected";
                                                        } ?>>Repos</option>
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
                                <option value='' disabled>Horaire</option>
                                <option value='Jour' <?php if ($jeudi == "Jour") {
                                                            echo "selected";
                                                        } ?>>Jour</option>
                                <option value='Jour/Perm' <?php if ($jeudi == "Jour/Perm") {
                                                                echo "selected";
                                                            } ?>>Jour/Perm</option>
                                <option value='Nuit' <?php if ($jeudi == "Nuit") {
                                                            echo "selected";
                                                        } ?>>Nuit</option>
                                <option value='Nuit/Perm' <?php if ($jeudi == "Nuit/Perm") {
                                                                echo "selected";
                                                            } ?>>Nuit/Perm</option>
                                <option value='Repos' <?php if ($jeudi == "Repos") {
                                                            echo "selected";
                                                        } ?>>Repos</option>
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
                                <option value='' disabled>Horaire</option>
                                <option value='Jour' <?php if ($vendredi == "Jour") {
                                                            echo "selected";
                                                        } ?>>Jour</option>
                                <option value='Jour/Perm' <?php if ($vendredi == "Jour/Perm") {
                                                                echo "selected";
                                                            } ?>>Jour/Perm</option>
                                <option value='Nuit' <?php if ($vendredi == "Nuit") {
                                                            echo "selected";
                                                        } ?>>Nuit</option>
                                <option value='Nuit/Perm' <?php if ($vendredi == "Nuit/Perm") {
                                                                echo "selected";
                                                            } ?>>Nuit/Perm</option>
                                <option value='Repos' <?php if ($vendredi == "Repos") {
                                                            echo "selected";
                                                        } ?>>Repos</option>
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
                                <option value='' disabled>Horaire</option>
                                <option value='Jour' <?php if ($samedi == "Jour") {
                                                            echo "selected";
                                                        } ?>>Jour</option>
                                <option value='Jour/Perm' <?php if ($samedi == "Jour/Perm") {
                                                                echo "selected";
                                                            } ?>>Jour/Perm</option>
                                <option value='Nuit' <?php if ($samedi == "Nuit") {
                                                            echo "selected";
                                                        } ?>>Nuit</option>
                                <option value='Nuit/Perm' <?php if ($samedi == "Nuit/Perm") {
                                                                echo "selected";
                                                            } ?>>Nuit/Perm</option>
                                <option value='Repos' <?php if ($samedi == "Repos") {
                                                            echo "selected";
                                                        } ?>>Repos</option>
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
                                <option value='' disabled>Horaire</option>
                                <option value='Jour' <?php if ($dimanche == "Jour") {
                                                            echo "selected";
                                                        } ?>>Jour</option>
                                <option value='Jour/Perm' <?php if ($dimanche == "Jour/Perm") {
                                                                echo "selected";
                                                            } ?>>Jour/Perm</option>
                                <option value='Nuit' <?php if ($dimanche == "Nuit") {
                                                            echo "selected";
                                                        } ?>>Nuit</option>
                                <option value='Nuit/Perm' <?php if ($dimanche == "Nuit/Perm") {
                                                                echo "selected";
                                                            } ?>>Nuit/Perm</option>
                                <option value='Repos' <?php if ($dimanche == "Repos") {
                                                            echo "selected";
                                                        } ?>>Repos</option>
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