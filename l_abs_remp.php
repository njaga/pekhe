<?php
session_start();
include 'connexion.php';

$req_site = $db->query("SELECT DISTINCT site.id, site.nom, site.localisation
FROM `absence_remplacement` 
INNER JOIN site ON absence_remplacement.id_site=site.id");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_absence)
FROM absence_remplacement 
ORDER BY date_absence ASC");
$mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$annee_actuelle = date('Y');
if (date('d') > 25) {
    $mois_actuel = $mois[date("n") + 1];
} else {
    $mois_actuel = $mois[date("n")];
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Liste des absences / remplacements</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>wood.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">
                <a href="e_abs_remp.php" class="btn col-4 col-md-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
            </div>
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des absences / remplacements</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <form method="POST" action="excel_abs_remp.php" class="row">
                            <div class="col-3 col-md-2 offset-md-3">
                                <select class="browser-default custom-select md-form" name="annee" id="annee" required="">
                                    <option disabled>Année </option>
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
                                <label for="annee">Année</label>
                            </div>
                            <div class="col-5 col-md-2 ">
                                <select class="browser-default custom-select md-form" id="mois" name="mois" required="">
                                    <option disabled>Sélectionnez le mois </option>
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
                                <label for="mois">Mois</label>
                            </div>
                            <div class="col-8 col-md-3 ">
                                <button type="submit" class="btn-floating btn-lg blue-gradient"><i class="fas fa-file-excel" aria-hidden="true"></i></button>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-hover text-center" id="l_abs_remp">
                                    <thead class="black ">
                                        <tr>
                                            <td class="white-text">Date</td>
                                            <td class="white-text">Site gardiennange</td>
                                            <td class="white-text">Agent remplacé</td>
                                            <td class="white-text">Motif </td>
                                            <td class="white-text">Montant retenu</td>
                                            <td class="white-text">Agent remplaçant</td>
                                            <td class="white-text">Motif </td>
                                            <td class="white-text">Montant HS</td>
                                            <td class="white-text">Motif</td>
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
        var table = $('#l_abs_remp').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            /*
            "createdRow": function( row, data, dataIndex){
                if( data[8] == "Complément"  ){
                    $(row).css('background-color', '#ef9a9a');
                }
                else{
                    $(row).css('background-color', '#2196f3');
                }

            },
            */
            'select': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'retrieve': true,
            "ajax": {
                'type': 'POST',
                'url': 'l_abs_remp_ajax.php',
                data: function(d) {
                    d.annee = $('select:eq(0)').val();
                    d.mois = $('select:eq(1)').val();
                }
            },
            'lengthMenu': [100, 150, 200],
            'columns': [{
                    data: 'date'
                },
                {
                    data: 'site'
                },
                {
                    data: 'emp_remplace',
                    "defaultContent": "<b>Néant</b>"
                },
                {
                    data: 'motif_absence',
                    "defaultContent": "<b>Néant</b>"
                },
                {
                    data: 'montant_retirer'
                },
                {
                    data: 'emp_remplacant',
                    "defaultContent": "<b>Néant</b>"
                },
                {
                    data: 'motif_hs',
                    "defaultContent": "<b>Néant</b>"
                },
                {
                    data: 'montant_heure_sup'
                },
                {
                    data: 'motif'
                },
                {
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return '<a data-toggle="tooltip" data-placement="top" title="Modifier"class="" href="m_abs_remp.php?id=' + data + '"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp<a class="red-text" href="s_abs_remp.php?s=' + data + '"><i class="fas fa-times"></i></a>';
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