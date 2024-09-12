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
if (!isset($_GET['s'])) {
?>
    <script type="text/javascript">
        alert("Veillez choisir un projet");
        window.history.go(-1);
    </script>
<?php
}
$id = intval($_GET['s']);
include 'connexion.php';
$req_projet = $db->query("SELECT id, nom_projet FROM `projet` WHERE etat=1");

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dépense projets</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>background-616360.jpg);">
    <?php
    include 'verif_menu.php';
    ?>

    <div class="container-fluid">
        <!-- Section: liste employe -->
        <section class="mb-5">

            <div class="text-left">
                <a href="" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modalDepense">Nouvelle
                    dépense
                    <i class="fas fa-dollar-sign ml-1"></i>
                </a>
                <a href="l_projet.php" class="btn btn-primary btn-rounded">
                    Retour
                </a>
            </div>
            <!-- Modal: Succursale form -->
            <div class="modal fade" id="modalDepense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog cascading-modal" role="document">
                    <!-- Content -->
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header light-blue darken-3 white-text">
                            <h4 class=""><i class="fas fa-dollar-sign"></i> Nouvelle dépense</h4>
                            <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body mb-0">
                            <form method="POST" action="e_depense_trmnt.php">
                                <input type="number" class="id" name="id" value="<?= $id ?>" hidden>
                                <div class="row">
                                    <div class="col-md-5 col-sm-8">
                                        <div class="md-form">
                                            <input type="text" id="date_depense" value="<?= date('Y-m-d') ?>" name="date_depense" class="form-control datepicker" required>
                                            <label for="date_depense" class="active">Date dépense</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="md-form">
                                            <select class="browser-default custom-select" name="projet" id="projet">
                                                <option value='' selected>Projet</option>
                                                <?php
                                                while ($donnee_projet = $req_projet->fetch()) {
                                                    echo "<option value='" . $donnee_projet['0'] . "'>" . $donnee_projet['1'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 ">
                                        <div class="">
                                            <select class="browser-default custom-select" name="priorite" id="priorite" required>
                                                <option value='' disabled selected>Priorité</option>
                                                <option value="Eleve">Eleve</option>
                                                <option value="Moyen">Moyen</option>
                                                <option value="Faible">Faible</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="">
                                            <select class="browser-default custom-select" name="departement" id="departement" required>
                                                <option value='' disabled selected>Département</option>
                                                <option value="Administration">Administration</option>
                                                <option value="Electronique">Electronique</option>
                                                <option value="Gardiennage">Gardiennage</option>
                                                <option value="Incendie">Incendie</option>
                                                <option value="Informatique">Informatique</option>
                                                <option value="Logistique">Logistique</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="md-form">
                                            <input type="text" id="description" name="description" class="form-control" required>
                                            <label for="description" class="active">Motif dépense</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="md-form">
                                            <input type="text" id="fournisseur" name="fournisseur" class="form-control">
                                            <label for="fournisseur" class="active">Fournisseur</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-8">
                                        <div class="md-form">
                                            <input type="number" id="qt" name="qt" class="form-control" required>
                                            <label for="qt" class="active">Quantité</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-8">
                                        <div class="md-form">
                                            <input type="number" id="montant" name="montant" class="form-control" required>
                                            <label for="montant" class="active">Montant</label>
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
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h3 class="mb-0">Dépenses sur le projet : <b></b></h3>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center ">
                        <div class="row">
                            <div class="col-12 table-responsive ">
                                <table class="table table-striped  table-hover " id="l_depense">
                                    <thead class="black ">
                                        <tr>
                                            <td class="white-text">Date dépense</td>
                                            <td class="white-text">Departement</td>
                                            <td class="white-text">Description</td>
                                            <td class="white-text">Priorité</td>
                                            <td class="white-text">Quantité</td>
                                            <td class="white-text">Montant</td>
                                            <td class="white-text">Fournisseur</td>
                                            <td class="white-text" width="50px"></td>
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
        var table = $('#l_depense').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
            },
            'lengthMenu': [100, 150, 200],
            'select': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'retrieve': true,
            "ajax": {
                'type': 'POST',
                'url': 'l_depense_ajax.php',
                data: function(d) {
                    d.id = $('.id').val();
                }
            },
            'columns': [{
                    data: 'date_depense'
                },
                {
                    data: 'departement'
                },
                {
                    data: 'description'
                },
                {
                    data: 'priorite'
                },
                {
                    data: 'qt'
                },
                {
                    data: 'montant'
                },
                {
                    data: 'fournisseur'
                },
                {
                    data: 'id_registre',
                    render: function(data, type, row) {
                        if (row.etat > 0) {
                            return '<a data-toggle="tooltip" data-placement="top" title="Modifier"class="" href="m_depense_projet.php?id=' +
                                data +
                                '"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp<a class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cette dépense ?\'))" href="s_depense_projet.php?id=' +
                                data + '"><i class="fas fa-times"></i></a>';

                        } else {
                            return '<p> En cours de validation...</p>';
                        }
                    }
                },


            ],
        });



    })
</script>

</html>