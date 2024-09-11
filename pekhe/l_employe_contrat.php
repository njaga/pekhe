<?php
session_start();
include 'connexion.php';
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des employés en activité</title>
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

                    <div class="view view-cascade gradient-card-header grey">
                        <h1 class="mb-0">Choix de l'employe pour un nouveau contrat</h1>
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
                                            <td class="white-text">Prénom</td>
                                            <td class="white-text">Nom</td>
                                            <td class="white-text">Date naissance</td>
                                            <td class="white-text">Lieu naissance</td>
                                            <td class="white-text">Situation matrimoniale</td>
                                            <td class="white-text">Adresse</td>
                                            <td class="white-text">Fonction</td>
                                            <td class="white-text">Departement</td>
                                            <td class="white-text">Date embauche</td>
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
                'url': 'l_employe_contrat_ajax.php'
            },
            'lengthMenu': [100, 150, 200],
            'columns': [{
                    data: 'prenom'
                },
                {
                    data: 'nom_employe'
                },
                {
                    data: 'date_naissance'
                },
                {
                    data: 'lieu_naissance'
                },
                {
                    data: 'situation_matrimoniale'
                },
                {
                    data: 'adresse'
                },
                {
                    data: 'fonction'
                },
                {
                    data: 'departement'
                },
                {
                    data: 'date_debut'
                },
                {
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return '<a data-toggle="tooltip" data-placement="top" title="Sélectionner"class="blue-gradient btn btn-rounded waves-effect" href="e_contrat_employe.php?id=' + data + '">Sélectionner</a>';
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