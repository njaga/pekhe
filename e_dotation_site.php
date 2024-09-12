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
include 'connexion.php';

$req_site = $db->query("SELECT id, nom FROM `site` ORDER BY nom ASC");

$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nouvelle dotation</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>wood-1108307_1280.jpg);">
    <?php
    include 'verif_menu.php';
    ?>
    <main class="container-fluid">

        <div class="row">
            <section class="mb-5 col-10 offset-md-1">
                <div class="card card-cascade narrower">
                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h4 class="mb-0"><b> Nouvelle dotation </b></h4>
                    </div>
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="e_dotation_site_trmnt.php" id="form">
                            <!-- Info département -->
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="date_dotation" name="date_dotation" class="form-control datepicker" required>
                                        <label for="date_dotation" class="active">Date dotation</label>
                                    </div>
                                </div>
                                <div class="col-md-5 ">
                                    <select class="mdb-select md-form" name="site" id="site" searchable="Recherhce  .." required>
                                        <option value='' disabled selected>Site</option>
                                        <?php
                                        while ($donnees_site = $req_site->fetch()) {
                                            echo "<option value='" . $donnees_site['0'] . "'  >" . $donnees_site['1'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="site">Site</label>
                                </div>
                            </div>
                            <!-- Infos  -->
                            <div class="row">
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="tonfa" value="0" name="tonfa" required class="form-control" required>
                                        <label for="tonfa" class="active">Tonfa</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="ceinturon" value="0" name="ceinturon" required class="form-control" required>
                                        <label for="ceinturon" class="active">Ceinturon</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="registre" value="0" name="registre" required class="form-control" required>
                                        <label for="registre" class="active">Registre</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="arme" value="0" name="arme" required class="form-control" required>
                                        <label for="arme" class="active">Arme</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="chargeur arme" value="0" name="chargeur_arme" required class="form-control" required>
                                        <label for="chargeur arme" class="active">Chargeur arme</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="casque" value="0" name="casque" required class="form-control" required>
                                        <label for="casque" class="active">Casque</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="smartphone" value="0" name="smartphone" required class="form-control" required>
                                        <label for="smartphone" class="active">Smartphone</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="telephone simple" value="0" name="telephone_simple" required class="form-control" required>
                                        <label for="telephone simple" class="active">Téléphone Simple</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="miroir telescopique" value="0" name="miroir_telescopique" required class="form-control" required>
                                        <label for="miroir telescopique" class="active">Miroir Télescopique</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="detecteur" value="0" name="detecteur" required class="form-control" required>
                                        <label for="detecteur" class="active">Détecteur</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="Chargeur Detecteur" value="0" name="chargeur_detecteur" required class="form-control" required>
                                        <label for="Chargeur Detecteur" class="active">Chargeur Détecteur</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="gilet fluorescent" value="0" name="gilet" required class="form-control" required>
                                        <label for="gilet fluorescent" class="active">Gilet fluorescent</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="torche" value="0" name="torche" required class="form-control" required>
                                        <label for="torche" class="active">Torche</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="text-center mt-4">
                                    <input type="submit" value="Enregistrer" class="btn blue-gradient">
                                </div>
                            </div>
                        </form>
                    </div>
            </section>
        </div>
    </main>
    <span id="fin"></span>
    <?php include 'footer.php'; ?>
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
            $('#form').submit(function() {
                if (!confirm('Voulez-vous confirmer l\'enregistrement ?')) {
                    return false;
                }
            });
            <?php
            if (isset($_GET['a'])) {
            ?>
                $('.toast').toast('show')
            <?php
            }
            ?>
        });
    </script>
</body>
<style type="text/css">

</style>

</html>