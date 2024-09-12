<?php
session_start();

$id= intval(htmlspecialchars($_GET['id']));
include 'connexion.php';

$req_categorie = $db->query("SELECT id, `categorie` FROM `categorie` WHERE etat=1");
$req_article = $db->prepare("SELECT `ref`, `designation`, `marque`, `modele`, `pu`, id_categorie FROM `article` WHERE id=? ");
$req_article->execute(array($id));
$donnee_article = $req_article->fetch();
$ref=$donnee_article['0'];
$designation=$donnee_article['1'];
$marque=$donnee_article['2'];
$modele=$donnee_article['3'];
$pu=$donnee_article['4'];
$id_categorie=$donnee_article['5'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modification article</title>
    <?php include 'css.php'; ?>
</head>

<body id="debut" class="blue-grey lighten-5" style="background-image: url(<?=$image?>e_mensualite.jpg);">
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
                <form action="m_art_trmnt.php" method="POST">
                    <input type="number" name="id" value="<?=$id ?>" hidden>
                    <div class="row">
                        <div class="col-md-5 col-sm-8">
                            <select class="mdb-select md-form" name="categorie" id="categorie"
                                searchable="Recherhce de categorie .." required>
                                <option value='' disabled selected>Catégorie</option>
                                <?php
                                    while ($donnees_categorie =$req_categorie->fetch()) {
                                        echo"<option value='".$donnees_categorie['0']."'";
                                        if($id_categorie==$donnees_categorie['0'])
                                        {
                                            echo "selected";
                                        }
                                        echo" >".$donnees_categorie['1']." </option>";
                                    }
                                ?>
                            </select>
                            <label for="categorie">Catégorie</label>
                        </div>
                        <div class="col-md-4 col-sm-8">
                            <div class="md-form">
                                <input type="text" id="reference" name="reference" value="<?=$ref ?>" class="form-control" required>
                                <label for="reference" class="active">Référence</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-4">
                            <div class="md-form">
                                <input type="text" id="designation" name="designation" value="<?=$designation ?>" class="form-control" required>
                                <label for="designation" class="active">Designation</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-4">
                            <div class="md-form">
                                <input type="number" id="pu" name="pu" value="<?=$pu ?>"  class="form-control" required>
                                <label for="pu" class="active">Prix Unitaire</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 col-sm-4">
                            <div class="md-form">
                                <input type="text" id="marque" value="<?=$marque ?>"  name="marque" class="form-control" required>
                                <label for="marque" class="active">Marque</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-4">
                            <div class="md-form">
                                <input type="text" id="modele" name="modele" value="<?=$modele ?>"  class="form-control" required>
                                <label for="modele" class="active">Modèle</label>
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