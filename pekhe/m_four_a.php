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
$id= intval(htmlspecialchars($_GET['m']));
include 'connexion.php';

$req_four=$db->query("SELECT `nom`, `adresse`, `contact`, categorie FROM `fournisseur_achat` WHERE id=".$id);
$donnee=$req_four->fetch();
$nom_four=$donnee['0'];
$adresse=$donnee['1'];
$contact=$donnee['2'];
$categorie=$donnee['3'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification fournisseur</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>2326315.jpg);">
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
                <h4 class="mb-0 col-sm-12">Modification fournisseur</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="m_four_a_trmnt.php" method="POST">
                    <input type="number" name="id" value="<?=$id ?>" hidden>
                    <div class="row">
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="nom" value="<?= $nom_four?>" name="nom"
                                    class="form-control " required>
                                <label for="nom" class="active">Nom du fournisseur</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="adresse" value="<?= $adresse?>" name="adresse"
                                    class="form-control" required>
                                <label for="adresse" class="active">Adresse</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="categorie" value="<?= $categorie?>" name="categorie"
                                    class="form-control" required>
                                <label for="categorie" class="active">Categorie</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group shadow-textarea col-sm-12 col-md-12">
                            <label for="contact"></label>
                            <textarea class="form-control z-depth-1" id="contact" name="contact" rows="3"
                                placeholder="Contact(s)"><?=$contact ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center mt-4 col-md-5 col-sm-6">
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