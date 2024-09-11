<?php

include 'connexion.php';
$req_employe_remplacer = $db->query("SELECT id, `matricule`, `prenom`, `nom` FROM `employe` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sanction employe</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>l.jpg);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="container">
        <br>
        <!-- Card -->
        <div class="card card-cascade narrower col-md-8 offset-md-2">
            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h4 class="mb-0 col-sm-12">Sanction employe</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="e_sanction_trmnt.php" enctype="multipart/form-data" method="POST">

                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="text" id="date_sanction" value="<?= date('Y-m-d') ?>" required name="date_sanction" class="form-control datepicker">
                                <label for="date_sanction" class="active">Date sanction</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ">
                            <select class="mdb-select md-form" name="employe" id="employe" searchable="Recherhce de l'employe .." required>
                                <option value='' disabled selected>Employe à sanctionner</option>
                                <?php
                                while ($donnees_employe_remplacer = $req_employe_remplacer->fetch()) {
                                    echo "<option value='" . $donnees_employe_remplacer['0'] . "'  >" . $donnees_employe_remplacer['2'] . " " . $donnees_employe_remplacer['3'] . "</option>";
                                }
                                ?>
                            </select>
                            <label for="employe">Employe à sanctionner</label>
                        </div>
                        <div class="col-md-6 ">
                            <select class="mdb-select md-form" name="sanction" id="sanction" required>
                                <option value='' disabled selected>Sanction appliquée</option>
                                <option value="Demande d'explication">Demande d'explication</option>
                                <option value="Mise à pied 1 à 3 jours">Mise à pied 1 à 3 jours</option>
                                <option value="Mise à pied 4 à 8 jours">Mise à pied 4 à 8 jours</option>
                                <option value="Licenciement">Licenciement</option>
                                <option value="Réprimande">Réprimande</option>
                                <option value="Retard">Retard</option>
                                <option value="Dormir en fonction">Dormir en fonction</option>
                                <option value="Tenue vestimentaire">Tenue vestimentaire</option>
                                <option value="Insuburdination">Insuburdination</option>
                            </select>
                            <label for="sanction">Sanction appliquée</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ">
                            <div class="md-form">
                                <input type="number" id="montant" value="0" required name="montant" class="form-control ">
                                <label for="montant" class="active">Montant retenu</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group shadow-textarea col-12">
                            <label for="motif_sanction"></label>
                            <textarea class="form-control z-depth-1" id="motif_sanction" name="motif_sanction" rows="3" placeholder="Commentaire..."></textarea>
                        </div>
                    </div>
                    <!-- Pièce Jointes -->
                    <h5 class="center-text">Pièces jointes</h5>
                    <div class="row">
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