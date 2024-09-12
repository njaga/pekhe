<?php
session_start();
include 'connexion.php';

$req_site=$db->query("SELECT DISTINCT site.id, site.nom, site.localisation
FROM affectation_site
INNER JOIN site ON affectation_site.id_site=site.id");

$req_annee=$db->query("SELECT DISTINCT YEAR(date_debut) 
FROM `affectation_site` WHERE 1");
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$mois_actuel = $mois[date("n")];
$annee_actuelle= date('Y');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Anciennes affectations</title>
    <?php include 'css.php';?>
</head>

<body style="background-image: url(<?=$image?>hsqj.jpg);">
    <?php
		include 'verif_menu.php';
		?>

    <div class="container-fluid">
        <!-- Section: liste employe absent -->
        <section class="mb-5">

            <!-- Card -->
            <div class="row">

                <div class="card card-cascade narrower col-md-10 offset-md-1">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h1 class="mb-0">Liste des anciennes affectations</h1>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center table-responsive">
                        <div class="row">
                            <div class="col-4 sm-4">
                                <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <input class="form-control form-control-sm ml-3 w-75" name="search" type="text"
                                        placeholder="Recherche" aria-label="Search">
                                </form>
                            </div>
                            <div class="col-md-2 ">
                                <select class="browser-default custom-select" searchable="Recherhce du site .."
                                    name="anne_academique" required="">
                                    <option selected>Année </option>
                                    <?php
                                        while($donnees_annee=$req_annee->fetch())
                                        {
                                            echo"<option value='".$donnees_annee['0']."'";
                                            if ($donnees_annee['0']==$annee_actuelle) {
                                                echo "selected";
                                            }
                                            echo">".$donnees_annee['0']."</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-2 ">
                                <select class="browser-default custom-select" name="mois" required="">
                                    <option selected>Sélectionnez le mois </option>
                                    <?php
                                            for ($i=1; $i <= 12; $i++) {
                                                echo "<option value='$i'";
                                                if ($mois[$i]==$mois_actuel) {
                                                    echo "selected";
                                                }
                                                echo">$mois[$i]</option>";
                                            }
                                        ?>
                                </select>
                            </div>

                            <div class="col-6 col-md-3 ">
                                <select class="browser-default custom-select" name="mois" required="">
                                    <option selected value="toutes">Toutes les sites </option>
                                    <?php
                                        while($donnees_site=$req_site->fetch())
                                        {
                                            echo"<option value=".$donnees_site['0'].">".$donnees_site['1']."</option>";
                                        }
                                        ?>
                                </select>
                            </div>

                        </div>
                        <table class="table table-hover " id="l_employe">
                            <thead class="black ">
                                <tr>
                                    <td class="white-text">#</td>
                                    <td class="white-text">Date début</td>
                                    <td class="white-text">Date fin</td>
                                    <td class="white-text">Agent </td>
                                    <td class="white-text">Nouveau site</td>
                                    <td class="white-text">Montant</td>
                                    <td class="white-text">Ancien site</td>
                                    <td class="white-text">Motif</td>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                            </tbody>
                        </table>
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
    function l_abs_remp(search) {
        var site = $('select:eq(2)').val();
        var mois = $('select:eq(1)').val();
        var annee = $('select:eq(0)').val();
        var search = $('input:first').val();
        $.ajax({
            type: 'POST',
            url: 'l_affectation_site_ancien_ajax.php',
            data: 'mois=' + mois + '&annee=' + annee + '&search=' + search + '&site=' + site,
            success: function(html) {
                $('tbody').html(html);
            }
        });
    }

    l_abs_remp();
    $('select').change(function() {
        l_abs_remp();
    });
    $('input:first').keyup(function() {
        l_abs_remp()
    });
})
</script>

</html>