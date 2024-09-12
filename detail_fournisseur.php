<?php
session_start();
include 'connexion.php';
$id = intval(htmlspecialchars($_GET['id']));

$req = $db->prepare("SELECT fournisseur_achat.nom, categorie 
FROM `fournisseur_achat` WHERE id=51");
$req->execute(array($id));
$donnees = $req->fetch();
$fournisseur = $donnees['0'];
$categorie = $donnees['1'];
$req->closeCursor();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Détail fournisseur</title>
    <?php include 'css.php'; ?>
</head>

<body class="fixed-sn white-skin" style="background-image: url(<?= $image ?>accueil.png);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid" style="margin-top: -65px;">
        <!-- Section: Team v.1 -->
        <section class="section team-section">

            <!-- Grid row -->
            <div class="row text-center">

                <div class="col-md-4">

                    <!-- Card -->
                    <div class="card profile-card">

                        <!-- Avatar -->


                        <div class="card-body pt-0 mt-0">

                            <!-- Name -->
                            <h3 class="mb-3 font-weight-bold"><strong><?= $fournisseur ?></strong></h3>
                            <h6 class="font-weight-bold cyan-text mb-4"><u>Catégorie : </u></h6>
                            <h5 class="font-weight-bold cyan-text mb-4"><?= $categorie ?></h5>


                        </div>

                    </div>
                    <!-- Card -->

                </div>
                <!-- Grid column -->
                <div class="col-md-8 mb-4">

                    <!-- Card -->
                    <div class="card card-cascade cascading-admin-card user-card">

                        <!-- Card Data -->
                        <div class="admin-up d-flex justify-content-start">
                            <i class="fas fa-users info-color py-4 mr-3 z-depth-2"></i>
                            <div class="data">
                                <h5 class="font-weight-bold dark-grey-text">Transaction(s) effectuée(s)<span class="text-muted"></span></h5>
                            </div>
                        </div>
                        <!-- Card Data -->

                        <!-- Card content -->
                        <div class="card-body card-body-cascade"></div>
                        <!-- Card content -->

                    </div>
                    <!-- Card -->

                </div>

                <!-- Grid column -->

                <!-- Grid column -->

                <!-- Grid column -->

            </div>
            <!-- Grid row -->
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card card-cascade cascading-admin-card user-card">
                        <div class="card-body pt-0 mt-0">

                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- Section: Team v.1 -->

    </div>

</body>
<?php include 'footer.php'; ?>
<?php include 'js.php'; ?>
<style type="text/css">
    body {
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #999;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {

    })
</script>

</html>