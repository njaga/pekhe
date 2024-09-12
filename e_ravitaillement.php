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
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nouvel Approvisionnement </title>
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
                        <h4 class="mb-0"><b> Nouvelle Approvisionnement </b></h4>
                    </div>
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="e_ravitaillement_trmnt.php" id="form">
                            <!-- Info département -->
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="date" id="date_ravitailement" name="date_ravitailement" class="form-control " required>
                                        <label for="date_ravitailement" class="active">Date Approvisionnement</label>
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
                                        <input type="number" id="lacoste" value="0" name="lacoste" required class="form-control" required>
                                        <label for="lacoste" class="active">Lacoste</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="veste normale" value="0" name="veste_normale" required class="form-control" required>
                                        <label for="veste normale" class="active">Veste normale</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="veste parka" value="0" name="veste_parka" required class="form-control" required>
                                        <label for="veste parka" class="active">Veste parka</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="chaussure de ville " value="0" name="chaussure_ville" required class="form-control" required>
                                        <label for="chaussure de ville " class="active">chaussure de ville </label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="chaussure de securite" value="0" name="chaussure_securite" required class="form-control" required>
                                        <label for="chaussure de securite" class="active">chaussure de sécurité</label>
                                    </div>
                                </div>
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
                                        <input type="number" id="epaulettes" value="0" name="epaulettes" required class="form-control" required>
                                        <label for="epaulettes" class="active">Epaulettes</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="chemise" value="0" name="chemise" required class="form-control" required>
                                        <label for="chemise" class="active">Chemise</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="pantalon simple" value="0" name="pantalon_simple" required class="form-control" required>
                                        <label for="pantalon simple" class="active">Pantalon simple</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="badge" value="0" name="badge" required class="form-control" required>
                                        <label for="badge" class="active">Badge</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="kepi" value="0" name="kepi" required class="form-control" required>
                                        <label for="kepi" class="active">Képi</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="casquette" value="0" name="casquette" required class="form-control" required>
                                        <label for="casquette" class="active">Casquette</label>
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="md-form">
                                        <input type="number" id="cravate" value="0" name="cravate" required class="form-control" required>
                                        <label for="cravate" class="active">Cravate</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="number" id="combinaison" value="0" name="combinaison" required class="form-control" required>
                                        <label for="combinaison" class="active">Combinaison tenue chantier</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                                        <input type="number" id="gilet" value="0" name="gilet" required class="form-control" required>
                                        <label for="gilet" class="active">Gilet Fluorescent</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="blouson" value="0" name="blouson" required class="form-control" required>
                                        <label for="blouson" class="active">Blouson</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="torche" value="0" name="torche" required class="form-control" required>
                                        <label for="torche" class="active">Torche</label>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="number" id="pantalon_parka" value="0" name="pantalon_parka" required class="form-control" required>
                                        <label for="pantalon_parka" class="active">Pantalon Parka</label>
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