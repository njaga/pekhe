<?php
session_start();
include 'connexion.php';

$req_categorie = $db->query("SELECT id, `categorie` FROM `categorie` WHERE etat=1");
$req_article = $db->query("SELECT article.id, article.ref, article.designation, article.marque
FROM `article` 
INNER JOIN categorie ON article.id_categorie = categorie.id 
WHERE article.etat=1");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_entree) 
FROM `entree_art` WHERE 1");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des affectations</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>001.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalForm">Ajouter
                </a>
            </div>
            <!-- Modal:  form -->
            <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog cascading-modal" role="document">
                    <!-- Content -->
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header light-blue darken-3 white-text">
                            <h4 class=""> Nouvelle entrée</h4>
                            <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body mb-0">
                            <form method="POST" action="e_entree_trmnt.php">

                                <div class="row">
                                    <div class="col-md-10 col-sm-10">
                                        <select class="mdb-select md-form" name="article" id="article" searchable="Recherhce un article .." required>
                                            <option value='' disabled selected>Article</option>
                                            <?php
                                            while ($donnees_article = $req_article->fetch()) {
                                                echo "<option value='" . $donnees_article['0'] . "'  >" . $donnees_article['1'] . " - " . $donnees_article['2'] . " - " . $donnees_article['3'] . " </option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="article">Article</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-8">
                                        <div class="md-form">
                                            <input type="date" id="date_entree" name="date_entree" class="form-control " required value="<?= date('Y-m-d') ?>">
                                            <label for="date_entree" class="active">Date entrée</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="md-form">
                                            <input type="number" id="qt" name="qt" class="form-control" required>
                                            <label for="qt" class="active">Quantité</label>
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
            <!-- Modal:  form -->
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des entrées</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-4 sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75 search" name="search" type="text" placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                            <div class="col-md-2 ">
                                <select class="browser-default custom-select list" name="annee" required="">
                                    <option selected>Année </option>
                                    <?php
                                    while ($donnees_annee = $req_annee->fetch()) {
                                        echo "<option value='" . $donnees_annee['0'] . "'";
                                        if ($donnees_annee['0'] == $annee_actuelle) {
                                            echo "selected";
                                        }
                                        echo ">" . $donnees_annee['0'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-2 ">
                                <select class="browser-default custom-select list" name="mois" required="">
                                    <option selected>Sélectionnez le mois </option>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo "<option value='$i'";
                                        if ($mois[$i] == $mois_actuel) {
                                            echo "selected";
                                        }
                                        echo ">$mois[$i]</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-6 col-md-3 ">
                                <select class="browser-default custom-select list" name="categorie" required="">
                                    <option selected value="toutes">Toutes les catégories </option>
                                    <?php
                                    while ($donnees_categorie = $req_categorie->fetch()) {
                                        echo "<option value=" . $donnees_categorie['0'] . ">" . $donnees_categorie['1'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover " id="">
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">#</td>
                                    <td class="white-text">Date entrée</td>
                                    <td class="white-text">Article </td>
                                    <td class="white-text">Qt avant entrée</td>
                                    <td class="white-text">Qt entée</td>
                                    <td class="white-text">Nvle Qt</td>
                                    <td class="white-text"></td>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                            </tbody>
                        </table>
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

    table {
        font-family: "times new roman";
        font-size: "28px";
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        function l_entree(search) {
            var categorie = $('select:eq(3)').val();
            var mois = $('select:eq(2)').val();
            var annee = $('select:eq(1)').val();
            var search = $('.search').val();
            $.ajax({
                type: 'POST',
                url: 'l_entree_art_ajax.php',
                data: 'mois=' + mois + '&annee=' + annee + '&search=' + search + '&categorie=' + categorie,
                success: function(html) {
                    $('tbody').html(html);
                }
            });
        }

        l_entree();
        $('.list').change(function() {
            l_entree();
        });
        $('.search').keyup(function() {
            l_entree()
        });
        $('.datepicker').pickadate({
            // Escape any “rule” characters with an exclamation mark (!).
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy/mm/dd',
            hiddenPrefix: 'prefix__',
            hiddenSuffix: '__suffix'
        });
    })
</script>

</html>