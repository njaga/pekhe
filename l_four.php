<?php
session_start();
include 'connexion.php';
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des fournisseurs</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>abstract.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe -->
        <section class="mb-5">

            <div class="row">

                <div class="card card-cascade narrower col-md-12">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des fournisseurs</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center ">
                        <!--
                                <div class="row">
                                    <div class="col-6 col-md-3 ">
                                        <select class="browser-default custom-select" name="mois" required="">
                                            <option selected value="tous">Toutes les départements </option>
                                            <?php
                                            while ($donnees_departement = $req_departement->fetch()) {
                                                echo "<option value=" . $donnees_departement['0'] . ">" . $donnees_departement['1'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                -->
                        <div class="row">
                            <div class="col-12 table-responsive ">
                                <table class="table table-striped  table-hover " id="l_employe">
                                    <thead class="black ">
                                        <tr>
                                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Fournisseur</th>
                                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Catégorie</th>
                                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Adresse</th>
                                            <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Contact</th>
                                            <th class="font-weight-bold text-center text-uppercase th-lg"></th>
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
        var table = $('#l_employe').DataTable({
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
                'url': 'l_four_ajax.php'
            },
            'lengthMenu': [20, 50, 100, 150],
            'columns': [{
                    data: 'nom'
                },
                {
                    data: 'categorie'
                },
                {
                    data: 'adresse'
                },
                {
                    data: 'contact'
                },
                {
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return '<a data-toggle="tooltip" data-placement="top" title="Modifier"class="" href="m_four_a.php?m=' + data + '"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp<a class="blue-text" href="detail_fournisseur.php?id=' + data + '"><i class="fas fa-eye"></i></a>&nbsp&nbsp<a class="red-text" onclick="return(confirm(\'Voulez-vous archiver ce fournisseur ?\'))" data-toggle="modal" data-target="#modalSiteForm"><i class="fas fa-times"></i></a> <div class="modal fade" id="modalSiteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog cascading-modal" role="document"><div class="modal-content"><div class="modal-header light-blue darken-3 white-text"><h4 class="">Archivage</h4><button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body mb-0"><form method="POST" action="archive_fournisseur.php?id=' + data + '"><div class="row"><div class="col-md-5  col-sm-8"><div class="md-form"><input type="date" id="date_arret" name="date_arret" class="form-control " required><label for="date_arret" class="active">Date arrêt</label></div></div><div class="col-md-6  col-sm-8"><select class="browser-default custom-select md-form" name="motif" required><option value="" disabled selected>Motif</option><option value="Non Respect des règles" >Non Respect des règles</option><option value="Fin de contrat" >Fin de contrat</option></select></div></div><div class="row"><div class="form-group shadow-textarea col-12"><label for="commentaire"></label><textarea class="form-control z-depth-1" id="commentaire" name="commentaire" rows="3"placeholder="Commentaire..."></textarea></div></div><div class="text-center mt-4"><button type="submit" class="btn blue-gradient">Enregistrer</button></div></form></div></div></div>  </div>';
                    }
                },
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