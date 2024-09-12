<?php
session_start();
include 'connexion.php';
$req_categorie = $db->query("SELECT id, `categorie` FROM `categorie` WHERE etat=1");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des articles</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>hsqj.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <section class="mb-5">

            <!-- Card -->

            <div class="row">
                <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalForm">Ajouter
                    <i class="fas fa-map-marker  ml-1"></i>
                </a>
            </div>
            <!-- Modal:  form -->
            <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog cascading-modal" role="document">
                    <!-- Content -->
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header light-blue darken-3 white-text">
                            <h4 class=""><i class="fas fa-map-marker "></i> Nouvel Article</h4>
                            <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body mb-0">
                            <form method="POST" action="e_art_trmnt.php">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <select class="mdb-select md-form" name="categorie" id="categorie" searchable="Recherhce de categorie .." required>
                                            <option value='' disabled selected>Catégorie</option>
                                            <?php
                                            while ($donnees_categorie = $req_categorie->fetch()) {
                                                echo "<option value='" . $donnees_categorie['0'] . "'  >" . $donnees_categorie['1'] . " </option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="categorie">Catégorie</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="md-form">
                                            <input type="text" id="reference" name="reference" class="form-control" required>
                                            <label for="reference" class="active">Référence</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-4">
                                        <div class="md-form">
                                            <input type="text" id="designation" name="designation" class="form-control" required>
                                            <label for="designation" class="active">Designation</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-4">
                                        <div class="md-form">
                                            <input type="number" id="pu" name="pu" class="form-control" required>
                                            <label for="pu" class="active">Prix Unitaire</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-sm-4">
                                        <div class="md-form">
                                            <input type="text" id="marque" name="marque" class="form-control" required>
                                            <label for="marque" class="active">Marque</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-4">
                                        <div class="md-form">
                                            <input type="text" id="modele" name="modele" class="form-control" required>
                                            <label for="modele" class="active">Modèle</label>
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

                <div class="card card-cascade narrower col-md-12">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des articles</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center ">

                        <div class="row">
                            <div class="col-12 table-responsive ">
                                <table class="table table-striped  table-hover " id="article">
                                    <thead class="black ">
                                        <tr>
                                            <td class="white-text">Référence</td>
                                            <td class="white-text">Catégorie</td>
                                            <td class="white-text">Désignation</td>
                                            <td class="white-text">PU</td>
                                            <td class="white-text">Qt </td>
                                            <td class="white-text">Montant </td>
                                            <td class="white-text"></td>
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
        $('.mdb-select').materialSelect();
        var departement = $('select').val();
        var table = $('#article').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
            },
            'select': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'retrieve': true,
            "ajax": {
                'type': 'POST',
                'url': 'article_ajax.php'
            },
            'lengthMenu': [100, 150, 200],
            'columns': [{
                    data: 'ref'
                },
                {
                    data: 'categorie'
                },
                {
                    data: 'designation'
                },
                {
                    data: 'pu'
                },
                {
                    data: 'qt'
                },
                {
                    data: 'prix'
                },
                <?php
                if ($_SESSION['profil_vigilus_user'] == "r_achat") {
                ?> {
                        data: 'id',
                        render: function(data, type, full, meta) {
                            return '<a data-toggle="tooltip" data-placement="top" title="Modifier"class="" href="m_article.php?id=' +
                                data +
                                '"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp<a class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cet article ?\'))" href="s_article.php?id=' +
                                data + '"><i class="fas fa-times"></i></a>';
                        }
                    },
                <?php
                }
                ?>

            ],


            /*
            bouton imprimer, excel, pdf
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
            */
        });



    })
</script>

</html>