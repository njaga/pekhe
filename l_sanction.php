<?php
session_start();
include 'connexion.php';


$req_annee = $db->query("SELECT DISTINCT YEAR(date_sanction) FROM `sanction_employe` 
ORDER BY date_sanction");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle = date('Y');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Employés sanctionnées pendant le mois de <?= $mois_actuel ?></title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>2326315.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="e_sanction.php" class="btn col-4 col-md-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Employés sanctionnées</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-3 col-md-2  ">
                                <select class="browser-default custom-select" searchable="Recherhce du site .." name="anne_academique" required="">
                                    <option selected disabled>Année </option>
                                    <option selected value="2021">2021 </option>
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
                                        <td class="white-text">Date</td>
                                        <td class="white-text">Employé</td>
                                        <td class="white-text">Sanction appliquée</td>
                                        <td class="white-text">Motif sanction</td>
                                        <td class="white-text">Montant</td>
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

    table {
        font-family: "times new roman";
        font-size: "28px";
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#l_controle').DataTable({
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
                'url': 'l_sanction_ajax.php',
                data: function(d) {
                    d.annee = $('select:eq(0)').val();
                    d.mois = $('select:eq(1)').val();
                }
            },
            'lengthMenu': [100, 150, 200],
            'columns': [{
                    data: 'date_sanction'
                },
                {
                    data: 'employe'
                },
                {
                    data: 'sanction'
                },
                {
                    data: 'motif_sanction'
                },
                {
                    data: 'montant'
                },
                {
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return '<a data-toggle="tooltip" data-placement="top" title="Modifier"class="" href="m_sanction.php?id=' + data + '"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp<a class="red-text" href="s_sanction.php?s=' + data + '" onclick="return(confirm(\'Voulez-vous supprimer cet enregistrement ?\'))"><i class="fas fa-times"></i></a>';
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