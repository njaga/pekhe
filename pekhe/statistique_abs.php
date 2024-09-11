<?php
session_start();
include 'connexion.php';
$color=array("#4285F4", "#ffbb33","#45cafc","#FF5252","#827717","#e65100","#4e342e","#ab47bc","#d50000","#1a237e","#004d40","#d4e157","#e65100","#8d6e63","#37474f","#f57f17","#004d40","#01579b","#e91e63","#673ab7","#006064","#ff9800","#8d6e63","#ffd180","#b9f6ca","#efebe9");
//requête absence
$req_absence = $db->query("SELECT motif_absence, COUNT(id) 
FROM `absence_remplacement` 
WHERE date_absence BETWEEN '2021-01-25' AND '2021-02-26'  
GROUP BY motif_absence");
$data="";
$nbr="";
$couleur="";
$motif_absence="";
$motif_hs="";
$i=0;
while($donnees_motif_absence=$req_absence->fetch())
{
    $data=$data.' '.$donnees_motif_absence['1'].',';
    $motif_absence=$motif_absence.'"'.$donnees_motif_absence['0'].'",';
    $couleur=$couleur.'"'.$color[$i].'",';
    $i++;
}
$data=substr($data, 0, -1);
$motif_absence=substr($motif_absence, 0, -1);
$couleur=substr($couleur, 0, -1);

//requète hs
$req_supplementaire = $db->query("SELECT motif_hs, COUNT(id)
FROM `absence_remplacement` WHERE 1
GROUP BY motif_hs");
$data_hs="";
$nbr_hs="";
$couleur_hs="";
$motif_hs="";
$motif_hs="";
$i=0;
while($donnees_motif_hs=$req_supplementaire->fetch())
{
    $data_hs=$data_hs.' '.$donnees_motif_hs['1'].',';
    $motif_hs=$motif_hs.'"'.$donnees_motif_hs['0'].'",';
    $couleur_hs=$couleur_hs.'"'.$color[$i].'",';
    $i++;
}
$data_hs=substr($data_hs, 0, -1);
$motif_hs=substr($motif_hs, 0, -1);
$couleur_hs=substr($couleur_hs, 0, -1);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Statistique des absences et remplacements</title>
    <?php include 'css.php';?>
</head>

<body style="background-image: url(<?=$image?>abstract.jpg);">
    <?php
		include 'verif_menu.php';
		?>

    <div class="container-fluid">
    <br>
    <br>
        <!-- Section: Cascading panels -->
        <section class="mb-5">

            <!-- Grid row -->
            <div class="row">

                <!-- Grid column -->
                <div class="col-lg-4 col-md-12 mb-4">

                    <!-- Card -->
                    <div class="card card-cascade narrower">

                        <!-- Card image -->
                        <div class="view view-cascade gradient-card-header ">
                            <canvas id="seo" height="155px"></canvas>
                        </div>
                        <!-- Card image -->

                        <!-- Card content -->
                        <div class="card-body card-body-cascade text-center deep-blue-gradient">

                            <div class="list-group list-panel ">
                                <h4>Absences</h4>
                            </div>
                        </div>
                        <!-- Card content -->

                    </div>
                    <!-- Card -->

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-lg-4 col-md-12 mb-4">

                    <!-- Card -->
                    <div class="card card-cascade narrower">

                        <!-- Card image -->
                        <div class="view view-cascade gradient-card-header ">
                            <canvas id="doughnutChart" height="155px"></canvas>
                        </div>
                        <!-- Card image -->

                        <!-- Card content -->
                        <div class="card-body card-body-cascade text-center blue-gradient">

                            <div class="list-group list-panel">

                                <h4>Heures supplémentaires</h4>
                            </div>
                        </div>
                        <!-- Card content -->

                    </div>
                    <!-- Card -->

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-lg-4 col-md-12 mb-4">

                    <!-- Card -->
                    <div class="card card-cascade narrower">

                        <!-- Card image -->
                        <div class="view view-cascade gradient-card-header purple-gradient">
                            <canvas id="conversion" height="155px"></canvas>
                        </div>
                        <!-- Card image -->

                        <!-- Card content -->
                        <div class="card-body card-body-cascade text-center">

                            <div class="list-group list-panel">
                                <h4>A venir prochainement</h4>

                            </div>
                        </div>
                        <!-- Card content -->

                    </div>
                    <!-- Card -->

                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row -->

        </section>
        <!-- Section: Cascading panels -->
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
</style>
<script type="text/javascript">
$(document).ready(function() {
    //pie
    let ctxP = document.getElementById("seo").getContext('2d');
    let myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: [<?=$motif_absence ?>],
            datasets: [{
                data: [<?=$data ?>],
                backgroundColor: [<?=$couleur ?>],
                hoverBackgroundColor: [<?=$couleur ?>]
            }]
        },
        options: {
            responsive: true
        }
    });

    
    //doughnut
    var ctxD = document.getElementById("doughnutChart").getContext('2d');
    var myLineChart = new Chart(ctxD, {
      type: 'doughnut',
      data: {
            labels: [<?=$motif_hs ?>],
            datasets: [{
                data: [<?=$data_hs ?>],
                backgroundColor: [<?=$couleur_hs ?>],
                hoverBackgroundColor: [<?=$couleur_hs ?>]
            }]
        },
        options: {
            responsive: true
        }
    });
    
    


})
</script>

</html>