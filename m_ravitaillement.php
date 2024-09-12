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
$id = $_GET['id'];
include 'connexion.php';
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

$req_ravitaillement = $db->prepare("SELECT id, date_ravitailement, `lacoste`, `veste_normale`, `veste_parka`, `chaussure_ville`, `chaussure_securite`, `tonfa`, `ceinturon`, `epaulettes`, `chemise`, `pantalon_simple`, `badge`, `kepi`, `casquette`, `registre`, `arme`, `chargeur_arme`, `casque`, `smartphone`, `telephone_simple`, `miroir_telescopique`, `detecteur`, `chargeur_detecteur`, `gilet` , `cravate`, combinaison
FROM `ravitaillement_art_gard` 
WHERE id=?");
$req_ravitaillement->execute(array($id));
$donnees = $req_ravitaillement->fetch();
$id = $donnees['0'];
$date_ravitaillement = $donnees['1'];
$lacoste = $donnees['2'];
$veste_normale = $donnees['3'];
$veste_parka = $donnees['4'];
$chaussure_ville = $donnees['5'];
$chaussure_securite = $donnees['6'];
$tonfa = $donnees['7'];
$ceinturon = $donnees['8'];
$epaulettes = $donnees['9'];
$chemise = $donnees['10'];
$pantalon_simple = $donnees['11'];
$badge = $donnees['12'];
$kepi = $donnees['13'];
$casquette = $donnees['14'];
$registre = $donnees['15'];
$arme = $donnees['16'];
$chargeur_arme = $donnees['17'];
$casque = $donnees['18'];
$smartphone = $donnees['19'];
$telephone_simple = $donnees['20'];
$miroir_telescopique = $donnees['21'];
$detecteur = $donnees['22'];
$chargeur_detecteur = $donnees['23'];
$gilet = $donnees['24'];
$cravate = $donnees['25'];
$combinaison = $donnees['26'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification ravitaillment</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>514.png);">
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
                        <form method="POST" action="m_ravitaillement_trmnt.php" id="form">
                            <!-- Info département -->
                            <input type="number" value="<?= $id ?>" name="id" hidden>
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="text" id="date_ravitailement" name="date_ravitailement" class="form-control datepicker" value="<?= $date_ravitaillement ?>" required>
                                        <label for="date_ravitailement" class="active">Date ravitaillement</label>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <select class="browser-default custom-select md-form" name="fournisseur" required>
                                        <option value='' disabled>Fournisseur</option>
                                        <option value='1' selected>Fournisseur</option>
                                    </select>
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
                                        <input type="number" id="veste normale" value="<?= $veste_normale ?>" name="veste_normale" required class="form-control" required>
                                        <label for="veste normale" class="active">Veste normale</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="veste parka" value="<?= $veste_parka ?>" name="veste_parka" required class="form-control" required>
                                        <label for="veste parka" class="active">Veste parka</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="chaussure de ville " value="<?= $chaussure_ville ?>" name="chaussure_ville" required class="form-control" required>
                                        <label for="chaussure de ville " class="active">chaussure de ville </label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="chaussure de securite" value="<?= $chaussure_securite ?>" name="chaussure_securite" required class="form-control" required>
                                        <label for="chaussure de securite" class="active">chaussure de sécurité</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="tonfa" value="<?= $tonfa ?>" name="tonfa" required class="form-control" required>
                                        <label for="tonfa" class="active">Tonfa</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="ceinturon" value="<?= $ceinturon ?>" name="ceinturon" required class="form-control" required>
                                        <label for="ceinturon" class="active">Ceinturon</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="epaulettes" value="<?= $epaulettes ?>" name="epaulettes" required class="form-control" required>
                                        <label for="epaulettes" class="active">Epaulettes</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="chemise" value="<?= $chemise ?>" name="chemise" required class="form-control" required>
                                        <label for="chemise" class="active">Chemise</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="pantalon simple" value="<?= $pantalon_simple ?>" name="pantalon_simple" required class="form-control" required>
                                        <label for="pantalon simple" class="active">Pantalon simple</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="badge" value="<?= $badge ?>" name="badge" required class="form-control" required>
                                        <label for="badge" class="active">Badge</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="kepi" value="<?= $kepi ?>" name="kepi" required class="form-control" required>
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
                                        <input type="number" id="cravate" value="<?= $cravate ?>" name="cravate" required class="form-control" required>
                                        <label for="cravate" class="active">Cravate</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="number" id="combinaison" value="<?= $combinaison ?>" name="combinaison" required class="form-control" required>
                                        <label for="combinaison" class="active">Combinaison tenue chantier</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="registre" value="<?= $registre ?>" name="registre" required class="form-control" required>
                                        <label for="registre" class="active">Registre</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="arme" value="<?= $arme ?>" name="arme" required class="form-control" required>
                                        <label for="arme" class="active">Arme</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="chargeur arme" value="<?= $chargeur_arme ?>" name="chargeur_arme" required class="form-control" required>
                                        <label for="chargeur arme" class="active">Chargeur arme</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="casque" value="<?= $casque ?>" name="casque" required class="form-control" required>
                                        <label for="casque" class="active">Casque</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="smartphone" value="<?= $smartphone ?>" name="smartphone" required class="form-control" required>
                                        <label for="smartphone" class="active">Smartphone</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="telephone simple" value="<?= $telephone_simple ?>" name="telephone_simple" required class="form-control" required>
                                        <label for="telephone simple" class="active">Téléphone Simple</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="miroir telescopique" value="<?= $miroir_telescopique ?>" name="miroir_telescopique" required class="form-control" required>
                                        <label for="miroir telescopique" class="active">Miroir Télescopique</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="detecteur" value="<?= $detecteur ?>" name="detecteur" required class="form-control" required>
                                        <label for="detecteur" class="active">Détecteur</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="Chargeur Detecteur" value="<?= $chargeur_detecteur ?>" name="chargeur_detecteur" required class="form-control" required>
                                        <label for="Chargeur Detecteur" class="active">Chargeur Détecteur</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="gilet" value="<?= $gilet ?>" name="gilet" required class="form-control" required>
                                        <label for="gilet" class="active">Gilet Fluorescent</label>
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