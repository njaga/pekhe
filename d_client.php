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
include "connexion.php";
$id=$_GET['id'];
//Devis
$req_devis = $db->prepare("SELECT devis.id, CONCAT(DATE_FORMAT(date_devis, '%d'), '/', DATE_FORMAT(date_devis, '%m'),'/', DATE_FORMAT(date_devis, '%Y')), num_devis, devis, devis.etat
FROM `devis` 
WHERE devis.id_client=?");
$req_devis->execute(array($id));

//Facture
$req_facture = $db->prepare("SELECT facture.id, CONCAT(DATE_FORMAT(date_facture, '%d'), '/', DATE_FORMAT(date_facture, '%m'),'/', DATE_FORMAT(date_facture, '%Y')), num_facture, facture, facture.etat
FROM `facture` 
WHERE facture.id_client=?");
$req_facture->execute(array($id));
?>
<!DOCTYPE html>
<html>

<head>
    <title>Détails client</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>lumber-84678_1280  .jpg);">
    <?php
		include 'verif_menu.php';
        ?>
    <div class="container">
        <div class="row">
            <!-- Devis -->
            <div class="col-lg-4 col-md-6 mb-4">

                <!-- Panel -->
                <div class="card">
                    <div class="card-header deep-orange lighten-1 white-text" style="font-size: x-large;">
                        Devis
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"></h4>
                        <p class="card-text">
                            <?php
                                while($donnee_devis = $req_devis->fetch())
                                {
                                    echo $donnee_devis['1']."&nbsp&nbsp&nbsp&nbsp <a href='".$donnee_devis['3']."'>".$donnee_devis['2']."</a>";
                                    if($donnee_devis['4']=="1")
                                    {
                                        echo " &nbsp&nbsp&nbsp&nbsp<span class='green-text accent-4'>En cours...</span>";
                                    }
                                    echo "<br>";
                                }
                            ?>
                        </p>
                        <a class="btn btn-deep-orange" data-toggle="modal" data-target="#modalDevis">Nouveau devis</a>
                    </div>
                </div>
                <!-- Modal: Succursale form -->
                <div class="modal fade" id="modalDevis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog cascading-modal" role="document">
                        <!-- Content -->
                        <div class="modal-content">
                            <!-- Header -->
                            <div class="modal-header deep-orange white-text">
                                <h4 class=""><i class="fas fa-map-marker "></i> Nouveau devis</h4>
                                <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Body -->
                            <div class="modal-body mb-0">
                                <form method="POST" action="e_devis_trmnt.php" enctype="multipart/form-data">
                                    <input type="number" name="id" value="<?=$_GET['id'] ?>" hidden>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="md-form">
                                                <input type="date" value="<?= date('Y-m-d'); ?>" required
                                                    name="date_devis" id="date_devis" class="form-control">
                                                <label for="date_devis" class="">Date devis</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form">
                                                <input type="text" name="num_devis" id="num_devis" class="form-control">
                                                <label for="num_devis" class="">Numéro devis</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-0">
                                            <div class="md-form">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="devis" accept="application/pdf"
                                                            class="custom-file-input" id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Devis
                                                            numériser</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group shadow-textarea col-12">
                                            <label for="commentaire"></label>
                                            <textarea class="form-control z-depth-1" id="commentaire" name="commentaire"
                                                rows="3" placeholder="Commentaire..."></textarea>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn deep-orange white-text">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Content -->
                    </div>
                </div>
                <!-- Modal: client form -->
                <!-- Panel -->

            </div>
            <!-- Facture -->
            <div class="col-lg-4 col-md-6 mb-4">

                <!-- Panel -->
                <div class="card">
                    <div class="card-header pink accent-3 white-text" style="font-size: x-large;">
                        Facture
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"></h4>
                        <p class="card-text">
                            <?php
                                while($donnee_facture = $req_facture->fetch())
                                {
                                    echo $donnee_facture['1']."&nbsp&nbsp&nbsp&nbsp <a href='".$donnee_facture['3']."'>".$donnee_facture['2']."</a>";
                                    echo "<br>";
                                }
                            ?>
                        </p>
                        <a class="btn btn-pink accent-3" data-toggle="modal" data-target="#modalFacture">Nouvelle facture</a>
                    </div>
                </div>
                <!-- Modal: Succursale form -->
                <div class="modal fade" id="modalFacture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog cascading-modal" role="document">
                        <!-- Content -->
                        <div class="modal-content">
                            <!-- Header -->
                            <div class="modal-header pink accent-3 white-text">
                                <h4 class=""><i class="fas fa-map-marker "></i> Nouvelle facture</h4>
                                <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Body -->
                            <div class="modal-body mb-0">
                                <form method="POST" action="e_facture_trmnt.php" enctype="multipart/form-data">
                                    <input type="number" name="id" value="<?=$_GET['id'] ?>" hidden>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="md-form">
                                                <input type="date" value="<?= date('Y-m-d'); ?>" required
                                                    name="date_facture" id="date_facture" class="form-control">
                                                <label for="date_facture" class="">Date facture</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form">
                                                <input type="text" name="num_facture" id="num_facture" class="form-control">
                                                <label for="num_facture" class="">Numéro facture</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-0">
                                            <div class="md-form">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="Facture" accept="application/pdf"
                                                            class="custom-file-input" id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Facture
                                                            numériser</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group shadow-textarea col-12">
                                            <label for="commentaire"></label>
                                            <textarea class="form-control z-depth-1" id="commentaire" name="commentaire"
                                                rows="3" placeholder="Commentaire..."></textarea>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn pink accent-3 white-text">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Content -->
                    </div>
                </div>
                <!-- Modal: client form -->
                <!-- Panel -->

            </div>
        </div>
    </div>



    <span id="fin"></span>
    <?php include 'js.php'; ?>
    <script type="text/javascript">
    $(document).ready(function() {
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