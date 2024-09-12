<?php
session_start();
include 'connexion.php';

$req_site = $db->query("SELECT DISTINCT site.id, site.nom, site.localisation
FROM `absence_remplacement` 
INNER JOIN site ON absence_remplacement.id_site=site.id");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_controle) FROM `controle_site` WHERE 1
ORDER BY date_controle");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');
if (isset($_GET['mois'])) {
    $mois_actuel = $_GET['mois'];
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Rapport controles de sites du mois de <?= $mois_actuel ?></title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>color-2174066_1280.png);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="e_rapport_site.php" class="btn col-4 col-md-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Contrôles des sites</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75" name="search" type="text" placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                            <div class="col-3 col-md-2  ">
                                <select class="browser-default custom-select" searchable="Recherhce du site .." name="anne_academique" required="">
                                    <option selected disabled>Année </option>
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
                            <div class="col-5 col-md-2 ">
                                <select class="browser-default custom-select" name="mois" required="">
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

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-hover center-text" id="l_controle">
                                <thead class="black ">
                                    <tr>
                                        <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Date demande</th>
                                        <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Employé</th>
                                        <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Département</th>
                                        <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Type demande
                                        </th>
                                        <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Période
                                        </th>
                                        <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">motif
                                        </th>
                                        <th class="font-weight-bold text-center text-uppercase th-lg" data-field="">Etat
                                            d'avancement</th>
                                        <th class="font-weight-bold text-center text-uppercase th-lg"></th>
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

    table {
        font-family: "times new roman";
        font-size: "28px";
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#l_controle').DataTable({
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> ',
                    titleAttr: 'Exporter en excel',
                    className: 'btn btn-success',
                    messageTop: 'All Logs',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> ',
                    titleAttr: 'Exporter en PDF',
                    className: 'btn btn-danger',
                    messageTop: 'All Logs',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> ',
                    titleAttr: 'Imprimer',
                    title: "Impression",
                    className: 'btn btn-info',
                    messageTop: 'All Logs',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },

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
                'url': 'test_demandes_ajax.php',
                data: function(d) {
                    d.annee = $('select:eq(0)').val();
                    d.mois = $('select:eq(1)').val();
                }
            },
            'lengthMenu': [100, 150, 200],
            'columns': [{
                    data: 'date_debut'
                },
                {
                    data: 'employe'
                },
                {
                    data: 'departement'
                },
                {
                    data: 'type_conges'
                },
                {
                    data: 'date_debut'
                },
                {
                    data: 'motif'
                },
                {
                    data: 'etat'
                },
                {
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return '<a data-toggle="tooltip" data-placement="top" title="Modifier"class="" href="m_rapport_site.php?s=' + data + '"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp<a class="red-text" href="s_rapport_site.php?s=' + data + '" onclick="return(confirm(\'Voulez-vous supprimer cet enregistrement ?\'))"><i class="fas fa-times"></i></a>';
                    }
                },
                {
                    data: 'pj',
                    render: function(data, type, full, meta) {
                        return '<a target="_blank" href="' + data + '" class="btn  blue-gradient btn-rounded waves-effect">Rapport</a>';
                    }
                },
            ],

        });
        $('select').change(function() {
            table.ajax.reload();
        });
        $('.mdb-select').materialSelect();
    })
</script>

</html>