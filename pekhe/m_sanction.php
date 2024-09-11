<?php

include 'connexion.php';
$req_employe_remplacer = $db->query("SELECT id, `matricule`, `prenom`, `nom` FROM `employe` WHERE etat=1");

$id = intval(htmlspecialchars($_GET['id']));
$sanction = $db->query("SELECT `date_sanction`, `sanction`, `motif_sanction`, `pj`, `id_employe`, montant FROM `sanction_employe` WHERE id=" . $id);
$donnee = $sanction->fetch();
$date_sanction = $donnee['0'];
$sanction = $donnee['1'];
$motif_sanction = $donnee['2'];
$pj = $donnee['3'];
$id_employe = $donnee['4'];
$montant = $donnee['5'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification Sanction employe</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="container">
        <br>
        <!-- Card -->
        <div class="card card-cascade narrower col-md-8 offset-md-2">
            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h4 class="mb-0 col-sm-12">Modification Sanction employe</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="m_sanction_trmnt.php" enctype="multipart/form-data" method="POST">
                    <input type="number" name="id_sanction" value="<?= $id ?>" hidden>
                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="text" id="date_sanction" value="<?= $date_sanction ?>" required name="date_sanction" class="form-control datepicker">
                                <label for="date_sanction" class="active">Date sanction</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ">
                            <select class="mdb-select md-form" name="employe" id="employe" searchable="Recherhce de l'employe .." required>
                                <option value='' disabled>Employe à sanctionner</option>
                                <?php
                                while ($donnees_employe_remplacer = $req_employe_remplacer->fetch()) {
                                    echo "<option value='" . $donnees_employe_remplacer['0'] . "'";
                                    if ($id_employe == $donnees_employe_remplacer['0']) {
                                        echo "selected";
                                    }
                                    echo ">" . $donnees_employe_remplacer['2'] . " " . $donnees_employe_remplacer['3'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="employe">Employe à sanctionner</label>
                        </div>
                        <div class="col-md-6 ">
                            <select class="mdb-select md-form" name="sanction" id="sanction" required>
                                <option value='' disabled>Sanction appliquée</option>
                                <option value="Demande d'explication" <?php if ($sanction == "Demande d'explication") {
                                                                            echo "selected";
                                                                        } ?>>
                                    Demande d'explication
                                </option>
                                <option value="Mise à pied 1 à 3 jours">
                                    Mise à pied 1 à 3 jours
                                </option>
                                <option value="Mise à pied 4 à 8 jours" <?php if ($sanction == "Mise à pied 4 à 8 jours") {
                                                                            echo "selected";
                                                                        } ?>>
                                    Mise à pied 4 à 8 jours
                                </option>
                                <option value="Licenciement" <?php if ($sanction == "Licenciement") {
                                                                    echo "selected";
                                                                } ?>>
                                    Licenciement
                                </option>
                                <option value="Réprimande" <?php if ($sanction == "Réprimande") {
                                                                echo "selected";
                                                            } ?>>
                                    Réprimande
                                </option>
                                <option value="Diplôme d'honneur" <?php if ($sanction == "Diplôme d'honneur") {
                                                                        echo "selected";
                                                                    } ?>>
                                    Diplôme d'honneur
                                </option>
                            </select>
                            <label for="sanction">Sanction appliquée</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="number" id="montant" value="<?= $montant ?>" required name="montant" class="form-control ">
                                <label for="montant" class="active">Montant retenu</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group shadow-textarea col-12">
                            <label for="motif_sanction"></label>
                            <textarea class="form-control z-depth-1" id="motif_sanction" name="motif_sanction" rows="3" placeholder="Commentaire..."><?= $motif_sanction ?></textarea>
                        </div>
                    </div>
                    <!-- Pièce Jointes -->
                    <h5 class="center-text">Pièces jointes</h5>
                    <div class="row">
                        <?php if ($pj != "") {
                            echo '<a href="' . $pj . '" class="col-12">Pièce Jointe</a>';
                        } ?>
                        <div class="col-md-10 ">
                            <div class="md-form">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="pj" accept="application/pdf" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Pièce jointe</label>
                                    </div>
                                </div>
                            </div>
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