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

$req_article=$db->query("SELECT `designation`, `pu` FROM `article_four` WHERE id=".$id);
$donnee=$req_article->fetch();
$designation=$donnee['0'];
$pu=$donnee['1'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification article</title>
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
                <h4 class="mb-0 col-sm-12">Modification d'un article</h4>
            </div>
            <!-- /Card image -->

            <!-- Card content -->
            <div class="card-body card-body-cascade  table-responsive">
                <form action="m_article_four_trmnt.php" method="POST">
                    <input type="number" name="id" value="<?=$id ?>" hidden>
                    <div class="row">
                        <div class="col-md-5 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="designation" value="<?= $designation?>" name="designation"
                                    class="form-control " required>
                                <label for="designation" class="active">Désignation</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-8">
                            <div class="md-form">
                                <input type="number" id="pu" value="<?= $pu?>" name="pu" class="form-control" required>
                                <label for="pu" class="active">PU</label>
                            </div>
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