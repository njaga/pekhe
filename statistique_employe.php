<?php
session_start();
include 'connexion.php';
$req_emp_departement = $db->query("SELECT departement.nom, COUNT(employe.id)
FROM `employe`
INNER JOIN departement ON employe.id_departement=departement.id
WHERE employe.etat=1 and departement.etat=1
GROUp BY departement.id");

$color=array("#4285F4", "#ffbb33","#45cafc","#FF5252","#827717","#e65100","#4e342e","#ab47bc","#d50000","#1a237e","#004d40","#d4e157","#e65100","#8d6e63","#37474f","#f57f17","#004d40","#01579b","#e91e63","#673ab7","#006064","#ff9800","#8d6e63","#ffd180","#b9f6ca","#efebe9");
$data="";
$nbr="";
$couleur="";
$departement="";
$i=0;
while($donnees_emp_departement=$req_emp_departement->fetch())
{
    $data=$data.' '.$donnees_emp_departement['1'].',';
    $departement=$departement.'"'.$donnees_emp_departement['0'].'",';
    $couleur=$couleur.'"'.$color[$i].'",';
    $i++;
}
$data=substr($data, 0, -1);
$departement=substr($departement, 0, -1);
$couleur=substr($couleur, 0, -1);


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Statistique employés</title>
		<?php include 'css.php';?>
	</head>
	<body style="background-image: url(<?=$image?>abstract.jpg);" >
		<?php
		include 'verif_menu.php';
		?>
            
        <div class="container-fluid">
            <!-- Section: Cascading panels -->
      <section class="mb-5">

<!-- Grid row -->
<div class="row">

  <!-- Grid column -->
  <div class="col-lg-4 col-md-12 mb-4">

    <!-- Card -->
    <div class="card card-cascade narrower">

      <!-- Card image -->
      <div class="view view-cascade gradient-card-header deep-blue-gradient">
        <canvas id="seo" height="155px"></canvas>
      </div>
      <!-- Card image -->

      <!-- Card content -->
      <div class="card-body card-body-cascade text-center">

        <div class="list-group list-panel">
         <h4>Employés par département</h4>
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
      <div class="view view-cascade gradient-card-header blue-gradient">
        <canvas id="traffic" height="155px"></canvas>
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
		body
		{
			background-position: center center;
			background-repeat:  no-repeat;
			background-attachment: fixed;
			background-size:  cover;
			background-color: #999;
		}       
	</style>
	<script type="text/javascript">
		$(document).ready(function () {
        //pie
        let ctxP = document.getElementById("seo").getContext('2d');
        let myPieChart = new Chart(ctxP, {
          type: 'pie',
          data: {
            labels: [<?=$departement ?>],
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
            
            
		})
	</script>
</html>