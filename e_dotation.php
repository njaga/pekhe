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
                        <form method="POST" action="e_dotation_trmnt.php" id="form">
                            <!-- Info département -->
                            <div class="row">
                                <div class="col-md-2 ">
                                    <div class="md-form">
                                        <input type="text" id="date_dotation" name="date_dotation" class="form-control datepicker" required>
                                        <label for="date_dotation" class="active">Date dotation</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <select class="mdb-select md-form " name="agent" id="agent" searchable="Recherhce  ..">
                                        <option value='' disabled selected>Employe</option>
                                        <?php
                                        while ($donnees_employe_remplacer = $req_employe_remplacer->fetch()) {
                                            echo "<option value='" . $donnees_employe_remplacer['0'] . "'  >" . $donnees_employe_remplacer['2'] . " " . $donnees_employe_remplacer['3'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="agent">Employe</label>
                                </div>
                                <div class="col-md-7 ">
                                    <p></p>
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
                                        <label for="combinaison" class="active">Combinaison Tenue chantier</label>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="md-form">
                                        <input type="number" id="blouson" value="0" name="blouson" required class="form-control" required>
                                        <label for="blouson" class="active">Blouson</label>
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

            function ancien_dotation() {
                var agent = $('#agent').val();
                $.ajax({
                    type: 'POST',
                    url: 'ancien_dotation_agent_ajax.php',
                    data: 'agent=' + agent,
                    success: function(html) {
                        $('p').html(html);
                    }
                });
            }

            $('select').change(function() {
                ancien_dotation()
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