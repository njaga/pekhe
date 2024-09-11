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
$id = intval($_GET['id']);
include 'connexion.php';
$req_dotation = $db->query("SELECT dotation_art_gard.id, date_dotation, agent, `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `cravate`, `combinaison`, blouson 
FROM `dotation_art_gard` 
WHERE dotation_art_gard.id=" . $id);
$donnees = $req_dotation->fetch();
$id = $donnees['0'];
$date_dotation = $donnees['1'];
$agent = $donnees['2'];
$lacoste = $donnees['3'];
$veste_normale = $donnees['4'];
$veste_parka = $donnees['5'];
$chaussure_ville = $donnees['6'];
$chaussure_securite = $donnees['7'];
$tonfa = $donnees['8'];
$ceinturon = $donnees['9'];
$epaulettes = $donnees['10'];
$chemise = $donnees['11'];
$pantalon_simple = $donnees['12'];
$badge = $donnees['13'];
$kepi = $donnees['14'];
$casquette = $donnees['15'];
$cravate = $donnees['16'];
$combinaison = $donnees['17'];
$blouson = $donnees['18'];


$req_employe_remplacer = $db->query("SELECT  employe.id, matricule, `prenom`, employe.nom
FROM `employe` 
INNER JOIN departement ON employe.id_departement = departement.id
WHERE departement.id=3 AND employe.etat=1
ORDER BY employe.prenom, employe.nom  DESC");

$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification dotation</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>floor-1256804_1280.jpg);">
    <?php
    include 'verif_menu.php';
    ?>
    <main class="container-fluid">

        <div class="row">
            <section class="mb-5 col-10 offset-md-1">
                <div class="card card-cascade narrower">
                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h4 class="mb-0"><b> Modification dotation </b></h4>
                    </div>
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="m_dotation_trmnt.php" id="form">
                            <!-- Info département -->
                            <input type="number" name="id" value="<?= $id ?>" hidden>
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" value="<?= $date_dotation ?>" id="date_dotation" name="date_dotation" class="form-control datepicker" required>
                                        <label for="date_dotation" class="active">Date dotation</label>
                                    </div>
                                </div>
                                <div class="col-md-5 ">
                                    <select class="mdb-select md-form" name="agent" id="agent" searchable="Recherhce  ..">
                                        <option value='' disabled>Employe</option>
                                        <?php
                                        while ($donnees_employe_remplacer = $req_employe_remplacer->fetch()) {
                                            echo "<option value='" . $donnees_employe_remplacer['0'] . "'  >";
                                            if ($agent == $donnees_employe_remplacer['0']) {
                                                echo "selected";
                                            }
                                            echo $donnees_employe_remplacer['2'] . " " . $donnees_employe_remplacer['3'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="agent">Employe</label>
                                </div>
                            </div>
                            <!-- Infos  -->
                            <div class="row">
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="lacoste" value="<?= $lacoste ?>" name="lacoste" required class="form-control" required>
                                        <label for="lacoste" class="active">Lacoste</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $veste_normale ?>" id="veste normale" name="veste_normale" required class="form-control" required>
                                        <label for="veste normale" class="active">Veste normale</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $veste_parka ?>" id="veste parka" name="veste_parka" required class="form-control" required>
                                        <label for="veste parka" class="active">Veste parka</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $chaussure_ville ?>" id="chaussure de ville " name="chaussure_ville" required class="form-control" required>
                                        <label for="chaussure de ville " class="active">chaussure de ville </label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $chaussure_securite ?>" id="chaussure de securite" name="chaussure_securite" required class="form-control" required>
                                        <label for="chaussure de securite" class="active">chaussure de sécurité</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $tonfa ?>" id="tonfa" name="tonfa" required class="form-control" required>
                                        <label for="tonfa" class="active">Tonfa</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $ceinturon ?>" id="ceinturon" name="ceinturon" required class="form-control" required>
                                        <label for="ceinturon" class="active">Ceinturon</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $epaulettes ?>" id="epaulettes" name="epaulettes" required class="form-control" required>
                                        <label for="epaulettes" class="active">Epaulettes</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $chemise ?>" id="chemise" name="chemise" required class="form-control" required>
                                        <label for="chemise" class="active">Chemise</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $pantalon_simple ?>" id="pantalon simple" name="pantalon_simple" required class="form-control" required>
                                        <label for="pantalon simple" class="active">Pantalon simple</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $badge ?>" id="badge" name="badge" required class="form-control" required>
                                        <label for="badge" class="active">Badge</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $kepi ?>" id="kepi" name="kepi" required class="form-control" required>
                                        <label for="kepi" class="active">Képi</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="casquette" value="<?= $casquette ?>" name="casquette" required class="form-control" required>
                                        <label for="casquette" class="active">Casquette</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $cravate ?>" id="cravate" name="cravate" required class="form-control" required>
                                        <label for="cravate" class="active">Cravate</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $combinaison ?>" id="combinaison" name="combinaison" required class="form-control" required>
                                        <label for="combinaison" class="active">Combinaison Tenue chantier</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="number" value="<?= $blouson ?>" id="blouson" name="blouson" required class="form-control" required>
                                        <label for="blouson" class="active">Blouson</label>
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