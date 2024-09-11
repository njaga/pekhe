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

$veste_normale = "";
$veste_parka = "";
$chaussure_ville = "";
$chaussure_securite = "";
$tonfa = "";
$ceinturon = "";
$epaulettes = "";
$chemise = "";
$pantalon_simple = "";
$badge = "";
$kepi = "";
$casquette = "";
$combinaison = "";
$registre = "";
$arme = "";
$chargeur_arme = "";
$casque = "";
$smartphone = "";
$telephone_simple = "";
$mirioir = "";
$detecteur = "";
$chargeur_detecteur = "";
$gilet_fluorescent = "";
$blouson = "";
$torche = "";
$pantalon_parka = "";
$req_stock = $db->query("SELECT id, `designation`, `qt`FROM `article_gardiennage` WHERE 1");
while ($donnees = $req_stock->fetch()) {
    if ($donnees['1'] == 'Lacoste') {
        $lacoste = $donnees['2'];
    } elseif ($donnees['1'] == 'Veste Normale') {
        $veste_normale = $donnees['2'];
    } elseif ($donnees['1'] == 'Veste Parka') {
        $veste_parka = $donnees['2'];
    } elseif ($donnees['1'] == 'Chaussure de ville') {
        $chaussure_ville = $donnees['2'];
    } elseif ($donnees['1'] == 'Chaussure de sécurité') {
        $chaussure_securite = $donnees['2'];
    } elseif ($donnees['1'] == 'Tonfa') {
        $tonfa = $donnees['2'];
    } elseif ($donnees['1'] == 'Ceinturon') {
        $ceinturon = $donnees['2'];
    } elseif ($donnees['1'] == 'Epaulettes') {
        $epaulettes = $donnees['2'];
    } elseif ($donnees['1'] == 'Chemise') {
        $chemise = $donnees['2'];
    } elseif ($donnees['1'] == 'Pantalon simple') {
        $pantalon_simple = $donnees['2'];
    } elseif ($donnees['1'] == 'Badge') {
        $badge = $donnees['2'];
    } elseif ($donnees['1'] == 'Kepi') {
        $kepi = $donnees['2'];
    } elseif ($donnees['1'] == 'Casquette') {
        $casquette = $donnees['2'];
    } elseif ($donnees['1'] == 'Cravate') {
        $cravate = $donnees['2'];
    } elseif ($donnees['1'] == 'Combinaison tenue chantier') {
        $combinaison = $donnees['2'];
    } elseif ($donnees['1'] == 'Registre') {
        $registre = $donnees['2'];
    } elseif ($donnees['1'] == 'Arme') {
        $arme = $donnees['2'];
    } elseif ($donnees['1'] == 'Chargeur arme') {
        $chargeur_arme = $donnees['2'];
    } elseif ($donnees['1'] == 'Casque') {
        $casque = $donnees['2'];
    } elseif ($donnees['1'] == 'Smartphone') {
        $smartphone = $donnees['2'];
    } elseif ($donnees['1'] == 'Telephone simple') {
        $telephone_simple = $donnees['2'];
    } elseif ($donnees['1'] == 'Miroir Telescopique') {
        $mirioir = $donnees['2'];
    } elseif ($donnees['1'] == 'Detecteur') {
        $detecteur = $donnees['2'];
    } elseif ($donnees['1'] == 'Chargeur Detecteur') {
        $chargeur_detecteur = $donnees['2'];
    } elseif ($donnees['1'] == 'Gilet Fluorescent') {
        $gilet_fluorescent = $donnees['2'];
    } elseif ($donnees['1'] == 'Blouson') {
        $blouson = $donnees['2'];
    } elseif ($donnees['1'] == 'Torche') {
        $torche = $donnees['2'];
    } elseif ($donnees['1'] == 'Pantalon Parka') {
        $pantalon_parka = $donnees['2'];
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Stock actuel</title>
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
                        <h4 class="mb-0"><b>Stock actuel</b></h4>
                    </div>
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="m_stock_art_gar.php" id="form">
                            <div class="row">
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="lacoste" value="<?= $lacoste ?>" name="lacoste" class="form-control">
                                        <label for="lacoste" class="active">Lacoste</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="veste normale" value="<?= $veste_normale ?>" name="veste_normale" class="form-control">
                                        <label for="veste normale" class="active">Veste normale</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="veste parka" value="<?= $veste_parka ?>" name="veste_parka" class="form-control">
                                        <label for="veste parka" class="active">Veste parka</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="chaussure de ville " value="<?= $chaussure_ville ?>" name="chaussure_ville" class="form-control">
                                        <label for="chaussure de ville " class="active">chaussure de ville </label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="chaussure de securite" value="<?= $chaussure_securite ?>" name="chaussure_securite" class="form-control">
                                        <label for="chaussure de securite" class="active">chaussure de sécurité</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="tonfa" value="<?= $tonfa ?>" name="tonfa" class="form-control">
                                        <label for="tonfa" class="active">Tonfa</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="ceinturon" value="<?= $ceinturon ?>" name="ceinturon" class="form-control">
                                        <label for="ceinturon" class="active">Ceinturon</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="epaulettes" value="<?= $epaulettes ?>" name="epaulettes" class=" form-control">
                                        <label for="epaulettes" class="active">Epaulettes</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="chemise" value="<?= $chemise ?>" name="chemise" class="form-control">
                                        <label for="chemise" class="active">Chemise</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="pantalon simple" value="<?= $pantalon_simple ?>" name="pantalon_simple" class="form-control">
                                        <label for="pantalon simple" class="active">Pantalon simple</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="badge" value="<?= $badge ?>" name="badge" class="form-control">
                                        <label for="badge" class="active">Badge</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="kepi" value="<?= $kepi ?>" name="kepi" class="form-control">
                                        <label for="kepi" class="active">Képi</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="casquette" value="<?= $casquette ?>" name="casquette" class="form-control">
                                        <label for="casquette" class="active">Casquette</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="cravate" value="<?= $cravate ?>" name="cravate" class="form-control">
                                        <label for="cravate" class="active">Cravate</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="combinaison" value="<?= $combinaison ?>" name="combinaison" class="form-control">
                                        <label for="combinaison" class="active">Combinaison Tenue chantier</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="registre" value="<?= $registre ?>" name="registre" class="form-control">
                                        <label for="registre" class="active">Registre</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="arme" value="<?= $arme ?>" name="arme" class="form-control">
                                        <label for="arme" class="active">Arme</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="chargeur_arme" value="<?= $chargeur_arme ?>" name="chargeur_arme" class="form-control">
                                        <label for="chargeur_arme" class="active">Chargeur Arme</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="casque" value="<?= $casque ?>" name="casque" class="form-control">
                                        <label for="casque" class="active">Casque</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="smartphone" value="<?= $smartphone ?>" name="smartphone" class="form-control">
                                        <label for="smartphone" class="active">Smartphone</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="telephone_simple" value="<?= $telephone_simple ?>" name="telephone_simple" class="form-control">
                                        <label for="telephone_simple" class="active">Téléphone simple</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="miroir_telescopique" value="<?= $mirioir ?>" name="miroir_telescopique" class="form-control">
                                        <label for="miroir_telescopique" class="active">Mirioir Télescopique</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="detecteur" value="<?= $detecteur ?>" name="detecteur" class="form-control">
                                        <label for="detecteur" class="active">Détecteur</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="chargeur_detecteur" value="<?= $chargeur_detecteur ?>" name="chargeur_detecteur" class="form-control">
                                        <label for="chargeur_detecteur" class="active">Chargeur Détecteur</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="gilet" value="<?= $gilet_fluorescent ?>" name="gilet" class="form-control">
                                        <label for="gilet" class="active">Gilet Fluorescent</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="blouson" value="<?= $blouson ?>" name="blouson" class="form-control">
                                        <label for="blouson" class="active">Blouson</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="torche" value="<?= $torche ?>" name="torche" class="form-control">
                                        <label for="torche" class="active">Torche</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" disabled id="pantalon_parka" value="<?= $pantalon_parka ?>" name="pantalon_parka" class="form-control">
                                        <label for="pantalon_parka" class="active">Pantalon Parka</label>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn blue-gradient">Enregistrer</button>
                                </div>
                            </div>
                            -->
                            <div class="row">
                                <div class="text-center mt-4">
                                    <a href="accueil.php" class="btn blue-gradient">Accueil</a>
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