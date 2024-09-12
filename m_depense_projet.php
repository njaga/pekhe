<?php
session_start();
if(!isset($_SESSION['id_vigilus_user']))
{
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
$id= intval(htmlspecialchars($_GET['id']));
include 'connexion.php';
$req_depense=$db->query("SELECT date_depense, description, qt, montant, fournisseur 
FROM `depense_projet` 
WHERE id=".$id);
$donnee=$req_depense->fetch();
$date_depense=$donnee['0'];
$description=$donnee['1'];
$qt=$donnee['2'];
$montant=$donnee['3'];
$fournisseur=$donnee['4'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification dépense</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>color-2174065_1280.png);">
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
                <h4 class="mb-0 col-sm-12">Modification dépense</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="m_depense_trmnt.php" method="POST">
                    <input type="number" name="id" value="<?= $id?>" hidden>
                    <div class="row">
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="date_depense" value="<?= $date_depense ?>" name="date_depense"
                                    class="form-control datepicker" required>
                                <label for="date_depense" class="active">Date dépense</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="description" value="<?= $description ?>" name="description" class="form-control" required>
                                <label for="description" class="active">Motif dépense</label>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="fournisseur" value="<?= $fournisseur ?>" name="fournisseur" class="form-control">
                                <label for="fournisseur" class="active">Fournisseur</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-8">
                            <div class="md-form">
                                <input type="number" id="qt" value="<?= $qt ?>" name="qt" class="form-control" required>
                                <label for="qt" class="active">Quantité</label>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                                <input type="number" id="montant" value="<?= $montant ?>" name="montant" class="form-control" required>
                                <label for="montant" class="active">Montant</label>
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