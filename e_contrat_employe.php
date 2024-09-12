<?php

include 'connexion.php';
$id = intval(htmlspecialchars($_GET['id']));
$req_employe = $db->prepare("SELECT `matricule`, `prenom`, employe.nom, CONCAT(DATE_FORMAT(employe.date_debut, '%d'), '/', DATE_FORMAT(employe.date_debut, '%m'),'/', DATE_FORMAT(employe.date_debut, '%Y')),contrat_employe.type_contrat, CONCAT(DATE_FORMAT(contrat_employe.date_debut, '%d'), '/', DATE_FORMAT(contrat_employe.date_debut, '%m'),'/', DATE_FORMAT(contrat_employe.date_debut, '%Y')), CONCAT(DATE_FORMAT(contrat_employe.date_prevu_fin, '%d'), '/', DATE_FORMAT(contrat_employe.date_prevu_fin, '%m'),'/', DATE_FORMAT(contrat_employe.date_prevu_fin, '%Y')), contrat_employe.montant
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
INNER JOIN contrat_employe ON employe.id=contrat_employe.id_employe
WHERE employe.id=?");
$req_employe->execute(array($id));
$donnee = $req_employe->fetch();
$prenom = $donnee['1'];
$nom = $donnee['2'];
$date_debut_emp = $donnee['3'];
$type_contrat = $donnee['4'];
$date_debut_contrat = $donnee['5'];
$date_fin_contrat = $donnee['6'];
$salaire = $donnee['7'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Enregistrement contrat</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>color-2174065_1280.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="container pt-4">

        <!-- Card -->
        <div class="card card-cascade narrower col-md-8 offset-md-2">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h1 class="mb-0">Enregistrement contrat</h1>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="e_contrat_employe_trmnt.php" method="POST" enctype="multipart/form-data" id="form">
                    <input type="number" name="id_employe" value="<?= $id ?>" hidden>
                    <div class="row">
                        <h6 class="col-6">
                            Prénom : <b><?= $prenom ?></b>
                            <br>
                            Nom &nbsp&nbsp&nbsp&nbsp: <b><?= $nom ?></b>
                        </h6>
                        <h6 class="col-6">
                            Type Contrat : <b><?= $type_contrat ?></b>
                            <br>
                            Validité &nbsp&nbsp&nbsp&nbsp: <b><?= $date_debut_contrat ?> - <?= $date_fin_contrat ?></b>
                        </h6>
                    </div>
                    <div class="row">
                        <div class="col-md-3 ">
                            <select class="mdb-select md-form" name="type_contrat" required>
                                <option value='' disabled selected>Type contrat</option>
                                <option value="Stage">Stage</option>
                                <option value="Prestation de service">Prestation de service</option>
                                <option value="CDD">CDD</option>
                                <option value="CDI">CDI</option>
                                <option value="Consultant">Consultant</option>
                            </select>
                        </div>
                        <div class="col-md-3 ">
                            <div class="md-form">
                                <input type="text" id="date_debut" required name="date_debut" class="form-control datepicker">
                                <label for="date_debut" class="active">Date début contrat</label>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="md-form">
                                <input type="text" id="date_fin" name="date_fin" class="form-control datepicker" required>
                                <label for="date_fin" class="active">Date fin contrat</label>
                            </div>
                        </div>
                        <div class="col-md-8 ">
                            <div class="md-form">
                                <input type="number" value="0" id="montant" name="montant" required class="form-control">
                                <label for="montant" class="active">Salaire</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="md-form">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="contrat" accept="application/pdf" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Contrat numériser</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <input type="submit" value="Enregistrer" class="btn blue-gradient">
                    </div>
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