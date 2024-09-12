<?php
session_start();

if(!isset($_SESSION['id_vigilus_user']))
{
?>
<script type="text/javascript">
alert("Veillez d'abord vous connectez !");
window.location = 'index.php';
</script>
<?php
}
include 'connexion.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Article(s) fournisseur</title>
    <?php include 'css.php';?>
</head>

<body style="background-image: url(<?=$image?>zedz.jpg);">
    <?php
		include 'verif_menu.php';
		?>

    <div class="container-fluid">
        <!-- Section: liste employe -->
        <section class="mb-5">

          
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h3 class="mb-0">Liste des articles</h3>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center ">
                        <div class="row">
                            <div class="col-12 table-responsive ">
                                <table class="table table-striped  table-hover " id="l_pr_four">
                                    <thead class="black ">
                                        <tr>
                                            <td class="white-text">Article</td>
                                            <td class="white-text">PU</td>
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
    var departement = $('select').val();
    var table = $('#l_pr_four').DataTable({
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
            'url': 'l_pr_ajax.php',
            data: function(d) {
                d.id = $('.id').val();
            }
        },
        'columns': [{
                data: 'designation'
            },
            {
                data: 'pu'
            },
            {
                data: 'fournisseur'
            },
            {
                data: 'id',
                render: function(data, type, full, meta) {
                    return '<a data-toggle="tooltip" data-placement="top" title="Modifier"class="" href="m_article_four.php?id=' +
                        data +
                        '"><i class="fas fa-pencil-alt"></i></a>&nbsp&nbsp<a class="red-text" onclick="return(confirm(\'Voulez-vous supprimer cet article ?\'))" href="s_article_four.php?id=' +
                        data + '"><i class="fas fa-times"></i></a>';
                }
            },
        ],
    });



})
</script>

</html>