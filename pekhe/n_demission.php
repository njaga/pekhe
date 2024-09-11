<?php
session_start();
include 'connexion.php';
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

$req_site = $db->query("SELECT DISTINCT site.id, site.nom, site.localisation
FROM `absence_remplacement` 
INNER JOIN site ON absence_remplacement.id_site=site.id");

$req_annee = $db->query("SELECT DISTINCT YEAR(date_arret) FROM `employe` WHERE etat=1 ORDER BY date_arret");
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
    <title>Démissions</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>wood.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="">
        <!-- Section: liste employe -->
        <section class="mb-5 red">

            <div class="row">

                <div class="card card-cascade narrower col-md-12">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Démissions du mois de :</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center ">
                        <div class="row">
                            <div class="col-3 col-md-2 offset-3">
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
                                    echo "<option value='" . $annee_actuelle + 1 . "'";
                                    echo ">" . $annee_actuelle + 2 . "</option>";
                                    ?>
                                </select>
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
                            </div>
                            <div class="col-5 col-md-2 ">
                                <select class="browser-default custom-select md-form" id="departement" name="departement" required="">
                                    <option value="0" selected>Département(s)</option>
                                    <option value="3">Gardiennage</option>
                                    <option value="5">Nettoyage</option>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive ">
                                <table class="table table-striped  table-hover " id="l_employe">
                                    <thead class="black ">
                                        <tr>
                                            <td class="white-text">Date embauche</td>
                                            <td class="white-text">Prénom</td>
                                            <td class="white-text">Nom</td>
                                            <td class="white-text">Date naissance</td>
                                            <td class="white-text">Téléphone</td>
                                            <td class="white-text">Type Contrat</td>
                                            <td class="white-text">Fonction</td>
                                            <td class="white-text">Site</td>
                                            <td class="white-text">Salaire de base</td>
                                            <td class="white-text">Prime</td>
                                            <td class="white-text">Salaire Net</td>
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
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json",

            },

            'lengthMenu': [100, 150, 200],
            'select': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'retrieve': true,
            "ajax": {
                'type': 'POST',
                'url': 'n_demission_ajax.php',
                data: function(d) {
                    d.annee = $('select:eq(0)').val();
                    d.mois = $('select:eq(1)').val();
                    d.departement = $('select:eq(2)').val();
                }
            },
            'columns': [{
                    data: 'date_debut'
                },
                {
                    data: 'prenom'
                },
                {
                    data: 'nom_employe'
                },
                {
                    data: 'date_naissance'
                },
                {
                    data: 'telephone'
                },
                {
                    data: 'type_contrat'
                },
                {
                    data: 'fonction'
                },
                {
                    data: 'site'
                },
                {
                    data: 'salaire'
                },
                {
                    data: 'prime'
                },
                {
                    data: 'net_payer'
                },
                {
                    data: 'employe_id',
                    render: function(data, type, full, meta) {
                        return '<a data-toggle="tooltip" data-placement="top" title="Modifier"class="" href="m_employe.php?id=' + data + '"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp<a class="blue-text" href="detail_employe.php?id=' + data + '"><i class="fas fa-eye"></i></a>';
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
        $('select').change(function() {
            table.ajax.reload();
        });


    })
</script>

</html>