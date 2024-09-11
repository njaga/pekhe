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
$id = intval(htmlspecialchars($_GET['m']));
include 'connexion.php';

$req_commercial = $db->query("SELECT id, prenom, nom FROM `user` WHERE etat=1");
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

$req_projet = $db->query("SELECT nom_projet, date_debut, localisation, id_commercial, id_departement, document_projet.nom_document, document_projet.chemin 
FROM `projet` 
LEFT JOIN document_projet ON document_projet.id_projet=projet.id
WHERE projet.id=" . $id);
$donnee = $req_projet->fetch();
$nom_projet = $donnee['0'];
$date_debut = $donnee['1'];
$localisation = $donnee['2'];
$commercial = $donnee['3'];
$departement = $donnee['4'];
$nom_document = $donnee['5'];
$chemin = $donnee['6'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification projet</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?= $image ?>color-2174065_1280.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <div class="container">
        <br>
        <br>
        <!-- Card -->
        <div class="card card-cascade narrower col-md-8 offset-md-2">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header blue-gradient">
                <h4 class="mb-0 col-sm-12">Modification projet</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="m_projet_trmnt.php" method="POST">
                    <input type="number" name="id" value="<?= $id ?>" hidden>
                    <div class="row">
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="date_debut" value="<?= $date_debut ?>" name="date_debut" class="form-control datepicker" required>
                                <label for="date_debut" class="active">Date début</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="nom_projet" value="<?= $nom_projet ?>" name="nom_projet" class="form-control" required>
                                <label for="nom_projet" class="active">nom du projet</label>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="localisation" value="<?= $localisation ?>" name="localisation" class="form-control">
                                <label for="localisation" class="active">Localisation</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ">
                            <select class="mdb-select md-form" name="commercial" id="commercial" searchable="Recherhce commercial ..">
                                <option value='' disabled selected>Commercial</option>
                                <?php
                                while ($donnee_commercial = $req_commercial->fetch()) {
                                    echo "<option value='" . $donnee_commercial['0'] . "'";
                                    if ($commercial == $donnee_commercial['0']) {
                                        echo "selected";
                                    }
                                    echo " >" . $donnee_commercial['1'] . " " . $donnee_commercial['2']  . "</option>";
                                }
                                ?>
                            </select>
                            <label for="commercial">Commercial</label>
                        </div>
                        <div class="col-md-6 ">
                            <select class="browser-default custom-select md-form" name="departement" searchable="Recherhce .." required>
                                <option value='' disabled selected>Département</option>
                                <?php
                                while ($donnees_departement = $req_departement->fetch()) {
                                    echo "<option value='" . $donnees_departement['0'] . "'";
                                    if ($departement == $donnees_departement['0']) {
                                        echo "selected";
                                    }
                                    echo ">" . $donnees_departement['1'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <a href="<?= $chemin ?>"><?= $nom_document ?></a>
                        </div>
                        <div class="col-md-12 ">
                            <div class="md-form">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="bc_client" accept="application/pdf" class="custom-file-input" id="bc_client" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="bc_client">Bon de commande client</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center mt-4 col-md-5 col-sm-6">
                            <button type="submit" class="btn blue-gradient">Enregistrer</button>
                        </div>
                        <div class="text-center mt-4 col-md-5 col-sm-6">
                            <a href="fin_projet.php?id=<?= $id ?>" class="btn btn-outline-danger btn-rounded waves-effect" onclick="return(confirm('Voulez-vous mettre fin à ce projet ?'))">Fin du projet</a>
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