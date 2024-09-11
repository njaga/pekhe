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
$lundi = "";
$mardi = "";
$mercredi = "";
$jeudi = "";
$vendredi = "";
$samedi = "";
$dimanche = "";
$id_site = intval($_GET['s']);
include 'connexion.php';
$req_planning = $db->prepare("SELECT CONCAT(employe.prenom,' ',employe.nom), employe.telephone, CONCAT(DATE_FORMAT(planning_agent.date_debut, '%d'), '/', DATE_FORMAT(planning_agent.date_debut, '%m'),'/', DATE_FORMAT(planning_agent.date_debut, '%Y')), lundi, mardi, mercredi, jeudi, vendredi, samedi, dimanche, observation,planning_agent.id
FROM `planning_agent` 
INNER JOIN employe on planning_agent.id_agent=employe.id
WHERE planning_agent.etat=1 AND id_site=?");
$req_planning->execute(array($id_site));

$req_site = $db->prepare("SELECT nom FROM `site` where id=?");
$req_site->execute(array($id_site));
$donnee_site = $req_site->fetch();
$site = $donnee_site['0'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Planning</title>
    <?php include 'css.php'; ?>
</head>

<body style="background-image: url(<?= $image ?>accueil.png);">
    <?php
    include 'verif_menu.php';
    ?>
    <!-- Card -->
    <div class="card card-cascade narrower col-12 ">


        <div class="row">
            <a href="l_planning.php" class="btn col-4 col-md-2 blue-gradient btn-rounded waves-effect">Retour</a>
            <a href="e_planning.php" class="btn col-4 col-md-2 blue-gradient btn-rounded waves-effect">Ajouter +</a>
        </div>
        <br>
        <!-- Card image -->
        <div class="view view-cascade gradient-card-header blue-gradient">
            <h1 class="mb-0">Planning <b><?= $site ?></b></h1>
        </div>
        <!-- /Card image -->

        <!-- Card content -->
        <div class="card-body card-body-cascade text-center table-responsive">

        </div>
        <div class="row ">
            <table class="table  table-hover centered table-bordered " style="font-family:'Times new roman';">
                <thead class="">
                    <tr>
                        <th class="th-sm"></th>
                        <th class="th-sm font-weight-bold text-center text-uppercase th-lg" data-field="">Lundi
                        </th>
                        <th class="th-sm font-weight-bold text-center text-uppercase th-lg" data-field="">
                            Mardi</th>
                        <th class="th-sm font-weight-bold text-center text-uppercase th-lg" data-field="">Mercredi
                        </th>
                        <th class="th-sm font-weight-bold text-center text-uppercase th-lg" data-field="">Jeudi
                        </th>
                        <th class="th-sm font-weight-bold text-center text-uppercase th-lg" data-field="">Vendredi
                        </th>
                        <th class="th-sm font-weight-bold text-center text-uppercase th-lg" data-field="">Samedi
                        </th>
                        <th class="th-sm font-weight-bold text-center text-uppercase th-lg" data-field="">Dimanche </th>
                        <th class="th-sm font-weight-bold text-center text-uppercase th-lg" data-field="">Observation </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nbr_lundi_jour = 0;
                    $nbr_lundi_soir = 0;
                    $nbr_mardi_jour = 0;
                    $nbr_mardi_soir = 0;
                    $nbr_mercredi_jour = 0;
                    $nbr_mercredi_soir = 0;
                    $nbr_jeudi_jour = 0;
                    $nbr_jeudi_soir = 0;
                    $nbr_vendredi_jour = 0;
                    $nbr_vendredi_soir = 0;
                    $nbr_samedi_jour = 0;
                    $nbr_samedi_soir = 0;
                    $nbr_dimanche_jour = 0;
                    $nbr_dimanche_soir = 0;
                    while ($donnee_planning = $req_planning->fetch()) {

                        echo "<tr>";
                        echo "<td><h6><b><a href='m_planning.php?s=" . $donnee_planning['11'] . "' class='' data-toggle='tooltip' data-placement='top title='Détails'><b>" . $donnee_planning['0'] . "</b><br>Tel : <b>" . $donnee_planning['1'] . "</b> <br>Début : <b>" . $donnee_planning['2'] . "</b></a></h6></td>";

                        if ($donnee_planning['3'] == "Jour") {
                            echo "<td class='info-color'><h5 class='white-text'>" . $donnee_planning['3'] . "</h5></td>";
                        } elseif ($donnee_planning['3'] == "Nuit") {
                            echo "<td class='special-color-dark'><h5 class='white-text'>" . $donnee_planning['3'] . "</h5></td>";
                        } elseif ($donnee_planning['3'] == "Repos") {
                            echo "<td class='danger-color-dark'><h5 class='white-text'>" . $donnee_planning['3'] . "</h5></td>";
                        } else {
                            echo "<td class=''><h5 class=''>" . $donnee_planning['3'] . "</h5></td>";
                        }

                        if ($donnee_planning['4'] == "Jour") {
                            echo "<td class='info-color'><h5 class='white-text'>" . $donnee_planning['4'] . "</h5></td>";
                        } elseif ($donnee_planning['4'] == "Nuit") {
                            echo "<td class='special-color-dark'><h5 class='white-text'>" . $donnee_planning['4'] . "</h5></td>";
                        } elseif ($donnee_planning['4'] == "Repos") {
                            echo "<td class='danger-color-dark'><h5 class='white-text'>" . $donnee_planning['4'] . "</h5></td>";
                        } else {
                            echo "<td class=''><h5 class=''>" . $donnee_planning['4'] . "</h5></td>";
                        }

                        if ($donnee_planning['5'] == "Jour") {
                            echo "<td class='info-color'><h5 class='white-text'>" . $donnee_planning['5'] . "</h5></td>";
                        } elseif ($donnee_planning['5'] == "Nuit") {
                            echo "<td class='special-color-dark'><h5 class='white-text'>" . $donnee_planning['5'] . "</h5></td>";
                        } elseif ($donnee_planning['5'] == "Repos") {
                            echo "<td class='danger-color-dark'><h5 class='white-text'>" . $donnee_planning['5'] . "</h5></td>";
                        } else {
                            echo "<td class=''><h5 class=''>" . $donnee_planning['5'] . "</h5></td>";
                        }

                        if ($donnee_planning['6'] == "Jour") {
                            echo "<td class='info-color'><h5 class='white-text'>" . $donnee_planning['6'] . "</h5></td>";
                        } elseif ($donnee_planning['6'] == "Nuit") {
                            echo "<td class='special-color-dark'><h5 class='white-text'>" . $donnee_planning['6'] . "</h5></td>";
                        } elseif ($donnee_planning['6'] == "Repos") {
                            echo "<td class='danger-color-dark'><h5 class='white-text'>" . $donnee_planning['6'] . "</h5></td>";
                        } else {
                            echo "<td class=''><h5 class=''>" . $donnee_planning['6'] . "</h5></td>";
                        }


                        if ($donnee_planning['7'] == "Jour") {
                            echo "<td class='info-color'><h5 class='white-text'>" . $donnee_planning['7'] . "</h5></td>";
                        } elseif ($donnee_planning['7'] == "Nuit") {
                            echo "<td class='special-color-dark'><h5 class='white-text'>" . $donnee_planning['7'] . "</h5></td>";
                        } elseif ($donnee_planning['7'] == "Repos") {
                            echo "<td class='danger-color-dark'><h5 class='white-text'>" . $donnee_planning['7'] . "</h5></td>";
                        } else {
                            echo "<td class=''><h5 class=''>" . $donnee_planning['7'] . "</h5></td>";
                        }

                        if ($donnee_planning['8'] == "Jour") {
                            echo "<td class='info-color'><h5 class='white-text'>" . $donnee_planning['8'] . "</h5></td>";
                        } elseif ($donnee_planning['8'] == "Nuit") {
                            echo "<td class='special-color-dark'><h5 class='white-text'>" . $donnee_planning['8'] . "</h5></td>";
                        } elseif ($donnee_planning['8'] == "Repos") {
                            echo "<td class='danger-color-dark'><h5 class='white-text'>" . $donnee_planning['8'] . "</h5></td>";
                        } else {
                            echo "<td class=''><h5 class=''>" . $donnee_planning['8'] . "</h5></td>";
                        }

                        if ($donnee_planning['9'] == "Jour") {
                            echo "<td class='info-color'><h5 class='white-text'>" . $donnee_planning['9'] . "</h5></td>";
                        } elseif ($donnee_planning['9'] == "Nuit") {
                            echo "<td class='special-color-dark'><h5 class='white-text'>" . $donnee_planning['9'] . "</h5></td>";
                        } elseif ($donnee_planning['9'] == "Repos") {
                            echo "<td class='danger-color-dark'><h5 class='white-text'>" . $donnee_planning['9'] . "</h5></td>";
                        } else {
                            echo "<td class=''><h5 class=''>" . $donnee_planning['9'] . "</h5></td>";
                        }

                        if ($donnee_planning['10'] == "Jour") {
                            echo "<td class='info-color'><h5 class='white-text'>" . $donnee_planning['10'] . "</h5></td>";
                        } elseif ($donnee_planning['10'] == "Nuit") {
                            echo "<td class='special-color-dark'><h5 class='white-text'>" . $donnee_planning['10'] . "</h5></td>";
                        } elseif ($donnee_planning['10'] == "Repos") {
                            echo "<td class='danger-color-dark'><h5 class='white-text'>" . $donnee_planning['10'] . "</h5></td>";
                        } else {
                            echo "<td class=''><h5 class=''>" . $donnee_planning['10'] . "</h5></td>";
                        }

                        echo '<td><a href="m_planning.php?s=' . $donnee_planning["11"] . '"  class="teal-text" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fas fa-pencil-alt"></i></a></td>';

                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>
            <?= $nbr_lundi_jour . " ---- " . $nbr_lundi_soir . " ---- " . $nbr_mardi_jour . " ---- " . $nbr_mardi_soir ?>
        </div>
    </div>
    <!-- Card content -->

    </div>
    <!-- Card -->
    </div>
    <span id="fin"></span>
    <?php include 'footer.php'; ?>
    <?php include 'js.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.mdb-select').materialSelect();
        });
    </script>
</body>
<style type="text/css">

</style>

</html>