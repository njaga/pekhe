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
if(!isset($_GET['s']))
{
?>
<script type="text/javascript">
alert("Veillez choisir un fournisseurs");
window.history.go(-1);
</script>
<?php
exit();
}
$id=intval($_GET['s']);
include 'connexion.php';
$req_fournisseur = $db->query("SELECT nom FROM `fournisseur_achat` WHERE id=".$id);
$donnee_fournisseur=$req_fournisseur->fetch();
$fournisseur=$donnee_fournisseur['0'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Article(s) fournisseur</title>
    <?php include 'css.php';?>
</head>

<body style="background-image: url(<?=$image?>background-616360.jpg);">
    <?php
		include 'verif_menu.php';
		?>

    <div class="container-fluid">
        <!-- Section: liste employe -->
        <section class="mb-5">

            <div class="text-left">
                <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalArticle">Nouvel
                    article
                    <i class="fas fa-map-marker  ml-1"></i>
                </a>
                <a href="l_four.php" class="btn btn-primary btn-rounded">
                    Retour
                </a>
            </div>

            <!-- Modal: Succursale form -->
            <div class="modal fade" id="modalArticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog cascading-modal" role="document">
                    <!-- Content -->
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header light-blue darken-3 white-text">
                            <h4 class=""><i class="fas fa-map-marker "></i> Nouvel article</h4>
                            <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body mb-0">
                            <form method="POST" action="e_article_trmnt.php">
                                <input type="number" class="id" name="id" value="<?=$id ?>" hidden>
                                <div class="row">
                                    <div class="col-md-6 col-sm-8">
                                        <div class="md-form">
                                            <input type="text" id="designation" name="designation" class="form-control"
                                                required>
                                            <label for="designation" class="active">Nom de l'article</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-8">
                                        <div class="md-form">
                                            <input type="number" id="pu" name="pu" class="form-control">
                                            <label for="pu" class="active">Prix Unitaire</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn blue-gradient">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Content -->
                </div>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h3 class="mb-0">Article(s) du fournisseurs: <b><?= $fournisseur ?></b></h3>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center ">
                        <div class="row">
                            <div class="col-4 sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75" name="search" type="text"
                                        placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive ">
                                <table class="table table-striped  table-hover " id="l_pr_four">
                                    <thead class="black ">
                                        <tr>
                                            <td class="white-text">N°</td>
                                            <td class="white-text">Article</td>
                                            <td class="white-text">PU</td>
                                            <td class="white-text" width="50px"></td>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Card content -->

                </div>
            </div>
            <!-- Card -->

        </section>
        <!-- Section -->
    </div>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>

</body>
<style type="text/css">
body {
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-color: #999;
}

td {
    background-color: "red";
    font-family: "times new roman";
    font-size: "25px";
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    var departement = $('select').val();
    var id_fournisseur = $('.id').val();

    function l_article() {
        $.ajax({
            type: 'POST',
            url: 'l_pr_four_ajax.php',
            data: 'search=' + search + '&id_fournisseur=' + id_fournisseur,
            success: function(html) {
                alert(html);
                $('tbody').html(html);
            }
        });
    }
    var search = "";
    l_article();
    $('.search').keyup(function() {
        var search = $('.search').val();
        l_article()
    });



})
</script>

</html>