<?php
session_start();
include 'connexion.php';
include "connexion.php";
$annee = $_POST['annee'];
//$req_site = $db->query("SELECT id, localisation FROM `sites` WHERE etat = 1");
$req_nbr_claim = $db->prepare("SELECT month(daterec), COUNT(*)
                            FROM reclamation
                            WHERE year(daterec)=?
                            GROUP BY month(daterec)
                            ORDER BY month(daterec)");
$req_nbr_claim->execute(array($annee));
$nbr_claim = $req_nbr_claim->rowCount();

$jan = 0;
$fev = 0;
$ma = 0;
$av = 0;
$mai = 0;
$juin = 0;
$juil = 0;
$aout = 0;
$sept = 0;
$oct = 0;
$nov = 0;
$dec = 0;
while ($donnees = $req_nbr_claim->fetch()) {
  if ($donnees['0'] == '9') {
    $jan = $donnees['1'];
  }
  if ($donnees['0'] == '11') {
    $mars = $donnees['1'];
  }
}
?>


<script>
  // SideNav Initialization
  $(".button-collapse").sideNav();

  var container = document.querySelector('.custom-scrollbar');
  var ps = new PerfectScrollbar(container, {
    wheelSpeed: 2,
    wheelPropagation: true,
    minScrollbarLength: 20
  });

  // Data Picker Initialization
  $('.datepicker').pickadate();

  // Material Select Initialization
  $(document).ready(function() {
    $('.mdb-select').material_select();
  });

  // Tooltips Initialization
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

<!-- Charts -->
<script>
  // Small chart
  $(function() {
    $('.min-chart#chart-sales').easyPieChart({
      barColor: "#4caf50",
      onStep: function(from, to, percent) {
        $(this.el).find('.percent').text(Math.round(percent));
      }
    });
  });

  //Main chart
  var ctxL = document.getElementById("lineChart-main").getContext('2d');
  var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
      labels: ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"],
      datasets: [{
        label: "Nombre de réclamations",
        fillColor: "#fff",
        backgroundColor: 'rgba(255, 255, 255, .3)',
        borderColor: 'rgba(255, 255, 255, .9)',
        data: [<?= $jan ?>, <?= $fev ?>, <?= $ma ?>, <?= $av ?>, <?= $mai ?>, <?= $juin ?>, <?= $juil ?>, <?= $aout ?>, <?= $sept ?>, <?= $oct ?>, <?= $nov ?>, <?= $dec ?>],
      }]
    },
    options: {
      legend: {
        labels: {
          fontColor: "#fff",
        }
      },
      scales: {
        xAxes: [{
          gridLines: {
            display: true,
            color: "rgba(255,255,255,.25)"
          },
          ticks: {
            fontColor: "#fff",
          },
        }],
        yAxes: [{
          display: true,
          gridLines: {
            display: true,
            color: "rgba(255,255,255,.25)"
          },
          ticks: {
            fontColor: "#fff",
          },
        }],
      }
    }
  });
</script>

<script type="text/javascript">
</script>