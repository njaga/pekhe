<?php
session_start();
if (!isset($_SESSION['id_vigilus_user'])) {
?>
    <script type="text/javascript">
        alert("Veillez d'abord vous connectez !");
        window.location = 'index.php';
    </script>
<?php
}
include 'connexion.php';
$req_departement = $db->query("SELECT id, nom FROM `departement` WHERE etat=1");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Archive des employés</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">

                <div class="card card-cascade narrower col-md-12">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Archive des employés</h1>
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
                                            <td class="white-text">Date arrêt</td>
                                            <td class="white-text">Motif arrêt</td>
                                            <td class="white-text">Commentaire</td>
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
                'url': 'l_emp_archive_ajax.php'
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
                    data: 'date_arret'
                },
                {
                    data: 'motif_arret'
                },
                {
                    data: 'commentaire'
                },
                <?php
                if ($_SESSION['profil_vigilus_user'] == "r_exp" or $_SESSION['profil_vigilus_user'] == "rh") {
                ?> {
                        data: 'id',
                        render: function(data, type, full, meta) {
                            return '<a class="blue-text" href="detail_employe.php?id=' + data + '"><i class="fas fa-eye"></i></a>&nbsp&nbsp<a class="blue-text" onclick="return(confirm(\'Voulez-vous rétablir cette employe ?\'))" href="activ_employe.php?id=' + data + '">Rétablir</a>';
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